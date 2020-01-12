<?php
/**
 * 首页信息
 */
namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Directory as directoryModel;
use app\common\model\Advert as advertModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\Brand as brandModel;
use app\index\model\ComdysalesPromotion as comdysalesPromotionModel;

class Index extends Common {

    public function index() {
        //轮播图片
        $advertList = advertModel::getAdvertlist('home_advert', 1,1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $common_advert = advertModel::getAdvertlist('home_advert', 2,1, 6);
        $this->assign('common_advert', $common_advert);
        //左边导航栏
        $dirfield = 'id,title,home_template_p,small_icon,alias';
        $dirWhere = ['type' => 3, 'pid' => 0];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 12)->toArray();
        $directoryList1 = array();
        foreach ($directoryList as $key => $val) {
            if (!in_array($val['id'], array(1, 61, 62))) {
                $directoryList1[$key] = $val;
                $directoryList1[$key]['directory_2'] = directoryModel::getDirectoryList(['pid' => $val['id']], $dirfield, 12)->toArray();
                foreach ($directoryList1[$key]['directory_2'] as $key2 => $val2) {
                    $directoryList1[$key]['directory_2'][$key2]['directory_3'] = directoryModel::getDirectoryList(['pid' => $val2['id']], $dirfield, 12)->toArray();
                }
            }
        }
        $this->assign('directory_list', $directoryList1);
        
        //品牌
        $brandlist = brandModel::getBrandlist(['is_show'=>1],5);
        $this->assign("brandlist", $brandlist['list']);
        //拼团商品
        $spellGroupList = spellGroupModel::getSpellGrouplist([], 0, 6);
        $this->assign('spellGroupList', $spellGroupList['list']);
        //促销优惠商品
        $comdysalespList = comdysalesPromotionModel::getPcList([], 0, 10);
        $this->assign('comdysalespList', $comdysalespList['list']);
        //猜你喜欢商品
        $salesfield = 'goods_id,goods_name,goods_price,thecover,sales';
        $salesGoodsList = GoodsModel::getGoodsList([], $salesfield, 0, 10, ['sales' => 'desc']);
        $this->assign('salesGoodsList', $salesGoodsList['list']);
        
        return $this->fetch();
    }
    //今天某个时间段的秒杀商品
    public function secondsKillCurrent() {
        if ($this->request->isAjax()) {
            $secondsKillList = secondsKillModel::getSecondsKillTime('', 0, 6);
            $list = array('shours' => date('H'), 'list' => $secondsKillList['list']);
            exit(json_encode($list));
        }
    }

}
