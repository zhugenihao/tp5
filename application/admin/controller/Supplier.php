<?php

/**
 * 供货商信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\Supplier as supplierModel;

class Supplier extends Common {

    public function supplier_list() {
        $supplier = supplierModel::getList(['store_id' => 0], 10);
        $this->assign('list', $supplier->toArray());
        $this->assign('page', $supplier->render());
        return $this->fetch();
    }

    public function supplier_add() {
        if ($this->request->isAjax()) {
            $result = supplierModel::supplierAddMd();
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function supplier_edit() {
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
    public function datadel() {
        if ($this->request->isAjax()) {
            $supplierid_str = input('idstr');
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
