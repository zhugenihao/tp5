<?php

/**
 * 配置信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Config as configModel;
use \think\Db;

class Config extends Common {

    public function getlist() {
        $limit = 10;
        $list = configModel::getConfiglist($limit);
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", $limit);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function index() {
        $list1 = configModel::getIndex(['title_type' => 1]);
        $list2 = configModel::getIndex(['title_type' => 2]);
        $this->assign("list2", $list2);
        $this->assign("list1", $list1);
        return $this->fetch();
    }

    public function add() {

        $id = (int) (input('id'));
        $info = configModel::get($id);
        $this->assign("info", $info);

        return $this->fetch();
    }

    public function config_addedit() {
        if ($this->request->isAjax()) {
            $res = configModel::ConfigAddeditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function index_submit() {
        if ($this->request->isAjax()) {
            $res = configModel::indexSubmitMd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info1 = configModel::get($id);
            $info = configModel::get($id);
            if ($info['is_show'] == '1') {
                $info->is_show = '0';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info1);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function configdetel() {
        if ($this->request->isAjax()) {
            $Config = configModel::get(input('id'));
            $res = $Config->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $idstr_str = input('idstr');
            $idstr_arr = explode(",", $idstr_str);
            if (empty($idstr_arr)) {
                Tiperror("您未选择！");
            }
            $result = configModel::destroy($idstr_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
