<?php

/**
 * 公共模型信息
 */

namespace app\admin\model;

use think\Model;
use think\Request;
use \think\Exception;
use think\Db;

class Commons extends Model {

    protected $resultSetType = 'collection';

    public static function rolename() {
        $user_id = session('user_id');
        $where3['ru.user_id'] = $user_id;
        $pre = config('DB_PREFIX');
        $res = db::name("role_user")->alias('ru')
                        ->join("{$pre}role r", 'r.id=ru.role_id', 'LEFT')
                        ->where($where3)->find();

        return $res;
    }

}
