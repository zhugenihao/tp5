<?php

/**
 * 商品版本信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Cates as CatesModel;
use app\admin\model\Directory as directoryModel;
use app\admin\model\Goods as goodsModel;
use app\admin\model\Norm as normModel;
use \think\Db;

class Cates extends Common {

    public function catesList() {
        $list = CatesModel::getCatesList(['store_id' => 0], 10);
        $directory = directoryModel::getList(50);
        $cates = $list->toArray();
        $this->assign("list", $cates);
        $this->assign("directorylist", $directory['list']);
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function catesAdd() {
        $directory = directoryModel::getList(50);
        $this->assign("directorylist", $directory['list']);
        if ($this->request->isAjax()) {
            $res = CatesModel::catesAdd();
            if ($res) {
                Tobesuccess("版本添加成功");
            } else {
                Tiperror("版本添加失败！");
            }
        }
        return $this->fetch();
    }


    public function catesEdit() {
        $info = CatesModel::get(input('get.cate_id'));
        $this->assign("info", $info);
        if ($this->request->isAjax()) {
            $res = CatesModel::catesEdit();
            if ($res) {
                Tobesuccess("版本修改成功");
            } else {
                Tiperror("版本修改失败！");
            }
        }
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $cate_id = (int) (input("cate_id"));
            $info1 = CatesModel::get($cate_id);
            $info = CatesModel::get($cate_id);
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

    public function catesDatadel() {
        if ($this->request->isAjax()) {
            $cateid_str = input('idstr');
            $cateid_arr = explode(",", $cateid_str);
            if (empty($cateid_arr)) {
                Tiperror("您未选择！");
            }
            $result = CatesModel::destroy($cateid_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
