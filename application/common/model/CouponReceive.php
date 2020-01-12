<?php

/**
 * 优惠券领取信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class CouponReceive extends Commons {

    protected $pk = 'id';
    protected $name = "coupon_receive";

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['receive_time' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getCouponReceivemList($where = [], $field = '*', $start = 0, $limit = 10) {
        $join = [
            ['mz_goods g', 'g.goods_id=cr.type_id', 'left'],
            ['mz_store s', 's.id=cr.type_id', 'left'],
        ];
        $order = ['receive_time' => 'desc'];
        $list['count'] = self::alias('cr')->join($join)->where($where)->count();
        $list['list'] = self::alias('cr')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($id) {
        return self::where(['id' => $id])->find();
    }

    public static function getCouponReInfo($where = [], $field = '*') {
        $info = self::field($field)->where($where)->find();
        return $info;
    }

    /**
     * 获取有效的优惠券
     * @param type $where
     * @param type $field
     * @return type
     */
    public static function getCouponReInfoisDate($where = [], $field = '*') {
        $todayTime = date("Y-m-d H:i:s");
        $where['copb_time'] = array('egt', $todayTime);
        $info = self::field($field)->where($where)->find()->toArray();
        return $info;
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->lock(true)->count();
    }

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

}
