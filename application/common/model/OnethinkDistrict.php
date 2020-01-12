<?php
/**
 * 区域信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class OnethinkDistrict extends Commons {

    protected $pk = 'id';
    protected $name = "onethink_district";

    public static function add($data) {
        return self::create($data);
    }
    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }
    public static function getList($where = [], $field = '*', $start = 0, $limit = 100) {
        $where['is_show'] = 1;
        $order = ['id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($id) {
        return self::where(['id' => $id])->find();
    }
    public static function getQdInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }
    

}
