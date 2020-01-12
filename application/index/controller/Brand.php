<?php

/**
 * 商品品牌信息
 */

namespace app\index\controller;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Brand as brandModel;

class Brand extends SellerCommon {

    public function brand_list() {
        $store = $this->store;
        $list = brandModel::getBrandList(['store_id' => $store['id']], 10);
        $this->assign('brandList', $list['list']);
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function brand_add() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $result = brandModel::brandAddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function brand_details() {
        if ($this->request->isAjax()) {
            $result = brandModel::brandEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = brandModel::get(input('brand_id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除品牌
     */
    public function delBrand() {
        if ($this->request->isAjax()) {
            $brandid_str = input('brandid_str');
            $brandid_arr = array_filter(explode(",", $brandid_str));

            if (empty($brandid_arr)) {
                Tiperror("您未选择！");
            }
            $list = BrandModel::all($brandid_str);
            foreach ($list as $val) {
                if (!empty($val['brand_logo'])) {
                    if (file_exists(ROOT_PATH . "public/static/" . $val['brand_logo'])) {
                        unlink(ROOT_PATH . "public/static/" . $val['brand_logo']);
                    }
                }
            }
            $result = BrandModel::destroy($brandid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
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
