<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\BesidesContent as besidesContentModel;
use app\common\model\SecondsKill as secondsKillModel;

class SecondsKill extends Common {

    public function index() {
        $secondGoodsTimeList = besidesContentModel::getSecondGoodsTimeList();

        //今天某个时间段的秒杀商品
        $hours = !empty(input('time')) ? input('time') : date('H:00:00');
        $secondsKillList = secondsKillModel::getSecondsKillTimePc($hours, 10);
        
        $this->assign('page', $secondsKillList['list']->render());
        $this->assign('secondsKillList', $secondsKillList['list']);
        $this->assign('secondGoodsTimeList', $secondGoodsTimeList);
        $this->assign('shours', date('H'));
        $this->assign('shours0', date('H:00:00'));
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
