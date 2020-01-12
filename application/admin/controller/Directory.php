<?php

/**
 * 导航分类
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Directory as directoryModel;
use app\admin\model\Language as languageModel;
use app\admin\model\Language_directory as languageDirectoryModel;
use \think\Db;

class Directory extends Common {

    public function directory_list() {
        $list = directoryModel::getList(15);
        $listPid = directoryModel::directoryPid(0);
        $this->assign([
            'list' => $list['list'],
            'allcount' => $list['count'],
            'page' => $list['page'],
            'listPid' => $listPid,
            'search' => input('post.search'),
            'onePid' => input('post.one_pid'),
            'isNavigation' => input('post.is_navigation'),
        ]);

        return $this->fetch();
    }

    public function getDirectory() {
        $pid = input('pid');
        $pid = !empty($pid) ? intval($pid) : 0;
        $dirfield = 'id,title,home_template_p,small_icon';
        $dirWhere = ['type' => 3, 'pid' => $pid, 'id' => ['not in', '61,62,1']];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 50);
        exit($directoryList);
    }

    public function directory_add() {
        $id = (int) (input('id'));
        $hiehy = (int) (input('hiehy'));
        $info = directoryModel::getInfo($id);
        if (!$hiehy) {
            $this->assign("info", $info);
        }
        $this->assign("id", $info['id']);
        $this->assign("hiehy", $hiehy);
        $list = directoryModel::getdirList();
        $this->assign('list', $list);
        $template_list = Db::name("template_list");
        $tmplist1 = $template_list->where('tmp_type', 1)->limit(20)->select();
        $tmplist2 = $template_list->where('tmp_type', 2)->limit(20)->select();
        $tmplist3 = $template_list->where('tmp_type', 3)->limit(20)->select();
        $this->assign('tmplist1', $tmplist1);
        $this->assign('tmplist2', $tmplist2);
        $this->assign('tmplist3', $tmplist3);

        $m_file_list = $this->template_files_list('/mobile/default/view/');
        $p_file_list = $this->template_files_list('/pc/default/view/');
        $this->assign('m_file_list', $m_file_list);
        $this->assign('p_file_list', $p_file_list);

        return $this->fetch();
    }

    public function language_directory() {
        $languageList = languageModel::getList(20);
        $this->assign("languageList", $languageList['list']);
        $info = directoryModel::get(input('dir_id'));
        $this->assign("info", $info);

        $languageDirectory = languageDirectoryModel::getList();
        $this->assign("language_lirectory", $languageDirectory['list']);
        $this->assign("language_id", input('language_id'));
        return $this->fetch();
    }

    public function language_directory_submit() {
        if ($this->request->isAjax()) {
            $res = languageDirectoryModel::languageDirectorySubmitMd();
            if ($res) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function language_directory_modify() {
        if ($this->request->isAjax()) {
            $res = languageDirectoryModel::languageDirectoryModifyMd();
            if ($res) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function language_lirectory_del() {
        if ($this->request->isAjax()) {
            $idstr_str = input('idstr');
            $idstr_arr = explode(",", $idstr_str);
            if (empty($idstr_arr)) {
                Tiperror("您未选择！");
            }
            $result = languageDirectoryModel::destroy($idstr_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function directory_addedit() {
        if ($this->request->isAjax()) {
            $res = directoryModel::directory_Dddeditmd();
            if ($res) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function directoryDel() {
        if ($this->request->isAjax()) {
            $id = (int) input('id');
            $infoCount = db::name("directory")->where('pid', $id)->count();
            if ($infoCount > 0) {
                Tiperror("你选择的分类还有子分类！");
            }
            $res = db::name("directory")->where('id', $id)->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function directoryDatadel() {
        if ($this->request->isAjax()) {
            $result = directoryModel::getDelete();
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function system_data() {
        return $this->fetch();
    }

    public function system_log() {
        $limit = 10; //每页数量
        $Directorys = new Directorys();
        $list = $Directorys->getLoginredlist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function system_logdetel() {
        if ($this->request->isAjax()) {
            $res = db("loginred")->where("id", input('id'))->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function system_log_datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = db("loginred")->where("id", "in", $id_arr)->delete();
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function block_word() {
        $info = db::name("block_word")->where('id', 1)->find();
        $this->assign('info', $info);
        if ($this->request->isAjax()) {
            $Directorys = new Directorys();
            $res = $Directorys->block_wordUpdatemd();
            if ($res) {
                Tobesuccess('保存成功');
            } else {
                Tiperror("保存失败");
            }
        }
        return $this->fetch();
    }

    public function template_list() {
        $list = Db::name("template_list")->where('tmp_type', input('tmp_type'))->select();
        $this->assign('list', $list);
        $this->assign('tmp_type', input('tmp_type'));
        return $this->fetch();
    }

    public function template_add() {
        $info = Db::name("template_list")->where('id', input('id'))->find();
        $this->assign('info', $info);
        $this->assign('tmp_type', input('tmp_type'));
        return $this->fetch();
    }

    public function template_submit() {
        if ($this->request->isAjax()) {
            $Directorys = new Directorys();
            $res = $Directorys->template_submit_md();
            if ($res) {
                Tobesuccess('保存成功');
            } else {
                Tiperror("保存失败");
            }
        }
    }

    public function template_del() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = db::name("template_list")->where('id', 'in', $id_arr)->delete();
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function language_directory_add() {
        return $this->fetch();
    }

}
