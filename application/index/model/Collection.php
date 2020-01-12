<?php

/**
 * 商品收藏信息
 */

namespace app\index\model;

use app\common\model\Collection as collectionModel;
use \think\Db;

class Collection extends collectionModel {

  
    public static function getListPc($where = [], $field = '*', $limit = 10) {
        $where['c.is_show'] = 1;
        $where['c.state'] = 1;
        $order = ['c.id' => 'desc'];
        $map['query'] = [
        ];
        $join = [['mz_goods g', 'g.goods_id=c.goods_id', 'left']];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

}
