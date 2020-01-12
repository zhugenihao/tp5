<?php
/**
 * 钱包信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Wallet as walletModel;
use \think\Db;

class Wallet extends Common {

    public function wallet_list() {
        $limit = 10;
        $list = walletModel::getList($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function wallet_add() {
        $info = walletModel::get(input('id'));
        $this->assign("info", $info);

        return $this->fetch();
    }

    public function walletSubmit() {
        if ($this->request->isAjax()) {
            $res = walletModel::Walletaddeditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $info = walletModel::get(input("id"));
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
            $result = walletModel::walletDelete();
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
