<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\index\model\Session as sessionModel;
use app\index\model\CouponReceive as couponReceiveModel;
use app\index\model\CouponUse as couponUseModel;
use app\index\model\Coupon as couponModel;

class Coupon extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
    }

    public function index() {
        $coupfield = "cr.*,s.store_name,g.goods_name";
        $todayTime = date("Y-m-d H:i:s");
        $state = input('state') ? input('state') : 1;
        if ($state == 1) {//有效优惠券
            $where['cr.copb_time'] = array('egt', $todayTime);
        } elseif ($state == 2) {//过期优惠券
            $where['cr.copb_time'] = array('elt', $todayTime);
        }
        $where['cr.m_id'] = $this->mid;
        $list = couponReceiveModel::getCouponReceivemListPc($where, $coupfield, 5);
        if (input('state') == 'record') {
            $coupufield = "cu.*,s.store_name,g.goods_name";
            $list = couponUseModel::getCouponUsemListPc(['cu.member_id' => $this->mid], $coupufield, 5);
        }
        $this->assign("list", $list['list']);
        $this->assign('page', $list['list']->render());
        $this->assign("state", $state);
        $count_all = couponReceiveModel::getCount(['m_id' => $this->mid]);
        $this->assign("count_all", $count_all);
        return $this->fetch();
    }


}
