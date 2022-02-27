<?php

return [
    "host" => "https://qyapi.weixin.qq.com/cgi-bin",

    "redis" => [
        "string" => [
            "access_token_key_name" => "weixin_work_develop_push_message_access_token",
        ],
    ],

    "get_access_token" => [
        "corpid" => "",
        "corpsecret" => "",
    ],
    "push_msg" => "",
];