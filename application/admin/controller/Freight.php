<?php

/**
 * 运费信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\Freight as freightModel;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;

class Freight extends Common {

    public function freight_list() {
        $list = freightModel::getFgList(['store_id' => 0], 10);
        $this->assign('freight', $list->toArray());
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function freight_add() {
        if ($this->request->isAjax()) {
            $result = freightModel::addMd();
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);

        return $this->fetch();
    }

    public function freight_edit() {
        if ($this->request->isAjax()) {
            $result = freightModel::editMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = freightModel::get(input('freight_id'));
        $info['dtionAreaList'] = json_decode($info['dtion_area'], true);
        $this->assign('info', $info);

        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);

        return $this->fetch();
    }

    /**
     * 删除运费模板
     */
    public function delFreight() {
        if ($this->request->isAjax()) {
            $freight_str = input('freight_str');
            $freight_arr = explode(",", $freight_str);

            if (empty($freight_arr)) {
                Tiperror("您未选择！");
            }
            $result = freightModel::destroy($freight_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    /**
     * 修改库存
     */
    public function modifyInventory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = inventoryModel::where(['id' => $get['inventory_id']])->update(['inventory' => $get['inventory']]);
            if ($res) {
                Tobesuccess('成功修改库存');
            } else {
                Tiperror("修改库存失败！");
            }
        }
    }

}
