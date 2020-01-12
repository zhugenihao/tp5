<?php

namespace app\index\controller;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Goods as GoodsModel;
use app\common\model\BusinessCategory as businessCategoryModel;
use app\common\model\Brand as brandModel;
use app\common\model\Cates as CatesModel;
use app\common\model\GoodsColor as GoodsColorModel;
use app\index\model\Inventory as inventoryModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\Norm as normModel;
use app\common\model\Freight as freightModel;

class SellerGoods extends SellerCommon {

    public function _initialize() {
        parent::_initialize();
    }

    public function index() {
        $store = $this->store;
        $businessCategory = businessCategoryModel::getListGroup(['store_id' => $store['id']], 'directory1_id', '*');
        $this->assign("businessCategory", $businessCategory);
        $brandlist = brandModel::getBrandList(['store_id' => $store['id']], 20);
        $this->assign("brandList", $brandlist['list']);
        
        $freightList = freightModel::getList(['store_id' => $store['id']], 'id,freight_name', 0, 50);
        $this->assign('freightList', $freightList);
        return $this->fetch();
    }

    /**
     * 销售排行
     * @return type
     */
    public function sales_ranking() {
        $store = $this->store;
        $field = 'goods_id,thecover,goods_name,goods_sku,sales,goods_price';
        $goodsList = GoodsModel::getGoodsSellerListPc(['store_id' => $store['id']], $field, 10, ['sales' => 'desc']);
        $this->assign('goods', $goodsList['list']->toArray());
        $this->assign('page', $goodsList['list']->render());
        return $this->fetch();
    }

    public function catesList() {
        $dirId = input('get.dir_id');
        $catesList = CatesModel::getList(['directory3_id' => $dirId, 'is_show' => 1]);
        $GoodsColorList = GoodsColorModel::getGoodsColor(['directory3_id' => $dirId, 'color_show' => 1]);
        Tobesuccess('获取数据', array('cates_list' => $catesList, 'goods_color_list' => $GoodsColorList));
    }

    /**
     * 商品发布
     */
    public function addGoods() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $post = input('post.');

            $goods_id = GoodsModel::goodsAdd($store['id']);
            if ($goods_id) {
                $normData = array();
                foreach ($post['goodscolor'] as $key => $val) {
                    $norm = normModel::normAdd($goods_id, $val, $key);
                    $normData[$norm['goodscolor_id']] = $norm['norm_id'];
                }
                $normData = array_filter($normData);
                foreach ($post['cates'] as $cates_key => $cate_id) {
                    $inty_price = $post['inty_price'][$cates_key];
                    $inventory = $post['inventory'][$cates_key];
                    $goodscolor_id = $post['goodscolor'][$cates_key];
                    $orgprice = $post['orgprice'][$cates_key];
                    $type_num = $post['type_num'][$cates_key];
                    $type = $post['type'][$cates_key];
                    $sort = $post['sort'][$cates_key];
                    $norm_id = $normData[$goodscolor_id];
                    $data[] = ['n_id' => $norm_id, 'cate_id' => $cate_id, 'inty_price' => $inty_price,
                        'inventory' => $inventory, 'orgprice' => $orgprice, 'type' => $type, 'type_num' => $type_num,
                        'sort' => $sort, 'goods_id' => $goods_id, 'create_time' => time()];
                }
                $inventoryModel = new inventoryModel();
                $galleryModel = new galleryModel();
                $inventoryModel->saveAll($data);
                $galleryModel->galleryAdd($goods_id);
                Tobesuccess('商品发布成功');
            } else {
                Tiperror("商品发布失败！");
            }
        }
        
    }

    public function sell_list() {
        $store = $this->store;
        $goodsList = GoodsModel::getGoodsSellerListPc(['store_id' => $store['id'], 'is_show' => 1], '*', 10);
//        print_r($goodsList['list']);die();
        $this->assign('goodsList', $goodsList['list']);
        $this->assign('page', $goodsList['list']->render());
        return $this->fetch();
    }

    public function warehouse_list() {
        $store = $this->store;
        $goodsList = GoodsModel::getGoodsSellerListPc(['store_id' => $store['id'], 'is_show' => 0], '*', 10);
        $this->assign('goodsList', $goodsList['list']);
        $this->assign('page', $goodsList['list']->render());
        return $this->fetch();
    }

    /**
     * 商品详情
     * @return type
     */
    public function goods_details() {
        $store = $this->store;
        $businessCategory = businessCategoryModel::getListGroup(['store_id' => $store['id']], 'directory1_id', '*');
        $this->assign("businessCategory", $businessCategory);
        $brandlist = brandModel::getBrandList(['store_id' => $store['id']], 20);
        $this->assign("brandList", $brandlist['list']);

        $goods = GoodsModel::getGoodsInfo(['goods_id' => input('goods_id')], '*');
        
        $businessCategoryInfo = businessCategoryModel::getInfo(['store_id' => $store['id'], 'directory3_id' => $goods['dir_id']], '*');
        $this->assign("goods", $goods);
        $this->assign("businessCategoryInfo", $businessCategoryInfo);

        $businessCategory2 = businessCategoryModel::getListGroup(['store_id' => $store['id'], 'directory1_id' => $businessCategoryInfo['directory1_id']], 'directory2_id', '*');
        $businessCategory3 = businessCategoryModel::getListGroup(['store_id' => $store['id'], 'directory2_id' => $businessCategoryInfo['directory2_id']], 'directory3_id', '*');
        $this->assign("businessCategory2", $businessCategory2);
        $this->assign("businessCategory3", $businessCategory3);

        $galleryList = galleryModel::getGalleryList(['goods_id' => $goods['goods_id']], '*', 50);
        $this->assign("galleryList", $galleryList);

        $inventoryList = inventoryModel::getSellerList(['in.goods_id' => $goods['goods_id']], 'in.*,no.goodscolor_id', 0, 10)->toArray();
        $this->assign("inventoryList", $inventoryList);

        $catesList = CatesModel::getList(['directory3_id' => $goods['dir_id'], 'is_show' => 1]);
        
        $GoodsColorList = GoodsColorModel::getGoodsColor(['directory3_id' => $goods['dir_id'], 'color_show' => 1]);
        $this->assign("catesList", $catesList);
        $this->assign("GoodsColorList", $GoodsColorList);
        
        $freightList = freightModel::getList(['store_id' => $store['id']], 'id,freight_name', 0, 50);
        $this->assign('freightList', $freightList);
        return $this->fetch();
    }

    /**
     * 商品编辑
     */
    public function editGoods() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $res = GoodsModel::goodsEdit();
            if ($res) {
                GoodsModel::delRedundantNorm($post['goods_id']);
                Tobesuccess('商品编辑成功');
            } else {
                Tiperror("商品编辑失败！");
            }
        }
    }

    /**
     * 删除商品
     */
    public function delGoods() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = GoodsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    /**
     * 库存管理
     * @return type
     */
    public function inventory_list() {
        $store = $this->store;
        $goodsList = GoodsModel::getGoodsSellerListPc(['store_id' => $store['id']], '*', 10);
        $this->assign('goodsList', $goodsList['list']);
        $this->assign('page', $goodsList['list']->render());

        return $this->fetch();
    }

    /**
     * 修改商品库存
     */
    public function modifyGoodsStock() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = GoodsModel::where(['goods_id' => $get['goods_id']])->update(['goods_stock' => $get['goods_stock']]);
            if ($res) {
                Tobesuccess('成功修改商品库存');
            } else {
                Tiperror("修改商品库存失败！");
            }
        }
    }

    public function brand_list() {
        return $this->fetch();
    }

}
