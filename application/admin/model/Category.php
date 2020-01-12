<?php

/**
 * 首页模块信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use app\admin\model\Directory as directoryModel;
use \think\Db;
use \think\Image;

class Category extends Commons {

    protected $pk = 'cat_id';
    protected $name = "category";

    public static function getCategorylist($limit, $field = '*', $where = []) {
        $search = trim(input('search'));
        $equipment = trim(input('equipment'));
        if (!empty($search)) {
            $where['cat_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($equipment)) {
            $where['equipment'] = $equipment;
        }
        $map['query'] = [
            'search' => $search,
            'equipment' => $equipment,
        ];
        $order = [
            'sort' => 'asc',
            'create_time' => 'desc',
        ];
        $join = [
            ["mz_directory d", 'd.id=c.dir_id', 'LEFT'],
        ];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->join($join)->field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function categoryAddmd() {
        $post = input('post.');
        $file = request()->file("icon");
        $icon = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/category/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/category/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $image = Image::open($PATH . $info->getSaveName());
                $image->thumb(50, 50)->save($PATH . $info->getSaveName(), null, 80); //图片压缩

                $icon = '/images/category/' . $info->getSaveName();
            } else {
                Tiperror("模块添加失败！", $file->getError());
            }
        }
        $methods = $post['methods'];
        if (!empty($post['dir_id'])) {
            $value = !empty($post['equipment'] == 1) ? "home_template_m" : "home_template_p";
            $methods = directoryModel::getValue(['id' => $post['dir_id']], $value);
        }
        $data = [
            'cat_name' => $post['cat_name'],
            'methods' => $methods,
            'equipment' => $post['equipment'],
            'is_newwindow' => $post['is_newwindow'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'icon' => $icon,
            'small_icon' => $post['small_icon'],
            'dir_id' => $post['dir_id'],
            'create_time' => time(),
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

    public static function categoryEditmd() {
        $post = input('post.');
        $file = request()->file("icon");
        $icon = $post['icon'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/category/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/category/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $image = Image::open($PATH . $info->getSaveName());
                $image->thumb(50, 50)->save($PATH . $info->getSaveName(), null, 80); //图片压缩

                $icon = self::where('cat_id', $post['cat_id'])->value('icon');
                if ($icon) {
                    if (file_exists(ROOT_PATH . "public/static/" . $icon)) {
                        unlink(ROOT_PATH . "public/static/" . $icon);
                    }
                }
                $icon = '/images/category/' . $info->getSaveName();
            } else {
                Tiperror("模块添加失败！", $file->getError());
            }
        }
        $methods = $post['methods'];
        if (!empty($post['dir_id'])) {
            $value = !empty($post['equipment'] == 1) ? "home_template_m" : "home_template_p";
            $methods = directoryModel::getValue(['id' => $post['dir_id']], $value);
        }
        $data = [
            'cat_id' => $post['cat_id'],
            'cat_name' => $post['cat_name'],
            'methods' => $methods,
            'equipment' => $post['equipment'],
            'is_newwindow' => $post['is_newwindow'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'icon' => $icon,
            'small_icon' => $post['small_icon'],
            'dir_id' => $post['dir_id'],
            'create_time' => time(),
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
