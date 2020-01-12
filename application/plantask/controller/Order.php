<?php

/**
 * 订单处理执行任务
 */

namespace app\plantask\controller;

use app\common\model\Goods as GoodsModel;
use app\common\model\Order as orderModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Inventory as inventoryModel;
use \think\Db;

class Order extends Common {

    /**
     * 未付款订单自动取消
     */
    public function orderAcancelled() {
        $where = ['state' => FORP_STATUS];
        $orderGoodsList = orderGoodsModel::where($where)->limit(0, 1000)->select()->toArray();
        $result = array();
        $time = time();
        $num = 0;
        if ($orderGoodsList) {
            foreach ($orderGoodsList as $val) {
                $timeDiff = $time - $val['tord_time']; //当前时间与下单时间的时间差
                $dayTime = 24 * 60 * 60; //一天的秒数（24小时）
                if ($timeDiff >= $dayTime) {//如果下单时间差超过24小时，则取消订单
                    //加回库存
                    GoodsModel::setIncs(['goods_id' => $val['goods_id']], 'goods_stock', $val['goods_num']);
                    inventoryModel::setIncs(['n_id' => $val['n_id'], 'cate_id' => $val['cate_id']], 'inventory', $val['goods_num']);
                    $result[] = orderGoodsModel::updates(['id' => $val['id']], ['state' => SHUTD_STATUS]);
                    orderModel::updates(['order_no' => $val['order_no']], ['state' => SHUTD_STATUS]);
                    echo "编号为：{$val['order_no']}的订单取消成功，"."\n";
                    $num ++;
                }
            }
        }
        if ($result) {
            exit('有' . $num . '个订单取消成功');
        } else {
            exit('取消失败');
        }
    }

}
