<?php

/**
 * 提现申请信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\common\model\Withdrawal as withdrawalModel;
use app\common\model\Seller as sellerModel;
use app\common\model\Store as storeModel;

class Withdrawal extends Common {

    public function withdrawal_list() {
        $withdrawal = withdrawalModel::getList([], 10);
        $this->assign('list', $withdrawal->toArray());
        $this->assign('page', $withdrawal->render());
        return $this->fetch();
    }

    public function withdrawal_edit() {
        $info = withdrawalModel::get(input('id'));
        if ($this->request->isAjax()) {
            Db::startTrans();
            try {
                $post = input('post.');
                $seller = sellerModel::lock(true)->where(['id' => $info['seller_id']])->find();
                $data = ['state' => $post['state'], 'note' => $post['note']];
//                print_r($data);die();
                $result = withdrawalModel::updates(['id' => $post['id']], $data);
                if ($result) {
                    if ($post['state'] == 3) {//审核失败就返回金额
                        sellerModel::setIncs(['id' => $info['seller_id']], 'seller_forehead', $info['toapplyfor_amount']);
                    }
                    Db::commit();
                    Tobesuccess('操作成功');
                } else {
                    Tiperror("编辑失败！");
                }
            } catch (\Exception $e) {
                Db::rollback();
                Tiperror("出现其他异常", $e->getMessage());
            }
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function modifyState() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = withdrawalModel::updates(['id' => $get['id']], ['state' => $get['state']]);
            if ($result) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 删除提现申请
     */
    public function delWithdrawal() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = withdrawalModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
