<?php

/**
 * 支付信息
 */

namespace app\index\controller;

use \think\Db;
use app\index\controller\Common;
use app\index\model\Session as sessionModel;
use app\common\model\Cart as cartModel;
use app\common\service\Pay as PayModel;
use app\common\model\Member as memberModel;
use app\common\service\OrderOperation as orderOperationModel;

class Pay extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            Tiperror("请登录账号！");
        }
    }

    /**
     * 支付操作
     */
    public function paySubmit() {
        $post = input('post.');
        $orderNo = orderOperationModel::OrderOperationSubmit();
        if ($orderNo) {
            Tobesuccess('订单生成成功');
        } else {
            Tiperror("订单生成失败！");
        }
    }

    /**
     * 多个订单付款
     */
    public function payUpdate() {
        $result = orderOperationModel::orderChange();
        if ($result) {
            Tobesuccess('支付成功');
        } else {
            Tiperror("支付失败！");
        }
    }

    /**
     * 单个订单付款
     */
    public function payUpdateOne() {
        $result = orderOperationModel::orderChangeOne();
        if ($result) {
            Tobesuccess('支付成功');
        } else {
            Tiperror("支付失败！");
        }
    }

}
