<?php

/**
 * 拼团支付数量信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SpellGroupOrdernum extends Commons {

    protected $pk = 'id';
    protected $name = "spell_group_ordernum";

    public static function add($data) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function createSpgOrdnum($where, $data) {
        $info = self::where($where)->find(); //信息是否已存在
        if (!empty($info)) {
            self::where($where)->update($data);
            $id = $info['id'];
        } else {
            $addSpgOrdnum = self::create($data);
            $id = $addSpgOrdnum->id;
        }
        return $id;
    }

    public static function getList($where = '', $field = '*', $start = 0, $limit = 10) {
//        $order = ['s.payment_time' => 'desc'];
//        $join = [
//            ['mz_member m', 'm.id=s.first_member_id', 'left'], //用户信息
//            ['mz_spell_group sg', 'sg.goods_id=s.goods_id', 'left'], //拼团信息
//        ];
//        $having = 'sg.sg_members_num > member_num';
//        $list['count'] = self::alias('s')->join($join)->group('s.first_member_id')->where($where)->having($having)->count();
//        $list['list'] = self::alias('s')->field($field)->join($join)->where($where)->group('s.first_member_id')->having($having)->order($order)->limit($start, $limit)->select()->toArray();
        $sql = "select {$field} from mz_spell_group_ordernum as s "
                . "left join mz_member as m on m.id=s.first_member_id "  //用户信息
                . "left join mz_spell_group as sg on sg.goods_id=s.goods_id "  //拼团信息
                . "where {$where} group by s.first_member_id having sg.sg_members_num > member_num order by s.payment_time asc limit {$start},{$limit}";

        $list['list'] = Db::query($sql);
        $list['count'] = count($list['list']);
        return $list;
    }

    public static function getSpgOrdnumList($where = [], $field = '*', $start = 0, $limit = 20) {
        $order = ['payment_time' => 'asc'];
        return self::field($field)->where($where)->order($order)->limit($start, $limit)->select();
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::lock(true)->where($where)->count();
    }

}
