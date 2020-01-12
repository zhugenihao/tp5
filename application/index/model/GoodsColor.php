<?php

/**
 * 商品颜色
 */

namespace app\index\model;

use app\common\model\GoodsColor as goodsColorModel;
use \think\Db;
use app\common\model\Directory as directoryModel;

class GoodsColor extends goodsColorModel {

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $directory3_id = trim(input('directory3_id'));
        if (!empty($search)) {
            $where['color_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($directory3_id)) {
            $where['directory3_id'] = $directory3_id;
        }
        $map['query'] = [
            'search' => $search,
            'directory3_id' => $directory3_id,
        ];
        $list = self::field($field)->where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getGoodsColor($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['color_show'] = 1;
        $order = ['sort' => 'asc', 'id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function goodsColorAdd($store_id = 0) {
        $post = input('post.');
        $directory1 = directoryModel::get($post['directory1_id']);
        $directory2 = directoryModel::get($post['directory2_id']);
        $directory3 = directoryModel::get($post['directory3_id']);
        $data = [
            'store_id' => $store_id,
            'color_name' => $post['color_name'],
            'color_show' => $post['color_show'],
            'directory1_id' => $post['directory1_id'],
            'directory2_id' => $post['directory2_id'],
            'directory3_id' => $post['directory3_id'],
            'directory1_name' => $directory1['title'],
            'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'],
            'sort' => $post['sort'],
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

    public static function goodsColorEdit() {
        $post = input('post.');
        $directory1 = directoryModel::get($post['directory1_id']);
        $directory2 = directoryModel::get($post['directory2_id']);
        $directory3 = directoryModel::get($post['directory3_id']);
        $data = [
            'color_name' => $post['color_name'],
            'color_show' => $post['color_show'],
            'directory1_id' => $post['directory1_id'],
            'directory2_id' => $post['directory2_id'],
            'directory3_id' => $post['directory3_id'],
            'directory1_name' => $directory1['title'],
            'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'],
            'sort' => $post['sort'],
            'create_time' => time(),
        ];
        if ($data) {
            $result = self::where(['id' => $post['id']])->update($data);
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
