<?php

namespace app\common\service;

class Tokens {
    public static function generateToken(){
        //32个字符组成一组字符串
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
}
