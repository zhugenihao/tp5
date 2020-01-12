<?php

/**
 * 首页模块信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Category extends Commons {

    protected $pk = 'cat_id';
    protected $name = "category";

    public static function getCategorylist($where = [], $field = '*', $limit = 20) {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select()->toArray();
//        print_R($list);
        return $list;
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $is_show = trim(input('is_show'));
        $equipment = trim(input('equipment'));
        if (!empty($search)) {
            $where['cat_name'] = array('like', "%" . $search . "%");
        }
        if ($is_show != '') {
            $where['is_show'] = $is_show;
        }
        if (!empty($equipment)) {
            $where['equipment'] = $equipment;
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
            'equipment' => $equipment,
        ];
        $list = self::field($field)->where($where)->order(['sort' => 'asc', 'cat_id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'cat_id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
