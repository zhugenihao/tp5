<?php

/**
 * 投诉信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\common\model\Complaints as complaintsModel;

class Complaints extends Common {

    public function complaints_list() {
        $complaints = complaintsModel::getList([], 10);
        $this->assign('list', $complaints->toArray());
        $this->assign('page', $complaints->render());
        return $this->fetch();
    }
    public function complaints_edit() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $result = complaintsModel::updates(['id' => $post['id']], ['state' => $post['state']]);
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = complaintsModel::get(input('id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function modifyState() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = complaintsModel::updates(['id' => $get['id']], ['state' => $get['state']]);
            if ($result) {
                if ($get['state'] == 2) {
                    Tobesuccess('处理中操作成功');
                } else {
                    Tobesuccess('已完成操作成功');
                }
            } else {
                Tiperror("编辑失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 删除投诉
     */
    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = complaintsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
