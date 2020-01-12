<?php

/**
 * 商品信息
 */

namespace app\index\model;

use \think\Db;
use \think\Image;
use app\common\model\Goods as goodsModel;
use app\common\model\Givealike as civealikeModel;
use app\common\model\Norm as normModel;
use app\common\model\Inventory as inventoryModel;

class Goods extends goodsModel {

    public static function getGoodsSellerListPc($where = [], $field = '*', $limit = 10, $order = []) {
        $search = trim(input('search'));
        $recommended = trim(input('recommended'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        if ($recommended != '') {
            $where['recommended'] = $recommended;
        }
        $order['sort'] = 'asc';
        $order['create_time'] = 'desc';
        $list['count'] = self::where($where)->count();
        $map['query'] = [
            'search' => $search,
            'recommended' => $recommended,
        ];
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);

        foreach ($list['list'] as $key => $val) {
            $list['list'][$key]['givealike_count'] = civealikeModel::getCount(['goods_id' => $val['goods_id']]);
        }

        return $list;
    }

    public static function goodsAdd($store_id = 0) {
        $post = input('post.');
        $file = request()->file("thecover");
        $thecover = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/cover/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/cover/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            $image = Image::open($PATH . $info->getSaveName());
            $image->thumb(500, 500)->save($PATH . $info->getSaveName(), null, 80); //图片压缩
            if ($info) {
                $thecover = '/images/goods/cover/' . $info->getSaveName();
            } else {
                Tiperror("商品添加失败！", $file->getError());
            }
        }
        $setup_norm = isset($post['setup_norm']) ? $post['setup_norm'] : 'off';
        $data = [
            'billing_num' => $post['billing_num'],
            'billing_way' => $post['billing_way'],
            'store_id' => $store_id,
            'freight_id' => $post['freight_id'],
            'brand_id' => $post['brand_id'],
            'cost_price' => $post['cost_price'],
            'goods_price' => $post['goods_price'],
            'goods_stock' => $post['goods_stock'],
            'dir_id' => $post['directory_id'],
            'goods_name' => $post['goods_name'],
            'goods2_name' => $post['goods2_name'],
            'goods_sku' => $post['goods_sku'],
            'goods_desc' => $post['goods_desc'],
            'goods_desc2' => $post['goods_desc2'],
            'recommended' => $post['recommended'],
            'sort' => $post['sort'],
            'is_show' => $post['is_show'],
            'thecover' => $thecover,
            'region' => $post['region'],
            'sales' => $post['sales'],
            'setup_norm' => $setup_norm,
            'create_time' => time()
        ];
        if ($data) {
            $result = self::create($data);
            if ($result) {
                return $result->goods_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function goodsEdit() {
        $post = input('post.');
        $file = request()->file("thecover");
        $thecover = $post['thecover'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/cover/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/cover/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $thecover = self::where(['goods_id' => $post['goods_id']])->value('thecover');
                if (!empty($thecover)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $thecover)) {
                        unlink(ROOT_PATH . "public/static/" . $thecover);
                    }
                }
                $thecover = '/images/goods/cover/' . $info->getSaveName();
            } else {
                Tiperror("商品添加失败！", $file->getError());
            }
        }
        $setup_norm = isset($post['setup_norm']) ? $post['setup_norm'] : 'off';
        $data = [
            'billing_num' => $post['billing_num'],
            'billing_way' => $post['billing_way'],
            'freight_id' => $post['freight_id'],
            'brand_id' => $post['brand_id'],
            'cost_price' => $post['cost_price'],
            'goods_price' => $post['goods_price'],
            'goods_stock' => $post['goods_stock'],
            'dir_id' => $post['directory_id'],
            'goods_name' => $post['goods_name'],
            'goods2_name' => $post['goods2_name'],
            'goods_sku' => $post['goods_sku'],
            'goods_desc' => $post['goods_desc'],
            'goods_desc2' => $post['goods_desc2'],
            'recommended' => $post['recommended'],
            'sort' => $post['sort'],
            'is_show' => $post['is_show'],
            'thecover' => $thecover,
            'region' => $post['region'],
            'sales' => $post['sales'],
            'setup_norm' => $setup_norm,
            'create_time' => time()
        ];
        if ($data) {
            $result = self::where(['goods_id' => $post['goods_id']])->update($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //删除多余规格颜色
    public static function delRedundantNorm($goods_id = 0) {
        $norm = normModel::getList(['goods_id' => $goods_id]);
        $normIdArr = [];
        foreach ($norm as $val) {
            $inventory = inventoryModel::getCount(['goods_id' => $goods_id, 'n_id' => $val['n_id']]);
            if (!$inventory) {
                $normIdArr[] = $val['n_id'];
            }
        }
        //删除多余规格颜色
        normModel::destroy($normIdArr);
    }

}
