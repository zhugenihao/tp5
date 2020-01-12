<?php
/**
 * 支付方式信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Payment as PaymentModel;
use \think\Db;

class Payment extends Common {

    public function getlist() {
        $list = PaymentModel::getPaymentlist(10);
        $this->assign("list", $list['list']);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 10);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function add() {
        if ($this->request->isAjax()) {
            $res = PaymentModel::add();
            if ($res) {
                Tobesuccess("支付方式添加成功");
            } else {
                Tiperror("支付方式添加失败");
            }
        }
        return $this->fetch();
    }

    public function edit() {
        if ($this->request->isAjax()) {
            $res = PaymentModel::updates();
            if ($res) {
                Tobesuccess("支付方式修改成功");
            } else {
                Tiperror("支付方式修改失败");
            }
        }
        $info = PaymentModel::get(input('get.id'));
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info1 = PaymentModel::get($id);
            $info = PaymentModel::get($id);
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
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = PaymentModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
