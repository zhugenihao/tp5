<?php

/**
 * 广告信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Advert extends Commons {

    protected $pk = 'adv_id';
    protected $name = "advert";

    public static function getAdvertlist($adt_mark = '', $ad_types = 1, $device_type = 1, $limit = 5, $field = '*') {
        $where = [
            'adv_show' => '1',
            'adt_mark' => $adt_mark, //轮播类型
            'ad_types' => $ad_types, //图片类型
            'device_type' => $device_type, //设备类型
        ];
        $order = ['sort' => 'asc', 'adv_id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    public static function getList($where = [], $limit = 5, $field = '*') {
        $where['adv_show'] = 1;
        $order = ['sort' => 'asc', 'adv_id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $where['adv_show'] = 1;
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        $where['adv_show'] = 1;
        return self::where($where)->value($value);
    }

}
