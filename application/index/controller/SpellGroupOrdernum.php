<?php

/**
 * 拼团支付数量信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\common\model\Member as memberModel;
use app\common\model\SpellGroup as spellGroupModel;

class SpellGroupOrdernum extends Common {

    /**
     * 参团信息 
     */
    public function getlist() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $field = 's.*,count(s.order_status) as member_num,m.photo,m.member_name,sg.sg_members_num,'
                    . '(sg.sg_members_num-count(s.order_status)) as poor_member';
//            $where = ['s.goods_id' => $get['goods_id'],'s.order_status'=>TOSG_STATUS]; 
            $where = "s.goods_id = {$get['goods_id']} and s.order_status=" . TOSG_STATUS;
            $spellGroupOrdernumList = spellGroupOrdernumModel::getList($where, $field, $get['start'], $get['limit']);
            exit(json_encode($spellGroupOrdernumList));
        }
    }

    public function getsgMemberList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $where = ['first_member_id' => $get['first_member_id'], 'goods_id' => $get['goods_id'], 'order_status' => TOSG_STATUS];
            $spellGroupOrdernumList = spellGroupOrdernumModel::getSpgOrdnumList($where, '*');
            $memberIdArr = array();
            foreach ($spellGroupOrdernumList as $key => $val) {
                $memberIdArr[] = $val['after_member_id'];
            }
            $memberIdArr = array_filter($memberIdArr);
            $after_member = memberModel::getList(['id' => ['in', $memberIdArr]], 'id,photo')->toArray();
            $first_member = memberModel::getMemberInfo(['id' => $get['first_member_id']], 'id,photo')->toArray();
            array_unshift($after_member, $first_member);
            exit(json_encode($after_member));
        }
    }

    /**
     * 拼团信息判断
     */
    public function spellGroupJudge() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $mId = $this->mid();
            if ($mId == $post['first_member_id']) {
                Tiperror("你已发起拼单!");
            }
            $spellGroup = spellGroupModel::getInfo(['goods_id' => $post['goods_id']], 'sg_members_num,sg_num');
            $mySpgOrdnumCount = spellGroupOrdernumModel::getCount(['goods_id' => $post['goods_id'], 'first_member_id' => $this->mid, 'order_status' => TOSG_STATUS]);

            //我发起拼单人数判断
            if ($post['first_member_id'] < 1) {
                if ($mySpgOrdnumCount > 0 && $mySpgOrdnumCount < $spellGroup['sg_members_num']) {
                    Tiperror("你已发起拼单,快去邀请朋友参与吧。");
                }
                //参团判断
            } else {
                //我参别人团人数判断
                $order_no = spellGroupOrdernumModel::getValue(['id' => $post['sgm_id']], 'order_no');
                $SpgOrdnumCount = spellGroupOrdernumModel::getCount(['order_no' => $order_no]);
                $afterSpgOrdnumCount = spellGroupOrdernumModel::getCount(['order_no' => $order_no, 'after_member_id' => $this->mid]);
                if ($SpgOrdnumCount >= $spellGroup['sg_members_num']) {
                    Tiperror("拼单人数已满。");
                }
                //我是否参别人的团
                if ($afterSpgOrdnumCount > 0) {
                    Tiperror("你已参团。");
                }
            }
            Tobesuccess('可以拼单');
        }
    }

}
