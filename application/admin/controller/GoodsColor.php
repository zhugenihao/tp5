<?php

/**
 * 商品颜色
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\GoodsColor as GoodsColorModel;
use app\admin\model\Directory as directoryModel;
use app\admin\model\Goods as goodsModel;
use \think\Db;

class GoodsColor extends Common {

    public function GoodsColorList() {
        $list = GoodsColorModel::getList(['store_id' => 0], 10);
        $directory = directoryModel::getList(50);
        $goodsColor = $list->toArray();
        $this->assign("list", $goodsColor);
        $this->assign("directorylist", $directory['list']);
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function goodsColorAdd() {
        if ($this->request->isAjax()) {
            $res = GoodsColorModel::GoodsColorAdd();
            if ($res) {
                Tobesuccess("颜色添加成功");
            } else {
                Tiperror("颜色添加失败！");
            }
        }
        return $this->fetch();
    }

    public function goodsColorEdit() {
        $info = GoodsColorModel::get(input('get.id'));
        $this->assign("info", $info);
        if ($this->request->isAjax()) {
            $res = GoodsColorModel::GoodsColorEdit();
            if ($res) {
                Tobesuccess("颜色修改成功");
            } else {
                Tiperror("颜色修改失败！");
            }
        }
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info1 = GoodsColorModel::get($id);
            $info = GoodsColorModel::get($id);
            if ($info['color_show'] == 1) {
                $info->color_show = 0;
            } else {
                $info->color_show = 1;
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info1);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function goodsColorDatadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = GoodsColorModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
