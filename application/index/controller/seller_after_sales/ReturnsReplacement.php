<?php

/**
 * 退换货信息
 */

namespace app\index\controller\seller_after_sales;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\ReturnsReplacement as returnsReplacementModel;

class ReturnsReplacement extends SellerCommon {

    public function retplt_list() {
        $store = $this->store;
        $retplt = returnsReplacementModel::getList(['store_id' => $store['id']], 10);
        $this->assign('retplt', $retplt->toArray());
        $this->assign('page', $retplt->render());
        return $this->fetch();
    }

    public function retplt_details() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $result = returnsReplacementModel::updates(['id' => $post['id']], ['state' => $post['state']]);
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = returnsReplacementModel::get(input('id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function modifyAudit() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = returnsReplacementModel::updates(['id' => $get['id']], ['state' => $get['state']]);
            if ($result) {
                if ($get['state'] == 2) {
                    Tobesuccess('审核通过操作成功');
                } else {
                    Tobesuccess('审核不通过操作成功');
                }
            } else {
                Tiperror("编辑失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 删除退换货
     */
    public function delRetplt() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = returnsReplacementModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
