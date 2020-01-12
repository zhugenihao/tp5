<?php

/**
 * 商品秒杀信息
 */

namespace app\mobile\controller;

use app\mobile\controller\Common;
use \think\Db;
use app\common\model\BesidesContent as besidesContentModel;
use app\common\model\SecondsKill as secondsKillModel;

class SecondsKill extends Common {

    public function index() {
        $secondGoodsTimeList = besidesContentModel::getSecondGoodsTimeList();
        $this->assign('secondGoodsTimeList', $secondGoodsTimeList);
        return $this->fetch();
    }

    //今天某个时间段的秒杀商品
    public function secondsKillCurrent() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $secondsKillList = secondsKillModel::getSecondsKillTime($get['hours'], $get['start'], $get['limit']);
            $secondsKillList['shours'] = date('H');
            exit(json_encode($secondsKillList));
        }
    }

    /**
     * 判断秒杀商品是否已超时
     */
    public function secondsKillJudge() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = secondsKillModel::getSecondsKillInfoTime(['goods_id' => $get['goods_id']]);
            if ($result) {
                Tobesuccess('秒杀商品可购买');
            } else {
                Tiperror("秒杀商品已超时！");
            }
        }
    }

}
