<?php

/**
 * 商品颜色
 */

namespace app\index\controller\seller_specifications;

use app\index\controller\SellerCommon;
use app\index\model\GoodsColor as GoodsColorModel;
use app\index\model\Directory as directoryModel;
use \think\Db;

class GoodsColor extends SellerCommon {

    public function goodsColor_list() {
        $store = $this->store;
        $list = GoodsColorModel::getList(['store_id' => $store['id']], 10);
        $goodsColor = $list->toArray();
        $this->assign("goodsColor", $goodsColor);
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function goodsColor_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $res = GoodsColorModel::goodsColorAdd($store['id']);
            if ($res) {
                Tobesuccess("颜色添加成功");
            } else {
                Tiperror("颜色添加失败！");
            }
        }
        return $this->fetch();
    }

    public function goodsColor_details() {
        $info = GoodsColorModel::get(input('id'));
        $this->assign("info", $info);
        if ($this->request->isAjax()) {
            $res = GoodsColorModel::goodsColorEdit();
            if ($res) {
                Tobesuccess("颜色修改成功");
            } else {
                Tiperror("颜色修改失败！");
            }
        }
        return $this->fetch();
    }


    public function goodsDatadel() {
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
