<?php

namespace app\common\service;

use app\mobile\model\Member as memberModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Order as orderModel;
use app\common\model\Address as addressModel;
use app\common\model\PaymentLog as paymentLogModel;
use app\common\model\Payment as paymentModel;
use app\common\model\Gallery as galleryModel;
use app\mobile\model\Goods as GoodsModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\common\model\CouponReceive as couponReceiveModel;
use app\common\model\CouponUse as couponUseModel;
use app\common\model\Cart as cartModel;
use app\common\model\RecordBooks as recordBooksModel;
use app\common\service\Pay as payModel;
use app\common\model\ComdysalesPromotion as comdysalesPromotionModel;
use think\Db;
use think\Log;

class OrderOperation {

    /**
     * 生成订单
     */
    public static function OrderOperationSubmit() {

        $post = input('post.');
        $orderNoRes = array();
        $orderNo = '';
        $mid = session('member_id');
        $orderGoodsData = array();
        $addressCount = addressModel::getCount(['m_id' => $mid]);
        if ($addressCount < 1) {
            Tiperror("请先添加收货地址。");
        }
        $orderCount = orderGoodsModel::getCount(['m_id' => $mid, 'state' => FORP_STATUS]);
        if ($orderCount >= 20) {
            Tiperror("你有共20个及以上未付款订单，请先去付款，或取消订单。");
        }
        $cartId = is_array($post['cart_id'])?$post['cart_id']:explode(',', $post['cart_id']);
        Db::startTrans();
        try {
            $cartList = cartModel::all($cartId)->toArray();

            foreach ($cartList as $key => $val) {

                //秒杀信息
                if ($val['activity'] == 'seconds_kill') {
                    self::secondsKillJudge($val['goods_id'], $val['goods_num']);
                }
                //促销信息
                if ($val['activity'] == 'comdysalesp') {
                    self::comdypJudge($val['goods_id'], $val['goods_num']);
                }
                //拼团信息
                if ($val['activity'] == 'spell_group') {
                    self::spellGroupJudge($val['goods_id'], $val['goods_num'], $val['spell_list_m_id'], $val['sgm_id']);
                }
                $goods = GoodsModel::getInfo(['goods_id' => $val['goods_id']], 'thecover,goods_name');
                $imgSmall = galleryModel::getValue(['n_id' => $val['n_id']], 'img_small');
                $imgSmall = !empty($imgSmall) ? $imgSmall : $goods['thecover'];
                $goods_img = !empty($val['setup_norm'] == 'off') ? $goods['thecover'] : $imgSmall;

                $addressInfo = addressModel::getAddressInfo(['ads_id' => $post['ads_id']]);

                $orderData = [
                    'courier_price' => $val['courier_price'],
                    'order_no' => self::trade_no(), 'm_id' => $mid, 'ads_name' => $addressInfo['ads_name'], 'ads_mobile' => $addressInfo['ads_mobile'],
                    'tcgaddress' => $addressInfo['tcgaddress'], 'state' => FORP_STATUS, 'order_time' => time(), 'total_price' => $val['total_price'],
                    'ads_id' => $post['ads_id'], 'cou_id' => $post['cou_id'], 'payment_type' => $post['payment_type'], 'leave_message' => $post['leave_message'],
                    'goods_num' => $val['goods_num'], 'activity' => $val['activity'], 'store_id' => $val['store_id'], 'cost_price' => $val['cost_price']
                ];
                $orderNoRes = orderModel::createOrder(['order_no' => $orderData['order_no']], $orderData);

                $orderGoodsData = [
                    'order_no' => $orderNoRes->order_no, 'm_id' => $mid, 'goods_id' => $val['goods_id'], 'n_id' => $val['n_id'], 'cate_id' => $val['cate_id'],
                    'copon_receive_id' => $val['copon_receive_id'], 'tord_time' => time(), 'goods_num' => $val['goods_num'],
                    'goods_price' => $val['goods_price'], 'total_price' => $val['total_price'], 'goods_information' => $val['goods_information'],
                    'payment_type' => $post['payment_type'], 'goods_name' => $goods['goods_name'], 'goods_img' => $goods_img, 'activity' => $val['activity'],
                    'state' => FORP_STATUS, 'setup_norm' => $val['setup_norm'], 'spell_list_m_id' => $val['spell_list_m_id'],
                    'sgm_id' => $val['sgm_id'], 'store_id' => $val['store_id'], 'cost_price' => $val['cost_price'], 'order_id' => $orderNoRes->id,
                ];

                $orderGoodsWhere = ['m_id' => $mid, 'setup_norm' => $val['setup_norm'], 'goods_id' => $val['goods_id'],
                    'n_id' => $val['n_id'], 'cate_id' => $val['cate_id'], 'state' => FORP_STATUS];

                $orderNo = orderGoodsModel::createOrderGoods($orderGoodsWhere, $orderGoodsData);
            }
            Db::commit();
        } catch (\Exception $e) {

            Db::rollback();

            Tiperror("出现其他异常", $e->getMessage());
        }
        return $orderNoRes;
    }

