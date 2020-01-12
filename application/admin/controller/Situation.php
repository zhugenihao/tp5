<?php

/**
 * 统计情况信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\common\model\Time as timeModel;
use app\common\model\Order as orderModel;
use app\common\model\OrderGoods as orderGoodsModel;

class Situation extends Common {

    /**
     * 订单概况
     * @return type
     */
    public function store_situation() {
        $store_id = input('store_id');
        $store_id = !empty($store_id) ? $store_id : 0;
        $start_time = input('start_time');
        $end_time = input('end_time');
        $mtimeq6 = date("Y-m-d", strtotime("-5 month")); //六个月前的时间
        $time = date('Y-m-d'); //当前时间
        $start_time2 = !empty($start_time) ? $start_time : $mtimeq6;
        $end_time2 = !empty($end_time) ? $end_time : $time;

        $date_list = array(); //时间日期
        $trading_amount_list = array(); //交易金额
        $phasbeen_num_list = array(); //已付款订单数
        $notpaying_num_list = array(); //未付款订单数
        $placeorder_num_list = array(); //下单人数
        $dateList = timeModel::getDateByInterval($start_time2, $end_time2, "month");
        foreach ($dateList as $key => $val) {
            $ostart_time = strtotime($val['startDate']);
            $oend_time = strtotime($val['endDate']);
            $all_total_price = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->sum('total_price');
            $all_phasbeen = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->count();
            $all_notpaying = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => FORP_STATUS])->count();
            $all_placeorder = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]]])->group('m_id')->count();

            $trading_amount_list[$key] = $all_total_price;
            $phasbeen_num_list[$key] = $all_phasbeen;
            $notpaying_num_list[$key] = $all_notpaying;
            $placeorder_num_list[$key] = $all_placeorder;
            $date_list[$key] = $val['name'];
        }
        $this->assign('date_list', json_encode($date_list));
        $this->assign('trading_amount_list', json_encode($trading_amount_list));
        $this->assign('phasbeen_num_list', json_encode($phasbeen_num_list));
        $this->assign('notpaying_num_list', json_encode($notpaying_num_list));
        $this->assign('placeorder_num_list', json_encode($placeorder_num_list));

        //本月订单总量
        $benyueMonth = timeModel::month();
        $benyueOrderTprice = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$benyueMonth[0], $benyueMonth[1]]]])->sum('total_price');
        $this->assign('benyueOrderTprice', $benyueOrderTprice);

        //今日订单总量
        $today = timeModel::today();
        $todayOrderNum = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$today[0], $today[1]]]])->count();
        $this->assign('todayOrderNum', $todayOrderNum);

        //人均客单价
        $allPrice = orderModel::where(['store_id' => $store_id, 'state' => TOSG_STATUS])->group('m_id')->sum('total_price');
        $orderMenerNum = orderModel::where(['store_id' => $store_id, 'state' => TOSG_STATUS])->group('m_id')->count();
        $guestUnitPrice = !empty($allPrice > 0 && $orderMenerNum > 0) ? ($allPrice / $orderMenerNum) : "0.00";
        $this->assign('guestUnitPrice', sprintf("%01.2f", $guestUnitPrice));

        //本月取消订单总量
        $quxiaoOrderNum = orderModel::where(['store_id' => $store_id, 'state' => SHUTD_STATUS, 'order_time' => ['between', [$benyueMonth[0], $benyueMonth[1]]]])->count();
        $this->assign('quxiaoOrderNum', $quxiaoOrderNum);
        return $this->fetch();
    }

    /**
     * 运营情况
     * @return type
     */
    public function runreports() {
        $store_id = input('store_id');
        $store_id = !empty($store_id) ? $store_id : 0;
        $start_time = input('start_time');
        $end_time = input('end_time');
        $mtimeq6 = date("Y-m-d", strtotime("-5 month")); //六个月前的时间
        $time = date('Y-m-d'); //当前时间
        $start_time2 = !empty($start_time) ? $start_time : $mtimeq6;
        $end_time2 = !empty($end_time) ? $end_time : $time;

        $date_list = array(); //时间日期
        $total_order_list = array(); //订单总额
        $total_goods_num_list = array(); //商品总数
        $cost_goods_list = array(); //商品成本
        $logistics_cost_list = array(); //物流费用
        $dateList = timeModel::getDateByInterval($start_time2, $end_time2, "month");
        foreach ($dateList as $key => $val) {
            $ostart_time = strtotime($val['startDate']);
            $oend_time = strtotime($val['endDate']);
            $all_total_price = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->sum('total_price');
            $all_goods_num = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->sum('goods_num');
            $all_cost_goods = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->sum('cost_price');
            $all_logistics_cost = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$ostart_time, $oend_time]], 'state' => TOSG_STATUS])->sum('courier_price');

            $total_order_list[$key] = $all_total_price;
            $total_goods_num_list[$key] = $all_goods_num;
            $cost_goods_list[$key] = $all_cost_goods;
            $logistics_cost_list[$key] = $all_logistics_cost;
            $date_list[$key] = $val['name'];
        }
        $this->assign('date_list', json_encode($date_list));
        $this->assign('total_order_list', json_encode($total_order_list));
        $this->assign('total_goods_num_list', json_encode($total_goods_num_list));
        $this->assign('cost_goods_list', json_encode($cost_goods_list));
        $this->assign('logistics_cost_list', json_encode($logistics_cost_list));

        //本月订单总量
        $benyueMonth = timeModel::month();
        $benyueOrderTprice = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$benyueMonth[0], $benyueMonth[1]]]])->sum('total_price');
        $this->assign('benyueOrderTprice', $benyueOrderTprice);

        //今日订单总量
        $today = timeModel::today();
        $todayOrderNum = orderModel::where(['store_id' => $store_id, 'order_time' => ['between', [$today[0], $today[1]]]])->count();
        $this->assign('todayOrderNum', $todayOrderNum);

        //人均客单价
        $allPrice = orderModel::where(['store_id' => $store_id, 'state' => TOSG_STATUS])->group('m_id')->sum('total_price');
        $orderMenerNum = orderModel::where(['store_id' => $store_id, 'state' => TOSG_STATUS])->group('m_id')->count();
        $guestUnitPrice = !empty($allPrice > 0 && $orderMenerNum > 0) ? ($allPrice / $orderMenerNum) : "0.00";
        $this->assign('guestUnitPrice', sprintf("%01.2f", $guestUnitPrice));

        //本月取消订单总量
        $quxiaoOrderNum = orderModel::where(['store_id' => $store_id, 'state' => SHUTD_STATUS, 'order_time' => ['between', [$benyueMonth[0], $benyueMonth[1]]]])->count();
        $this->assign('quxiaoOrderNum', $quxiaoOrderNum);
        return $this->fetch();
    }

}
