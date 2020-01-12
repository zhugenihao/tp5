<?php

/**
 * 用户信息
 */

namespace app\common\model;

use \think\Exception;
use \think\Image;
use \think\Db;
use app\common\model\Commons;

class TemporaryImg extends Commons {

    protected $pk = 'id';
    protected $name = "temporary_img";

    public static function getValue($mId, $value = 'id') {
        $res = self::where(['id' => $mId])->value($value);
        return $res;
    }

    public static function getwhereValue($where = [], $value = 'id') {
        $res = self::where($where)->value($value);
        return $res;
    }

    public static function getList($where = [], $field = '*') {
        $res = self::field($field)->where($where)->order("id", 'desc')->select();
        return $res;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getDel($where = []) {
        return self::where($where)->delete();
    }

}
