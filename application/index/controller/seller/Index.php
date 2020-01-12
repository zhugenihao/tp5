<?php

namespace app\index\controller\Seller;

use \think\Exception;
use \think\Db;
use app\index\controller\SellerCommon;
use app\common\model\Seller as sellerModel;
use app\common\model\SellerMenu as sellerMenuModel;
use app\index\model\Goods as goodsModel;
use app\common\model\Order as orderModel;
use app\common\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\Comments as commentsModel;
use app\common\model\Complaints as complaintsModel;
use app\common\model\ReturnsReplacement as returnsReplacementModel;
use app\common\model\SellerNotice as sellerNoticeModel;
use app\common\model\SellerGroup as sellerGroupModel;
use think\Cache;

class Index extends SellerCommon {

    public function _initialize() {
        parent::_initialize();
    }

    public function home() {
//        session('seller_id',null);
//        $storeIs = sellerModel::getCount(['seller_name' => $this->seller_name]);
        
        if (!$this->seller_id) {
            $this->redirect('seller/login');
        }
        $sellerMenu = sellerMenuModel::getMenuList(['pid' => 0], 20);
        $sellerMenu = $sellerMenu->toArray();

        $smenu_id = input('smenu_id');
        $smenu_id = !empty($smenu_id) ? $smenu_id : $sellerMenu[0]['id'];

        $sellerMenuEr = Cache::get("sellerMenuEr" . $smenu_id);
        if (empty($sellerMenuEr)) {
            $sellerMenuEr = sellerMenuModel::getMenuList(['pid' => $smenu_id], 20);
            Cache::set("sellerMenuEr" . $smenu_id, $sellerMenuEr);
        }

        $this->assign('sellerMenuEr', $sellerMenuEr);

        $seller = sellerModel::getInfo(['id' => $this->seller_id], "*");
        $this->assign('seller', $seller);
        $store = $this->store;
        $sellerGroup = sellerGroupModel::getInfo(['store_id' => $store['id'], 'id' => $seller['group_id']], '*');
        $menuid_arr = json_decode($sellerGroup['menuid_str'], true);
        $menuid_is_arr = array();
        if ($menuid_arr) {
            foreach ($menuid_arr as $key => $menu_id) {
                $menuid_is_arr[$menu_id] = $menu_id;
            }
        }
        $this->assign('store', $store);
        $this->assign('seller_name', $this->seller_name);
        $this->assign('menuid_is_arr', $menuid_is_arr);

        return $this->fetch();
    }

    public function index() {
        if (!$this->seller_id) {
            $this->redirect('seller/login');
        }
        $store = $this->store;
        $this->assign('store', $store);
        $seller = sellerModel::getInfo(['id' => $this->seller_id], "*");
        $this->assign('seller', $seller);
        //全部商品
        $this->assign('goodsCountAll', goodsModel::getCount(['store_id' => $store['id']]));
        //出售中的商品
        $this->assign('goodsCountSell', goodsModel::getCount(['store_id' => $store['id'], 'is_show' => 1]));
        //仓库中的商品
        $this->assign('goodsCountWarehouse', goodsModel::getCount(['store_id' => $store['id'], 'is_show' => 0]));

        //全部订单
        $this->assign('orderCountAll', orderModel::getCount(['store_id' => $store['id']]));
        //秒杀订单
        $this->assign('orderCountSkill', orderModel::getCount(['store_id' => $store['id'], 'activity' => 'seconds_kill']));
        //拼团订单
        $this->assign('orderCountSgroup', orderModel::getCount(['store_id' => $store['id'], 'activity' => 'spell_group']));
        //促销订单
        $this->assign('orderCountCsalesp', orderModel::getCount(['store_id' => $store['id'], 'activity' => 'comdysalesp']));

        //商品促销
        $this->assign('goodsCountCsalesp', comdysalesPromotionModel::getCount(['store_id' => $store['id']]));
        //商品拼团
        $this->assign('goodsCountSgroup', spellGroupModel::getCount(['store_id' => $store['id']]));
        //商品秒杀
        $this->assign('goodsCountSkill', secondsKillModel::getCount(['store_id' => $store['id']]));

        //总评论
        $this->assign('commentsAll', commentsModel::getCount(['store_id' => $store['id']]));
        //投诉
        $this->assign('complaintsAll', complaintsModel::getCount(['store_id' => $store['id']]));
        //退换货
        $this->assign('retpltAll', returnsReplacementModel::getCount(['store_id' => $store['id']]));

        //系统消息
        $this->assign('noticeAll', sellerNoticeModel::getCount(['store_id' => $store['id']]));

        //销售排行
        $goodsList = goodsModel::getGoodsSellerListPc(['store_id' => $store['id']], 'goods_id,goods_name,sales', 4, ['sales' => 'desc']);
        $this->assign('goodsList', $goodsList['list']);
        return $this->fetch();
    }

}
