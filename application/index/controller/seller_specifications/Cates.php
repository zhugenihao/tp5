<?php

/**
 * 商品版本信息
 */

namespace app\index\controller\seller_specifications;

use app\index\controller\SellerCommon;
use app\index\model\Cates as CatesModel;
use app\common\model\Directory as directoryModel;
use \think\Db;

class Cates extends SellerCommon {

    public function cates_list() {
        $store = $this->store;
        $list = CatesModel::getCatesList(['store_id' => $store['id']], 10);
        $directory = directoryModel::getDirectoryList();
        $cates = $list->toArray();
        $this->assign("cates", $cates);
        $this->assign("directorylist", $directory);
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function cates_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $res = CatesModel::catesAdd($store['id']);
            if ($res) {
                Tobesuccess("版本添加成功");
            } else {
                Tiperror("版本添加失败！");
            }
        }
        return $this->fetch();
    }


    public function cates_details() {
        $info = CatesModel::get(input('cate_id'));
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

    public function delCates() {
        if ($this->request->isAjax()) {
            $cateid_str = input('id_str');
            $cateid_arr = explode(",", $cateid_str);
            if (empty($cateid_arr)) {
                Tiperror("您未选择！");
            }
            $result = CatesModel::destroy($cateid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
