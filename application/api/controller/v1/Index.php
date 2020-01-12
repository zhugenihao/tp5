<?php

/**
 * 首页信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Advert as advertModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\api\model\Goods as GoodsModel;
use app\api\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Category as categoryModel;
use app\common\model\BesidesContent as besidesContentModel;

class Index extends Common {

    public function index() {
        //轮播图片
        $advertList = advertModel::getAdvertlist('home_advert', 1, 2, 6);
        //单图广告
        $common_advert = advertModel::getAdvertlist('home_advert', 2, 2, 6);

        //首页模块按钮
        $category = categoryModel::getCategorylist(['store_id' => 0, 'equipment' => 1], "*", 20);

        //拼团商品
        $spellGroupList = spellGroupModel::getSpellGrouplist([], 0, 6);
        //促销优惠商品
        $comdysalespList = comdysalesPromotionModel::getMobileList([], 0, 10);
        //猜你喜欢商品
        $salesfield = 'goods_id,goods_name,goods_price,thecover,sales';
        $salesGoodsList = GoodsModel::getGoodsList([], $salesfield, 0, 10, ['sales' => 'desc']);

        $list = ['advert_list' => $advertList, 'common_advert' => $common_advert, 'category' => $category,
            'spell_group_list' => $spellGroupList['list'], 'comdysalesp_list' => $comdysalespList['list'],
            'sales_goods_list' => $salesGoodsList['list'],'small_icon' => besidesContentModel::small_icon_list()];
        
        Tobesuccess("成功获取首页数据", $list);
    }

    //今天某个时间段的秒杀商品
    public function secondsKillCurrent() {
        if ($this->request->isGet()) {
            $secondsKillList = secondsKillModel::getSecondsKillTime('', 0, 6);
            $list = array('shours' => date('H'), 'list' => $secondsKillList['list']);
            Tobesuccess("成功获取首页数据", $list);
        }
    }


}
