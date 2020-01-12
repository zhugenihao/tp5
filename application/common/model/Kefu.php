<?php

/**
 * 客服信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Kefu extends Commons {

    protected $pk = 'id';
    protected $name = "kefu";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $kefu_type = trim(input('kefu_type'));
        if (!empty($search)) {
            $where['kefu_name|kefu_account'] = array('like', "%" . $search . "%");
        }
        if (!empty($kefu_type)) {
            $where['kefu_type'] = $kefu_type;
        }
        
        $map['query'] = [
            'search' => $search,
            'kefu_type' => $kefu_type,
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
