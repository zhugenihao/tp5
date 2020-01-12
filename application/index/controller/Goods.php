<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Goods as GoodsModel;
use app\common\model\Norm as NormModel;
use app\common\model\Cates as catesModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\Directory as directoryModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\Cart as cartModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Comments as commentsModel;
use app\common\model\Givealike as givealikeModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\mobile\model\Advert as advertModel;
use app\common\model\Brand as brandModel;
use app\index\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Store as storeModel;
use app\index\model\Kefu as kefuModel;

class Goods extends Common {

    public function index() {
        return $this->fetch();
    }

    public function goods_details() {
        $goodsId = input('goods_id');
        $activity = input('activity'); //活动参数
        $goodsInfo = GoodsModel::getGoodsInfo(['goods_id' => $goodsId]);

        if ($activity == 'seconds_kill') {//秒杀信息
            $secondsKillInfo = secondsKillModel::getInfo(['goods_id' => $goodsId]);
            $this->assign('secondsKillInfo', $secondsKillInfo);
        } else if ($activity == 'spell_group') {//拼团信息
            $spellGroupInfo = spellGroupModel::getInfo(['goods_id' => $goodsId]);
            $this->assign('spellGroupInfo', $spellGroupInfo);
        } else if ($activity == 'comdysalesp') {//促销信息
            $comdysalespInfo = comdysalesPromotionModel::getInfo(['goods_id' => $goodsId]);
            $this->assign('comdysalespInfo', $comdysalespInfo);
        }
        $this->assign('comments_count', commentsModel::getCount(['goods_id' => input('goods_id')]));
        $this->assign('goodsInfo', $goodsInfo);
        $this->assign('givealike_count', givealikeModel::getCount(['goods_id' => input('goods_id'), 'givealike' => 1]));

        $store = storeModel::getInfo(['id' => $goodsInfo['store_id']], "id,store_name,image");
        $this->assign('store', $store);

        $kefu = kefuModel::getInfo(['store_id' => $goodsInfo['store_id'], 'is_show' => 1, 'kefu_type' => 1]);
        $this->assign('kefu', $kefu);
        return $this->fetch();
    }

    /**
     * 获取商品版本信息
     */
    public function catesList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $goods = GoodsModel::getInfo(['goods_id' => $get['goods_id']], 'goods_price,thecover');
            $normInfo = NormModel::getInfo(['goods_id' => $get['goods_id'], 'goodscolor_id' => $get['goodscolor_id']], 'n_id,goodscolor_id');
            $inventoryArr = inventoryModel::getList(['n_id' => $normInfo['n_id'], 'goods_id' => $get['goods_id']])->toArray();
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
                    //秒杀信息
                    if ($get['activity'] == 'seconds_kill') {
                        $sk_price = secondsKillModel::getValue(['goods_id' => $get['goods_id']], 'sk_price');
                        //秒杀规格价格的运算：秒杀规格价格=(秒杀价格/商品价格)*原商品规格价格
                        $cate_price = ($sk_price / $goods['goods_price']) * $cate_price_arr[$catelVal['cate_id']];
                    } else if ($get['activity'] == 'spell_group') {
                        $sg_price = spellGroupModel::getValue(['goods_id' => $get['goods_id']], 'sg_price');
                        //拼团规格价格的运算：拼团规格价格=(拼团价格/商品价格)*原商品规格价格
                        $cate_price = ($sg_price / $goods['goods_price']) * $cate_price_arr[$catelVal['cate_id']];
                    } else if ($get['activity'] == 'comdysalesp') {
                        //促销规格价格的运算
                        $comdysalesp = comdysalesPromotionModel::getInfo(['goods_id' => $get['goods_id']], 'cp_price,cp_type,discount');
                        if ($comdysalesp['cp_type'] == 1) {//直接打折
                            //打折规格价格=(折扣/10)*原商品规格价格
                            $cate_price = ($comdysalesp['discount'] / 10) * $cate_price_arr[$catelVal['cate_id']];
                        } elseif ($comdysalesp['cp_type'] == 2) {//减价优惠
                            //打折规格价格=(减价价格/商品价格)*原商品规格价格
                            $cate_price = ($comdysalesp['cp_price'] / $goods['goods_price']) * $cate_price_arr[$catelVal['cate_id']];
                        }
                    } else {
                        $cate_price = $cate_price_arr[$catelVal['cate_id']];
                    }

