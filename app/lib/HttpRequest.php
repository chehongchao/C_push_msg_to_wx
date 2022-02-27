<?php

namespace app\lib;

class HttpRequest{
    public static function curlGet($data)
    {
        $host = $data["host"];
        $timeout = $data["timeout"];
        $params = $data["params"];

        //拼接请求地址
        $url = $host . '?' . http_build_query($params);

        //执行请求获取数据
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $responseData = curl_exec($ch);
        $responseError = curl_error($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            "http_code" => $httpCode,
            "response_data" => $responseData,
            "response_error" => $responseError,
        ];
    }

    public static function postRequest($data)
    {

        $host = $data["host"];
        $contentType = $data["content_type"];
        $body = $data["body"];
        $timeout = $data["timeout"];

        //执行请求获取数据
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //https调用
        //curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $header = [
            $contentType,
            'Client-Sdk-Type: php',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $responseData = curl_exec($ch);
        $responseError = curl_error($ch);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            "http_code" => $httpCode,
            "response_data" => $responseData,
            "response_error" => $responseError,
        ];
    }
}