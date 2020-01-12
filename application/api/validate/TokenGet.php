<?php

namespace app\api\validate;
use app\api\validate\Base;

class TokenGet extends Base{
     protected $rule = [
        'code'  =>  'require|isNotEmpty',
    ];
     protected $message = [
        'code'  =>  'code获取失败！',
    ];
}
