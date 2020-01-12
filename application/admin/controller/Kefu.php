<?php

/**
 * 客服信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\Kefu as kefuModel;

class Kefu extends Common {

    public function kefu_list() {
        $kefu = kefuModel::getList(['store_id' => 0], 10);
        $this->assign('list', $kefu->toArray());
        $this->assign('page', $kefu->render());
        return $this->fetch();
    }

    public function kefu_add() {
        if ($this->request->isAjax()) {
            $result = kefuModel::kefuAddMd();
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
    public function del() {
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
