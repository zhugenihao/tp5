<?php

/**
 * 用户优惠券信息
 */

namespace app\mobile\controller;

use \think\Db;
use app\mobile\controller\Common;
use app\common\model\WatchHistory as watchHistoryModel;

class WatchHistory extends Common {

    /**
     * 清空足迹
     */
    public function deleteWatchHistory() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $mid = $this->mId();
            $result = watchHistoryModel::destroy(['m_id' => $mid]);
            if ($result) {
                Tobesuccess('已经清空足迹');
            } else {
                Tiperror("清空失败！");
            }
        }
    }

}
