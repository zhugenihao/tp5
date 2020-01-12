<?php

/**
 * 广告信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Advert as AdvertModel;
use app\admin\model\AdvertType as advertTypeModel;
use app\admin\model\Directory as directoryModel;
use \think\Db;

class Advert extends Common {

    public function advert_list() {
        $limit = 5;
        $list = AdvertModel::getAdvertlist(['a.store_id' => 0], $limit, 'a.*,d.alias,at.*');
        $advertType = advertTypeModel::getAdvertTypeLister([], 20);
        $this->assign("advertTypeList", $advertType);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("dirId", input('dir_id'));
        $this->assign("adt_mark", input('adt_mark'));
        $this->assign("catetype", input('catetype'));
        $this->assign('page', $list['list']->render());
        $directory = directoryModel::getLister([], 50);
        $this->assign("directoryList", $directory);
        return $this->fetch();
    }

    public function advert_add() {
        $advertType = advertTypeModel::getAdvertTypeList([], 20);
        $this->assign("advertTypeList", $advertType['list']);
        $directory = directoryModel::getList(50);
        $this->assign("directoryList", $directory['list']);
        if ($this->request->isAjax()) {
            $res = AdvertModel::advertAddmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        return $this->fetch();
    }

    public function advert_edit() {
        if ($this->request->isAjax()) {
            $res = AdvertModel::advertEditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $advertType = advertTypeModel::getAdvertTypeList([], 20);
        $this->assign("advertTypeList", $advertType['list']);
        $info = AdvertModel::get(input('adv_id'));
        $this->assign("info", $info);
        $directory = directoryModel::getList(50);
        $this->assign("directoryList", $directory['list']);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $adv_id = (int) (input("adv_id"));
            $info = AdvertModel::get($adv_id);
            if ($info['adv_show'] == '1') {
                $info->adv_show = '0';
            } else {
                $info->adv_show = '1';
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function advertdetel() {
        if ($this->request->isAjax()) {
            $Adverts = AdvertModel::get(input('adv_id'));
            $res = $Adverts->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $advid_str = input('advidstr');
            $advid_arr = explode(",", $advid_str);
            if (empty($advid_str)) {
                Tiperror("您未选择！");
            }
            $result = AdvertModel::destroy($advid_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
