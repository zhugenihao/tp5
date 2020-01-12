<?php

/**
 * 促销信息
 */

namespace app\api\model;

use app\common\model\ComdysalesPromotion as comdysalesPromotionModel;
use \think\Db;

class ComdysalesPromotion extends comdysalesPromotionModel {

    public static function getMobileList($where = [], $start = 0, $limit = 10, $field = "c.*,g.goods_name,g.thecover,g.goods_price,g.number_payment") {
        $where['c.is_show'] = 1;
        $order = ['c.sort' => 'asc', 'c.create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=c.goods_id', 'left']];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->join($join)
                        ->field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

}
