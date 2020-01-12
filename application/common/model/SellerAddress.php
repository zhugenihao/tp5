<?php

/**
 * 首页模块信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SellerAddress extends Commons {

    protected $pk = 'id';
    protected $name = "seller_address";


    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $address_type = trim(input('address_type'));
        if (!empty($search)) {
            $where['contact_name|mobile|zip_code'] = array('like', "%" . $search . "%");
        }
        if (!empty($address_type)) {
            $where['address_type'] = $address_type;
        }
        $map['query'] = [
            'search' => $search,
            'address_type' => $address_type,
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
