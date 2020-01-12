<?php

/**
 * 商家通知信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\SellerNotice as sellerNoticeModel;

class SellerNotice extends Common {

    public function sellernce_list() {
        $store_id = input('store_id');
        $where = !empty($store_id) ? ['store_id' => $store_id] : [];
        $sellernce = sellerNoticeModel::getList($where, 10);
        $this->assign('list', $sellernce->toArray());
        $this->assign('page', $sellernce->render());
        return $this->fetch();
    }

    public function sellernce_add() {
        if ($this->request->isAjax()) {
            $result = sellerNoticeModel::addMd($this->user_id);
            if ($result) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败！");
            }
        }
        return $this->fetch();
    }

    public function sellernce_edit() {
        if ($this->request->isAjax()) {
            $result = sellerNoticeModel::editMd();
            if ($result) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败！");
            }
        }
        $info = sellerNoticeModel::get(input('id'));
        $this->assign("info", $info);
        return $this->fetch();
    }

    /**
     * 删除商家通知
     */
    public function delSellernce() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerNoticeModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
