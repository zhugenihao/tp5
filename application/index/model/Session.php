<?php

/**
 * session数据保存信息
 */

namespace app\index\model;

use \think\Exception;
use think\Model;

class Session extends Model {

    public static function check_session() {
        $member_id = session('member_id');
        $member_mobile = session('member_mobile');
        if (empty($member_mobile) || empty($member_id)) {
            return false;
        } else {
            return true;
        }
    }

}
