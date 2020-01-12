<?php

/**
 * 首页模块信息
 */

namespace app\index\model;

use app\common\model\Category as categoryModel;
use \think\Db;

class Category extends categoryModel {

    public static function categoryAddMd($store_id = 0) {
        $post = input('post.');
        $data = ['cat_name' => $post['cat_name'], 'cat_link' => $post['cat_link'], 'sort' => $post['sort'],
            'description' => $post['description'], 'is_newwindow' => $post['is_newwindow'], 'store_id' => $store_id,
            'dir_id' => $post['dir_id'], 'is_show' => $post['is_show'], 'equipment' => $post['equipment'],
            'create_time' => time()];
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

    public static function categoryEditMd() {
        $post = input('post.');
        $data = ['cat_name' => $post['cat_name'], 'cat_link' => $post['cat_link'], 'sort' => $post['sort'],
            'description' => $post['description'], 'is_newwindow' => $post['is_newwindow'],
            'dir_id' => $post['dir_id'], 'is_show' => $post['is_show'], 'equipment' => $post['equipment'],
            'create_time' => time()];
        if ($data) {
            $res = self::where(['cat_id' => $post['cat_id']])->update($data);
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
