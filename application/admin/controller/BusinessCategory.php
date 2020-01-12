<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\BusinessCategory as businessCategoryModel;
use app\admin\model\Directory as directoryModel;
use app\admin\model\Store as storeModel;

class BusinessCategory extends Common {

    public function bcategory_list() {
        $bcategory = businessCategoryModel::getBcategoryList([], 10, 'b.*,s.store_name,m.member_name');
        $this->assign('bcategory', $bcategory->toArray());
        $this->assign('page', $bcategory->render());
        return $this->fetch();
    }

    public function bcategory_add() {
        if ($this->request->isAjax()) {
            $result = businessCategoryModel::addBcategoryMd();
            if ($result) {
                Tobesuccess('类目添加成功');
            } else {
                Tiperror("类目添加失败！");
            }
        }
        $directory1_list = directoryModel::getSelectList(['pid' => 0], 50, 'id,title');
        $this->assign("directory1_list", $directory1_list);
        return $this->fetch();
    }

    public function bcategory_edit() {
        if ($this->request->isAjax()) {
            $result = businessCategoryModel::editBcategoryMd();
            if ($result) {
                Tobesuccess('类目编辑成功');
            } else {
                Tiperror("类目编辑失败！");
            }
        }
        $info = businessCategoryModel::get(input('id'));
        $this->assign("info", $info);
        $this->assign("store_name", storeModel::getValue(['id' => $info['store_id']], 'store_name'));
        $directory1_list = directoryModel::getSelectList(['pid' => 0], 50, 'id,title');
        $directory2_list = directoryModel::getSelectList(['pid' => $info['directory1_id']], 50, 'id,title');
        $directory3_list = directoryModel::getSelectList(['pid' => $info['directory2_id']], 50, 'id,title');
        $this->assign("directory1_list", $directory1_list);
        $this->assign("directory2_list", $directory2_list);
        $this->assign("directory3_list", $directory3_list);
        return $this->fetch();
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(',', $id_str);
            if (empty($id_arr)) {
                Tiperror("未选择！");
            }
            $result = businessCategoryModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

}
