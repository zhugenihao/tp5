<?php

/**
 * 商品库存信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Inventory extends Commons {

    protected $pk = 'id';
    protected $name = "inventory";

    public static function add($data){
        return self::create($data);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $res = self::field($field)->where($where)->order("id", 'asc')->limit($start, $limit)->select();
        return $res;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->lock(true)->where($where)->find();
    }

    public static function getCount($where = []) {
        return self::where($where)->lock(true)->count();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->lock(true)->value($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getDelete($where = []) {
        return self::where($where)->delete();
    }
    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }
    

}
