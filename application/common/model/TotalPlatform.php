<?php

/**
 * 平台总余额信息
 */

namespace app\common\model;

use \think\Exception;
use app\common\model\Commons;

class TotalPlatform extends Commons {

    protected $pk = 'id';
    protected $name = "total_platform";

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        $where['seller_delete'] = 1;
        $res = self::field($field)->where($where)->find();
        return $res;
    }

    public static function getValue($where = [], $value = 'id') {
        $res = self::where($where)->value($value);
        return $res;
    }
    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }


}
