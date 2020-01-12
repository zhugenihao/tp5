<?php

/**
 * 商家地址信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\SellerAddress as sellerAddressModel;

class SellerAddress extends Common {

    public function seller_address_list() {
        $sellerAddress = sellerAddressModel::getList(['store_id' => 0], 10);
        $this->assign('list', $sellerAddress->toArray());
        $this->assign('page', $sellerAddress->render());
        return $this->fetch();
    }

    public function seller_address_add() {
        if ($this->request->isAjax()) {
            $result = sellerAddressModel::sellerAddressAddMd();
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function seller_address_edit() {
        if ($this->request->isAjax()) {
            $result = sellerAddressModel::sellerAddressEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = sellerAddressModel::get(input('id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除地址
     */
    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerAddressModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
