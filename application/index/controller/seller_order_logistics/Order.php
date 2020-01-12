<?php

/**
 * 订单信息
 */

namespace app\index\controller\seller_order_logistics;

use app\index\controller\SellerCommon;
use app\index\model\Order as orderModel;
use app\index\model\OrderGoods as orderGoodsModel;
use \think\Db;

class Order extends SellerCommon {

    public function order_list() {
        $store = $this->store;
        $order = orderModel::getOrderlist(['store_id' => $store['id']], '*', 10);
        
        $list = $order['list']->toArray();
        $this->assign('order', $list);
        $this->assign('page', $order['list']->render());
        $activity = trim(input('activity'));
        if ($activity == 'seconds_kill') {
            $orderTitle = "秒杀订单(" . $list['total'] . ")";
        } elseif ($activity == 'spell_group') {
            $orderTitle = "拼团订单(" . $list['total'] . ")";
        } elseif ($activity == 'comdysalesp') {
            $orderTitle = "促销订单(" . $list['total'] . ")";
        } else {
            $orderTitle = "全部订单(" . $list['total'] . ")";
        }
        $this->assign('orderTitle', $orderTitle);
        return $this->fetch();
    }

    /**
     * 未结算订单
     * @return type
     */
    public function outstanding_orders() {
        $store = $this->store;
        $order = orderModel::getOrderlist(['store_id' => $store['id'], 'state' => ['neq', SUCCE_STATUS]], '*', 10);
        $list = $order['list']->toArray();
        $this->assign('order', $list);
        $this->assign('page', $order['list']->render());
        $orderTitle = "未结算订单(" . $list['total'] . ")";
        $this->assign('orderTitle', $orderTitle);
        return $this->fetch('seller_order_logistics/order/order_list');
    }

    public function order_details() {
        $order = orderModel::getSellerOrderInfo(['id' => input('order_id')], '*');
//        print_r($order);die();
        $this->assign('order', $order);
        return $this->fetch();
    }

    /**
     * 付款
     */
    public function disable() {
        if ($this->request->isAjax()) {
            $res = false;
            $order_id = (int) (input("order_id"));
            $orderType = input("order_type");
            if ($orderType == 'order') {
                $order = orderModel::get($order_id);
                if ($order['state'] === FORP_STATUS) {
                    $res = orderModel::updates(['id' => $order_id], ['state' => TOSG_STATUS]);
                    orderGoodsModel::updates(['order_no' => $order['order_no']], ['state' => TOSG_STATUS]);
                }
            }
            if ($orderType == 'order_goods') {
                $orderGoods = orderGoodsModel::get($order_id);
                if ($orderGoods['state'] === FORP_STATUS) {
                    $res = orderGoodsModel::updates(['id' => $order_id], ['state' => TOSG_STATUS]);
                }
            }
            if ($res) {
                Tobesuccess('付款成功');
            } else {
                Tiperror("付款失败");
            }
        }
    }

    /**
     * 发货操作
     */
    public function deliveryStart() {
        if ($this->request->isAjax()) {
            $res = false;
            $order_id = (int) (input("order_id"));
            $orderType = input("order_type");

            if ($orderType == 'order') {
                $order = orderModel::get($order_id);

                if ($order['state'] == TOSG_STATUS) {
                    $res = orderModel::updates(['id' => $order_id], ['state' => FORG_STATUS, 'delivery_time' => time()]);
                    orderGoodsModel::updates(['order_no' => $order['order_no']], ['state' => FORG_STATUS, 'delivery_time' => time()]);
                }
            }

            if ($orderType == 'order_goods') {
                $orderGoods = orderGoodsModel::get($order_id);
                if ($orderGoods['state'] == TOSG_STATUS) {
                    $res = orderGoodsModel::updates(['id' => $order_id], ['state' => FORG_STATUS, 'delivery_time' => time()]);
                }
            }
            if ($res) {
                Tobesuccess('发货成功');
            } else {
                Tiperror("发货失败");
            }
        }
    }

    /**
     * 修改订单金额 
     */
    public function modifyTotalPrice() {
        if ($this->request->isAjax()) {
            $order_id = (int) (input("order_id"));
            $TotalPrice = input("total_price");
            $order = orderModel::get($order_id);
            if ($TotalPrice > $order['total_price']) {
                Tiperror("修改金额只能小于原来的");
            }
            $res = orderModel::updates(['id' => $order_id], ['total_price' => $TotalPrice]);

            if ($res) {
                $difference = $order['total_price'] - $TotalPrice;
                $difData = array();
                $orderGoodsModel = new orderGoodsModel();
                $orderGoods = $orderGoodsModel->where(['order_no' => $order['order_no']])->select();
                $differenceOne = ($difference / count($orderGoods)); //每个单要减得金额
                foreach ($orderGoods as $val) {
                    $differencePrice = $val['total_price'] - $differenceOne;
                    $difData[] = ['id' => $val['id'], 'total_price' => $differencePrice];
                }
                $orderGoodsModel->saveAll($difData);
                Tobesuccess('修改金额成功');
            } else {
                Tiperror("修改金额失败");
            }
        }
    }

    public function orderDel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $order = orderModel::all($id_arr);
            foreach ($order as $val) {
                orderGoodsModel::getDelete(['order_no' => $val['order_no']]);
            }
            $result = orderModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function orderGoodsDel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = orderGoodsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
