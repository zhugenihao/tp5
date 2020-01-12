<?php

/**
 * 购买余额币信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Buyseecoinlist extends Commons {

    protected $pk = 'id';
    protected $name = "buyseecoinlist";

    public static function getBuyseecoinlist($limit = 20) {
        $search = trim(input('search'));
        $where = [];
        if (!empty($search)) {
            $where['cash'] = $search;
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['sort' => 'asc', 'create_time' => 'asc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function buyseecoinlistAddeditmd() {
        $post = input('post.');
        $id = (int) ($post['id']);
        $data = [
            'cash' => $post['cash'],
            'seecoin' => $post['seecoin'],
            'readingnotes' => $post['readingnotes'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'create_time' => time(),
        ];
        if ($data) {
            if ($id) {
                $result = self::where(['id' => $id])->update($data);
            } else {
                $result = self::insert($data);
            }
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