    /**
     * 秒杀信息
     * @param type $goods_id
     * @param type $goods_num
     */
    public static function secondsKillJudge($goods_id, $goods_num) {
        //判断秒杀数量
        $sk_num = secondsKillModel::getValue(['goods_id' => $goods_id], 'sk_num');
        if ($sk_num < 1) {
            Tiperror("商品秒杀数量已售罄。");
        }
        if ($sk_num < $goods_num) {
            Tiperror("商品秒杀数量不足。");
        }
        $seklInfo = secondsKillModel::getSecondsKillInfoTime(['goods_id' => $goods_id]);
        if (empty($seklInfo)) {
            Tiperror("秒杀商品已超时！");
        }
    }

    /**
     * 促销信息
     * @param type $goods_id
     * @param type $goods_num
     */
    public static function comdypJudge($goods_id, $goods_num) {
        //判断秒杀数量
        $cp_num = comdysalesPromotionModel::getValue(['goods_id' => $goods_id], 'cp_num');
        if ($cp_num < 1) {
            Tiperror("商品促销数量已售罄。");
        }
        if ($cp_num < $goods_num) {
            Tiperror("商品促销数量不足。");
        }
        $comdypInfo = comdysalesPromotionModel::getComdypInfoTime(['goods_id' => $goods_id]);
        if (empty($comdypInfo)) {
            Tiperror("促销商品已超时！");
        }
    }

    /**
     * 拼团信息
     * @param type $goods_id
     * @param type $goods_num
     */
    public static function spellGroupJudge($goods_id, $goods_num, $first_member_id, $sgm_id) {
        $mid = session('member_id');
        //判断拼团数量
        $spellGroup = spellGroupModel::getInfo(['goods_id' => $goods_id], 'sg_members_num,sg_num');
        if ($spellGroup['sg_num'] < 1) {
            Tiperror("商品拼团数量已售罄。");
        }
        if ($spellGroup['sg_num'] < $goods_num) {
            Tiperror("商品拼团数量不足。");
        }
        if ($mid == $first_member_id) {
            Tiperror("你已发起拼单!");
        }
        $mySpgOrdnumCount = spellGroupOrdernumModel::getCount(['goods_id' => $goods_id, 'first_member_id' => $mid, 'order_status' => TOSG_STATUS]);

        //我发起拼单人数判断
        if ($first_member_id < 1) {
            if ($mySpgOrdnumCount > 0 && $mySpgOrdnumCount < $spellGroup['sg_members_num']) {
                Tiperror("你已发起拼单,快去邀请朋友参与吧。");
            }
            //参团判断
        } else {
            $order_no = spellGroupOrdernumModel::getValue(['id' => $sgm_id], 'order_no');
            $SpgOrdnumCount = spellGroupOrdernumModel::getCount(['order_no' => $order_no]);
            $afterSpgOrdnumCount = spellGroupOrdernumModel::getCount(['order_no' => $order_no, 'after_member_id' => $mid, 'order_status' => TOSG_STATUS]);
            //我参别人团人数判断
            if ($SpgOrdnumCount >= $spellGroup['sg_members_num']) {
                Tiperror("拼单人数已满。");
            }
            //我是否参别人的团
            if ($afterSpgOrdnumCount > 0) {
                Tiperror("你已参团。");
            }
        }
    }

