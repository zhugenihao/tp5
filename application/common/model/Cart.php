<?php

/**
 * 购物车信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\Address as addressModel;
use app\common\model\Courier as CourierModel;
use app\common\model\CouponReceive as CouponReceiveModel;
use app\common\model\Payment as PaymentModel;
use app\common\model\Member as memberModel;
use app\common\model\Goods as goodsModel;
use app\common\model\Order as orderModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\Cates as catesModel;
use app\common\model\Norm as NormModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\api\model\ComdysalesPromotion as comdysalesPromotionModel;

class Cart extends Commons {

    protected $pk = 'cart_id';
    protected $name = "cart";

    public static function add($data) {
        return self::create($data);
    }

    public static function updates($where = [], $date = []) {
        return self::where($where)->update($date);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['cart_id' => 'desc'];
        $join = [
                ['mz_goods g', 'g.goods_id=c.goods_id', 'left'], //商品表信息
            ['mz_norm n', 'n.n_id=c.n_id', 'left'], //规格表信息
            ['mz_goods_color gc', 'gc.id=n.goodscolor_id', 'left'], //商品颜色表信息
            ['mz_cates cs', 'cs.cate_id=c.cate_id', 'left'], //商品版本表信息
        ];
        $list['count'] = self::alias('c')->join($join)->where($where)->count();
        $list['list'] = self::alias('c')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getCartInfo($where = [], $field = '*') {
        $join = [
                ['mz_goods g', 'g.goods_id=c.goods_id', 'left'], //商品表信息
            ['mz_norm n', 'n.n_id=c.n_id', 'left'], //规格表信息
            ['mz_goods_color gc', 'gc.id=n.goodscolor_id', 'left'], //商品颜色表信息
            ['mz_cates cs', 'cs.cate_id=c.cate_id', 'left'], //商品版本表信息
        ];
        $info = self::alias('c')->field($field)->join($join)->where($where)->find()->toArray();
        return $info;
    }

    /**
     * 提交订单详情
     */
    public static function submitTheorder($where = [], $field = '*') {
        $join = [
                ['mz_goods g', 'g.goods_id=c.goods_id', 'left'], //商品表信息
            ['mz_norm n', 'n.n_id=c.n_id', 'left'], //规格表信息
            ['mz_goods_color gc', 'gc.id=n.goodscolor_id', 'left'], //商品颜色表信息
            ['mz_cates cs', 'cs.cate_id=c.cate_id', 'left'], //商品版本表信息
        ];
        $list['cart_list'] = self::alias('c')->field($field)->join($join)->where($where)->select()->toArray();
        $list['cart_goods_num'] = self::alias('c')->field($field)->join($join)->where($where)->sum('c.goods_num');
        $cart_total_price = self::alias('c')->field($field)->join($join)->where($where)->sum('c.total_price');
        $list['cart_total_price'] = sprintf('%.2f', $cart_total_price);
        $addressCount = addressModel::getCount(['m_id' => session('member_id'), 'ads_default' => 'on']);
        if ($addressCount) {
            $list['address_default'] = addressModel::getAddressInfo(['m_id' => session('member_id'), 'ads_default' => 'on']); //获取默认地址
        }
        $list['address_list'] = addressModel::getList(['m_id' => session('member_id')]); //获取收货地址列表
        $list['courier_list'] = CourierModel::getList(); //获取快递列表
        $storeIdArr = array();
        $goodsIdArr = array();
        $gpriceArr = array();
        $spriceArr = array();
        $totalfreightArr = array();
        foreach ($list['cart_list'] as $key => $val) {
            $storeIdArr[] = goodsModel::getValue(['goods_id' => $val['goods_id']], 'store_id');
            $goodsIdArr[] = $val['goods_id'];
            $gpriceArr[$val['goods_id']] = $val['goods_price'];
            $spriceArr[$val['store_id']] = $val['goods_price'];
            $CouponReInfo = array();
            if ($val['copon_receive_id']) {
                $CouponReInfo = CouponReceiveModel::getCouponReInfo(['id' => $val['copon_receive_id']], "*")->toArray(); //已使用的优惠券
            }
            $list['cart_list'][$key]['hasbeenused_copon'] = $CouponReInfo;
            $totalfreightArr[] = $val['courier_price'];
        }
        $todayTime = date("Y-m-d H:i:s");
        $crwhere1 = ['cr.m_id' => member_id(), 'cr.type_id' => ['in', $goodsIdArr], 'type' => 1, 'cr.copb_time' => array('egt', $todayTime)];
        $crwhere2 = ['cr.m_id' => member_id(), 'cr.type_id' => ['in', $storeIdArr], 'type' => 2, 'cr.copb_time' => array('egt', $todayTime)];
        $crField = "cr.*,g.goods_name";
        $CouponReceive1 = CouponReceiveModel::getCouponReceivemList($crwhere1, $crField); //取指定商品的优惠券
        $CouponReceive2 = CouponReceiveModel::getCouponReceivemList($crwhere2, $crField); //取指定商铺的优惠券

        $CouponReceive1_new = array();
        $CouponReceive2_new = array();
        foreach ($CouponReceive1['list'] as $cop1val) {
            if ($gpriceArr[$cop1val['type_id']] > $cop1val['full_amount']) {
                $CouponReceive1_new[] = $cop1val;
            }
        }
        foreach ($CouponReceive2['list'] as $cop2val) {
            if ($spriceArr[$cop2val['type_id']] > $cop2val['full_amount']) {
                $CouponReceive2_new[] = $cop2val;
            }
        }
        $list['copon_receive_mlist'] = array_merge($CouponReceive1_new, $CouponReceive2_new);
        $list['payment_list'] = PaymentModel::getList(); //获取支付方式列表
        $list['forehead'] = memberModel::getValue(session('member_id'), 'forehead'); //获取用户余额
        $list['totalFreight'] = array_sum($totalfreightArr); //总运费

        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getDelete($where) {
        return self::where($where)->delete();
    }

    public static function cartOneSubmitMd() {
        $post = input('post.');
        //商品价格
        $cart = self::getInfo(['cart_id' => $post['cart_id']]);
        $goods = goodsModel::get($cart['goods_id']);
        $imgSmall = galleryModel::getValue(['n_id' => $post['n_id']], 'img_small');
        $goods_img = !empty($goods['setup_norm'] == 'off' || $imgSmall == '') ? $goods['thecover'] : $imgSmall;
        $goodsColor = goodsColorModel::get(NormModel::getValue(['n_id' => $post['n_id']], 'goodscolor_id'));
        $cates = catesModel::get($post['cate_id']);
        $goods_price = orderGoodsModel::priceCalculation($cart['goods_id'], $post['n_id'], $post['cate_id'], $cart['activity']);

        //成本价
        $costPrice = goodsModel::getCostPrice($cart['goods_id'], $post['n_id'], $post['cate_id']);
        //运费
        $totalFreight = orderModel::freightCalculate($cart['goods_id'], $post['goods_num'], $post['n_id'], $post['cate_id']);
        //总费用
        $totalPrice = $goods_price * $post['goods_num'] + $totalFreight;

        $data = ['cart_id' => $post['cart_id'], 'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'goods_num' => $post['goods_num']
            , 'goods_price' => $goods_price, 'total_price' => $totalPrice, 'goods_img' => $goods_img,
            'goods_information' => $goodsColor['color_name'] . $cates['cate_name'], 'cost_price' => $costPrice, 'courier_price' => $totalFreight];
        $res = self::update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    #商品库存判断

    public static function goodsJudge($cartidArr = []) {
        $cart = self::all($cartidArr)->toArray();
        foreach ($cart as $key => $val) {
            //商品库存判断
            if ($val['setup_norm'] == 'on') {
                $inventory = inventoryModel::getValue(['n_id' => $val['n_id'], 'cate_id' => $val['cate_id']], 'inventory');
                if ($inventory < $val['goods_num']) {
                    return ['code' => 1, 'msg' => '商品库存不足！'];
                }
            } else {
                $goods_stock = goodsModel::getValue(['goods_id' => $val['goods_id']], 'goods_stock');
                if ($goods_stock < $val['goods_num']) {
                    return ['code' => 1, 'msg' => '商品库存不足！'];
                }
            }
            //判断秒杀库存
            if ($val['activity'] == 'seconds_kill') {
                $sk_num = secondsKillModel::getValue(['goods_id' => $val['goods_id']], 'sk_num');
                if ($sk_num < $val['goods_num']) {
                    return ['code' => 1, 'msg' => '商品库存不足！'];
                }
                $is_sk_time = secondsKillModel::getSecondsKillInfoTime(['goods_id' => $val['goods_id']]);
                if (empty($is_sk_time)) {
                    return ['code' => 1, 'msg' => '秒杀商品已过时！'];
                }
                //判断拼团库存
            } elseif ($val['activity'] == 'spell_group') {

                $sg_num = spellGroupModel::getValue(['goods_id' => $val['goods_id']], 'sg_num');
                if ($sg_num < $val['goods_num']) {
                    return ['code' => 1, 'msg' => '商品库存不足！'];
                }
            } elseif ($val['activity'] == 'comdysalesp') {//判断促销库存
                $cp_num = comdysalesPromotionModel::getValue(['goods_id' => $val['goods_id']], 'cp_num');
                if ($cp_num < $val['goods_num']) {
                    return ['code' => 1, 'msg' => '促销商品库存不足！'];
                }
                $is_cp_time = comdysalesPromotionModel::getComdypInfoTime(['goods_id' => $val['goods_id']]);
                if (empty($is_cp_time)) {
                    return ['code' => 1, 'msg' => '促销商品已过时！'];
                }
            }
        }
        return ['code' => 0, 'msg' => '商品可以购买！'];
    }

}
