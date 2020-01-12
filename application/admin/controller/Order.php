<?php

/**
 * 订单信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Order as orderModel;
use app\admin\model\OrderGoods as orderGoodsModel;
use \think\Db;

class Order extends Common {

    public function getlist() {
        $list = orderModel::getOrderlist(['store_id' => 0], '*', 10);
        $listas = $list['list']->toArray();
//        print_R($listas);
        $this->assign([
            'list' => $listas['data'],
            'amount' => $list['amount'],
            'limit' => 10,
            'allcount' => $list['count'],
            'member_name' => input('member_name'),
            'order_no' => input('order_no'),
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
            'state' => input('state'),
            'activity' => input('activity'),
            'page' => $list['list']->render(),
        ]);
        return $this->fetch();
    }

    /**
     * 未结算订单
     * @return type
     */
    public function outstanding_orders() {
        $list = orderModel::getOrderlist(['store_id' => 0, 'state' => ['neq', SUCCE_STATUS]], '*', 10);
        
        $listas = $list['list']->toArray();
        $this->assign([
            'list' => $listas['data'],
            'amount' => $list['amount'],
            'limit' => 10,
            'allcount' => $list['count'],
            'member_name' => input('member_name'),
            'order_no' => input('order_no'),
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
            'state' => input('state'),
            'activity' => input('activity'),
            'page' => $list['list']->render(),
        ]);
        return $this->fetch('order/getlist');
    }

    public function order_details() {
        $order = orderModel::getInfo(['id' => input('get.order_id')], '*');
//        print_r($order->toArray());die();
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

    public function financialsetup() {
        $financialsetup = db::name("financialsetup");
        $info = $financialsetup->where("id", 1)->find();
        $this->assign("info", $info);
        if ($this->request->isAjax()) {
            $post = input('post.');
            $id = $post['id'];
            $author = $post['author'];
            $platform = $post['platform'];
            $data = ['author' => $author, 'platform' => $platform,];
            $sum = $author + $platform;
            if ($sum != 10) {
                Tiperror("分润相加必须为10！");
            }
            $res = $financialsetup->where("id", $id)->update($data);
            if ($res) {
                Tobesuccess('分润比例设置成功！');
            } else {
                Tiperror("分润比例设置失败！");
            }
        }
        return $this->fetch();
    }

}
