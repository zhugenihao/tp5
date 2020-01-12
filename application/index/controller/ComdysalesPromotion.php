<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\index\model\ComdysalesPromotion as comdysalesPromotionModel;

class ComdysalesPromotion extends Common {

    public function index() {
        $comdypList = comdysalesPromotionModel::getList([], 10);
        $this->assign('page', $comdypList->render());
        $this->assign('comdypList', $comdypList->toArray());
        return $this->fetch();
    }

    /**
     * 判断促销商品是否已超时
     */
    public function comdypJudge() {
        if ($this->request->isAjax()) {
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
