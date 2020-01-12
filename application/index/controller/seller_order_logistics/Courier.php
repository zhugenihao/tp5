<?php

/**
 * 快递信息
 */

namespace app\index\controller\seller_order_logistics;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Courier as courierModel;
use app\common\model\SellerCourier as sellerCourierModel;

class Courier extends SellerCommon {

    public function courier_index() {
        $store = $this->store;
        $courierid_arr = array();
        $courierList = courierModel::getList(['is_show' => 1], '*', 0, 10);
        $courierid_str = sellerCourierModel::getValue(['store_id' => $store['id']], 'courierid_str');
        $courierid_str_arr = explode(",", $courierid_str);
        foreach ($courierid_str_arr as $courier_id) {
            $courierid_arr[$courier_id] = $courier_id;
        }
        foreach ($courierList as $courier_key => $courier_val) {
            $is_show = 0;
            if (isset($courierid_arr[$courier_val['id']])) {
                $is_show = 1;
            }
            $courierList[$courier_key]['is_show'] = $is_show;
        }
        $this->assign('courierList', $courierList);
        return $this->fetch();
    }

    /**
     * 编辑快递方式
     */
    public function updateSellerCourier() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $courierid_str = trim(input('courierid_str'));
            if (empty($courierid_str)) {
                Tiperror("您未选择！");
            }
            if (sellerCourierModel::getCount(['store_id' => $store['id']])) {
                $result = sellerCourierModel::where(['store_id' => $store['id']])->update(['courierid_str' => $courierid_str, 'update_time' => time()]);
            } else {
                $result = sellerCourierModel::create(['store_id' => $store['id'], 'courierid_str' => $courierid_str, 'update_time' => time()]);
            }
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败");
            }
        }
    }

}
