<?php

/**
 * 商家菜单信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SellerMenu extends Commons {

    protected $pk = 'id';
    protected $name = "seller_menu";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $is_show = trim(input('is_show'));
        $oneid = trim(input('oneid'));
        if (!empty($search)) {
            $where['menu_name|methods'] = array('like', "%" . $search . "%");
        }
        if (!empty($is_show)) {
            $where['is_show'] = $is_show;
        }
        if (!empty($oneid)) {
            $where['id'] = $oneid;
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
            'oneid' => $oneid,
        ];
        $list = self::field($field)->where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getMenuList($where = [], $limit = 30, $field = '*') {
        $where['is_show'] = 1;
        return self::field($field)->where($where)->limit($limit)->select();
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
