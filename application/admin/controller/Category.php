<?php

/**
 * 首页模块信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Category as CategoryModel;
use app\admin\model\Directory as directoryModel;
use \think\Db;

class Category extends Common {

    public function category_list() {
        $list = CategoryModel::getCategorylist(10, 'c.*,d.id,d.title', ['c.store_id' => 0]);
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 10);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function category_add() {
        if ($this->request->isAjax()) {
            $res = CategoryModel::categoryAddmd();
            if ($res) {
                Tobesuccess("模块添加成功");
            } else {
                Tiperror("模块添加失败");
            }
        }
        $directoryList = directoryModel::getDirLister('pid=0 and type<>7', 'id,title,pid,type', 30);
        $this->assign('directoryList', $directoryList);
        return $this->fetch();
    }

    public function category_edit() {
        if ($this->request->isAjax()) {
            $res = CategoryModel::categoryEditmd();
            if ($res) {
                Tobesuccess("模块修改成功");
            } else {
                Tiperror("模块修改失败");
            }
        }
        $info = CategoryModel::get(input('get.cat_id'));
        $this->assign("info", $info);
        $directoryList = directoryModel::getDirLister('pid=0 and type<>7', 'id,title,pid,type', 30);
        $this->assign('directoryList', $directoryList);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $cat_id = (int) (input("cat_id"));
            $info1 = CategoryModel::get($cat_id);
            $info = CategoryModel::get($cat_id);
            if ($info['is_show'] == '1') {
                $info->is_show = '0';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info1);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $catid_str = input('catidstr');
            $catid_arr = explode(",", $catid_str);
            if (empty($catid_arr)) {
                Tiperror("您未选择！");
            }
            $result = CategoryModel::destroy($catid_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
