<?php

namespace app\controller;

use app\lib\Str;

class PushMsg{
    public function pushMsg()
    {
        $params = request()->param();
        return (new \app\business\PushMsg())->pushMsg($params);
    }
}