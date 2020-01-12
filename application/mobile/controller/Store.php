<?php

/**
 * 店铺信息
 */

namespace app\mobile\controller;

use app\mobile\controller\Common;
use app\common\model\Store as storeModel;
use app\common\model\Category as categoryModel;
use app\common\model\Advert as advertModel;
use app\common\model\Goods as goodsModel;
use app\common\model\BusinessCategory as businessCategoryModel;

class Store extends Common {

    public $store_id = 0;

    public function _initialize() {
        parent::_initialize();
        $this->store_id = input('store_id');
        $this->assign("store", storeModel::get($this->store_id));
        $category = categoryModel::getCategorylist(['store_id' => $this->store_id, 'equipment' => 1], '*', 10);
        $this->assign('category', $category);
    }

    public function index() {
        $store_id = $this->store_id;
        $advert = advertModel::getList(['store_id' => $store_id, 'dire' => ['neq', ''], 'device_type' => 2], 5, "*");
        $this->assign('advert', $advert);


        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $goods = goodsModel::getGoodsListPc(['store_id' => $store_id], $field, 20, ['sales' => 'desc']);
        $recommendGoods = goodsModel::getGoodsListPc(['store_id' => $store_id, 'recommended' => 1], $field, 6, ['sales' => 'desc']);
        $this->assign('recommendGoods', $recommendGoods['list']);
        $this->assign('goods', $goods['list']);
        $this->assign('page', $goods['list']->render());
        return $this->fetch();
    }

    public function bcategory_index() {
        $store_id = $this->store_id;
        $bCategory = businessCategoryModel::getListGroup(['store_id' => $store_id], "directory1_id", "*", 0, 10)->toArray();

        if ($this->request->isAjax()) {
            $get = input('get.');
            $bCategory2 = businessCategoryModel::getListGroup(['store_id' => $store_id,
                        'directory1_id' => $get['directory1_id']], "directory2_id", "*", 0, 10)->toArray();
            foreach ($bCategory2 as $key2 => $val2) {
                $bCategory2[$key2]['bCategory3'] = businessCategoryModel::getListGroup(['store_id' => $store_id,
                            'directory2_id' => $val2['directory2_id']], "directory3_id", "*", 0, 10)->toArray();
            }
            $bCategory2['list'] = $bCategory2;
            exit(json_encode($bCategory2));
        }
        $this->assign('bCategory', $bCategory);
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

        if ($this->request->isAjax()) {
            $post = input('post.');
            $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment,store_id';
            $goodsList = goodsModel::getGoodserList(['store_id' => $store_id, 'dir_id' => ['in', $dirIdStr],
                            ], $field, $post['start'], $post['limit'], $order);
            $goodsList_er = $goodsList['list'];
            if ($type == 'goodwill' && count($goodsList_er) > 0) {
                $goods = array_sort($goodsList_er, "givealike_count");
                $goodsList['list'] = $goods;
            }
            exit(json_encode($goodsList));
        }

        return $this->fetch();
    }

    public function categoryAjax() {
        
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

    public function storeGoodsAll() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $field = 'goods_id,goods_name,goods_price,thecover,number_payment,store_id';
            $goodsList = goodsModel::getGoodsList(['store_id' => $get['store_id']], $field, $get['start'], $get['limit'], ['sales' => 'desc']);
            exit(json_encode($goodsList));
        }
        return $this->fetch();
    }

}
