<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\index\model\Session as sessionModel;
use app\common\model\Order as orderModel;
use app\index\model\OrderGoods as orderGoodsModel;
use app\common\model\Cart as cartModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\Gallery as galleryModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\Cates as catesModel;
use app\common\model\Norm as NormModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\CouponReceive as couponReceiveModel;
use app\common\model\Member as memberModel;
use app\common\model\Payment as paymentModel;
use app\common\model\StoreSettlement as storeSettlementModel;
use app\common\model\BesidesContent;
use app\common\model\Comments as commentsModel;
use app\index\model\Kefu as kefuModel;

class Order extends Common {

    public function _initialize() {

        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
    }

    public function orderList() {

        $mid = $this->mId();
        $state = input('state');
        $search = input('search');
        $activity = input('activity');
        $where['o.m_id'] = $mid;
        if ($state != 'all' && $state != '') {
            $where['o.state'] = $state;
        }
        if ($search != '') {
            $where['g.goods_name|o.order_no'] = array('like', "%" . $search . "%");
        }
        if ($activity != '') {
            $where['o.activity'] = $activity;
        }
//        print_r($where);
        $field = 'o.*,g.thecover,g.goods_name,n.goodscolor_id,gc.color_name,cs.cate_name,sg.sg_members_num';
        $orderList = orderGoodsModel::getListPc($where, $field, 10);
        $this->assign('orderList', $orderList['list']);
        $this->assign('orderCount', $orderList['count']);
        $this->assign('page', $orderList['list']->render());


        if ($activity == 'seconds_kill') {
            $orderCount = orderGoodsModel::getCount(['m_id' => $mid, 'activity' => 'seconds_kill']);
            $orderTitle = "我的秒杀({$orderCount})";
        } elseif ($activity == 'spell_group') {
            $orderCount = orderGoodsModel::getCount(['m_id' => $mid, 'activity' => 'spell_group']);
            $orderTitle = "我的拼团({$orderCount})";
        } else {
            $orderCount = orderGoodsModel::getCount(['m_id' => $mid]);
            $orderTitle = "订单中心({$orderCount})";
        }
        $this->assign('orderTitle', $orderTitle);
        $this->assign('state', $state);
        $this->assign('search', $search);
        $this->assign('forehead', memberModel::getValue($this->mid, 'forehead'));
        $this->assign('payment_list', paymentModel::getList()); //获取支付方式列表

        $comments = commentsModel::where(['m_id' => $this->mid])->select();
        $commentsIs = array();
        foreach ($comments as $val) {
            $commentsIs[$val['order_no']] = $val['id'];
        }
        $this->assign('commentsIs', $commentsIs);
        return $this->fetch();
    }

    public function order_details() {
        $order_id = (int) input('order_id');
        $field = 'og.*,o.ads_name,o.ads_mobile,o.tcgaddress,o.leave_message,o.courier_price,c.cop_price,p.payment_name';
        $orderGoods = orderGoodsModel::getInfo(['og.id' => $order_id], $field);
//        print_r($orderGoods);
        $this->assign('orderGoods', $orderGoods);
        
        $kefu = kefuModel::getInfo(['store_id' => $orderGoods['store_id'], 'is_show' => 1, 'kefu_type' => 2]);
        $this->assign('kefu', $kefu);
        return $this->fetch();
    }

