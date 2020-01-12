<?php

/**
 * 促销信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class ComdysalesPromotion extends Commons {

    protected $pk = 'id';
    protected $name = "comdysales_promotion";

    public static function addMd($store_id = 0) {
        $post = input('post.');
        $data = [
            'cp_name' => $post['cp_name'], 'goods_id' => $post['goods_id'], 'cp_price' => $post['cp_price'],
            'cp_num' => $post['cp_num'], 'start_time' => $post['start_time'], 'end_time' => $post['end_time'],
            'store_id' => $store_id, 'is_show' => $post['is_show'], 'description' => $post['description'],
            'cp_type' => $post['cp_type'], 'discount' => $post['discount'],
            'sort' => $post['sort'], 'create_time' => time(),
        ];
        if (!$post['cp_name'] || !$post['goods_id'] || !$post['cp_num'] || !$post['start_time'] ||
                !$post['end_time'] || !$post['description']) {
            Tiperror("促销名称、商品、限购数量、开始时间、结束时间、品牌描述缺一不可！");
        }
        $file = request()->file("cp_img");
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/cpimg');
            if ($info) {
                $data['cp_img'] = "/images/cpimg/" . $info->getSaveName();
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

    public static function editMd() {
        $post = input('post.');
        $file = request()->file("cp_img");
        $cpimg = $post['cp_img'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/cpimg');
            if ($info) {
                $get_cpimg = self::where(['id' => $post['id']])->value('cp_img');
                if (!empty($get_cpimg)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_cpimg)) {
                        unlink(ROOT_PATH . "public/static/" . $get_cpimg);
                    }
                }
                $cpimg = "/images/cpimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data = [
            'id' => $post['id'],
            'cp_name' => $post['cp_name'], 'goods_id' => $post['goods_id'], 'cp_price' => $post['cp_price'],
            'cp_num' => $post['cp_num'], 'start_time' => $post['start_time'], 'end_time' => $post['end_time'],
            'is_show' => $post['is_show'], 'description' => $post['description'], 'cp_type' => $post['cp_type'],
            'discount' => $post['discount'], 'cp_img' => $cpimg,
            'sort' => $post['sort'], 'create_time' => time(),
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

    public static function getList($where = [], $limit = 50) {
        $search = trim(input('search'));
        $is_show = trim(input('is_show'));
        if (!empty($search)) {
            $where['cp_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($is_show)) {
            $where['c.is_show'] = $is_show;
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
        ];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [
            ["mz_goods g", 'g.goods_id=c.goods_id', 'left'],
            ["mz_store s", 's.id=c.store_id', 'left']
        ];
        $list = self::alias('c')->join($join)
                        ->field("c.*,g.goods_name,g.thecover,g.goods_price,s.store_name")->where($where)->order($order)->paginate($limit, false, $map);
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
