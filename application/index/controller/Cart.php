<?php

/**
 * 购物车信息
 */

namespace app\index\controller;

use \think\Db;
use app\index\controller\Common;
use app\index\model\Session as sessionModel;
use app\common\model\Cart as cartModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\Norm as NormModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\Cates as catesModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\CouponReceive as couponReceiveModel;
use app\common\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Order as orderModel;

class Cart extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
        $this->mid = session('member_id');
    }

    public function cartList() {
        $field = 'c.*,g.goods_name,g.thecover,n.goodscolor_id,gc.color_name,cs.cate_name';
        $cartList = cartModel::getList(['c.m_id' => $this->mid], $field, 0, 50);
        $this->assign("cartList", $cartList['list']);
        return $this->fetch();
    }

    public function normList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $goods = GoodsModel::get($get['goods_id']);
            //商品颜色
            $GoodsColor = NormModel::getList(['goods_id' => $get['goods_id']], 'goodscolor_id');
            $GoodsColorArr = [];
            foreach ($GoodsColor as $colorVal) {
                $GoodsColorArr[] = $colorVal['goodscolor_id'];
            }
            $goodsColorList = goodsColorModel::getGoodsColor(['id' => ['in', $GoodsColorArr]], "*", 0, 10);
            $goodsColorId0 = isset($goodsColorList[0]) ? $goodsColorList[0]['id'] : 0;
            $normInfo = NormModel::getInfo(['goods_id' => $get['goods_id'], 'goodscolor_id' => $goodsColorId0], 'n_id,goodscolor_id');
            $inventoryArr = inventoryModel::getList(['goods_id' => $get['goods_id'], 'n_id' => $normInfo['n_id']])->toArray();
            $cateid = array();
            $cate_price0 = '';
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

            $catesList = !empty($inventoryArr) ? catesModel::all($cateid) : '';
            if ($catesList) {
                foreach ($catesList as $catelKey => $catelVal) {
                    $catesList[$catelKey]['cate_price'] = $cate_price_arr[$catelVal['cate_id']];
                    $catesList[$catelKey]['inventory'] = $inventory_arr[$catelVal['cate_id']];
                }
                $cate_price0 = $catesList[0]['cate_price'];
                $inventory0 = $catesList[0]['inventory'];
            }
            $field = 'c.*,g.goods_name,g.goods_price,g.thecover,n.goodscolor_id,gc.color_name,gc.id as goodscolor_id,cs.cate_name';
            $cartInfo = cartModel::getCartInfo(['c.m_id' => $this->mid, 'c.cart_id' => $get['cart_id']], $field);
            $img_small = galleryModel::getValue(['n_id' => $normInfo['n_id']], 'img_small');
            $default_gallery = !empty($img_small) ? $img_small : $goods['thecover'];
            $normInfo['default_gallery'] = $default_gallery;
            $list = array('inventory' => $inventory0, 'goods_color_list' => $goodsColorList, 'cate_price' => $cate_price0,
                'cates_list' => $catesList, 'cart_info' => $cartInfo, 'norm_info' => $normInfo);
            exit(json_encode($list));
        }
    }

    public function catesList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $goods = GoodsModel::getInfo(['goods_id' => $get['goods_id']], 'goods_price,thecover');
            $cart = cartModel::getInfo(['cart_id' => $get['cart_id']], '*');
            $normInfo = NormModel::getInfo(['goods_id' => $get['goods_id'], 'goodscolor_id' => $get['goodscolor_id']], 'n_id,goodscolor_id');
            $inventoryArr = inventoryModel::getList(['n_id' => $normInfo['n_id'], 'goods_id' => $get['goods_id']])->toArray();
            $cateid = array();
            $cate_price_arr = array();
            $cate_price0 = '';
            $inventory0 = '';
            $inventory_arr = array();
            if ($inventoryArr) {
                foreach ($inventoryArr as $inval) {
                    $cateid[] = $inval['cate_id'];
                    $cate_price_arr[$inval['cate_id']] = $inval['inty_price'];
                    $inventory_arr[$inval['cate_id']] = $inval['inventory'];
                }
            }
            $catesList = !empty($inventoryArr) ? catesModel::all($cateid) : '';
            if ($catesList) {

                foreach ($catesList as $catelKey => $catelVal) {
                    //秒杀信息
                    if ($cart['activity'] == 'seconds_kill') {
                        $sk_price = secondsKillModel::getValue(['goods_id' => $get['goods_id']], 'sk_price');
                        //秒杀规格价格的运算：秒杀规格价格=(秒杀价格/商品价格)*原商品规格价格
                        $cate_price = ($sk_price / $goods['goods_price']) * $cate_price_arr[$catelVal['cate_id']];
                    } else if ($cart['activity'] == 'spell_group') {
                        $sg_price = spellGroupModel::getValue(['goods_id' => $get['goods_id']], 'sg_price');
                        //拼团规格价格的运算：拼团规格价格=(拼团价格/商品价格)*原商品规格价格
                        $cate_price = ($sg_price / $goods['goods_price']) * $cate_price_arr[$catelVal['cate_id']];
                    } else if ($cart['activity'] == 'comdysalesp') {
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
                    $catesList[$catelKey]['inventory'] = $inventory_arr[$catelVal['cate_id']];
                }
                $cate_price0 = $catesList[0]['cate_price'];
                $inventory0 = $catesList[0]['inventory'];
            }
            $img_small = galleryModel::getValue(['n_id' => $normInfo['n_id']], 'img_small');
            $default_gallery = !empty($img_small) ? $img_small : $goods['thecover'];
            $normInfo['default_gallery'] = $default_gallery;
            $list = array('inventory' => $inventory0, 'cate_list' => $catesList, 'norm_info' => $normInfo, 'cate_price' => $cate_price0,);
            exit(json_encode($list));
        }
    }

    public function cartOneSubmit() {
        if ($this->request->isAjax()) {
            $result = cartModel::cartOneSubmitMd();
            if ($result) {
                Tobesuccess('修改成功，去购买吧');
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    public function cartDel() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $cartArr = explode(',', $get['cart_id']);
            $result = cartModel::destroy($cartArr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

    /**
     * 使用优惠券
     */
    public function algorithmCart() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $cop_price = 0;
            //判断优惠券是否已使用
            $copon_receive_id = isset($get['copon_receive_id']) ? $get['copon_receive_id'] : 0;
            if ($copon_receive_id > 0) {
                $couponRisdate = couponReceiveModel::getCouponReInfoisDate(['id' => $copon_receive_id]);
                if (empty($couponRisdate)) {
                    Tiperror("优惠券已过时！");
                } elseif (!empty($couponRisdate) && $couponRisdate['copr_state'] == 2) {
                    Tiperror("该优惠券有订单已使用");
                }
                //更新成已使用状态
                couponReceiveModel::updates(['id' => $copon_receive_id], ['copr_state' => 2]);
                $cop_price = $couponRisdate['cop_price'];
            }
            $cart = cartModel::getInfo(['cart_id' => $get['cart_id']]);

            //运费
            $totalFreight = orderModel::freightCalculate($cart['goods_id'], $get['goods_num'], $cart['n_id'], $cart['cate_id']);
            //总费用
            $totalPrice = $cart['goods_price'] * $get['goods_num'] + $totalFreight - $cop_price;

            $result = cartModel::updates(['cart_id' => $get['cart_id']], ['goods_num' => $get['goods_num'],
                        'copon_receive_id' => $copon_receive_id, 'total_price' => $totalPrice, 'courier_price' => $totalFreight]);
            if ($result) {
                Tobesuccess('修改成功', cartModel::get($get['cart_id']));
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    /**
     * 商品库存判断
     */
    public function goodsJudge() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $cart = cartModel::all($post['cartid'])->toArray();
            foreach ($cart as $key => $val) {
                //商品库存判断
                if ($val['setup_norm'] == 'on') {
                    $inventory = inventoryModel::getValue(['n_id' => $val['n_id'], 'cate_id' => $val['cate_id']], 'inventory');
                    if ($inventory < $val['goods_num']) {
                        Tiperror("商品库存不足！");
                    }
                } else {
                    $goods_stock = GoodsModel::getValue(['goods_id' => $val['goods_id']], 'goods_stock');
                    if ($goods_stock < $val['goods_num']) {
                        Tiperror("商品库存不足！");
                    }
                }
                //判断秒杀库存
                if ($val['activity'] == 'seconds_kill') {
                    $sk_num = secondsKillModel::getValue(['goods_id' => $val['goods_id']], 'sk_num');
                    if ($sk_num < $val['goods_num']) {
                        Tiperror("秒杀商品库存不足！");
                    }
                    $is_sk_time = secondsKillModel::getSecondsKillInfoTime(['goods_id' => $val['goods_id']]);
                    if (empty($is_sk_time)) {
                        Tiperror("秒杀商品已过时！");
                    }
                } elseif ($val['activity'] == 'spell_group') {//判断拼团库存
                    $sg_num = spellGroupModel::getValue(['goods_id' => $val['goods_id']], 'sg_num');
                    if ($sg_num < $val['goods_num']) {
                        Tiperror("拼团商品库存不足！");
                    }
                } elseif ($val['activity'] == 'comdysalesp') {//判断促销库存
                    $cp_num = comdysalesPromotionModel::getValue(['goods_id' => $val['goods_id']], 'cp_num');
                    if ($cp_num < $val['goods_num']) {
                        Tiperror("促销商品库存不足！");
                    }
                    $is_cp_time = comdysalesPromotionModel::getComdypInfoTime(['goods_id' => $val['goods_id']]);
                    if (empty($is_cp_time)) {
                        Tiperror("促销商品已过时！");
                    }
                }
                Tobesuccess('商品可以购买');
            }
        }
    }

    /**
     * 清空购物车
     */
    public function emptyCart() {
        if ($this->request->isAjax()) {
            $result = cartModel::destroy(['m_id' => $this->mid]);
            if ($result) {
                Tobesuccess('已经清空购物车');
            } else {
                Tiperror("清空失败！");
            }
        }
    }

}
