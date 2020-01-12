<?php

/**
 * 商家信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\Seller as sellerModel;

class Seller extends Common {

    public function seller_list() {
        $limit = 10;
        $search = input('search');
        if ($search) {
            $where = ['seller_name|member_name' => $search];
        }
        $where['parent_id'] = 0;
        $list = sellerModel::getList($limit, $where);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function seller_add() {
        if ($this->request->isAjax()) {
            $res = sellerModel::sellerAddmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $start_time = date('Y-m-d H:i:s');
        $this->assign('start_time', $start_time);

        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $info = sellerModel::get(input("get.id"));
            if ($info['seller_delete'] == 1) {
                $info->seller_delete = 0;
            } else {
                $info->seller_delete = 1;
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    /**
     * 商家详情 
     * @return type
     */
    public function seller_edit() {

        if ($this->request->isAjax()) {
            $post = input('post.');
            $info = sellerModel::get($post['seller_id']);
            $data = ['seller_delete' => $post['seller_delete']];
            if (trim($post['queren_password'])) {
                $password = passwordEncryption($post['queren_password']);
                $data['salt'] = $password['salt'];
                $data['seller_password'] = $password['password'];
            }
            $res = sellerModel::updates(['id' => $post['seller_id']], $data);
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $get = input('get.');
        $info = sellerModel::get($get['id']);
        $this->assign("info", $info);

        return $this->fetch();
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $idStr = input('idstr');
            $idArr = explode(",", $idStr);
            if (empty($idArr)) {
                Tiperror("您未选择！");
            }
            $result = sellerModel::destroy($idArr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
