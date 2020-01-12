<?php

/**
 * 首页信息
 */

namespace app\mobile\controller;

use \think\Db;
use app\mobile\controller\Common;
use app\mobile\model\Advert as advertModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\mobile\model\Goods as GoodsModel;
use app\mobile\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Category as categoryModel;

class Index extends Common {

    public function index() {
        //轮播图片
        $advertList = advertModel::getAdvertlist('home_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $common_advert = advertModel::getAdvertlist('home_advert', 2, 2, 6);
        $this->assign('common_advert', $common_advert);

        //首页模块按钮
        $category = categoryModel::getCategorylist(['store_id' => 0, 'equipment' => 1], "*", 20);

        $this->assign('category', $category);

        //拼团商品
        $spellGroupList = spellGroupModel::getSpellGrouplist([], 0, 6);
        $this->assign('spellGroupList', $spellGroupList['list']);
        //促销优惠商品
        $comdysalespList = comdysalesPromotionModel::getMobileList([], 0, 10);
        $this->assign('comdysalespList', $comdysalespList['list']);
        //猜你喜欢商品
        $salesfield = 'goods_id,goods_name,goods_price,thecover,sales';
        $salesGoodsList = GoodsModel::getGoodsList([], $salesfield, 0, 10, ['sales' => 'desc']);
        $this->assign('salesGoodsList', $salesGoodsList['list']);

        return $this->fetch("index/home");
    }

    //今天某个时间段的秒杀商品
    public function secondsKillCurrent() {
        if ($this->request->isAjax()) {
            $secondsKillList = secondsKillModel::getSecondsKillTime('', 0, 6);
            $list = array('shours' => date('H'), 'list' => $secondsKillList['list']);
            exit(json_encode($list));
        }
    }

    public function home() {
        $this->index();
        return $this->fetch();
    }

}
