<?php

/**
 * 区域信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\OnethinkDistrict as onethinkDistrictModel;
use \think\Db;

class OnethinkDistrict extends Common {

    public function getlist() {
        $get = input('get.');
        $upid = isset($get['upid']) ? $get['upid'] : 0;
        $list = onethinkDistrictModel::getList(['upid' => $upid], '*');
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 10);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());

        $info = onethinkDistrictModel::getInfo(['id' => $upid]);
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function add() {
        if ($this->request->isAjax()) {
            $res = onethinkDistrictModel::add();
            if ($res) {
                Tobesuccess("区域添加成功");
            } else {
                Tiperror("区域添加失败");
            }
        }
        $get = input('get.');
        $infoUpid = onethinkDistrictModel::getInfo(['id' => $get['upid']]);
        $upid = !empty($infoUpid) ? $infoUpid['upid'] : 0;
        $list = onethinkDistrictModel::getList(['upid' => $upid], '*', 100);
        $this->assign("list", $list['list']);
        $info = onethinkDistrictModel::getInfo(['id' => $get['upid']]);
        $level = isset($info['level']) ? $info['level'] + 1 : 1;
        $this->assign("upid", $get['upid']);
        $this->assign("level", $level);
        return $this->fetch();
    }

    public function edit() {
        if ($this->request->isAjax()) {
            $res = onethinkDistrictModel::updates();
            if ($res) {
                Tobesuccess("区域修改成功");
            } else {
                Tiperror("区域修改失败");
            }
        }
        $info = onethinkDistrictModel::get(input('get.id'));
        $this->assign("info", $info);
        $infoUpid = onethinkDistrictModel::getInfo(['id' => $info['upid']]);
        $upid = !empty($infoUpid) ? $infoUpid['upid'] : 0;
        $list = onethinkDistrictModel::getList(['upid' => $upid], '*', 100);
        $this->assign("list", $list['list']);

        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info1 = onethinkDistrictModel::get($id);
            $info = onethinkDistrictModel::get($id);
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

    public function datadel() {
        if ($this->request->isAjax()) {
            $catid_str = input('catidstr');
            $catid_arr = explode(",", $catid_str);
            if (empty($catid_arr)) {
                Tiperror("您未选择！");
            }
            $result = onethinkDistrictModel::destroy($catid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    //获取区域信息
    public function otDisList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $upid = isset($get['upid']) ? $get['upid'] : 0;
            $otDisList = onethinkDistrictModel::getLister(['upid' => $upid]);
            exit(json_encode($otDisList));
        }
    }

}
