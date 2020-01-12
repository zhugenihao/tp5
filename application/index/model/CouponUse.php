<?php

/**
 * 优惠券领取信息
 */

namespace app\index\model;

use app\index\model\Commons;
use \think\Db;
use app\common\model\CouponUse as couponUseModel;
use app\common\model\Goods as goodsModel;

class CouponUse extends couponUseModel {

    public static function getCouponUsemListPc($where = [], $field = '*', $limit = 10){
        $join = [
            ['mz_goods g','g.goods_id=cu.type_id','left'],
            ['mz_store s','s.id=cu.type_id','left'],
        ];
        $order = ['cu.create_time' => 'desc'];
        $map['query'] = [
            'type'=>input('type'),
            'state'=>input('state')
        ];
        $list['count'] = self::alias('cu')->join($join)->where($where)->count();
        $CouponUseList = self::alias('cu')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        foreach($CouponUseList as $key=>$val){
            $CouponUseList[$key]['use_goods_name'] = goodsModel::getValue(['goods_id'=>$val['goods_id']], 'goods_name');
        }
        $list['list'] = $CouponUseList;
        return $list;
    }

}
