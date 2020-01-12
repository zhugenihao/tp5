<?php

/**
 * 商品库存信息
 */

namespace app\index\model;

use app\common\model\Inventory as inventoryModel;
use app\common\model\Goods as goodsModel;
use \think\Db;

class Inventory extends inventoryModel {

    public static function getSellerList($where = [], $field = '*', $start = 0, $limit = 10) {
        $join = [
            ['mz_norm no', 'no.n_id=in.n_id', 'left'],
        ];
        $res = self::alias('in')->join($join)->field($field)->where($where)->order("id", 'asc')->limit($start, $limit)->select();
        return $res;
    }

    public static function getSellerAjaxaList($where = [], $field = '*', $start = 0, $limit = 10) {
        $join = [
            ['mz_norm no', 'no.n_id=in.n_id', 'left'],
            ['mz_cates ct', 'ct.cate_id=in.cate_id', 'left'],
            ['mz_goods_color gc', 'gc.id=no.goodscolor_id', 'left'],
        ];
        $res = self::alias('in')->join($join)->field($field)->where($where)->order("id", 'asc')->limit($start, $limit)->select();
        return $res;
    }


}