    /**
     * 单个商品订单提交
     * @return type
     */
    public function submit_orders() {
        $post = input('post.');
        $mid = $this->mId();
        $cartWhere = ['goods_id' => $post['goods_id'], 'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'm_id' => $mid,
            'setup_norm' => $post['setup_norm']];
        $count = cartModel::getCount($cartWhere);
        $goods = GoodsModel::get($post['goods_id']);
        //商品价格
        $goods_price = orderGoodsModel::priceCalculation($post['goods_id'], $post['n_id'], $post['cate_id'], $post['activity']);
        //若购物车没有则添加数据
        if ($count < 1) {
            $imgSmall = galleryModel::getValue(['n_id' => $post['n_id']], 'img_small');
            $imgSmall = !empty($imgSmall) ? $imgSmall : $goods['thecover'];
            $goods_img = !empty($goods['setup_norm'] == 'off') ? $goods['thecover'] : $imgSmall;
            $goodsColor = goodsColorModel::get(NormModel::getValue(['n_id' => $post['n_id']], 'goodscolor_id'));
            $cates = catesModel::get($post['cate_id']);

            //运费
            $totalFreight = orderModel::freightCalculate($post['goods_id'], $post['goods_num'], $post['n_id'], $post['cate_id']);
            //总费用
            $totalPrice = $goods_price * $post['goods_num'] + $totalFreight;
            //成本价
            $costPrice = GoodsModel::getCostPrice($post['goods_id'], $post['n_id'], $post['cate_id']);

            if ($goods['setup_norm'] == 'off') {
                $data = ['goods_id' => $post['goods_id'], 'goods_price' => $goods_price, 'goods_num' => $post['goods_num'],
                    'm_id' => $mid, 'total_price' => $totalPrice, 'create_time' => time(),
                    'goods_name' => $goods['goods_name'], 'goods_img' => $goods['thecover'], 'activity' => $post['activity'],
                    'setup_norm' => $goods['setup_norm'], 'spell_list_m_id' => $post['first_member_id'],
                    'sgm_id' => $post['sgm_id'], 'store_id' => $goods['store_id'], 'cost_price' => $costPrice, 'courier_price' => $totalFreight];
            } else {
                $data = ['goods_id' => $post['goods_id'], 'n_id' => $post['n_id'], 'cate_id' => $post['cate_id'], 'goods_price' => $goods_price,
                    'goods_num' => $post['goods_num'], 'm_id' => $mid, 'total_price' => $totalPrice, 'create_time' => time(),
                    'goods_name' => $goods['goods_name'], 'goods_img' => $goods_img, 'goods_information' => $goodsColor['color_name'] . $cates['cate_name'],
                    'activity' => $post['activity'], 'setup_norm' => $goods['setup_norm'], 'spell_list_m_id' => $post['first_member_id'],
                    'sgm_id' => $post['sgm_id'], 'store_id' => $goods['store_id'], 'cost_price' => $costPrice, 'courier_price' => $totalFreight];
            }
            cartModel::add($data);
        } else {
            $cart = cartModel::getInfo($cartWhere, 'copon_receive_id');
            if ($cart['copon_receive_id'] > 0) {
                couponReceiveModel::updates(['id' => $cart['copon_receive_id']], ['copr_state' => 1]);
            }
            cartModel::updates($cartWhere, ['goods_price' => $goods_price, 'goods_num' => $post['goods_num'],
                'total_price' => $goods_price * $post['goods_num'], 'activity' => $post['activity'], 'setup_norm' => $post['setup_norm'],
                'spell_list_m_id' => $post['first_member_id'], 'sgm_id' => $post['sgm_id'], 'copon_receive_id' => 0]);
        }

        $where = ['c.goods_id' => $post['goods_id'], 'c.n_id' => $post['n_id'], 'c.cate_id' => $post['cate_id'], 'c.m_id' => $mid];
        $field = 'c.*,g.goods_name,g.thecover,n.goodscolor_id,gc.color_name,cs.cate_name';
        $submitOrdersInfo = cartModel::submitTheorder($where, $field);
        $this->assign('submitOrdersInfo', $submitOrdersInfo);
        return $this->fetch();
    }

    /**
     * 购物车订单提交
     * @return type
     */
    public function cart_order_submit() {
        $post = input('post.');
        $mid = $this->mId();
        $where = ['c.cart_id' => ['in', $post['cartid']], 'c.m_id' => $mid];
        $field = 'c.*,g.goods_name,g.thecover,n.goodscolor_id,gc.color_name,cs.cate_name';
        $submitOrdersInfo = cartModel::submitTheorder($where, $field);
        $this->assign('submitOrdersInfo', $submitOrdersInfo);
        return $this->fetch('order/submit_orders');
    }

    /**
     * 订单取消
     */
    public function orderDel() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $orderIdArr = explode(',', $get['order_id']);
            $orderGoodsList = orderGoodsModel::all($orderIdArr)->toArray();
            $result = array();
            foreach ($orderGoodsList as $val) {
                //加回库存
                GoodsModel::setIncs(['goods_id' => $val['goods_id']], 'goods_stock', $val['goods_num']);
                inventoryModel::setIncs(['n_id' => $val['n_id'], 'cate_id' => $val['cate_id']], 'inventory', $val['goods_num']);
                $result[] = orderGoodsModel::updates(['id' => $val['id']], ['state' => SHUTD_STATUS]);
                orderModel::updates(['order_no' => $val['order_no']], ['state' => SHUTD_STATUS]);
            }
            if ($result) {
                Tobesuccess('取消成功');
            } else {
                Tiperror("取消失败！");
            }
        }
    }

    /**
     * 确认收货
     */
    public function confirmGoods() {
        if ($this->request->isAjax()) {
            Db::startTrans();
            try {
                $get = input('get.');
                $mid = $this->mId();
                $data = ['state' => SUCCE_STATUS, 'complete_time' => time()];

                $result = orderGoodsModel::updates(['order_no' => $get['order_no'], 'm_id' => $mid], $data);
                $orderGoods = orderGoodsModel::getOrderGoodsInfo(['order_no' => $get['order_no']], '*');
                if ($result) {
                    orderModel::updates(['order_no' => $get['order_no'], 'm_id' => $mid], $data);
                    //订单结算记录
                    storeSettlementModel::addSettlement($get['order_no']);
                    //添加商品销量
                    GoodsModel::setIncs(['goods_id' => $orderGoods['goods_id']], 'sales', $orderGoods['goods_num']);
                    Db::commit();
                    Tobesuccess('成功确认收货');
                } else {
                    Tiperror("确认收货失败！");
                }
            } catch (\Exception $e) {
                Db::rollback();
                Tiperror("出现其他异常", $e->getMessage());
            }
        }
    }

    public function logistics() {
        $order_id = (int) input('order_id');
        $orderGoods = orderGoodsModel::getOrderGoodsInfo(['id' => $order_id], '*');
        $this->assign('orderGoods', $orderGoods);
        return $this->fetch();
    }

    public function evaluation() {
        $order_id = (int) input('order_id');
        $orderGoods = orderGoodsModel::getOrderGoodsInfo(['id' => $order_id], '*');
        $this->assign('orderGoods', $orderGoods);

        $BesidesContent = BesidesContent::getScore();
        $this->assign('BesidesContent', $BesidesContent);
        return $this->fetch();
    }

}
