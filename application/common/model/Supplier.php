<?php

/**
 * 首页模块信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Supplier extends Commons {

    protected $pk = 'id';
    protected $name = "supplier";

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['supplier_name|contact_name|contact_phone'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
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
