<?php

namespace app\index\controller;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\BusinessCategory as businessCategoryModel;

class BusinessCategory extends SellerCommon {

    public function index() {
        return $this->fetch();
    }

    public function businessCategoryList() {
        $mid = $this->mid;
        $list = businessCategoryModel::getList(['member_id' => $mid], '*');
        exit($list);
    }

    public function addBusCategory() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $where = ['member_id' => $this->mid, 'directory1_id' => $post['directory1_id'], 'directory2_id' => $post['directory2_id'],
                'directory3_id' => $post['directory3_id']];
            $count1 = businessCategoryModel::getCount($where);
            $count2 = businessCategoryModel::getCount(['member_id' => $this->mid]);
            if ($count1) {
                Tiperror('该类目已添加！');
            }
            if ($count2 >= 50) {
                Tiperror('只能添加50个类目！');
            }
            $result = businessCategoryModel::addMd($this->mid);
            if ($result) {
                Tobesuccess('提交成功');
            } else {
                Tiperror("提交失败！");
            }
        }
    }

    public function delbuscategory() {
        if ($this->request->isAjax()) {
            $buscategory_id = input('buscategory_id');
            $result = businessCategoryModel::destroy($buscategory_id);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

    public function goodsBuscategory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $store = $this->store;
            $where = ['store_id' => $store['id']];
            $group = 'directory1_id';
            if ($get['type'] == 'directory1_id') {
                $where['directory1_id'] = $get['directory1_id'];
                $group = 'directory2_id';
            } elseif ($get['type'] == 'directory2_id') {
                $where['directory2_id'] = $get['directory2_id'];
                $group = 'directory3_id';
            }
            $businessCategory = businessCategoryModel::getListGroup($where, $group, '*');
            exit($businessCategory);
        }
    }

}
