<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Goods as GoodsModel;

class GuessYouLike extends Common {

    public function index() {
        $salesfield = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $salesGoodsList = GoodsModel::getGoodsListPc([], $salesfield, 10, ['sales' => 'desc']);
        $this->assign('page', $salesGoodsList['list']->render());
        $this->assign('salesGoodsList', $salesGoodsList['list']);
        return $this->fetch();
    }

}
