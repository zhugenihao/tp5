<?php

/**
 * 商品秒杀信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SecondsKill extends Commons {

    protected $pk = 'id';
    protected $name = "seconds_kill";

    public static function getSecondsKilllist($where = [], $start = 0, $limit = 10, $field = 's.*,g.goods_name,g.thecover,g.goods_price') {
        $where ['s.is_show'] = 1;
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field($field)->where($where)->order($order)->limit($start = 0, $limit = 10)->select()->toArray();
        return $list;
    }

    //今天某个时间段的秒杀商品
    public static function getSecondsKillTime($hours = '', $start = 0, $limit = 10) {
        $time = date('H') . ':00:00';
        $hours2 = !empty($hours) ? $hours : $time;
        $hours3 = !empty($hours2 == $time) ? date("H:i:s") : $hours;
        $seklWhere['s.every_day'] = 1;
        $seklWhere['s.start_time'] = array('elt', $hours2);
        $seklWhere['s.end_time'] = array('egt', $hours3);
        $list = self::getSecondsKilllist($seklWhere, $start, $limit);
        return $list;
    }

    public static function getSecondsKilllistPc($where = [], $limit = 10, $field = 's.*,g.goods_name,g.thecover,g.goods_price,g.number_payment') {
        $where ['s.is_show'] = 1;
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $map['query'] = [
        ];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    //今天某个时间段的秒杀商品
    public static function getSecondsKillTimePc($hours = '', $limit = 10) {
        $time = date('H') . ':00:00';
        $hours2 = !empty($hours) ? $hours : $time;
        $hours3 = !empty($hours2 == $time) ? date("H:i:s") : $hours;
        $seklWhere['s.every_day'] = 1;
        $seklWhere['s.start_time'] = array('elt', $hours2);
        $seklWhere['s.end_time'] = array('egt', $hours3);
        $list = self::getSecondsKilllistPc($seklWhere, $limit);
        return $list;
    }

    public static function getSecondsKillInfoTime($seklWhere = [], $hours = '') {
        $time = date('H') . ':00:00';
        $hours2 = !empty($hours) ? $hours : $time;
        $hours3 = !empty($hours2 == $time) ? date("H:i:s") : $hours;
        $seklWhere['every_day'] = 1;
        $seklWhere['start_time'] = array('elt', $hours2);
        $seklWhere['end_time'] = array('egt', $hours3);
        $info = self::getInfo($seklWhere);
        return $info;
    }

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->lock(true)->where($where)->find();
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
    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
