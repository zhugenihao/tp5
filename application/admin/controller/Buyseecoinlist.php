<?php

/**
 * 购买余额币信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Buyseecoinlist as BuyseecoinlistModel;
use \think\Db;

class Buyseecoinlist extends Common {

    public function Buyseecoinlist() {
        $limit = 10;
        $list = BuyseecoinlistModel::getBuyseecoinlist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("catetype", input('catetype'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function Buyseecoinlist_add() {

        $id = (int) (input('id'));
        $info = BuyseecoinlistModel::get($id);
        $this->assign("info", $info);

        return $this->fetch();
    }

    public function Buyseecoinlist_addedit() {
        $res = BuyseecoinlistModel::buyseecoinlistAddeditmd();
        if ($res) {
            Tobesuccess("操作成功");
        } else {
            Tiperror("操作失败");
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $idStr = input('post.idStr');
            $idArr = explode(",", $idStr);
            if (empty($idArr)) {
                Tiperror("您未选择！");
            }
            $result = BuyseecoinlistModel::destroy($idArr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
