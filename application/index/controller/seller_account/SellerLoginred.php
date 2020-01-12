<?php

/**
 * 商家登陆日志
 */

namespace app\index\controller\seller_account;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\SellerLoginred as sellerLoginredModel;

class SellerLoginred extends SellerCommon {

    public function seller_loginred() {
        $store = $this->store;
        $sellerLoginred = sellerLoginredModel::getList(['store_id' => $store['id']], 10);
        $this->assign('sellerLoginred', $sellerLoginred->toArray());
        $this->assign('page', $sellerLoginred->render());
        return $this->fetch();
    }

    /**
     * 删除登陆日志
     */
    public function delSellerLoginred() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = sellerLoginredModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
