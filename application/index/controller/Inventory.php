<?php

/**
 * 规格库存信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\index\model\Inventory as inventoryModel;
use app\common\model\Norm as normModel;
use app\index\model\Goods as goodsModel;

class Inventory extends Common {

    public function addInventory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = inventoryModel::add(['goods_id' => $get['goods_id']]);
            if ($result) {
                goodsModel::delRedundantNorm($get['goods_id']);
                Tobesuccess('添加成功', $result->id);
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 删除规格库存
     */
    public function delInventory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $inventory = inventoryModel::get($get['inventory_id']);
            $result = inventoryModel::destroy($get['inventory_id']);
            if ($result) {
                goodsModel::delRedundantNorm($inventory['goods_id']);
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
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
            $gallery = inventoryModel::updates(['id' => $get['inventory_id']], $data);
            if ($gallery) {
                goodsModel::delRedundantNorm($inventory['goods_id']);
                Tobesuccess('修改成功', $gallery);
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    /**
     * 规格库存
     */
    public function getInventoryList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $field = 'in.*,gc.color_name,ct.cate_name';
            $inventoryList = inventoryModel::getSellerAjaxaList(['in.goods_id' => $get['goods_id']], $field, 0, 10);
            exit($inventoryList);
        }
    }

    /**
     * 修改库存
     */
    public function modifyInventory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = inventoryModel::where(['id' => $get['inventory_id']])->update(['inventory' => $get['inventory']]);
            if ($res) {
                Tobesuccess('成功修改库存');
            } else {
                Tiperror("修改库存失败！");
            }
        }
    }

}
