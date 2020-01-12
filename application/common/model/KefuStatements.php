<?php

/**
 * 常用语句信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class KefuStatements extends Commons {

    protected $pk = 'id';
    protected $name = "kefu_statements";

    public static function add($data = []) {
        return self::create($data);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = input('search', '', 'trim');
        $is_show = input('is_show', '', 'intval');
        if (!empty($search)) {
            $where['content'] = array('like', "%" . $search . "%");
        }
        if (!empty($is_show)) {
            $where['is_show'] = $is_show;
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
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

    public static function kefuStatementsAddMd($store_id = 0) {
        $post = input('post.');
        $data = ['content' => $post['content'], 'is_show' => $post['is_show'],
            'store_id' => $store_id, 'create_time' => time()];
        if ($data) {
            $res = self::create($data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function kefuStatementsEditMd() {
        $post = input('post.');
        $data = ['content' => $post['content'], 'is_show' => $post['is_show'],
            'create_time' => time()];
        if ($data) {
            $res = self::where(['id' => $post['kstem_id']])->update($data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
