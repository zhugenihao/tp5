<?php

namespace app\api\validate;

use app\api\validate\Base;

class PayGet extends Base {

    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message = [
        'id.require' => 'ID是必须的',
        'id.isPositiveInteger' => 'ID必须是正整数',
    ];

}
