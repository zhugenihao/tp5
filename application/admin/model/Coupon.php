<?php

/**
 * 优惠券信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Coupon extends Commons {

    protected $pk = 'cop_id';
    protected $name = "coupon";

    public static function getCouponlist($limit,$where = []) {
        $search = trim(input('search'));
        $type = trim(input('type'));
        if (!empty($search)) {
            $where['c.cop_name|g.goods_name|s.store_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($type)) {
            $where['c.type'] = $type;
        }
        $map['query'] = ['search' => $search, 'type' => $type];
        $order = ['copb_time' => 'desc'];
        $join = [
            ["mz_goods g", 'g.goods_id=c.type_id', 'left'],
            ["mz_store s", 's.id=c.type_id', 'left']
        ];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->join($join)
                        ->field("c.*,g.goods_name,g.thecover,g.goods_price,s.store_name")->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function getInfo($where = [], $field = "*") {
        $join = [
            ["mz_goods g", 'g.goods_id=c.type_id', 'left'],
            ["mz_store s", 's.id=c.type_id', 'left']
        ];
        $info = self::alias('c')->field($field)->join($join)->where($where)->find();
        return $info;
    }

    /*
     * 添加优惠券
     */

    public static function couponAddmd() {
        $post = input('post.');
        $typeId = !empty($post['type'] == 1) ? $post['goods_id'] : $post['store_id'];
        $data = [
            'cop_name' => $post['cop_name'], 'type_id' => $typeId, 'cop_num' => $post['cop_num'], 'cop_price' => $post['cop_price'],
            'type' => $post['type'], 'copa_time' => $post['copa_time'], 'copb_time' => $post['copb_time'], 'cop_show' => $post['cop_show'],
            'full_amount' => $post['full_amount'],
        ];
        $typeGoods = self::where(['type_id' => $post['goods_id'], 'type' => 1])->find();
        $typeStore = self::where(['type_id' => $post['store_id'], 'type' => 2])->find();
        if ($typeGoods['cop_price'] == $post['cop_price'] || $typeStore['cop_price'] == $post['cop_price']) {
            Tiperror("优惠券已存在，请直接编辑！");
        }
        if (!$post['cop_name'] || !$typeId || !$post['cop_num'] || !$post['cop_price'] ||
                !$post['copa_time'] || !$post['copb_time'] || !$post['full_amount']) {
            Tiperror("优惠券名称、商铺或商品、优惠券数量、金额、开始时间、结束时间、满足金额都缺一不可！");
        }
        if ($post['copa_time'] >= $post['copb_time']) {
            Tiperror("开始时间不能大于结束时间！");
        }
        $file = request()->file("cop_img");
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/cop_img');
            if ($info) {
                $data['cop_img'] = "/images/cop_img/" . $info->getSaveName();
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

    /*
     * 编辑商品优惠券
     */

    public static function couponEditmd() {
        $post = input('post.');
        $typeId = !empty($post['type'] == 1) ? $post['goods_id'] : $post['store_id'];
        $data = [
            'cop_id' => $post['cop_id'],
            'cop_name' => $post['cop_name'], 'type_id' => $typeId, 'cop_num' => $post['cop_num'], 'cop_price' => $post['cop_price'],
            'type' => $post['type'], 'copa_time' => $post['copa_time'], 'copb_time' => $post['copb_time'], 'cop_show' => $post['cop_show'],
            'full_amount' => $post['full_amount'],
        ];
        $typeGoods = self::where(['type_id' => $post['goods_id'], 'type' => 1])->find();
        $typeStore = self::where(['type_id' => $post['store_id'], 'type' => 2])->find();
        if (!($typeGoods['cop_id'] == $post['cop_id'] || $typeStore['cop_id'] == $post['cop_id'])) {
            if ($typeGoods['cop_price'] == $post['cop_price'] || $typeStore['cop_price'] == $post['cop_price']) {
                Tiperror("优惠券已存在，请直接编辑！");
            }
        }
        if (!$post['cop_name'] || !$typeId || !$post['cop_num'] || !$post['cop_price'] ||
                !$post['copa_time'] || !$post['copb_time'] || !$post['full_amount']) {
            Tiperror("优惠券名称、商铺或商品、优惠券数量、金额、开始时间、结束时间、满足金额都缺一不可！");
        }
        if ($post['copa_time'] >= $post['copb_time']) {
            Tiperror("开始时间不能大于结束时间！");
        }
        $file = request()->file("cop_img");
        $copimg = $post['cop_img'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/cop_img');
            if ($info) {
                $get_cop_img = self::where(['cop_id' => $post['cop_id']])->value('cop_img');
                if (!empty($get_cop_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_cop_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_cop_img);
                    }
                }
                $copimg = "/images/cop_img/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data['cop_img'] = $copimg;
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
