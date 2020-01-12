<?php

/**
 * 优惠券使用记录
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\Goods as goodsModel;

class CouponUse extends Commons {

    protected $pk = 'id';
    protected $name = "coupon_use";

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['create_time' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }
    public static function getCouponUsemList($where = [], $field = '*', $start = 0, $limit = 10){
        $join = [
            ['mz_goods g','g.goods_id=cu.type_id','left'],
            ['mz_store s','s.id=cu.type_id','left'],
        ];
        $order = ['cu.create_time' => 'desc'];
        $list['count'] = self::alias('cu')->join($join)->where($where)->count();
        $CouponUseList = self::alias('cu')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        foreach($CouponUseList as $key=>$val){
            $CouponUseList[$key]['use_goods_name'] = goodsModel::getValue(['goods_id'=>$val['goods_id']], 'goods_name');
        }
        $list['list'] = $CouponUseList;
        return $list;
    }

    public static function getInfo($id) {
        return self::where(['id' => $id])->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

}
