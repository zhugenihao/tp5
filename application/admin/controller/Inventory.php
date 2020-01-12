<?php

/**
 * 商品规格信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Inventory as InventoryModel;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\GoodsColor as GoodsColorModel;
use app\admin\model\Cates as CatesModel;
use app\admin\model\Gallery as GalleryModel;
use app\admin\model\Norm as normModel;
use \think\Db;

class Inventory extends Common {

    public function inventory_list() {

        $goods_id = input('goods_id');
        $list = InventoryModel::getInventoryList(['in.goods_id' => $goods_id], 'in.*,no.goodscolor_id', 15);
        $goodsInfo = GoodsModel::get($goods_id);
        $inventory = $list->toArray();
        $this->assign("goodsInfo", $goodsInfo);
        $this->assign("list", $inventory);
        $this->assign("limit", 15);
        $this->assign('page', $list->render());

        $catesList = CatesModel::getList(['dir_id' => $goodsInfo['dir_id']]);
        $GoodsColorList = GoodsColorModel::getGoodsColor(['dir_id' => $goodsInfo['dir_id']]);
        $this->assign("catesList", $catesList);
        $this->assign("GoodsColorList", $GoodsColorList);
        return $this->fetch();
    }

    public function inventory_add() {
        if ($this->request->isAjax()) {
            $res = InventoryModel::inventoryAddMd();
            if ($res) {
                Tobesuccess("规格添加成功");
            } else {
                Tiperror("规格添加失败！");
            }
        }
        $this->inventoryGoodsColorCates();
        return $this->fetch();
    }

    public function inventory_edit() {
        if ($this->request->isAjax()) {
            $res = InventoryModel::inventoryEditMd();
            if ($res) {
                Tobesuccess("规格修改成功");
            } else {
                Tiperror("规格修改失败！");
            }
        }

        $inventory_id = input('inventory_id');
        $info = InventoryModel::get($inventory_id);
        $norm = normModel::getInfo(['n_id' => $info['n_id']]);

        $this->assign("norm", $norm);
        $this->assign("info", $info);

        $this->inventoryGoodsColorCates($info['goods_id']);

        return $this->fetch();
    }

    public function inventory_imageslist() {
        if ($this->request->isAjax()) {
            $res = GalleryModel::galleryAdd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败！");
            }
        }
        $n_id = input('get.n_id');
        $galleryList = GalleryModel::getGalleryList(['n_id' => $n_id]);
        $info = normModel::get($n_id);
        $gallery = $galleryList['list']->toArray();
        $this->assign("gallery", $gallery);
        $this->assign('page', $galleryList['list']->render());
        $this->assign("info", $info);
        $this->assign("limit", 10);
        return $this->fetch();
    }

    public function inventoryGoodsColorCates($goods_id = 0) {
        $goodsid_i = input('get.goods_id');
        $goods_id = !empty($goods_id) ? $goods_id : $goodsid_i;
        $goodsInfo = GoodsModel::get($goods_id);
        $catesList = CatesModel::getList(['dir_id' => $goodsInfo['dir_id']]);
        $goodsColorList = GoodsColorModel::getGoodsColor(['dir_id' => $goodsInfo['dir_id']]);
        $this->assign("goodsColorList", $goodsColorList);
        $this->assign("catesList", $catesList);
        $this->assign("goodsInfo", $goodsInfo);
    }

    /**
     * 修改数据
     */
    public function editInventory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $data = [];
            $inventory = inventoryModel::getInfo(['id' => $get['inventory_id']], '*');
            switch ($get['type']) {
                case 'inty_price':
                    $data = ['inty_price' => $get['inty_price']];
                    break;
                case 'orgprice':
                    $data = ['orgprice' => $get['orgprice']];
                    break;
                case 'inventory':
                    $data = ['inventory' => $get['inventory']];
                    break;
                case 'type':
                    $data = ['type' => $get['type_i']];
                    break;
                case 'type_num':
                    $data = ['type_num' => $get['type_num']];
                    break;
                case 'sort':
                    $data = ['sort' => $get['sort']];
                    break;
                case 'cate_id':
                    $data = ['cate_id' => $get['cate_id']];
                    break;
                case 'goodscolor_id':
                    $norm = normModel::getInfo(['goods_id' => $inventory['goods_id'], 'goodscolor_id' => $get['goodscolor_id']], '*');
                    $n_id = $norm['n_id'];
                    if (empty($norm['n_id'])) {
                        $norm = normModel::create(['goods_id' => $inventory['goods_id'], 'goodscolor_id' => $get['goodscolor_id'],
                                    'create_time' => time()]);
                        $n_id = $norm->n_id;
                    }
                    $data = ['n_id' => $n_id];
                    break;
                default:
                    break;
            }
            $gallery = InventoryModel::updates(['id' => $get['inventory_id']], $data);
            if ($gallery) {
                GoodsModel::delRedundantNorm($inventory['goods_id']);
                Tobesuccess('修改成功', $gallery);
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $inventoryid_str = input('idstr');
            $inventoryid_arr = explode(",", $inventoryid_str);
            if (empty($inventoryid_arr)) {
                Tiperror("您未选择！");
            }
            $result = InventoryModel::destroy($inventoryid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
