<?php

/**
 * 商品广告类型信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\AdvertType as AdvertTypeModel;
use \think\Db;

class AdvertType extends Common {

    public function getList() {
        $list = AdvertTypeModel::getAdvertTypeList([], 10);
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 10);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function add() {
        if ($this->request->isAjax()) {
            $res = AdvertTypeModel::advertTypeAdd();
            if ($res) {
                Tobesuccess("广告类型添加成功");
            } else {
                Tiperror("广告类型添加失败！");
            }
        }
        return $this->fetch();
    }

    public function edit() {
        $info = AdvertTypeModel::get(input('get.id'));
        $this->assign("info", $info);
        if ($this->request->isAjax()) {
            $res = AdvertTypeModel::advertTypeEdit();
            if ($res) {
                Tobesuccess("广告类型修改成功");
            } else {
                Tiperror("广告类型修改失败！");
            }
        }
        return $this->fetch();
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = AdvertTypeModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
