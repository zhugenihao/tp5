<?php

/**
 * 店铺结算记录信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\Order as orderModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Store as storeModel;
use app\common\model\Goods as goodsModel;
use app\common\model\BusinessCategory as businessCategoryModel;
use app\common\model\Seller as sellerModel;
use app\common\model\TotalPlatform as totalPlatformModel;

class StoreSettlement extends Commons {

    protected $pk = 'id';
    protected $name = "store_settlement";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $start_time = strtotime(input('start_time'));
        $end_time = strtotime(input('end_time'));
        if (!empty($search)) {
            $where['store_name|order_no'] = array('like', "%" . $search . "%");
        }
        if (!empty($start_time)) {
            $where['create_time'] = ['>= time', $start_time];
        }
        if (!empty($end_time)) {
            $where['create_time'] = ['<= time', $end_time];
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where['create_time'] = ['between', [$start_time, $end_time]];
        }
        $map['query'] = [
            'search' => $search,
            'start_time' => $start_time, 'end_time' => $end_time,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    /**
     * 添加结算记录
     */
    public static function addSettlement($order_no = '') {
        $order = orderModel::getInfo(['order_no' => $order_no]);
        $store = storeModel::getInfo(['id' => $order['store_id']]);
        $orderGoods = orderGoodsModel::getOrderGoodsInfo(['order_no' => $order_no]);
        $goods = goodsModel::getInfo(['goods_id' => $orderGoods['goods_id']]);
        $platformasa = businessCategoryModel::getValue(['directory3_id' => $goods['dir_id'], 'store_id' => $store['id']], 'commission_rate');

        $platforme_amount = $order['total_price'] * ($platformasa / 100); //平台抽成金额
        $shouldbe_amount = $order['total_price'] - $platforme_amount; //店铺应获金额

        $data = ['order_no' => $order_no, 'store_id' => $store['id'], 'store_name' => $store['store_name'],
            'total_price' => $order['total_price'], 'courier_price' => $order['courier_price'], 'platformasa' => $platformasa,
            'platforme_amount' => $platforme_amount, 'shouldbe_amount' => $shouldbe_amount, 'create_time' => time()];

        $res = self::create($data);
        if ($res) {
            //店铺进钱
            sellerModel::setIncs(['id' => $store['seller_id']], 'seller_forehead', $shouldbe_amount);
            //平台进钱
            totalPlatformModel::setIncs(['id' => 1], 'total_balance', $platforme_amount);
            return true;
        } else {
            return false;
        }
    }

}
