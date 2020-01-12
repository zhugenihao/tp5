<?php

/**
 * 用户收藏商品信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Collection as collectionModel;

class Collection extends Common {

    /**
     * 清空收藏
     */
    public function deleteCollection() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $mid = $this->mId();
            $result = collectionModel::destroy(['m_id' => $mid]);
            if ($result) {
                Tobesuccess('已经清空收藏');
            } else {
                Tiperror("收藏失败！");
            }
        }
    }

    public function addCollection() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $mid = $this->mId();
            $where = ['goods_id' => $get['goods_id'], 'm_id' => $mid];
            $data = ['m_id' => $mid, 'goods_id' => $get['goods_id'], 'create_time' => time()];
            $result = collectionModel::updates($where, $data);
            if ($result) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("成功失败！");
            }
        }
    }

}
