<?php

/**
 * 结算记录信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\common\model\StoreSettlement as storeSettlementModel;

class StoreSettlement extends Common {

    public $total_platform = '';

    public function _initialize() {
        parent::_initialize();
        $this->total_platform = db::name('total_platform');
    }

    public function storelemt_list() {
        $store_id = input('store_id');
        $where = !empty($store_id) ? ['store_id' => $store_id] : [];
        $storelemt = storeSettlementModel::getList($where, 10);
        $this->assign('list', $storelemt->toArray());
        $this->assign('page', $storelemt->render());
        
        $total_balance = $this->total_platform->where('id','=',1)->value('total_balance');
        $this->assign('total_balance', $total_balance);
        return $this->fetch();
    }

}
