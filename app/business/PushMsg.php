<?php

namespace app\business;

use app\lib\HttpRequest;
use app\lib\Show;
use app\lib\Str;

class PushMsg{
    public function pushMsg($params)
    {
        #获取客户端参数
        $agentId = request()->param("agent_id");
        $toUser = request()->param("to_user");
        $content = request()->param("content");

        #获取access_token
        $accessToken = (new Str())->getAccessToken();
        if($accessToken===false){
            return Show::error("获取access_token失败，请重试~");
        }

        #设置http请求数据
        $contenType = "Content-Type: application/json";
        $host = config("push_msg.host")."/message/send?access_token=".$accessToken;
        $body = [
            "touser" => $toUser,
            "msgtype" => "text",
            "agentid" => $agentId,
            "text" => [
                "content" => $content,
            ],
            "safe" => 0,
            "enable_id_trans" => 0,
            "enable_duplicate_check" => 0,
        ];
        $body = json_encode($body,JSON_UNESCAPED_UNICODE);

        #http请求数据组装到数组
        $data["content_type"] = $contenType;
        $data["host"] = $host;
        $data["body"] = $body;
        $data["timeout"] = 10;

        $postRequestResultArr = HttpRequest::postRequest($data);
        $pushMsgResultArr = json_decode($postRequestResultArr["response_data"],true);
        if( $postRequestResultArr["http_code"] === 200 && $pushMsgResultArr["errcode"] === 0 ){
            return Show::success("消息推送成功~");
        }
        return Show::error("消息推送失败",0,$pushMsgResultArr);
    }
}