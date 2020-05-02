<?php

/**
 * 商品信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Goods as GoodsModel;
use app\common\model\Norm as NormModel;
use app\common\model\Cates as catesModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\Cart as cartModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\Directory as directoryModel;
use app\api\model\Advert as advertModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\api\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Order as orderModel;
use app\index\model\Kefu as kefuModel;

class Goods extends Common {

    //商品推荐
    public function recommended() {
        if ($this->request->isGet()) {
            $get = input('get.');
            $start = isset($get['start']) ? $get['start'] : 0;
            $limit = isset($get['limit']) ? $get['limit'] : 10;
            $field = 'goods_id,goods_name,goods_price,thecover,number_payment';
            $goodsRecommendedList = GoodsModel::getGoodsList(['recommended' => 1], $field, $start, $limit, ['number_payment' => 'desc']);
            $recommended_advert2 = advertModel::getAdvertlist('recommended_advert', 2, 2, 6);
            $recommended_advert20 = isset($recommended_advert2[0]) ? $recommended_advert2[0] : array('adv_link' => '', 'dire' => '');

            $list = ['goods_list' => $goodsRecommendedList, 'recommended_advert20' => $recommended_advert20];
            exit(json_encode($list));
        }
    }

    /**
     * 商品详情
     * @return type
     */
    public function goods_details() {
        if ($this->request->isGet()) {
            $goodsId = input('goods_id', 0, 'intval');
            $activity = input('activity', '', 'trim'); //活动参数
            $goodsInfo = GoodsModel::getGoodsInfo(['goods_id' => $goodsId]);

            $cartCount = cartModel::getCount(['m_id' => $this->mid]);

            $secondsKillInfo = [];
            $spellGroupInfo = [];
            $comdysalespInfo = [];
            if ($activity == 'seconds_kill') {//秒杀信息
                $secondsKillInfo = secondsKillModel::getInfo(['goods_id' => $goodsId]);
            } else if ($activity == 'spell_group') {//拼团信息
                $spellGroupInfo = spellGroupModel::getInfo(['goods_id' => $goodsId]);
            } else if ($activity == 'comdysalesp') {//促销信息
                $comdysalespInfo = comdysalesPromotionModel::getInfo(['goods_id' => $goodsId]);
            }
            $list = ['goods' => $goodsInfo, 'secondsKillInfo' => $secondsKillInfo, 'spellGroupInfo' => $spellGroupInfo,
                'comdysalespInfo' => $comdysalespInfo, 'cart_count' => $cartCount];
            exit(json_encode($list));
        }
    }

    /**
     * 获取商品版本信息
     */
    public function catesList() {
        if ($this->request->isGet()) {
            $goods_id = input('goods_id', 0, 'intval');
            $goodscolor_id = input('goodscolor_id', 0, 'intval');
            $activity = input('activity', '', 'trim'); //活动参数
            $goods = GoodsModel::getInfo(['goods_id' => $goods_id], 'goods_price,thecover');
            $normInfo = NormModel::getInfo(['goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id], 'n_id,goodscolor_id');
            $inventoryArr = inventoryModel::getList(['n_id' => $normInfo['n_id'], 'goods_id' => $goods_id])->toArray();
            $cateid = array();
            $cate_price0 = '';
            $orgprice0 = '';
            $inventory0 = '';
            $cate_price_arr = array();
            $inventory_arr = array();
            if ($inventoryArr) {
                foreach ($inventoryArr as $inval) {
                    $cateid[] = $inval['cate_id'];
                    $cate_price_arr[$inval['cate_id']] = $inval['inty_price'];
                    $inventory_arr[$inval['cate_id']] = $inval['inventory'];
                }
            }
            $catesList = catesModel::all($cateid);
            $catesList = !empty($inventoryArr) ? $catesList : '';
            if ($catesList) {

                foreach ($catesList as $catelKey => $catelVal) {
                    //商品价格
                    $cate_price = orderGoodsModel::priceCalculation($goods_id, $normInfo['n_id'], $catelVal['cate_id'], $activity);

                    $catesList[$catelKey]['cate_price'] = sprintf("%.2f", $cate_price);
                    $catesList[$catelKey]['orgprice'] = sprintf("%.2f", $cate_price_arr[$catelVal['cate_id']]);
                    $catesList[$catelKey]['inventory'] = $inventory_arr[$catelVal['cate_id']];
                }
                $cate_price0 = $catesList[0]['cate_price'];
                $orgprice0 = $catesList[0]['orgprice'];
                $inventory0 = $catesList[0]['inventory'];
            }
            $img_small = galleryModel::getValue(['n_id' => $normInfo['n_id']], 'img_small');
            $default_gallery = !empty($img_small) ? $img_small : $goods['thecover'];
            $normInfo['default_gallery'] = $default_gallery;
            $list = array('cate_price' => $cate_price0, 'orgprice' => $orgprice0, 'inventory' => $inventory0,
                'norm_info' => $normInfo, 'cates_list' => $catesList);
            exit(json_encode($list));
        }
    }

    /**
     * 添加购物车
     */
    public function addCart() {
        if ($this->request->isPost()) {
            $post = input('post.');
            $mid = $this->mId();
            $where = ['setup_norm' => $post['setup_norm'], 'goods_id' => $post['goods_id'],
                'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'm_id' => $mid];
            $count = cartModel::getCount($where);
            if ($count) {
                Tiperror("已添加过了！");
            }

            $goods = GoodsModel::get($post['goods_id']);
            //成本价
            $costPrice = GoodsModel::getCostPrice($post['goods_id'], $post['n_id'], $post['cate_id']);
            //商品价格
            $goods_price = orderGoodsModel::priceCalculation($post['goods_id'], $post['n_id'], $post['cate_id'], $post['activity']);
            //运费
            $totalFreight = orderModel::freightCalculate($post['goods_id'], $post['goods_num'], $post['n_id'], $post['cate_id']);
            //总费用
            $totalPrice = $goods_price * $post['goods_num'] + $totalFreight;

            $imgSmall = galleryModel::getValue(['n_id' => $post['n_id']], 'img_small');
            $goods_img = !empty($post['setup_norm'] == 'off' || !$imgSmall) ? $goods['thecover'] : $imgSmall;
            $goodsColor = goodsColorModel::get(NormModel::getValue(['n_id' => $post['n_id']], 'goodscolor_id'));
            $cates = catesModel::get($post['cate_id']);
            $data = ['goods_id' => $post['goods_id'], 'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'goods_price' => $goods_price,
                'goods_num' => $post['goods_num'], 'm_id' => $mid, 'total_price' => $totalPrice, 'create_time' => time(),
                'goods_name' => $goods['goods_name'], 'goods_img' => $goods_img, 'goods_information' => $goodsColor['color_name'] . $cates['cate_name'],
                'activity' => $post['activity'], 'setup_norm' => $post['setup_norm'], 'spell_list_m_id' => $post['first_member_id'],
                'sgm_id' => $post['sgm_id'], 'store_id' => $post['store_id'], 'cost_price' => $costPrice, 'courier_price' => $totalFreight];
            $result = cartModel::add($data);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 日常超市
     * @return type
     */
    public function supermarket() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('supermarket_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $supermarket_advert2 = advertModel::getAdvertlist('supermarket_advert', 2, 2, 6);
        $supermarket_advert20 = isset($supermarket_advert2[0]) ? $supermarket_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('supermarket_advert20', $supermarket_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_m,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $supermarketGoodsList = GoodsModel::getGoodsList(['dir_id' => ['in', $dirIdArr]], $field, 0, 10, ['sales' => 'desc']);
        $this->assign('supermarketGoodsList', $supermarketGoodsList['list']);

        return $this->fetch();
    }

    public function goods_lucky_draw() {
        return $this->fetch();
    }

    /**
     * 服装市场
     * @return type
     */
    public function clothing_store() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('clothing_store_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $clothing_store_advert2 = advertModel::getAdvertlist('clothing_store_advert', 2, 2, 6);
        $clothing_store_advert20 = isset($clothing_store_advert2[0]) ? $clothing_store_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('clothing_store_advert20', $clothing_store_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_m,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $clothingGoodsList = GoodsModel::getGoodsList(['dir_id' => ['in', $dirIdArr]], $field, 0, 10, ['sales' => 'desc']);
        $this->assign('clothingGoodsList', $clothingGoodsList['list']);
        return $this->fetch();
    }

    /**
     * 家电商场
     * @return type
     */
    public function electrical_appliances() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('electrical_appliances_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $electrical_appliances_advert2 = advertModel::getAdvertlist('electrical_appliances_advert', 2, 2, 6);
        $electrical_appliances_advert20 = isset($electrical_appliances_advert2[0]) ? $electrical_appliances_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('electrical_appliances_advert20', $electrical_appliances_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_m,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $electricalGoodsList = GoodsModel::getGoodsList(['dir_id' => ['in', $dirIdArr]], $field, 0, 10, ['sales' => 'desc']);
        $this->assign('electricalGoodsList', $electricalGoodsList['list']);
        return $this->fetch();
    }

    /**
     * 手机数码
     */
    public function api_digital() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('api_digital_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $api_digital_advert2 = advertModel::getAdvertlist('api_digital_advert', 2, 2, 6);
        $api_digital_advert20 = isset($api_digital_advert2[0]) ? $api_digital_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('api_digital_advert20', $api_digital_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_m,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $apifield = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $apiGoodsList = GoodsModel::getGoodsList(['dir_id' => ['in', $dirIdArr]], $apifield, 0, 10, ['sales' => 'desc']);
        $this->assign('apiGoodsList', $apiGoodsList['list']);

        return $this->fetch();
    }

    /**
     * 电脑城
     * @return type
     */
    public function computer_shop() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('computer_shop_advert', 1, 2, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $computer_shop_advert2 = advertModel::getAdvertlist('computer_shop_advert', 2, 2, 6);
        $computer_shop_advert20 = isset($computer_shop_advert2[0]) ? $computer_shop_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('computer_shop_advert20', $computer_shop_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_m,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $computerfield = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $computerGoodsList = GoodsModel::getGoodsList(['dir_id' => ['in', $dirIdArr]], $computerfield, 0, 10, ['sales' => 'desc']);
        $this->assign('computerGoodsList', $computerGoodsList['list']);
        return $this->fetch();
    }

    /**
     * 全部商品
     * @return type
     */
    public function goods_all() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        if ($this->request->isAjax()) {
            $get = input('get.');
            $where = [];
            $order = [];
            $array_sort_str = 'goods_id';
            $short = SORT_DESC;
            switch ($get['type']) {
                case 'all':
                    break;
                case 'sales':
                    $order = ['sales' => 'desc'];
                    break;
                case 'goodwill':
                    $array_sort_str = 'givealike_count';
                    break;
                case 'screening':
                    if (isset($get['goods_data'])) {
                        //价格从高到低
                        if ($get['goods_data']['highandlow'] == 'high-low') {
                            $array_sort_str = 'goods_price';
                            $order = ['goods_price' => 'desc'];
                        } elseif ($get['goods_data']['highandlow'] == 'low-high') {
                            //价格从低到高
                            $array_sort_str = 'goods_price';
                            $order = ['goods_price' => 'asc'];
                        }
                        //输入金额
                        if ($get['goods_data']['price_low'] && $get['goods_data']['price_high']) {
                            $where['goods_price'] = ['between', [$get['goods_data']['price_low'], $get['goods_data']['price_high']]];
                            $array_sort_str = 'goods_price';
                            $order = ['goods_price' => 'asc'];
                        }
                        //价格段
                        if ($get['goods_data']['pricesegment']) {
                            $goods_price_arr = explode('-', $get['goods_data']['pricesegment']);
                            $where['goods_price'] = ['between', [$goods_price_arr[0], $goods_price_arr[1]]];
                            $array_sort_str = 'goods_price';
                            $order = ['goods_price' => 'asc'];
                        }
                    }
                    break;
                default:
                    break;
            }
            if (isset($get['goods_data']['typeclassif']) && $get['goods_data']['typeclassif'] == 'classification') {
                $dirIdArr = directoryModel::getChildrenIds($get['goods_data']['dir_id']);
                $dirIdArr .= $get['goods_data']['dir_id'];
                $where['dir_id'] = ['in', $dirIdArr];
            }
            $field = 'goods_id,dir_id,goods_name,goods_price,thecover,sales,number_payment';
            $allGoodsList = GoodsModel::getGoodserList($where, $field, $get['start'], $get['limit'], $order);
            if ($get['type'] == 'goodwill') {
                $goodslist = array_sort($allGoodsList['list'], $array_sort_str, $short);
                $allGoodsList['list'] = $goodslist;
            }

            exit(json_encode($allGoodsList));
        }

        return $this->fetch();
    }

}
