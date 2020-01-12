<?php
/**
 * 付款记录信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\PaymentLog as PaymentLogModel;
use \think\Db;

class PaymentLog extends Common {

    public function getlist() {
        $list = PaymentLogModel::getPaymentLoglist([],'pl.*,m.member_name,m.mobile,p.payment_mark,p.payment_name',10);
        $this->assign("ploglist", $list['list']);
        $this->assign("list", $list);
        $this->assign("allcount", $list['count']);
        $this->assign("limit", 10);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign("pay_state", input('pay_state'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }


    public function edit() {
        if ($this->request->isAjax()) {
            $res = PaymentLogModel::updates();
            if ($res) {
                Tobesuccess("修改成功");
            } else {
                Tiperror("修改失败");
            }
        }
        $info = PaymentLogModel::get(input('get.id'));
        $this->assign("info", $info);
        return $this->fetch();
    }
    public function paymentOperation() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = PaymentLogModel::updates(['id'=>$get['id']],['state'=>40,'create_time'=>time()]);
            if ($res) {
                Tobesuccess("付款成功");
            } else {
                Tiperror("付款失败");
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
            $result = PaymentLogModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
