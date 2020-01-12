<?php

/**
 * 商品收藏信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Collection extends Commons {

    protected $pk = 'id';
    protected $name = "collection";

    public static function add($data) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        $info = self::getInfo(['goods_id' => $where['goods_id'], 'm_id' => $where['m_id']]);
        if ($info) {
            $state = !empty($info['state'] == 1) ? 2 : 1;
            $res = self::where(['id'=>$info['id']])->update(['state'=>$state]);
        }else{
            $res = self::add($data);
        }

        return $res;
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['c.is_show'] = 1;
        $where['c.state'] = 1;
        $order = ['c.id' => 'desc'];
        $join = [['mz_goods g', 'g.goods_id=c.goods_id', 'left']];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        $where['is_show'] = 1;
        return self::where($where)->count();
    }

}
