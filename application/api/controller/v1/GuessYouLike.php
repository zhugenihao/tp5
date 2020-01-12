<?php

/**
 * 猜你喜欢商品信息
 */

namespace app\api\controller\v1;

use app\api\controller\v1\Common;
use \think\Db;
use app\api\model\Goods as GoodsModel;

class GuessYouLike extends Common {

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $salesfield = 'goods_id,goods_name,goods_price,thecover,sales';
            $salesGoodsList = GoodsModel::getGoodsList([], $salesfield, $get['start'], $get['limit'], ['sales' => 'desc']);
            exit(json_encode($salesGoodsList));
        }
        return $this->fetch();
    }

}
