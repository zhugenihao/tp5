<?php

/**
 * 供货商信息
 */

namespace app\index\controller\seller_store;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Supplier as supplierModel;

class Supplier extends SellerCommon {

    public function supplier_list() {
        $store = $this->store;
        $supplier = supplierModel::getList(['store_id' => $store['id']], 10);
        $this->assign('supplier', $supplier->toArray());
        $this->assign('page', $supplier->render());
        return $this->fetch();
    }

    public function supplier_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = supplierModel::supplierAddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function supplier_details() {
        if ($this->request->isAjax()) {
            $result = supplierModel::supplierEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = supplierModel::get(input('supplier_id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除供货商
     */
    public function delSupplier() {
        if ($this->request->isAjax()) {
            $supplierid_str = input('supplierid_str');
            $supplierid_arr = explode(",", $supplierid_str);

            if (empty($supplierid_arr)) {
                Tiperror("您未选择！");
            }
            $result = supplierModel::destroy($supplierid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
