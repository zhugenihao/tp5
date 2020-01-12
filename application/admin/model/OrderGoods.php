<?php
/**
 * 商品订单信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class OrderGoods extends Commons {

    protected $pk = 'id';
    protected $name = "order_goods";

    public function goods() {
        return $this->hasOne('Goods', 'goods_id', 'goods_id')->field('goods_id,goods_name,goods_sku,thecover');
    }

    public function payment() {
        return $this->hasOne('Payment', 'payment_mark', 'payment_type')->field('payment_name,payment_mark');
    }

    public static function sums($where = [], $value = 'total_price') {
        return self::where($where)->sum($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }
    public static function getDelete($where=[]){
        return self::where($where)->delete();
    }

}
