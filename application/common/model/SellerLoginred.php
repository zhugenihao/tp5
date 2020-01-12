<?php

/**
 * 商家登陆日志
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SellerLoginred extends Commons {

    protected $pk = 'id';
    protected $name = "seller_loginred";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $start_time = strtotime(input('start_time'));
        $end_time = strtotime(input('end_time'));
        if (!empty($search)) {
            $where['seller_name|login_ip'] = array('like', "%" . $search . "%");
        }
        if (!empty($start_time)) {
            $where['create_time'] = ['>= time', $start_time];
        }
        if (!empty($end_time)) {
            $where['create_time'] = ['<= time', $end_time];
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where['create_time'] = ['between', [$start_time, $end_time]];
        }
        $map['query'] = [
            'search' => $search,
            'start_time' => $start_time, 'end_time' => $end_time,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
