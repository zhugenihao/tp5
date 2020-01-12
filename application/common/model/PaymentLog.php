<?php

/**
 * 付款记录信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class PaymentLog extends Commons {

    protected $pk = 'id';
    protected $name = "payment_log";

    public static function add($data) {
        return self::create($data);
    }

    public static function getOrderMumberID($order_number) {
        $res = self::where("order_number", "=", $order_number)->find();
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

}
