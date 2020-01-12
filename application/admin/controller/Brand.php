<?php

/**
 * 广告信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Brand as BrandModel;
use \think\Db;

class Brand extends Common {

    public function brand_list() {
        $limit = 10;
        $list = BrandModel::getBrandlist(['store_id' => 0], $limit, '*');
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function brand_add() {
        if ($this->request->isAjax()) {
            $res = BrandModel::brandAddmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        return $this->fetch();
    }

    public function brand_edit() {
        if ($this->request->isAjax()) {
            $res = BrandModel::brandEditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $info = BrandModel::get(input('brand_id'));
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $brand_id = (int) (input("brand_id"));
            $info = BrandModel::get($brand_id);
            if ($info['is_show'] == '1') {
                $info->is_show = '0';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $brandid_str = input('brandid_str');
            $brandid_arr = explode(",", $brandid_str);
            if (empty($brandid_arr)) {
                Tiperror("您未选择！");
            }
            $result = BrandModel::destroy($brandid_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
