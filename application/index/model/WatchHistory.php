<?php

/**
 * 商品足迹信息
 */

namespace app\index\model;

use app\common\model\WatchHistory as watchHistoryModel;
use \think\Db;

class WatchHistory extends watchHistoryModel {

    

    public static function getListPc($where = [], $field = '*', $limit = 10) {
        $where['w.is_show'] = 1;
        $order = ['w.id' => 'desc'];
        $map['query'] = [
        ];
        $join = [['mz_goods g', 'g.goods_id=w.goods_id', 'left']];
        $list['count'] = self::alias('w')->join($join)->where($where)->count();
        $list['list'] = self::alias('w')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }


}
