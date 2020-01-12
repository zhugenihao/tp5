<?php

/**
 * 商家通知信息
 */

namespace app\index\controller\seller_kefu;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\SellerNotice as sellerNoticeModel;

class SellerNotice extends SellerCommon {

    public function sellernce_list() {
        $store = $this->store;
        $sellernce = sellerNoticeModel::getList(['store_id' => $store['id']], 10);
        $this->assign('sellernce', $sellernce->toArray());
        $this->assign('page', $sellernce->render());
        return $this->fetch();
    }

    public function sellernce_details() {
        $info = sellerNoticeModel::get(input('id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除商家通知
     */
    public function delSellernce() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerNoticeModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
