<?php
/**
 * 区域信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class OnethinkDistrict extends Commons {

    protected $pk = 'id';
    protected $name = "onethink_district";

    public static function getList($where = [], $field = '*', $limit = 10) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = ['search' => $search,'upid'=>input('upid')];
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }
    public static function getLister($where = [], $field = '*', $start = 0, $limit = 100) {
        $where['is_show'] = 1;
        $order = ['id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function add() {
        $post = input('post.');
        $data = [
            'name' => $post['name'],
            'is_show' => $post['is_show'],
            'level' => $post['level'],
            'upid' => $post['upid'],
            'sort' => $post['sort'],
        ];
        if ($data) {
            $result = self::insert($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function updates() {
        $post = input('post.');
        $data = ['id' => $post['id'], 'name' => $post['name'], 'is_show' => $post['is_show'],
            'level' => $post['level'], 'upid' => $post['upid'], 'sort' => $post['sort'],
        ];
        if ($data) {
            $result = self::update($data);
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
