<?php

/**
 * 商品点赞信息
 */

namespace app\index\model;

use \think\Db;
use app\common\model\Givealike as givealikeModel;

class Givealike extends givealikeModel {

    public static function getListPc($where = [], $field = '*', $limit = 10) {
        $where['givealike'] = 1;
        $order = ['gl.id' => 'desc'];
        $map['query'] = [
        ];
        $join = [['mz_goods g', 'g.goods_id=gl.goods_id', 'left']];
        $list['count'] = self::alias('gl')->join($join)->where($where)->count();
        $list['list'] = self::alias('gl')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }


}
