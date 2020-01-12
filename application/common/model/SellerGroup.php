<?php

/**
 * 商家账号组信息
 */

namespace app\common\model;

use \think\Exception;
use \think\Image;
use app\common\model\Commons;

class SellerGroup extends Commons {

    protected $pk = 'id';
    protected $name = "seller_group";

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        $res = self::field($field)->where($where)->find();
        return $res;
    }

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
