<?php

namespace app\lib;

use think\facade\Cache;

class Str{
    /**
     * @var mixed
     */
    private $stringKeyName;
    private $accessTokenInRedis;

    public function __construct()
    {
        #获取redis string名称
        $this->stringKeyName = config("push_msg.redis.string.access_token_key_name");
        $this->accessTokenInRedis = Cache::store('redis')->get($this->stringKeyName);
    }
    
    public function getAccessToken()
    {

        #判断redis中是否已存在access_token
        $isAccessTokenKeyNameExist = $this->isAccessTokenKeyNameExist();
        if ($isAccessTokenKeyNameExist!==false){
            return $isAccessTokenKeyNameExist;
        }

        #组装请求数据
        $data = [
            "host" => config("push_msg.host")."/gettoken",
            "timeout" => 10,
            "params" => [
                "corpid" => config("push_msg.get_access_token.corpid"),
                "corpsecret" => config("push_msg.get_access_token.corpsecret"),
            ],
        ];

        #获取请求结果
        $res = HttpRequest::curlGet($data);
        if ($res["http_code"]===200){
            $responseDataArr = json_decode($res["response_data"],true);

            #获取响应状态码、错误信息
            $errCode = $responseDataArr["errcode"];
            $errMsg = $responseDataArr["errmsg"];

            #获取access_token
            $accessToken = $responseDataArr["access_token"];

            #设置本地access_token释放时间
            $expiresIn = $responseDataArr["expires_in"];

            #如果获取access_token成功，存入redis
            if( $errCode === 0 && $errMsg === "ok" ){
                $this->saveAccessTokenToRedis($accessToken,$expiresIn);
                return $accessToken;
            }
        }

        return false;
    }

    //判断redis中是否已存在access_token
    public function isAccessTokenKeyNameExist()
    {
        if($this->accessTokenInRedis===null){
            return false;
        }
        return $this->accessTokenInRedis;
    }
    
    //方法：如果access_token不存在，记录到redis
    public function saveAccessTokenToRedis($accessToken,$expiresIn)
    {
        if($this->accessTokenInRedis===null){
            Cache::store('redis')->setex($this->stringKeyName,$expiresIn,$accessToken);
        }
        return true;
    }
}