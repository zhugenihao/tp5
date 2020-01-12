<?php

/**
 * 商家账号组信息
 */

namespace app\index\controller\seller_account;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\SellerGroup as sellerGroupModel;
use app\common\model\SellerMenu as sellerMenuModel;

class SellerGroup extends SellerCommon {

    public function seller_group_list() {
        $store = $this->store;
        $sellerGroup = sellerGroupModel::getList(['store_id' => $store['id']], 10);
        $this->assign('sellerGroup', $sellerGroup->toArray());
        $this->assign('page', $sellerGroup->render());
        return $this->fetch();
    }

    public function seller_group_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = sellerGroupModel::AddMd($store['id']);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
        $sellerMenu = sellerMenuModel::getList(['pid' => 0], 20);
        $menuList = $sellerMenu->toArray();
        $menuData = $menuList['data'];
        foreach ($menuData as $key => $val) {
            $menuData[$key] = $val;
            $menuData[$key]['lister'] = sellerMenuModel::where(['pid' => $val['id']])->select();
            foreach ($menuData[$key]['lister'] as $key2 => $val2) {
                $menuData[$key]['lister'][$key2]['lister2'] = sellerMenuModel::where(['pid' => $val2['id']])->select();
            }
        }
        $this->assign('menuList', $menuData);
        return $this->fetch();
    }

    public function seller_group_details() {
        if ($this->request->isAjax()) {
            $result = sellerGroupModel::editMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = sellerGroupModel::get(input('group_id'));
        $this->assign('info', $info);
        $menuid_arr = json_decode($info['menuid_str'], true);
        $menuid_arris = [];
        foreach ($menuid_arr as $menu_id) {
            $menuid_arris[$menu_id] = $menu_id;
        }
        $sellerMenu = sellerMenuModel::getList(['pid' => 0], 20);
        $menuList = $sellerMenu->toArray();
        $menuData = $menuList['data'];
        foreach ($menuData as $key => $val) {
            $menuData[$key] = $val;
            $menuData[$key]['lister'] = sellerMenuModel::where(['pid' => $val['id']])->select();
            foreach ($menuData[$key]['lister'] as $key2 => $val2) {
                $menuData[$key]['lister'][$key2]['lister2'] = sellerMenuModel::where(['pid' => $val2['id']])->select();
            }
        }
        $this->assign('menuList', $menuData);
        $this->assign('menuid_arris', $menuid_arris);
        return $this->fetch();
    }

    /**
     * 删除商家账号
     */
    public function delSellerGroup() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerGroupModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
