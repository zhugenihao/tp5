<?php

/**
 * 订单信息
 */

namespace app\common\model;

use app\common\model\Commons;
use app\common\model\Goods as goodsModel;
use app\common\model\Freight as freightModel;
use app\common\model\Inventory as inventoryModel;
use \think\Db;

class Order extends Commons {

    protected $pk = 'id';
    protected $name = "order";

    public static function add($data) {
        return self::create($data);
    }

    public static function getOrderNoID($order_no) {
        $res = self::where("order_no", "=", $order_no)->find();
        return $res;
    }

    public static function createOrder($where, $data) {
        $ordersInfo = self::where($where)->find(); //订单是否已存在
        if (!empty($ordersInfo)) {
            unset($data['order_time']);
            self::where($where)->update($data);
        } else {
            $addOrder = self::create($data);
            $ordersInfo = $addOrder;
        }
        return $ordersInfo;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getDel($where = []) {
        return self::where($where)->delete();
    }

    public static function getValue($where = [], $value = 'order_no') {
        return self::where($where)->value($value);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $res = self::field($field)->where($where)->order("id", 'desc')->limit($start, $limit)->select();
        return $res;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    /**
     * 运费计算
     * @param type $goods_id
     * @param type $goods_price
     * @param type $goods_num
     * @param type $n_id
     * @param type $cate_id
     * @return type
     */
    public static function freightCalculate($goods_id = 0, $goods_num = 0, $n_id = 0, $cate_id = 0) {

        $totalFreight = 0;//总费用
        $goods = goodsModel::getInfo(['goods_id' => $goods_id]);
        $inventory = inventoryModel::getInfo(['goods_id' => $goods_id, 'n_id' => $n_id, 'cate_id' => $cate_id]);
        $freight = freightModel::getInfo(['id' => $goods['freight_id'], 'is_use' => 1]);

        if ($goods['setup_norm'] == 'on') {//有规格时
            if ($freight['billing_way'] == 1) {//计费方式:件数
                //运费 = (首件*首费)+(续件*续费)；
                $totalFreight = self::getBilling($goods_num, $freight['first_number'], $freight['first_fee'], $freight['tocontinue_fee']);
            } elseif ($freight['billing_way'] == 2) {//计费方式:重量（kg）
                $totalTypeNum = $inventory['type_num'] * $goods_num; //总重量（kg）
                
                //运费 = (首重[kg]*首费)+(续重[kg]*续费)；
                $totalFreight = self::getBilling($totalTypeNum, $freight['first_heavy'], $freight['first_fee'], $freight['tocontinue_fee']);
            } elseif ($freight['billing_way'] == 3) {//计费方式:体积
                $totalTypeNum = $inventory['type_num'] * $goods_num; //总体积（立方米）

                //运费 = (首体积[立方米]*首费)+(续体积[立方米]*续费)；
                $totalFreight = self::getBilling($totalTypeNum, $freight['first_volume'], $freight['first_fee'], $freight['tocontinue_fee']);
            }
        } else {//无规格时
            if ($freight['billing_way'] == 1) {//计费方式:件数
                //运费 = (首件*首费)+(续件*续费)；
                $totalFreight = self::getBilling($goods_num, $freight['first_number'], $freight['first_fee'], $freight['tocontinue_fee']);
            } elseif ($freight['billing_way'] == 2) {//计费方式:重量（kg）
                $totalBillingNum = $goods['billing_num'] * $goods_num; //总重量（kg）

                //运费 = (首重[kg]*首费)+(续重[kg]*续费)；
                $totalFreight = self::getBilling($totalBillingNum, $freight['first_heavy'], $freight['first_fee'], $freight['tocontinue_fee']);
            } elseif ($freight['billing_way'] == 3) {//计费方式:体积
                $totalBillingNum = $goods['billing_num'] * $goods_num; //总体积（立方米）

                //运费 = (首体积[立方米]*首费)+(续体积[立方米]*续费)；
                $totalFreight = self::getBilling($totalBillingNum, $freight['first_volume'], $freight['first_fee'], $freight['tocontinue_fee']);
            }
        }
        return $totalFreight;
    }

    /**
     * 统一计费方法
     * @param type $totalNum
     * @param type $firstNum
     * @param type $firstFee
     * @param type $tocontinueFee
     * @return type
     */
    public static function getBilling($totalNum = 0, $firstNum = 0, $firstFee = 0, $tocontinueFee = 0) {
        if ($totalNum <= $firstNum) {
            $first_num_all = $totalNum;
            $tocontinue_num_all = 0;
        } else {
            $first_num_all = $firstNum;
            $tocontinue_num_all = $totalNum - $firstNum;
        }
        $firstCost = $first_num_all * $firstFee;//首总费用
        $tocontinueCost = $tocontinue_num_all * $tocontinueFee;//续总费用
        $totalFreight = $firstCost + $tocontinueCost;//总费用
        return $totalFreight;
    }

}
