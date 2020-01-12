<?php

/**
 * 商品订单信息
 */

namespace app\index\model;

use \think\Db;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\common\model\Member as memberModel;
use app\common\model\OrderGoods as orderGoodsModel;

class OrderGoods extends orderGoodsModel {


    /**
     * 订单列表
     * @param type $where
     * @param type $field
     * @param type $start
     * @param type $limit
     * @return type
     */
    public static function getListPc($where = [], $field = '*', $limit = 10) {
        $order = ['o.id' => 'desc'];
        $join = [
            ['mz_goods g', 'g.goods_id=o.goods_id', 'left'], //商品表信息
            ['mz_norm n', 'n.n_id=o.n_id', 'left'], //规格表信息
            ['mz_goods_color gc', 'gc.id=n.goodscolor_id', 'left'], //商品颜色表信息
            ['mz_cates cs', 'cs.cate_id=o.cate_id', 'left'], //商品版本表信息
            ['mz_spell_group sg', 'sg.goods_id=o.goods_id', 'left'], //商品拼团表信息
        ];
        $map['query'] = [
            'type'=>input('type'),
            'state'=>input('state'),
            'search'=>input('search'),
            'activity'=>input('activity'),
        ];
        $list['count'] = self::alias('o')->join($join)->where($where)->count();
        $lists = self::alias('o')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        if ($lists) {
            foreach ($lists as $key => $val) {
                $spgOrdnumInfo = spellGroupOrdernumModel::getInfo(['id' => $val['sgm_id']], 'order_no');
                $order_no = !empty($spgOrdnumInfo) ? $spgOrdnumInfo['order_no'] : $val['order_no'];
                $spgOrdnumList = spellGroupOrdernumModel::getSpgOrdnumList(['order_no' => $order_no], 'first_member_id,after_member_id')->toArray();
                $memberIdArr = array();
                $first_member_id = '';
                $after_member = array();
                $first_member = array();
                foreach ($spgOrdnumList as $sgmkey => $sgmval) {
                    $memberIdArr[] = $sgmval['after_member_id'];
                    $first_member_id = $sgmval['first_member_id'];
                }
                $memberIdArr = array_filter($memberIdArr);
                if ($memberIdArr) {
                    $after_member = memberModel::getList(['id' => ['in', $memberIdArr]], 'id,photo')->toArray();
                }
                if ($first_member_id) {
                    $first_member = memberModel::getMemberInfo(['id' => $first_member_id], 'id,photo')->toArray();
                }
                if ($after_member || $first_member) {
                    array_unshift($after_member, $first_member);
                }

                $lists[$key]['sgm_member_list'] = $after_member; //拼团成员
                $sg_members_num = spellGroupModel::getValue(['goods_id' => $val['goods_id']], 'sg_members_num');
                $lists[$key]['sgm_member_poor'] = $sg_members_num - count($spgOrdnumList);
            }
        }
        $list['list'] = $lists;
        return $list;
    }
    public function goods() {
        return $this->hasOne('Goods', 'goods_id', 'goods_id')->field('goods_id,goods_name,goods_sku,thecover');
    }

    public function payment() {
        return $this->hasOne('Payment', 'payment_mark', 'payment_type')->field('payment_name,payment_mark');
    }
    public static function sums($where = [], $value = 'total_price') {
        return self::where($where)->sum($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }
    public static function getDelete($where=[]){
        return self::where($where)->delete();
    }

    
}
