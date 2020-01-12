<?php
/**
 * 优惠券信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Coupon extends Commons {

    protected $pk = 'cop_id';
    protected $name = "coupon";

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['cop_show'] = 1;
        $order = ['cop_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->lock(true)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }
    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }

}
