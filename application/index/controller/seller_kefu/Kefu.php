<?php

/**
 * 客服信息
 */

namespace app\index\controller\seller_kefu;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Kefu as kefuModel;

class Kefu extends SellerCommon {

    public function kefu_list() {
        $store = $this->store;
        $kefu = kefuModel::getList(['store_id' => $store['id']], 10);
        $this->assign('kefu', $kefu->toArray());
        $this->assign('page', $kefu->render());
        return $this->fetch();
    }

    public function kefu_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = kefuModel::kefuAddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        return $this->fetch();
    }

    public function kefu_details() {
        if ($this->request->isAjax()) {
            $result = kefuModel::kefuEditMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = kefuModel::get(input('kefu_id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除客服
     */
    public function delKefu() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = kefuModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
