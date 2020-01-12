<?php

/**
 * 拼团信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SpellGroup extends Commons {

    protected $pk = 'id';
    protected $name = "SpellGroup";

    public static function getSpellGrouplist($where = [], $start = 0, $limit = 10, $field = "s.*,g.goods_name,g.thecover,g.goods_price") {
        $where['s.is_show'] = 1;
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }
    public static function getSpellGrouplistPc($where = [], $limit = 10, $field = "s.*,g.goods_name,g.thecover,g.goods_price,g.number_payment") {
        $where['s.is_show'] = 1;
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $map['query'] = [
        ];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }
    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->lock(true)->where($where)->find();
    }
    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getValue($where = [], $value = '') {
        return self::lock(true)->where($where)->value($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }
    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }


}
