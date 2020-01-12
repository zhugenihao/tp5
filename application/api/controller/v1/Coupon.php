<?php

/**
 * 商品优惠券信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Session as sessionModel;
use app\common\model\CouponReceive as couponReceiveModel;
use app\common\model\CouponUse as couponUseModel;

class Coupon extends Common {

    public function _initialize() {
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
        $this->mid = session('member_id');
    }

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $coupfield = "cr.*,s.store_name,g.goods_name";
            $todayTime = date("Y-m-d H:i:s");
            if ($get['state'] == 1) {//有效优惠券
                $where['cr.copb_time'] = array('egt', $todayTime);
            } elseif ($get['state'] == 2) {//过期优惠券
                $where['cr.copb_time'] = array('elt', $todayTime);
            }
            $where['cr.m_id'] = $this->mid;
            $list = couponReceiveModel::getCouponReceivemList($where, $coupfield, $get['start'], $get['limit']);
            if($get['state'] == 'record'){
                $coupufield = "cu.*,s.store_name,g.goods_name";
                $list = couponUseModel::getCouponUsemList(['cu.member_id'=>$this->mid], $coupufield, $get['start'], $get['limit']);
            }
            exit(json_encode($list));
        }
        $count_all = couponReceiveModel::getCount(['m_id' => $this->mid]);
        $this->assign("count_all", $count_all);
        return $this->fetch();
    }

}
