<?php

/**
 * 特价优惠
 */

namespace app\api\controller\v1;

use app\api\controller\v1\Common;
use \think\Db;
use app\api\model\ComdysalesPromotion as comdysalesPromotionModel;

class ComdysalesPromotion extends Common {

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $comdypList = comdysalesPromotionModel::getMobileList([], $get['start'], $get['limit']);
            exit(json_encode($comdypList));
        }
        return $this->fetch();
    }
    /**
     * 判断促销商品是否已超时
     */
    public function comdypJudge() {
        if ($this->request->isGet()) {
            $get = input('get.');
            $result = comdysalesPromotionModel::getComdypInfoTime(['goods_id' => $get['goods_id']]);
            if ($result) {
                Tobesuccess('促销商品可购买');
            } else {
                Tiperror("促销商品已超时！");
            }
        }
    }

}
