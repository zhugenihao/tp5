<?php

/**
 * 模板信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Themetemplate as ThemetemplateModel;
use \think\Db;

class Themetemplate extends Common {

    public function themetemplate_list() {
        $limit = 10;
        $list = ThemetemplateModel::getThemetemplatelist([], $limit, '*');
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function themetemplate_add() {
        if ($this->request->isAjax()) {
            $res = ThemetemplateModel::themetemplateAddmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        return $this->fetch();
    }

    public function themetemplate_edit() {
        if ($this->request->isAjax()) {
            $res = ThemetemplateModel::themetemplateEditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $info = ThemetemplateModel::get(input('tpl_id'));
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $tpl_id = (int) (input("tpl_id"));
            $info = ThemetemplateModel::get($tpl_id);
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
            $tplid_str = input('tplid_str');
            $tplid_arr = explode(",", $tplid_str);
            if (empty($tplid_arr)) {
                Tiperror("您未选择！");
            }
            $result = ThemetemplateModel::destroy($tplid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
