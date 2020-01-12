<?php

/**
 * 商家菜单信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\SellerMenu as sellerMenuModel;
use \think\Db;

class SellerMenu extends Common {

    public function seller_menu_list() {
        $sellerMenu = sellerMenuModel::getList(['pid' => 0], 2);
        $list = $sellerMenu->toArray();
        $listData = $list['data'];
        $seller_menu_html = '';
        foreach ($listData as $key => $val) {
            $lister2 = sellerMenuModel::getPidlist($val['id']);
            $seller_menu_html .= $this->seller_menu_html($val, 1);
            foreach ($lister2 as $key2 => $val2) {
                $seller_menu_html .= $this->seller_menu_html($val2, 2);
                $lister3 = sellerMenuModel::getPidlist($val2['id']);
                foreach ($lister3 as $key3 => $val3) {
                    $seller_menu_html .= $this->seller_menu_html($val3, 3);
                }
            }
        }
//        print_R($seller_menu_html);
        $this->assign("limit", 5);
        $this->assign('seller_menu_html', $seller_menu_html);
        $this->assign('page', $sellerMenu->render());
        $menu_pid_list = sellerMenuModel::getPidlist(0);
        $this->assign('menu_pid_list', $menu_pid_list);
        return $this->fetch();
    }

    public function seller_menu_html($val = array(), $type = 1) {
        $trClass = '';
        $add_text = '';
        $add_url = url("seller_menu/seller_menu_add") . '?id=' . $val['id'] . '&hierarchy=' . ($val['hierarchy'] + 1);
        if ($type == 1) {
            $trClass = 'bacgtr1';
            $type_text = "|----";
            $add_text = '<a onClick="href_url(\'添加子栏目\', \'' . $add_url . '\')" href="javascript:;" title="添加子栏目">添加子栏目</a>';
        }
        if ($type == 2) {
            $trClass = 'bacgtr2';
            $type_text = "|--------";
            $add_text = '<a onClick="href_url(\'添加子栏目\', \'' . $add_url . '\')" href="javascript:;" title="添加子栏目">添加子栏目</a>';
        }
        if ($type == 3) {
            $type_text = "|------------";
        }
        if ($val['is_show'] == 1) {
            $is_show = '<span class="label label-success radius">已显示</span>';
        } else {
            $is_show = '<span class="label label-defaunt radius">已隐藏</span>';
        }
        $edit_url = url('seller_menu/seller_menu_edit') . '?id=' . $val['id'];
        $html = '<tr class="text-c ' . $trClass . '" >';
        $html .= '   <td><input name="id[]" type="checkbox" value="' . $val['id'] . '"></td>';
        $html .= '   <td>' . $val['id'] . '</td>';
        $html .= '   <td class="text-l">' . $type_text . '<i class="Hui-iconfont"></i>&nbsp;&nbsp;' . $val['menu_name'] . '</td>';
        $html .= '   <td class="text-l">' . $val['methods'] . '</td>';
        $html .= '   <td>' . $val['parameter'] . '</td>';
        $html .= '   <td>' . $val['hierarchy'] . '</td>';
        $html .= '   <td>' . $val['sort'] . '</td>';
        $html .= '   <td>' . $val['create_time'] . '</td>';
        $html .= '   <td class="td-status">' . $is_show . '</td>';
        $html .= '   <td class="td-manage">';
        $html .= '      ' . $add_text;
        $html .= '      <a style="text-decoration:none" class="ml-5" onClick="href_url(\'商家菜单编辑\', \'' . $edit_url . '\')" href="javascript:;" title="编辑">';
        $html .= '         <i class="Hui-iconfont">&#xe6df;</i>';
        $html .= '      </a>';
        $html .= '      <a style="text-decoration:none" class="ml-5" onClick="datadel(' . $val['id'] . ')" href="javascript:;" title="删除">';
        $html .= '         <i class="Hui-iconfont">&#xe6e2;</i>';
        $html .= '      </a>';
        $html .= '   </td>';
        $html .= '</tr>';
        return $html;
    }

    public function seller_menu_add() {
        if ($this->request->isAjax()) {
            $res = sellerMenuModel::addMd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $sellerMenu = sellerMenuModel::getList(['pid' => 0], 50);
        $list = $sellerMenu->toArray();
        foreach ($list['data'] as $key => $val) {
            $list['data'][$key]['lister'] = sellerMenuModel::getPidlist($val['id']);
        }
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function seller_menu_edit() {
        if ($this->request->isAjax()) {
            $res = sellerMenuModel::editMd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $info = sellerMenuModel::get(input('id'));
        $this->assign("info", $info);
        $sellerMenu = sellerMenuModel::getList(['pid' => 0], 50);
        $list = $sellerMenu->toArray();
        foreach ($list['data'] as $key => $val) {
            $list['data'][$key]['lister'] = sellerMenuModel::getPidlist($val['id']);
        }
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            foreach ($id_arr as $val) {
                $infoCount = sellerMenuModel::where(['pid' => $val])->count();
                if ($infoCount > 0) {
                    Tiperror("你选择的分类还有子分类！");
                }
            }
            $result = sellerMenuModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
