<?php

/**
 * 提现申请信息
 */

namespace app\index\controller\seller_statselement;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\Withdrawal as withdrawalModel;
use app\common\model\Seller as sellerModel;

class Withdrawal extends SellerCommon {

    public function withdrawal_list() {
        $store = $this->store;
        $withdrawal = withdrawalModel::getList(['store_id' => $store['id']], 10);
        $this->assign('withdrawal', $withdrawal->toArray());
        $this->assign('page', $withdrawal->render());
        return $this->fetch();
    }

    public function withdrawal_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            Db::startTrans();
            try {
                $post = input('post.');
                $seller = sellerModel::lock(true)->where(['id' => $store['seller_id']])->find();
                if (!is_pinteger($post['toapplyfor_amount'])) {
                    Tiperror("提现金额必须是正整数！");
                }
                if ($post['toapplyfor_amount'] < 10) {
                    Tiperror("提现金额最小10元！");
                }
                if ($seller['seller_forehead'] < $post['toapplyfor_amount']) {
                    Tiperror("可提现余额不足！");
                }
                $balance = $seller['seller_forehead'] - $post['toapplyfor_amount'];
                $data = ['store_id' => $store['id'], 'store_name' => $store['store_name'], 'toapplyfor_amount' => $post['toapplyfor_amount'],
                    'bank_name' => $post['bank_name'], 'bank_account' => $post['bank_account'], 'account_name' => $post['account_name'],
                    'bank_name' => $post['bank_name'], 'state' => 1, 'note' => $post['note'], 'balance' => $balance, 'seller_id' => $store['seller_id'],
                    'create_time' => time()];
                $result = withdrawalModel::add($data);
                if ($result) {
                    sellerModel::setDecs(['id' => $store['seller_id']], 'seller_forehead', $post['toapplyfor_amount']);
                    Db::commit();
                    Tobesuccess('提现申请提交成功');
                } else {
                    Tiperror("提现申请提交失败！");
                }
            } catch (\Exception $e) {
                Db::rollback();
                Tiperror("出现其他异常", $e->getMessage());
            }
        }

        return $this->fetch();
    }

    public function modifyAudit() {
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
