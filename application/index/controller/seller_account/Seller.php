<?php

/**
 * 商家账号信息
 */

namespace app\index\controller\seller_account;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Seller as sellerModel;
use app\index\model\SellerGroup as sellerGroupModel;

class Seller extends SellerCommon {

    public function seller_list() {
        $seller_id = $this->seller_id;
        $seller = sellerModel::getSellerList(['parent_id' => $seller_id], 10);
        $this->assign('seller', $seller->toArray());
        $this->assign('page', $seller->render());
        return $this->fetch();
    }

    public function seller_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = sellerModel::sellerAddMd($store['seller_id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        $sellerGroup = sellerGroupModel::getList(['store_id' => $store['id']], 10);
        $this->assign('sellerGroup', $sellerGroup);
        return $this->fetch();
    }

    public function seller_details() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = sellerModel::sellerEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = sellerModel::get(input('seller_id'));
        $this->assign('info', $info);
        $sellerGroup = sellerGroupModel::getList(['store_id' => $store['id']], 10);
        $this->assign('sellerGroup', $sellerGroup);
        return $this->fetch();
    }

    /**
     * 账号设置
     * @return type
     */
    public function account_settings() {
        if ($this->request->isAjax()) {
            $result = sellerModel::sellerSettingsMd($this->seller_id);
            if ($result) {
                Tobesuccess('设置成功');
            } else {
                Tiperror("设置失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 删除商家账号
     */
    public function delSeller() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