                    $catesList[$catelKey]['cate_price'] = sprintf("%.2f", $cate_price);
                    $catesList[$catelKey]['orgprice'] = sprintf("%.2f", $cate_price_arr[$catelVal['cate_id']]);
                    $catesList[$catelKey]['inventory'] = $inventory_arr[$catelVal['cate_id']];
                }
                $cate_price0 = $catesList[0]['cate_price'];
                $orgprice0 = $catesList[0]['orgprice'];
                $inventory0 = $catesList[0]['inventory'];
            }
            $galleryList = galleryModel::getGalleryList(['n_id' => $normInfo['n_id']], 'img_small,img_big');
            $default_gallery = !empty($galleryList) ? $galleryList : array(array('img_small' => $goods['thecover'], 'img_big' => $goods['thecover']));
            $normInfo['gallery_list'] = $default_gallery;
            $list = array('cate_price' => $cate_price0, 'orgprice' => $orgprice0, 'inventory' => $inventory0, 'norm_info' => $normInfo,
                'cates_list' => $catesList);
            exit(json_encode($list));
        }
    }

    /**
     * 添加购物车
     */
    public function addCart() {
        if ($this->request->isAjax()) {
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
            $imgSmall = galleryModel::getValue(['n_id' => $post['n_id']], 'img_small');
            $goods_img = !empty($post['setup_norm'] == 'off') ? $goods['thecover'] : $imgSmall;
            $goodsColor = goodsColorModel::get(NormModel::getValue(['n_id' => $post['n_id']], 'goodscolor_id'));
            $cates = catesModel::get($post['cate_id']);
            $data = ['goods_id' => $post['goods_id'], 'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'goods_price' => $goods_price,
                'goods_num' => $post['goods_num'], 'm_id' => $mid, 'total_price' => $goods_price * $post['goods_num'], 'create_time' => time(),
                'goods_name' => $goods['goods_name'], 'goods_img' => $goods_img, 'goods_information' => $goodsColor['color_name'] . $cates['cate_name'],
                'activity' => $post['activity'], 'setup_norm' => $post['setup_norm'], 'spell_list_m_id' => $post['first_member_id'],
                'sgm_id' => $post['sgm_id'], 'store_id' => $post['store_id'], 'cost_price' => $costPrice];
            $result = cartModel::add($data);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 手机数码
     */
    public function mobile_digital() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('mobile_digital_advert', 1, 1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $mobile_digital_advert2 = advertModel::getAdvertlist('mobile_digital_advert', 2, 1, 6);
        $mobile_digital_advert20 = isset($mobile_digital_advert2[0]) ? $mobile_digital_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('mobile_digital_advert20', $mobile_digital_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_p,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $mobilefield = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $mobileGoodsList = GoodsModel::getGoodsListPc(['dir_id' => ['in', $dirIdArr]], $mobilefield, 20, ['sales' => 'desc']);
        $this->assign('mobileGoodsList', $mobileGoodsList['list']);
        $this->assign('page', $mobileGoodsList['list']->render());
        return $this->fetch();
    }

    /**
     * 日常超市
     * @return type
     */
    public function supermarket() {
        $dirId = input('dir_id');
        $this->assign('directoryTitle', directoryModel::getValue(['id' => $dirId], 'title'));
        //轮播图片
        $advertList = advertModel::getAdvertlist('supermarket_advert', 1, 1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $supermarket_advert2 = advertModel::getAdvertlist('supermarket_advert', 2, 1, 6);
        $supermarket_advert20 = isset($supermarket_advert2[0]) ? $supermarket_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('supermarket_advert20', $supermarket_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_p,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $supermarketGoodsList = GoodsModel::getGoodsListPc(['dir_id' => ['in', $dirIdArr]], $field, 20, ['sales' => 'desc']);
        $this->assign('supermarketGoodsList', $supermarketGoodsList['list']);
        $this->assign('page', $supermarketGoodsList['list']->render());
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
        $advertList = advertModel::getAdvertlist('computer_shop_advert', 1, 1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $computer_shop_advert2 = advertModel::getAdvertlist('computer_shop_advert', 2, 1, 6);
        $computer_shop_advert20 = isset($computer_shop_advert2[0]) ? $computer_shop_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('computer_shop_advert20', $computer_shop_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_p,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $computerfield = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $computerGoodsList = GoodsModel::getGoodsListPc(['dir_id' => ['in', $dirIdArr]], $computerfield, 20, ['sales' => 'desc']);
        $this->assign('computerGoodsList', $computerGoodsList['list']);
        $this->assign('page', $computerGoodsList['list']->render());
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
        $advertList = advertModel::getAdvertlist('clothing_store_advert', 1, 1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $clothing_store_advert2 = advertModel::getAdvertlist('clothing_store_advert', 2, 1, 6);
        $clothing_store_advert20 = isset($clothing_store_advert2[0]) ? $clothing_store_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('clothing_store_advert20', $clothing_store_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_p,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $clothingGoodsList = GoodsModel::getGoodsListPc(['dir_id' => ['in', $dirIdArr]], $field, 20, ['sales' => 'desc']);
        $this->assign('clothingGoodsList', $clothingGoodsList['list']);
        $this->assign('page', $clothingGoodsList['list']->render());
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
        $advertList = advertModel::getAdvertlist('electrical_appliances_advert', 1, 1, 6);
        $this->assign('advertList', $advertList);
        //单图广告
        $electrical_appliances_advert2 = advertModel::getAdvertlist('electrical_appliances_advert', 2, 1, 6);
        $electrical_appliances_advert20 = isset($electrical_appliances_advert2[0]) ? $electrical_appliances_advert2[0] : array('adv_link' => '', 'dire' => '');
        $this->assign('electrical_appliances_advert20', $electrical_appliances_advert20);
        //模块按钮
        $dirfield = 'id,title,home_template_p,small_icon';
        $directoryList = directoryModel::getDirectoryList(['pid' => $dirId, 'is_navigation' => 1], $dirfield, 10);
        $this->assign('directoryList', $directoryList);
        //商品列表
        $dirIdArr = directoryModel::getChildrenIds($dirId);
        $dirIdArr .= $dirId;
        $field = 'goods_id,goods_name,goods_price,thecover,sales,number_payment';
        $electricalGoodsList = GoodsModel::getGoodsListPc(['dir_id' => ['in', $dirIdArr]], $field, 20, ['sales' => 'desc']);
        $this->assign('electricalGoodsList', $electricalGoodsList['list']);
        $this->assign('page', $electricalGoodsList['list']->render());
        return $this->fetch();
    }

    /**
     * 全部商品
     * @return type
     */
    public function goods_all() {
        $type = input("type");
        $screening = input("screening");
        $pricesegment = input("pricesegment");
        $dirId = input('dir_id');
        $where = [];
        $order = [];
        $array_sort_str = 'goods_id';
        $short = SORT_DESC;
        switch ($type) {
            case 'all':
                break;
            case 'sales':
                $order = ['sales' => 'desc'];
                break;
            case 'goodwill':
                $array_sort_str = 'givealike_count';
                break;
            case 'screening':

                break;
            default:
                break;
        }
        if (input('screening') == 'high-low') {
            //价格从高到低
            $array_sort_str = 'goods_price';
            $order = ['goods_price' => 'desc'];
        } elseif (input('price_low') && input('price_high')) {
            //输入金额
            $where['goods_price'] = ['between', [input('price_low'), input('price_high')]];
            $array_sort_str = 'goods_price';
            $order = ['goods_price' => 'asc'];
            $type = "";
            $screening = "";
            $pricesegment = "";
        } elseif (input('screening') == 'low-high') {
            //价格从低到高
            $array_sort_str = 'goods_price';
            $order = ['goods_price' => 'asc'];
        } elseif (input('pricesegment')) {
            //价格段
            $goods_price_arr = explode('-', input('pricesegment'));
            $where['goods_price'] = ['between', [$goods_price_arr[0], $goods_price_arr[1]]];
            $array_sort_str = 'goods_price';
            $order = ['goods_price' => 'asc'];
        } elseif ($dirId) {
            //分类模块搜索商品
            $dirIdArr = directoryModel::getChildrenIds($dirId);
            $dirIdArr .= $dirId;
            if (!in_array($dirId, array(1))) {
                $where['dir_id'] = ['in', $dirIdArr];
            }
        } elseif (input('brand_id')) {
            //搜索品牌商品
            $where['brand_id'] = input('brand_id');
        }
        $field = 'goods_id,dir_id,goods_name,goods_price,thecover,sales,number_payment';

        $goodsList = GoodsModel::getGoodsListPc($where, $field, 20, $order);
        $goodsList_er = $goodsList['list']->toArray();
        if ($type == 'goodwill') {
            $goodslist = array_sort($goodsList_er['data'], $array_sort_str, $short);
            $goodsList_er['data'] = $goodslist;
        }

        $this->assign("goodsList", $goodsList_er['data']);
        $this->assign("page", $goodsList['list']->render());
        $this->assign("type", $type);
        $this->assign("screening", $screening);
        $this->assign("pricesegment", $pricesegment);
        $this->assign(['price_low' => input('price_low'), 'price_high' => input('price_high')]);


        $directoryInfo1 = directoryModel::getInfo(['id' => $dirId]);
        $directoryInfo2 = directoryModel::getInfo(['id' => $directoryInfo1['pid']]);
        $directoryInfo3 = directoryModel::getInfo(['id' => $directoryInfo2['pid']]);
        $this->assign('directoryInfo1', $directoryInfo1);
        $this->assign('directoryInfo2', $directoryInfo2);
        $this->assign('directoryInfo3', $directoryInfo3);

        $brandinfo = brandModel::getInfo(['id' => input('brand_id')]);
        $this->assign('brandinfo', $brandinfo);
        return $this->fetch();
    }

}
