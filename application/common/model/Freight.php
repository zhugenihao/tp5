<?php
/**
 * 运费信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Freight extends Commons {

    protected $pk = 'id';
    protected $name = "freight";

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['is_use'] = 1;
        $order = ['create_time' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
