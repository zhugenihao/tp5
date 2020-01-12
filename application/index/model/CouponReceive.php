<?php

/**
 * 优惠券领取信息
 */

namespace app\index\model;

use app\index\model\Commons;
use \think\Db;
use app\common\model\CouponReceive as couponReceiveModel;

class CouponReceive extends couponReceiveModel {

    public static function getCouponReceivemListPc($where = [], $field = '*', $limit = 10) {
        $join = [
            ['mz_goods g', 'g.goods_id=cr.type_id', 'left'],
            ['mz_store s', 's.id=cr.type_id', 'left'],
        ];
        $order = ['receive_time' => 'desc'];
        $map['query'] = [
            'type'=>input('type'),
            'state'=>input('state')
        ];
        $list['count'] = self::alias('cr')->join($join)->where($where)->count();
        $list['list'] = self::alias('cr')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

}
