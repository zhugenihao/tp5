<?php

/**
 * 商品版本信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\admin\model\Directory as directoryModel;

class Cates extends Commons {

    protected $pk = 'cate_id';
    protected $name = "cates";

    public static function getCatesList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $directory3_id = trim(input('directory3_id'));
        if (!empty($search)) {
            $where['cate_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($directory3_id)) {
            $where['directory3_id'] = $directory3_id;
        }
        $map['query'] = [
            'search' => $search,
            'directory3_id' => $directory3_id,
        ];
        $list = self::field($field)->where($where)->order(['sort' => 'asc', 'cate_id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'cate_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function catesAdd() {
        $post = input('post.');
        $directory1 = directoryModel::get($post['directory1_id']);
        $directory2 = directoryModel::get($post['directory2_id']);
        $directory3 = directoryModel::get($post['directory3_id']);
        $data = [
            'cate_name' => $post['cate_name'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'directory1_id' => $post['directory1_id'],
            'directory2_id' => $post['directory2_id'],
            'directory3_id' => $post['directory3_id'],
            'directory1_name' => $directory1['title'],
            'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'],
            'create_time' => time(),
        ];
        if ($data) {
            $result = self::create($data);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function catesEdit() {
        $post = input('post.');
        $directory1 = directoryModel::get($post['directory1_id']);
        $directory2 = directoryModel::get($post['directory2_id']);
        $directory3 = directoryModel::get($post['directory3_id']);
        $data = [
            'cate_name' => $post['cate_name'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'directory1_id' => $post['directory1_id'],
            'directory2_id' => $post['directory2_id'],
            'directory3_id' => $post['directory3_id'],
            'directory1_name' => $directory1['title'],
            'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'],
            'create_time' => time(),
        ];
        if ($data) {
            $result = self::where(['cate_id' => $post['cate_id']])->update($data);
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
