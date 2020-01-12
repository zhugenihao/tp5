<?php

/**
 * 店铺结算记录信息
 */

namespace app\index\controller\seller_statselement;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\StoreSettlement as storeSettlementModel;

class StoreSettlement extends SellerCommon {

    public function storelemt_list() {
        $store = $this->store;
        $storelemt = storeSettlementModel::getList(['store_id' => $store['id']], 10);
        $this->assign('storelemt', $storelemt->toArray());
        $this->assign('page', $storelemt->render());
        return $this->fetch();
    }

}
