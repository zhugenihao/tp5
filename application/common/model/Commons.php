<?php

/**
 * 公共模型信息
 */

namespace app\common\model;

use think\Model;
use think\Request;
use \think\Exception;
use think\Db;
use think\Cache;

class Commons extends Model {

    protected $resultSetType = 'collection';

    public static function pre() {
        return config('DB_PREFIX');
    }

    public function data_time() {
        return config('datalist.datalist_time');
    }

}
