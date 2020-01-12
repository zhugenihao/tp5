<?php

/**
 * 商品喜欢信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Givealike as givealikeModel;

class Givealike extends Common {

    public function submitGivealike() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $where = ['m_id' => $this->mId(), 'goods_id' => $get['goods_id']];
            $data = ['m_id' => $this->mId(), 'goods_id' => $get['goods_id'], 'givealike' => 1];
            $result = givealikeModel::submitGivealikeMd($where, $data);
            $givealike = givealikeModel::getValue($where, 'givealike');
            if ($givealike == 1) {
                Tobesuccess('感谢喜欢');
            } elseif ($givealike == 2) {
                Tobesuccess('不喜欢也可以');
            } elseif ($result == '') {
                Tiperror("操作失败！");
            }
        }
    }

}
