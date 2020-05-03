<?php

/**
 * 购物车信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Session as sessionModel;
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
use app\api\model\ComdysalesPromotion as comdysalesPromotionModel;
use app\common\model\Order as orderModel;
use app\common\model\OrderGoods as orderGoodsModel;

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
        if ($this->request->isGet()) {
            $get = input('get.');
            $field = 'c.*,g.goods_name,g.thecover,n.goodscolor_id,gc.color_name,cs.cate_name';
            $cartList = cartModel::getList(['c.m_id' => $this->mid], $field, $get['start'], $get['limit']);
            returnMessage($cartList);
        }
    }

    public function normList() {
        if ($this->request->isGet()) {
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
            $inventoryArr = inventoryModel::getList(['n_id' => $normInfo['n_id']])->toArray();
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

            returnMessage($list);
        }
    }

    public function catesList() {
        if ($this->request->isGet()) {
            $get = input('get.');
            $goods = GoodsModel::get($get['goods_id']);
            $field = 'c.*,g.goods_name,g.goods_price,g.thecover,n.goodscolor_id,gc.color_name,gc.id as goodscolor_id,cs.cate_name';
            $cartInfo = cartModel::getCartInfo(['c.m_id' => $this->mid, 'c.cart_id' => $get['cart_id']], $field);
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
                    //商品价格
                    $cate_price = orderGoodsModel::priceCalculation($get['goods_id'], $normInfo['n_id'], $catelVal['cate_id'], $cartInfo['activity']);

                    $catesList[$catelKey]['cate_price'] = sprintf("%.2f", $cate_price);

                    $catesList[$catelKey]['inventory'] = $inventory_arr[$catelVal['cate_id']];
                }
                $cate_price0 = $catesList[0]['cate_price'];
                $inventory0 = $catesList[0]['inventory'];
            }
            $img_small = galleryModel::getValue(['n_id' => $normInfo['n_id']], 'img_small');
            $default_gallery = !empty($img_small) ? $img_small : $goods['thecover'];
            $normInfo['default_gallery'] = $default_gallery;
            $list = array('inventory' => $inventory0, 'cate_list' => $catesList, 'norm_info' => $normInfo, 'cate_price' => $cate_price0,
                'cart_info' => $cartInfo);
            returnMessage($list);
        }
    }

    public function cartOneSubmit() {
        if ($this->request->isPost()) {
            $result = cartModel::cartOneSubmitMd();
            if ($result) {
                Tobesuccess('修改成功，去购买吧');
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    #单个删除购物车
    public function cartDel() {
        if ($this->request->isGet()) {
            $get = input('get.');
            $cartArr = explode(',', $get['cartid_str']);
            $result = cartModel::destroy($cartArr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

    /**
     * 使用优惠券和商品数量变动
     */
    public function algorithmCart() {
        if ($this->request->isGet()) {
            $get = input('get.');
            $res = cartModel::goodsJudge([$get['cart_id']]); #判断库存
            if ($res['code']) {
                Tiperror($res['msg']);
            }
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
        if ($this->request->isPost()) {
            $post = input('post.');
            $cartidArr = explode(',', $post['cartid']);
            $res = cartModel::goodsJudge($cartidArr);
            if ($res['code']) {
                Tiperror($res['msg']);
            } else {
                Tobesuccess($res['msg']);
            }
        }
    }

    /**
     * 清空购物车
     */
    public function emptyCart() {
        if ($this->request->isGet()) {
            $result = cartModel::destroy(['m_id' => $this->mid]);
            if ($result) {
                Tobesuccess('已经清空购物车');
            } else {
                Tiperror("清空失败！");
            }
        }
    }

}
