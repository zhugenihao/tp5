<?php

/**
 * 店铺信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use app\index\model\Store as storeModel;
use app\index\model\Category as categoryModel;
use app\index\model\Advert as advertModel;
use app\index\model\Goods as goodsModel;
use app\index\model\BusinessCategory as businessCategoryModel;

class Store extends Common {

    public $store_id = 0;

    public function _initialize() {
        parent::_initialize();
        $this->store_id = input('store_id');
        $this->assign("store", storeModel::get($this->store_id));
        $category = categoryModel::getCategorylist(['store_id' => $this->store_id, 'equipment' => 2], '*', 10);
        $this->assign('category', $category);
    }

    public function index() {
        $store_id = $this->store_id;
        $advert = advertModel::getList(['store_id' => $store_id, 'dire' => ['neq', ''], 'device_type' => 1], 5, "*");
        $this->assign('advert', $advert);

        $bCategory = businessCategoryModel::getListGroup(['store_id' => $store_id], "directory1_id", "*", 0, 10)->toArray();

        foreach ($bCategory as $key => $val) {
            $bCategory[$key]['bCategory2'] = businessCategoryModel::getListGroup(['store_id' => $store_id,
                        'directory1_id' => $val['directory1_id']], "directory2_id", "*", 0, 10)->toArray();
            foreach ($bCategory[$key]['bCategory2'] as $key2 => $val2) {
                $bCategory[$key]['bCategory2'][$key2]['bCategory3'] = businessCategoryModel::getListGroup(['store_id' => $store_id,
                            'directory2_id' => $val2['directory2_id']], "directory3_id", "*", 0, 10)->toArray();
            }
        }

        $this->assign('bCategory', $bCategory);

        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $goods = goodsModel::getGoodsListPc(['store_id' => $store_id], $field, 20, ['sales' => 'desc']);
        $recommendGoods = goodsModel::getGoodsListPc(['store_id' => $store_id, 'recommended' => 1], $field, 5, ['sales' => 'desc']);
        $this->assign('recommendGoods', $recommendGoods['list']);
        $this->assign('goods', $goods['list']);
        $this->assign('page', $goods['list']->render());
        return $this->fetch();
    }

    public function category_index() {
        $store_id = $this->store_id;
        $this->cacheDirId();
        $cat_id = session('cat_id');
        $directory1_id = session('directory1_id');
        $directory2_id = session('directory2_id');
        $directory3_id = session('directory3_id');
        $type = input('type');
        $categoryInfo = categoryModel::getInfo(['store_id' => $store_id, 'cat_id' => $cat_id], '*');

        $dirIdStr = '';
        $categoryTitle = '';
        if ($cat_id || $directory1_id) {//大类目查询
            $directory1_name = businessCategoryModel::getValue(['store_id' => $store_id, 'directory1_id' => $directory1_id], 'directory1_name');
            $categoryTitle = !empty($cat_id) ? $categoryInfo['cat_name'] : $directory1_name;
            $directory1_id = !empty($cat_id) ? $categoryInfo['dir_id'] : $directory1_id;
            $businessCategory = businessCategoryModel::getList(['store_id' => $store_id, 'directory1_id' => $directory1_id], '*');
            foreach ($businessCategory as $val) {
                $dirIdStr .= $val['directory3_id'] . ',';
            }
        }
        if ($directory2_id) {//二级类目查询
            $categoryTitle = businessCategoryModel::getValue(['store_id' => $store_id, 'directory2_id' => $directory2_id], 'directory2_name');
            $businessCategory = businessCategoryModel::getList(['store_id' => $store_id, 'directory2_id' => $directory2_id], '*');
            foreach ($businessCategory as $val) {
                $dirIdStr .= $val['directory3_id'] . ',';
            }
        }
        if ($directory3_id) {//三级类目查询
            $categoryTitle = businessCategoryModel::getValue(['store_id' => $store_id, 'directory3_id' => $directory3_id], 'directory3_name');
            $businessCategory = businessCategoryModel::getList(['store_id' => $store_id, 'directory3_id' => $directory3_id], '*');
            foreach ($businessCategory as $val) {
                $dirIdStr .= $val['directory3_id'] . ',';
            }
        }
        $order = ['sales' => 'desc'];
        if ($type == 'sales') {
            $order = ['sales' => 'desc'];
        }
        if ($type == 'high-low') {
            $order = ['goods_price' => 'desc'];
        }
        if ($type == 'low-high') {
            $order = ['goods_price' => 'asc'];
        }

        $this->assign('categoryTitle', $categoryTitle);
        $this->assign('type', $type);

        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $goods = goodsModel::getGoodsListPc(['store_id' => $store_id, 'dir_id' => ['in', $dirIdStr]], $field, 20, $order);
        $goodsList_er = $goods['list']->toArray();
        if ($type == 'goodwill' && $goodsList_er['total'] > 0) {
            $goodslist = array_sort($goodsList_er['data'], "givealike_count");
            $goodsList_er['data'] = $goodslist;
        }
        $this->assign('goods', $goodsList_er['data']);
        $this->assign('page', $goods['list']->render());

        return $this->fetch();
    }

    /**
     * 类目id缓存
     */
    public function cacheDirId() {
        $i_cat_id = input('cat_id');
        $i_directory1_id = input('directory1_id');
        $i_directory2_id = input('directory2_id');
        $i_directory3_id = input('directory3_id');
        if ($i_cat_id) {
            session('cat_id', $i_cat_id);
            session('directory1_id', null);
            session('directory2_id', null);
            session('directory3_id', null);
        }
        if ($i_directory1_id) {
            session('cat_id', null);
            session('directory1_id', $i_directory1_id);
            session('directory2_id', null);
            session('directory3_id', null);
        }
        if ($i_directory2_id) {
            session('cat_id', null);
            session('directory1_id', null);
            session('directory2_id', $i_directory2_id);
            session('directory3_id', null);
        }
        if ($i_directory3_id) {
            session('cat_id', null);
            session('directory1_id', null);
            session('directory2_id', null);
            session('directory3_id', $i_directory3_id);
        }
    }

}
