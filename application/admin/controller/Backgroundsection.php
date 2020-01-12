<?php

/**
 * 后台栏目信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Backgroundsection as backgroundsectionModel;
use \think\Db;
use think\cache;

class Backgroundsection extends Common {

    public function getlist() {
        $page = input('get.page');
        $search = trim(input('search'));
        $oneId = trim(input('oneid'));
        $list = cache::get('backgroundsection_list' . $page . $search . $oneId);
        if (empty($list)) {
            $list = backgroundsectionModel::getlist(15);
            cache::set('backgroundsection_list' . $page . $search . $oneId, $list);
        }
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 15);
        $this->assign("search", input('search'));
        $this->assign('page', $list['page']);
//        print_r($list['list']);
        $section_pid_list = backgroundsectionModel::getPidlist(0);
        $this->assign('section_pid_list', $section_pid_list);
        $this->assign('oneid', input('oneid'));
        return $this->fetch();
    }

    public function edit() {
        $info = backgroundsectionModel::get(input('id'));
        $this->assign("info", $info);
        $this->assign("hierarchy", $info['hierarchy']);

        $section_pid_list = backgroundsectionModel::getlist(100);
        $this->assign('section_pid_list', $section_pid_list['list']);

        return $this->fetch();
    }

    public function addpid() {
        $info = backgroundsectionModel::get(input('id'));
        $this->assign("section_name", $info['section_name']);
        $this->assign("info", $info);
        $this->assign("hierarchy", input('hierarchy'));

        $section_pid_list = backgroundsectionModel::getlist(100);
        $this->assign('section_pid_list', $section_pid_list['list']);

        return $this->fetch();
    }

    public function addedit() {
        if ($this->request->isAjax()) {
            $res = backgroundsectionModel::editmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            foreach ($id_arr as $val) {
                $infoCount = backgroundsectionModel::where(['pid' => $val])->count();
                if ($infoCount > 0) {
                    Tiperror("你选择的分类还有子分类！");
                }
            }
            $result = backgroundsectionModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function mp_submit() {
        if ($this->request->isAjax()) {
            $res = backgroundsectionModel::mpSubmitMd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

}
