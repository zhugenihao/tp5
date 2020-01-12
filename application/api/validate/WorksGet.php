<?php

namespace app\api\validate;

use app\api\validate\Base;

class WorksGet extends Base {

    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message = [
        'id.require' => '作品id是必须的',
        'id.isPositiveInteger' => '作品id必须是正整数',
    ];

}
