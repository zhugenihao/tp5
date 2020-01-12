<?php

/**
 * 售后服务信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class ReturnsReplacement extends Commons {

    protected $pk = 'id';
    protected $name = "returns_replacement";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $state = trim(input('state'));
        if (!empty($search)) {
            $where['order_no|member_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($state)) {
            $where['state'] = $state;
        }
        $map['query'] = [
            'search' => $search,
            'state' => $state,
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
