<?php

/**
 * 用户出入账信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class RecordBooks extends Commons {

    protected $pk = 'id';
    protected $name = "record_books";

    public static function add($data) {
        return self::create($data);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['id' => 'desc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }
    public static function getListPc($where = [], $field = '*', $limit = 10) {
        $order = ['id' => 'desc'];
        $map['query'] = [
            'type'=>input('type'),
            'books_type'=>input('books_type')
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
