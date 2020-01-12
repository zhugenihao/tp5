<?php

/**
 * 订单信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\common\model\Time as timeModel;
use app\admin\model\OrderGoods as OrderGoodsModel;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\common\model\Member as memberModel;
use app\common\model\SpellGroup as spellGroupModel;

class Order extends Commons {

    protected $pk = 'id';
    protected $name = "order";

    public function OrderGoods() {
        $field = '*';
        return $this->hasMany('OrderGoods', 'order_no', 'order_no')->with(['payment', 'goods'])->field($field);
    }

    public function member() {
        return $this->hasOne('Member', 'id', 'm_id')->field('id,member_name,photo');
    }

    public function payment() {
        return $this->hasOne('Payment', 'payment_mark', 'payment_type')->field('payment_name,payment_mark');
    }

    public static function getOrderlist($where = [], $field = '*', $limit = 10) {

        $member_name = trim(input('member_name'));
        $order_no = trim(input('order_no'));
        $state = (int) (input('state'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $activity = trim(input('activity'));
        if (!empty($order_no)) {
            $where['order_no'] = $order_no;
        }
        if (!empty($member_name)) {
            $where['m_id'] = memberModel::getwhereValue(['member_name' => $member_name], 'id');
        }
        if (!empty($datemin)) {
            $where['order_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['order_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['order_time'] = ['between', [$datemin, $datemax]];
        }
        if (!empty($state)) {
            $where['state'] = $state;
        }
        if (!empty($activity)) {
            $where['activity'] = $activity;
        }

        $map['query'] = ['order_no' => $order_no, 'member_name' => $member_name, 'state' => $state,
            'datemin' => input('datemin'), 'datemax' => input('datemax'), 'activity' => $activity];
        $order = ['order_time' => 'desc'];
        $list['count'] = self::with(['OrderGoods', 'member'])->where($where)->count();

        $lists = self::with(['OrderGoods', 'member'])->field($field)->where($where)->order($order)->paginate($limit, false, $map);
        if ($lists) {
            foreach ($lists as $key => $val) {
                $spellGroupMember = self::spellGroupMember($val['order_goods']);
                $lists[$key]['sgm_member_list'] = $spellGroupMember['sgm_member_list']; //拼团成员
                $lists[$key]['sg_members_num'] = $spellGroupMember['sg_members_num']; //拼团上限成员数量
                $lists[$key]['sgm_member_poor'] = $spellGroupMember['sgm_member_poor']; //还差拼团人数
            }
        }
        $list['list'] = $lists;
        $list['amount'] = self::getAmount();
        return $list;
    }

    public static function getAmount($where = []) {
        $monthTime = timeModel::month();
        $yearTime = timeModel::year();
        $monthWhere['tord_time'] = ['between', [$monthTime[0], $monthTime[1]]];
        $yearWhere['tord_time'] = ['between', [$yearTime[0], $yearTime[1]]];
        $where['state'] = TOSG_STATUS;
        $monthWhere['state'] = TOSG_STATUS;
        $yearWhere['state'] = TOSG_STATUS;
        //总入账
        $list['booked_all'] = sprintf('%.2f', OrderGoodsModel::where($where)->sum('total_price'));
        //今年入账
        $list['booked_year'] = sprintf('%.2f', OrderGoodsModel::sums($monthWhere, 'total_price'));
        //本月入账
        $list['booked_month'] = sprintf('%.2f', OrderGoodsModel::sums($yearWhere, 'total_price'));
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $info = self::with(['OrderGoods', 'member', 'payment'])->field($field)->where($where)->find();
        $spellGroupMember = self::spellGroupMember($info['order_goods']);
        $info['sgm_member_list'] = $spellGroupMember['sgm_member_list']; //拼团成员
        $info['sg_members_num'] = $spellGroupMember['sg_members_num'];
        $info['sgm_member_poor'] = $spellGroupMember['sgm_member_poor'];
        return $info->toArray();
    }
    /**
     * 获取拼团团员
     * @param type $orderGoodsVal
     * @return type
     */
    public static function spellGroupMember($orderGoodsVal = array()) {
        $orderGoods = $orderGoodsVal[0];
        $spgOrdnumInfo = spellGroupOrdernumModel::getInfo(['id' => $orderGoods['sgm_id']], 'order_no');
        $order_no = !empty($spgOrdnumInfo) ? $spgOrdnumInfo['order_no'] : $orderGoods['order_no'];
        $spgOrdnumList = spellGroupOrdernumModel::getSpgOrdnumList(['order_no' => $order_no], 'first_member_id,after_member_id')->toArray();
        $memberIdArr = array();
        $first_member_id = '';
        $after_member = array(); //拼团成员
        $first_member = array();
        foreach ($spgOrdnumList as $sgmkey => $sgmval) {
            $memberIdArr[] = $sgmval['after_member_id'];
            $first_member_id = $sgmval['first_member_id'];
        }
        $memberIdArr = array_filter($memberIdArr);
        if ($memberIdArr) {//团员
            $after_member = memberModel::getList(['id' => ['in', $memberIdArr]], 'id,photo,member_name')->toArray();
        }
        if ($first_member_id) {//团长
            $first_member = memberModel::getMemberInfo(['id' => $first_member_id], 'id,photo,member_name')->toArray();
        }
        if ($after_member || $first_member) {
            array_unshift($after_member, $first_member);
        }
        //拼团上限成员数量
        $sg_members_num = spellGroupModel::getValue(['goods_id' => $orderGoods['goods_id']], 'sg_members_num');
        //还差拼团人数
        $sgm_member_poor = $sg_members_num - count($spgOrdnumList);

        return array('sgm_member_list' => $after_member, 'sg_members_num' => $sg_members_num, 'sgm_member_poor' => $sgm_member_poor);
    }

    public static function sums($where = [], $value = 'total_price') {
        return self::where($where)->sum($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getDelete($where = []) {
        return self::where($where)->delete();
    }

}
