<?php

/**
 * 店铺导航信息
 */

namespace app\index\controller\seller_store;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Category as categoryModel;
use app\common\model\BusinessCategory as businessCategoryModel;

class Category extends SellerCommon {

    public function category_list() {
        $store = $this->store;
        $category = categoryModel::getList(['store_id' => $store['id']], 10);
        $this->assign('category', $category->toArray());
        $this->assign('page', $category->render());
        return $this->fetch();
    }

    public function category_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = categoryModel::categoryAddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        $businessCategory = businessCategoryModel::getListGroup(['store_id' => $store['id']], 'directory1_id', '*');
        $this->assign("businessCategory", $businessCategory);
        return $this->fetch();
    }

    public function category_details() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = categoryModel::categoryEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $businessCategory = businessCategoryModel::getListGroup(['store_id' => $store['id']], 'directory1_id', '*');
        $this->assign("businessCategory", $businessCategory);
        $info = categoryModel::get(input('category_id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除导航
     */
    public function delCategory() {
        if ($this->request->isAjax()) {
            $categoryid_str = input('categoryid_str');
            $categoryid_arr = explode(",", $categoryid_str);

            if (empty($categoryid_arr)) {
                Tiperror("您未选择！");
            }
            $result = categoryModel::destroy($categoryid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
