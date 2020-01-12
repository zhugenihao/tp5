<?php

/**
 * 聊天在线状态信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class KefuMemberOnline extends Commons {

    protected $pk = 'id';
    protected $name = "kefu_member_online";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = input('search', '', 'trim');
        if (!empty($search)) {
            $where['content'] = array('like', "%" . $search . "%");
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
