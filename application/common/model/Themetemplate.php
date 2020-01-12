<?php

/**
 * 品牌信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Themetemplate extends Commons {

    protected $pk = 'id';
    protected $name = "themetemplate";

    public static function getList($where = [], $limit = 50) {
        $where['is_show'] = 1;
        $map['query'] = [
        ];
        $list = self::where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
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