    //多个订单付款
    public static function orderChange() {
        $post = input('post.');
        $mid = session('member_id');
        $forehead = memberModel::getValue($mid, 'forehead');
        if ($post['cart_total_price'] > $forehead) {
            Tiperror("你的余额不足！");
        }
        
        $post['goods_id'] = empty(is_array($post['goods_id'])) ? explode(',', $post['goods_id']) : $post['goods_id'];
        $post['n_id'] = empty(is_array($post['n_id'])) ? explode(',', $post['n_id']) : $post['n_id'];
        $post['cate_id'] = empty(is_array($post['cate_id'])) ? explode(',', $post['cate_id']) : $post['cate_id'];
        
        Db::startTrans();
        try {
            $total_price = array();
            //判断优惠券是否过期
            foreach ($post['goods_id'] as $key1 => $goods_id1) {
                $orderGoodsWhere = ['m_id' => $mid, 'goods_id' => $goods_id1, 'n_id' => $post['n_id'][$key1], 'cate_id' => $post['cate_id'][$key1], 'state' => FORP_STATUS];

                $orderGoods = orderGoodsModel::getOrderGoodsInfo($orderGoodsWhere, '*');

                $todayTime = date("Y-m-d H:i:s");
                $couponReceiveInfo = couponReceiveModel::getCouponReInfo(['id' => $orderGoods['copon_receive_id'], 'copb_time' => array('egt', $todayTime)]);
                if ($orderGoods['copon_receive_id'] > 0 && empty($couponReceiveInfo)) {
                    Tiperror("优惠券已过期");
                }
                $total_price[] = $orderGoods['total_price'];
            }
            $cart_total_price = array_sum($total_price);
            //扣除用户金额
            $result = payModel::deductions($post['payment_type'], $cart_total_price);
            if ($result) {
                foreach ($post['goods_id'] as $key => $goods_id) {
                    //订单变更
                    $orderGoodsWhere = ['m_id' => $mid, 'goods_id' => $goods_id, 'n_id' => $post['n_id'][$key], 'cate_id' => $post['cate_id'][$key], 'state' => FORP_STATUS];

                    $orderGoods = orderGoodsModel::getOrderGoodsInfo($orderGoodsWhere, '*');
                    orderGoodsModel::updates(['order_no' => $orderGoods['order_no']], ['state' => TOSG_STATUS, 'payment_time' => time()]);
                    orderModel::updates(['order_no' => $orderGoods['order_no']], ['state' => TOSG_STATUS, 'payment_time' => time()]);
                    //添加已付款人数
                    GoodsModel::setIncs(['goods_id' => $goods_id], 'number_payment', 1);

                    //添加拼单支付信息
                    if ($orderGoods['activity'] == 'spell_group') {
                        //参与
                        if ($orderGoods['spell_list_m_id'] > 0) {
                            $sg_order_no = spellGroupOrdernumModel::getValue(['goods_id' => $goods_id,
                                        'first_member_id' => $orderGoods['spell_list_m_id'], 'order_status' => TOSG_STATUS], 'order_no');
                            $spellData = ['goods_id' => $goods_id, 'first_member_id' => $orderGoods['spell_list_m_id'], 'after_member_id' => $mid,
                                'order_no' => $sg_order_no, 'order_status' => TOSG_STATUS, 'payment_time' => time()];
                            //发起
                        } else {
                            $spellData = ['goods_id' => $goods_id, 'first_member_id' => $mid, 'order_status' => TOSG_STATUS, 'order_no' => $orderGoods['order_no'],
                                'payment_time' => time()];
                        }
                        spellGroupOrdernumModel::add($spellData);

                        $first_mid = !empty($orderGoods['spell_list_m_id']) ? $orderGoods['spell_list_m_id'] : $mid;
                        $SpgOrdnumCount = spellGroupOrdernumModel::getCount(['goods_id' => $goods_id, 'first_member_id' => $first_mid,
                                    'order_status' => TOSG_STATUS]);
                        $spellGroup = spellGroupModel::getInfo(['goods_id' => $goods_id], 'sg_members_num,sg_num');
                        $spellmpoor = $spellGroup['sg_members_num'] - $SpgOrdnumCount;
                        //如果拼团人数已满则更新为已满状态
                        if ($spellmpoor < 1) {
                            $spwhere = ['goods_id' => $goods_id, 'first_member_id' => $first_mid, 'order_status' => TOSG_STATUS];
                            spellGroupOrdernumModel::updates($spwhere, ['order_status' => 21]);
                        }
                    }

                    //删除优惠券
                    if ($orderGoods['copon_receive_id'] > 0) {
                        $couponReceiveInfo = couponReceiveModel::getCouponReInfo(['id' => $orderGoods['copon_receive_id']], "*");
                        //添加优惠券使用记录
                        couponUseModel::add(['member_id' => $mid, 'goods_id' => $goods_id, 'copre_id' => $couponReceiveInfo['id'],
                            'create_time' => time(), 'type' => $couponReceiveInfo['type'], 'type_id' => $couponReceiveInfo['type_id'],
                            'cop_price' => $couponReceiveInfo['cop_price'], 'copa_time' => $couponReceiveInfo['copa_time'],
                            'copb_time' => $couponReceiveInfo['copb_time'], 'full_amount' => $couponReceiveInfo['full_amount']]);
                        couponReceiveModel::destroy($orderGoods['copon_receive_id']);
                    }
                }


                //记录付款记录
                paymentLogModel::add([
                    'm_id' => $mid, 'order_number' => self::plogtrade_no(), 'payment_type' => $post['payment_type'], 'type_text' => "商品购买",
                    'amount' => $cart_total_price, 'state' => 20, 'create_time' => time(),
                ]);

                //记录用户出入账
                $payment_name = paymentModel::getValue(['payment_mark' => $post['payment_type']], 'payment_name');
                recordBooksModel::add(['member_id' => $mid, 'books_text' => "商品购买(" . $payment_name . ")", 'books_type' => 'out', 'amount' => $cart_total_price,
                    'create_time' => time(), 'payment_type' => $post['payment_type'], 'rdbook_type' => 1]);

                Db::commit();

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {

            Db::rollback();

            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    /**
     * 单个订单付款
     */
    public static function orderChangeOne() {
        $post = input('post.');
        $mid = session('member_id');
        $orderGoodsNo = $post['order_no'];
        $payment_type = isset($post['payment_type']) ? $post['payment_type'] : 'balance';
        $orderGoods = orderGoodsModel::getOrderGoodsInfo(['order_no' => $orderGoodsNo], '*');
        if ($orderGoods['activity'] == 'spell_group') {
            self::spellGroupJudge($orderGoods['goods_id'], $orderGoods['goods_num'], $orderGoods['spell_list_m_id'], $orderGoods['sgm_id']);
        }
        if ($orderGoods['activity'] == 'seconds_kill') {
            self::secondsKillJudge($orderGoods['goods_id'], $orderGoods['goods_num']);
        }
        $forehead = memberModel::getValue($mid, 'forehead');
        if ($orderGoods['total_price'] > $forehead && $payment_type == 'balance') {
            Tiperror("你的余额不足！");
        }
        Db::startTrans();
        try {
            //扣除用户余额
            $result = payModel::deductions($payment_type, $orderGoods['total_price']);

            if ($result) {
                $todayTime = date("Y-m-d H:i:s");
                $couponReceiveInfo = couponReceiveModel::getCouponReInfo(['id' => $orderGoods['copon_receive_id'], 'copb_time' => array('egt', $todayTime)]);
                if ($orderGoods['copon_receive_id'] > 0 && empty($couponReceiveInfo)) {
                    Tiperror("优惠券已过期");
                }
                //订单变更
                orderGoodsModel::updates(['order_no' => $orderGoodsNo], ['state' => TOSG_STATUS, 'payment_type' => $payment_type, 'payment_time' => time()]);
                orderModel::updates(['order_no' => $orderGoodsNo], ['state' => TOSG_STATUS, 'payment_type' => $payment_type, 'payment_time' => time()]);
                //添加已付款人数
                GoodsModel::setIncs(['goods_id' => $orderGoods['goods_id']], 'number_payment', 1);
                //记录付款记录
                paymentLogModel::add([
                    'm_id' => $mid, 'order_number' => self::plogtrade_no(), 'payment_type' => $orderGoods['payment_type'], 'type_text' => "商品购买",
                    'amount' => $orderGoods['total_price'], 'state' => 20, 'create_time' => time(),
                ]);
                //添加拼单支付信息
                if ($orderGoods['activity'] == 'spell_group') {
                    if ($orderGoods['spell_list_m_id'] > 0) {
                        $order_no = spellGroupOrdernumModel::getValue(['id' => $orderGoods['sgm_id']], 'order_no');
                        $spellData = ['goods_id' => $orderGoods['goods_id'], 'first_member_id' => $orderGoods['spell_list_m_id'], 'after_member_id' => $mid,
                            'order_no' => $order_no, 'order_status' => TOSG_STATUS, 'payment_time' => time()];
                    } else {
                        $spellData = ['goods_id' => $orderGoods['goods_id'], 'first_member_id' => $mid, 'order_status' => TOSG_STATUS,
                            'order_no' => $orderGoodsNo, 'payment_time' => time()];
                    }
                    spellGroupOrdernumModel::add($spellData);

                    $first_mid = !empty($orderGoods['spell_list_m_id']) ? $orderGoods['spell_list_m_id'] : $mid;
                    $SpgOrdnumCount = spellGroupOrdernumModel::getCount(['goods_id' => $orderGoods['goods_id'], 'first_member_id' => $first_mid,
                                'order_status' => TOSG_STATUS]);
                    $spellGroup = spellGroupModel::getInfo(['goods_id' => $orderGoods['goods_id']], 'sg_members_num,sg_num');
                    $spellmpoor = $spellGroup['sg_members_num'] - $SpgOrdnumCount;
                    //如果拼团人数已满则更新为已满状态
                    if ($spellmpoor < 1) {
                        $spwhere = ['goods_id' => $orderGoods['goods_id'], 'first_member_id' => $first_mid, 'order_status' => TOSG_STATUS];
                        spellGroupOrdernumModel::updates($spwhere, ['order_status' => 21]);
                    }
                }
                //删除优惠券
                if ($orderGoods['copon_receive_id'] > 0) {
                    $couponReceiveInfo = couponReceiveModel::getCouponReInfo(['id' => $orderGoods['copon_receive_id']], "*");
                    //添加优惠券使用记录
                    couponUseModel::add(['member_id' => $mid, 'goods_id' => $orderGoods['goods_id'], 'copre_id' => $couponReceiveInfo['id'],
                        'create_time' => time(), 'type' => $couponReceiveInfo['type'], 'type_id' => $couponReceiveInfo['type_id'],
                        'cop_price' => $couponReceiveInfo['cop_price'], 'copa_time' => $couponReceiveInfo['copa_time'],
                        'copb_time' => $couponReceiveInfo['copb_time'], 'full_amount' => $couponReceiveInfo['full_amount']]);
                    couponReceiveModel::destroy($orderGoods['copon_receive_id']);
                }
                //记录用户出入账
                $payment_name = paymentModel::getValue(['payment_mark' => $orderGoods['payment_type']], 'payment_name');
                recordBooksModel::add(['member_id' => $mid, 'books_text' => "商品购买(" . $payment_name . ")", 'books_type' => 'out', 'amount' => $orderGoods['total_price'],
                    'create_time' => time(), 'payment_type' => $orderGoods['payment_type']]);

                Db::commit();

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {

            Db::rollback();

            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    /**
     * 生成唯一的订单号 20110809111259232312
     * 2011-年日期
     * 08-月份
     * 09-日期
     * 11-小时
     * 12-分
     * 59-秒
     * 2323-微秒
     * 12-随机值
     * @return string
     */
    public static function trade_no() {
        list($usec, $sec) = explode(" ", microtime());
        $usec = substr(str_replace('0.', '', $usec), 0, 4);
        $str = rand(10, 99);
        $order_no = date("YmdHis") . $usec . $str;
        $orders = orderGoodsModel::getOrderNoID($order_no);
        if ($orders) {
            Tiperror("有订单重复！");
        }
        return $order_no;
    }

    /**
     * 生成付款编号
     * @return string
     */
    public static function plogtrade_no() {
        list($usec, $sec) = explode(" ", microtime());
        $usec = substr(str_replace('0.', '', $usec), 0, 4);
        $str = rand(10, 99);
        $order_no = date("YmdHis") . $usec . $str;
        $paymentLog = paymentLogModel::getOrderMumberID($order_no);
        if ($paymentLog) {
            Tiperror("有订单重复！");
        }
        return $order_no;
    }

}
