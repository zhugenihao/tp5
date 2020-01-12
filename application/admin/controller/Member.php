<?php

/**
 * 用户信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Member as memberModel;
use \think\Db;

class Member extends Common {

    public function member_list() {
        $limit = 10;
        $Member = new memberModel();
        $list = $Member->getMemberlist($limit);
        $this->assign('datemin', input('datemin'));
        $this->assign('datemax', input('datemax'));
        $this->assign('search', input('search'));
        $this->assign('delete', input('delete'));
        $this->assign('list', $list['list']);
        $this->assign('allcount', $list['count']);
        $this->assign("limit", $limit);
        $this->assign('page', $list['list']->render());

        return $this->fetch();
    }

    public function member_add() {

        $Member = new memberModel();
        $m_id = input('m_id');
        $Info = $Member->getMemberInfo($m_id);
        $this->assign('Info', $Info);
        return $this->fetch();
    }

    public function member_addedit() {
        if ($this->request->isPost()) {
            $Member = new memberModel();
            $mid = trim(input('id'));
            $Member->member_addeditmd($mid);
        }
    }

    public function member_show() {
        $mid = input('get.m_id');
        $Member = new memberModel();
        $Info = $Member->getMemberInfo($mid);
        $this->assign('Info', $Info);


        return $this->fetch();
    }

    public function change_password() {
        $mid = input('m_id');
        $Member = new memberModel();
        $Info = $Member->getMemberInfo($mid);
        $this->assign('Info', $Info);
        if (request()->isAjax()) {
            $input = input('post.');
            $mid = intval($input['m_id']);
            $password = passwordEncryption($input['password']);
            $data = [
                'salt' => $password['salt'],
                'password' => $password['password'],
            ];
            if ($data) {
                memberModel::where('id', $mid)
                        ->update($data);
                Tobesuccess('密码修改成功', $mid);
            } else {
                Tiperror("操密码修改失败");
            }
        }
        return $this->fetch();
    }

    public function memberdetel_true() {
        if (request()->isAjax()) {
            $Member = memberModel::get(input('m_id'));
            $res = $Member->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $mid = input("m_id");
            $Member = memberModel::get($mid);
            if ($Member['state'] == '1') {
                $Member->state = '2';
            } else {
                $Member->state = '1';
            }
            $res = $Member->save();
            if ($res) {
                Tobesuccess('操作成功', $Member);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function memberdetel() {
        if ($this->request->isAjax()) {
            $mid = input("m_id");
            $title = input("title");
            $Member = memberModel::get($mid);
            if ($Member['delete'] == '1') {
                $Member->delete = '2';
            } else {
                $Member->delete = '1';
            }
            $res = $Member->save();
            if ($res) {
                Tobesuccess($title . '成功', $Member);
            } else {
                Tiperror($title . "失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $delete = input('delete');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            if ($delete == 1) {
                $result = memberModel::where('id', 'in', $id_arr)->update(['delete' => 2]);
            } else {
                // $result = Member::destroy($id_arr);
            }
            if ($result) {
                Tobesuccess('批量删除成功', $delete);
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function collection_list() {
        $limit = 10;
        $Member = new memberModel();
        $list = $Member->getCollection_list($limit);
        $this->assign([
            'list' => $list['list'],
            'limit' => $limit,
            'allcount' => $list['count'],
            'search' => input('search'),
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
            'page' => $list['list']->render(),
        ]);
        return $this->fetch();
    }

    public function collectiondetel() {
        if ($this->request->isAjax()) {
            $res = db::name("collection")->where("id", input('id'))->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function collection_datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = db::name("collection")->where('id', 'in', $id_arr)->delete();

            if ($result) {
                Tobesuccess('批量删除成功', $result);
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
