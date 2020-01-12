<?php

/**
 * 商品足迹信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class WatchHistory extends Commons {

    protected $pk = 'id';
    protected $name = "watch_history";

    public static function add($data) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['w.is_show'] = 1;
        $order = ['w.id' => 'desc'];
        $join = [['mz_goods g', 'g.goods_id=w.goods_id', 'left']];
        $list['count'] = self::alias('w')->join($join)->where($where)->count();
        $list['list'] = self::alias('w')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function getInfo($id) {
        return self::where(['id' => $id])->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        $where['is_show'] = 1;
        return self::where($where)->count();
    }

}
