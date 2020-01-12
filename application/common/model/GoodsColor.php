<?php

/**
 * 商品颜色
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class GoodsColor extends Commons {

    protected $pk = 'id';
    protected $name = "goods_color";

    public static function getGoodsColor($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['color_show'] = 1;
        $order = ['sort' => 'asc', 'id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

}
