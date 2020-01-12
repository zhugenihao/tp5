<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Systems;
use \think\Db;

class System extends Common {

    public function system_base() {
        $Systems = new Systems();
        $info = $Systems->getsystem_baseInfo();
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function system_baseUpdate() {
        if ($this->request->isAjax()) {
            $Systems = new Systems();
            $info = $Systems->system_baseUpdatemd();
            if ($info) {
                Tobesuccess('保存成功');
            } else {
                Tiperror("保存失败");
            }
        }
    }

    public function directory_list() {
        $Systems = new Systems();
        $list = $Systems->getDirectorylist();
        $this->assign([
            'list' => $list['list'],
            'allcount' => $list['count'],
        ]);
        return $this->fetch();
    }

    public function directory_add() {
        $id = (int) (input('id'));
        $hiehy = (int) (input('hiehy'));
        $info = db::name("directory")->where('id', $id)->find();
        if (!$hiehy) {
            $this->assign("info", $info);
        }
        $this->assign("id", $info['id']);
        $this->assign("hiehy", $hiehy);
        $Systems = new Systems();
        $list = $Systems->getDirectorylist();
        $this->assign('list', $list['list']);
        $template_list = Db::name("template_list");
        $tmplist1 = $template_list->where('tmp_type',1)->limit(20)->select();
        $tmplist2 = $template_list->where('tmp_type',2)->limit(20)->select();
        $tmplist3 = $template_list->where('tmp_type',3)->limit(20)->select();
        $this->assign('tmplist1',$tmplist1);
        $this->assign('tmplist2',$tmplist2);
        $this->assign('tmplist3',$tmplist3);

        return $this->fetch();
    }

    public function directory_addedit() {
        if ($this->request->isAjax()) {
            $Systems = new Systems();
            $Systems->directory_Dddeditmd();
        }
    }

    public function directoryDel() {
        if ($this->request->isAjax()) {
            $id = (int) input('id');
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
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = db::name("directory")->where('id', 'in', $id_arr)->delete();
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function system_data() {
        return $this->fetch();
    }

    public function system_log() {
        $limit = 10; //每页数量
        $Systems = new Systems();
        $list = $Systems->getLoginredlist($limit);
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
            $Systems = new Systems();
            $res = $Systems->block_wordUpdatemd();
            if ($res) {
                Tobesuccess('保存成功');
            } else {
                Tiperror("保存失败");
            }
        }
        return $this->fetch();
    }

    public function template_list() {
        $list = Db::name("template_list")->where('tmp_type',input('tmp_type'))->select();
        $this->assign('list',$list);
        $this->assign('tmp_type',input('tmp_type'));
        return $this->fetch();
    }

    public function template_add() {
        $info = Db::name("template_list")->where('id',input('id'))->find();
        $this->assign('info',$info);
        $this->assign('tmp_type',input('tmp_type'));
        return $this->fetch();
    }

    public function template_submit() {
        if ($this->request->isAjax()) {
            $Systems = new Systems();
            $res = $Systems->template_submit_md();
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

}
