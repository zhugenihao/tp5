<?php

/**
 * 商品订单信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\Goods as goodsModel;
use app\common\model\Norm as normModel;
use app\common\model\Cart as cartModel;
use app\common\model\Order as OrderModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\SecondsKill as secondsKillModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\SpellGroupOrdernum as spellGroupOrdernumModel;
use app\common\model\Member as memberModel;
use app\common\model\Courier as courierModel;
use app\common\model\ComdysalesPromotion as comdysalesPromotionModel;

class OrderGoods extends Commons {

    protected $pk = 'id';
    protected $name = "order_goods";

    public static function add($data) {
        return self::create($data);
    }

    public static function getOrderNoID($order_no) {
        $res = self::where("order_no", "=", $order_no)->find();
        return $res;
    }

    public static function getValue($where = [], $value = 'order_no') {
        return self::where($where)->value($value);
    }

    public static function createOrderGoods($where, $data) {
        $mid = session('member_id');
        $goodsInfo = goodsModel::getInfo(['goods_id' => $data['goods_id']], 'goods_id,goods_stock');
        $inventoryInfo = inventoryModel::getInfo(['n_id' => $where['n_id'], 'cate_id' => $where['cate_id']], 'id,inventory');
        //当商品没有规格时判断商品库存
        if ($goodsInfo['goods_stock'] < $data['goods_num'] && $data['setup_norm'] == 'off') {
            Tiperror("商品库存不足。");
        }
        //当商品有规格时判断商品库存
        if ($inventoryInfo['inventory'] < $data['goods_num'] && $data['setup_norm'] == 'on') {
            Tiperror("商品库存不足。");
        }
        $ordersInfo = self::where($where)->find(); //订单是否已存在
        if (!empty($ordersInfo)) {
            unset($data['order_no'], $data['tord_time']);
            self::where($where)->update($data);
            $orderNo = $ordersInfo['order_no'];
        } else {
            $addOrder = self::create($data);
            //减商品库存
            goodsModel::setDecs(['goods_id' => $where['goods_id']], 'goods_stock', $data['goods_num']);
            //减商品规格库存
            if ($data['setup_norm'] == 'on') {
                inventoryModel::setDecs(['id' => $inventoryInfo['id']], 'inventory', $data['goods_num']);
            }
            //秒杀减库存
            if ($data['activity'] == 'seconds_kill') {
                secondsKillModel::setDecs(['goods_id' => $where['goods_id']], 'sk_num', $data['goods_num']);
            }
            //促销减库存
            if ($data['activity'] == 'comdysalesp') {
                comdysalesPromotionModel::setDecs(['goods_id' => $where['goods_id']], 'cp_num', $data['goods_num']);
            }
            //拼团减库存
            if ($data['activity'] == 'spell_group') {
                spellGroupModel::setDecs(['goods_id' => $where['goods_id']], 'sg_num', $data['goods_num']);
            }
            $orderNo = $addOrder->order_no;
        }

        //清除购物车记录
        cartModel::getDelete(['goods_id' => $data['goods_id'], 'n_id' => $data['n_id'], 'm_id' => $mid,
            'cate_id' => $data['cate_id'], 'setup_norm' => $data['setup_norm']]);
        return $orderNo;
    }

    /**
     * 订单列表
     * @param type $where
     * @param type $field
     * @param type $start
     * @param type $limit
     * @return type
     */
    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['o.id' => 'desc'];
        $join = [
            ['mz_goods g', 'g.goods_id=o.goods_id', 'left'], //商品表信息
            ['mz_norm n', 'n.n_id=o.n_id', 'left'], //规格表信息
            ['mz_goods_color gc', 'gc.id=n.goodscolor_id', 'left'], //商品颜色表信息
            ['mz_cates cs', 'cs.cate_id=o.cate_id', 'left'], //商品版本表信息
            ['mz_spell_group sg', 'sg.goods_id=o.goods_id', 'left'], //商品拼团表信息
        ];
        $list['count'] = self::alias('o')->join($join)->where($where)->count();
        $lists = self::alias('o')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        if ($lists) {
            foreach ($lists as $key => $val) {
                $spgOrdnumInfo = spellGroupOrdernumModel::getInfo(['id' => $val['sgm_id']], 'order_no');
                $order_no = !empty($spgOrdnumInfo) ? $spgOrdnumInfo['order_no'] : $val['order_no'];
                $spgOrdnumList = spellGroupOrdernumModel::getSpgOrdnumList(['order_no' => $order_no], 'first_member_id,after_member_id')->toArray();
                $memberIdArr = array();
                $first_member_id = '';
                $after_member = array();
                $first_member = array();
                foreach ($spgOrdnumList as $sgmkey => $sgmval) {
                    $memberIdArr[] = $sgmval['after_member_id'];
                    $first_member_id = $sgmval['first_member_id'];
                }
                $memberIdArr = array_filter($memberIdArr);
                if ($memberIdArr) {
                    $after_member = memberModel::getList(['id' => ['in', $memberIdArr]], 'id,photo,avatarUrl,nickName')->toArray();
                }
                if ($first_member_id) {
                    $first_member = memberModel::getMemberInfo(['id' => $first_member_id], 'id,photo,avatarUrl,nickName')->toArray();
                }
                if ($after_member || $first_member) {
                    array_unshift($after_member, $first_member);
                }

                $lists[$key]['sgm_member_list'] = $after_member; //拼团成员
                $sg_members_num = spellGroupModel::getValue(['goods_id' => $val['goods_id']], 'sg_members_num');
                $lists[$key]['sgm_member_poor'] = $sg_members_num - count($spgOrdnumList);
                $lists[$key]['tord_time'] = date('Y-m-d H:i:s', $val['tord_time']);
            }
        }
        $list['list'] = $lists;
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $join = [
            ['mz_order o', 'o.order_no=og.order_no', 'left'], //商品表信息
            ['mz_coupon_receive cr', 'cr.id=og.copon_receive_id', 'left'], //优惠券领取表信息
            ['mz_coupon c', 'c.cop_id=cr.cop_id', 'left'], //优惠券表信息
            ['mz_payment p', 'p.payment_mark=og.payment_type', 'left'], //支付方式表信息
        ];
        $res = self::alias('og')->field($field)->join($join)->where($where)->find();
        $res['tord_time'] = !empty($res['tord_time']) ? date('Y-m-d H:i:s', $res['tord_time']) : '0';
        $res['payment_time'] = !empty($res['payment_time']) ? date('Y-m-d H:i:s', $res['payment_time']) : '0';
        $res['delivery_time'] = !empty($res['delivery_time']) ? date('Y-m-d H:i:s', $res['delivery_time']) : '0';
        return $res;
    }

    public static function getOrderGoodsInfo($where = [], $field = '*') {
        $info = self::field($field)->where($where)->find();
        $info['cou_name'] = courierModel::getValue(['id' => OrderModel::getValue(['order_no' => $info['order_no']], 'cou_id')], 'cou_name');
        return $info;
    }

    public static function getOrderGoodsList($where = [], $field = '*') {
        return self::field($field)->where($where)->select();
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    /**
     * 价格运算
     * @param type $goods_id 商品id
     * @param type $n_id 规格id
     * @param type $cate_id 版本id
     * @param type $activity 活动类型
     * @return type
     */
    public static function priceCalculation($goods_id = '', $n_id = '', $cate_id = '', $activity = '') {
        $goods = GoodsModel::get($goods_id);
        $inventoryArr = inventoryModel::getInfo(['goods_id'=>$goods_id,'n_id' => $n_id, 'cate_id' => $cate_id]);
        $goods_price = !empty($goods['setup_norm'] == 'off') ? $goods['goods_price'] : $inventoryArr['inty_price'];
        //秒杀信息
        if ($activity == 'seconds_kill') {
            $sk_price = secondsKillModel::getValue(['goods_id' => $goods['goods_id']], 'sk_price');
            //秒杀规格价格的运算：秒杀规格价格=(秒杀价格/商品价格)*原商品规格价格
            $cate_price = ($sk_price / $goods['goods_price']) * $goods_price;
        } else if ($activity == 'spell_group') {
            $sg_price = spellGroupModel::getValue(['goods_id' => $goods['goods_id']], 'sg_price');
            //拼团规格价格的运算：拼团规格价格=(拼团价格/商品价格)*原商品规格价格
            $cate_price = ($sg_price / $goods['goods_price']) * $goods_price;
        } else if ($activity == 'comdysalesp') {
            //促销规格价格的运算
            $comdysalesp = comdysalesPromotionModel::getInfo(['goods_id' => $goods['goods_id']], 'cp_price,cp_type,discount');
            if ($comdysalesp['cp_type'] == 1) {//直接打折
                //打折规格价格=(折扣/10)*原商品规格价格
                $cate_price = ($comdysalesp['discount'] / 10) * $goods_price;
            } elseif ($comdysalesp['cp_type'] == 2) {//减价优惠
                //减价规格价格=(减价价格/商品价格)*原商品规格价格
                $cate_price = ($comdysalesp['cp_price'] / $goods['goods_price']) * $goods_price;
            }
        } else {
            $cate_price = $goods_price;
        }

        return sprintf("%.2f", $cate_price);
    }
    
    

}
