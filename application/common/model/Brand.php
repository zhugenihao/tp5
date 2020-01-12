<?php

/**
 * 品牌信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Brand extends Commons {

    protected $pk = 'id';
    protected $name = "Brand";

    public static function brandAddMd($store_id = 0) {
        $post = input('post.');
        $data = [
            'brand_name' => $post['brand_name'], 'brand_url' => $post['brand_url'], 'sort' => $post['sort'],
            'store_id' => $store_id, 'is_show' => $post['is_show'], 'describe' => $post['describe'],
            'create_time' => time(),
        ];
        $file = request()->file("brand_logo");
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/brandimg');
            if ($info) {
                $data['brand_logo'] = "/images/brandimg/" . $info->getSaveName();
            } else {
                Tiperror("添加失败！", $file->getError());
            }
        }
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

    public static function brandEditMd() {
        $post = input('post.');
        $file = request()->file("brand_logo");
        $brand_logo = $post['brand_logo'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/brandimg');
            if ($info) {
                $get_brand_logo = self::where(['id' => $post['brand_id']])->value('brand_logo');
                if (!empty($get_brand_logo)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_brand_logo)) {
                        unlink(ROOT_PATH . "public/static/" . $get_brand_logo);
                    }
                }
                $brand_logo = "/images/brandimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data = [
            'id' => $post['brand_id'],
            'brand_name' => $post['brand_name'], 'brand_url' => $post['brand_url'], 'sort' => $post['sort'],
            'brand_logo' => $brand_logo, 'is_show' => $post['is_show'], 'describe' => $post['describe'],
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

    public static function getBrandList($where = [], $limit = 50) {
        $search = trim(input('search'));
        $is_show = trim(input('is_show'));
        if (!empty($search)) {
            $where['brand_name'] = array('like', "%" . $search . "%");
        }
        if ($is_show != '') {
            $where['is_show'] = $is_show;
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
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
