<?php

/**
 * 常用语句信息
 */

namespace app\index\controller\seller_kefu;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\KefuStatements as kefuStatementsModel;

class KefuStatements extends SellerCommon {

    public function statements_list() {
        $store = $this->store;
        $kefuStatements = kefuStatementsModel::getList(['store_id' => $store['id']], 10);
        $this->assign('list', $kefuStatements->toArray());
        $this->assign('page', $kefuStatements->render());
        return $this->fetch();
    }

    public function statements_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = kefuStatementsModel::kefuStatementsAddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function statements_details() {
        if ($this->request->isAjax()) {
            $result = kefuStatementsModel::kefuStatementsEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = kefuStatementsModel::get(input('kstem_id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除常用语句
     */
    public function del() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = kefuStatementsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
