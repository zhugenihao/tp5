<?php

namespace app\index\controller\seller_sales_promotion;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Coupon as couponModel;
use app\common\model\Goods as goodsModel;

class Coupon extends SellerCommon {

    public function _initialize() {
        parent::_initialize();
    }

    public function coupon_list() {
        $store = $this->store;
        $field = 'c.*,g.goods_name,g.thecover,g.goods_price,s.store_name';
        $coupon = couponModel::getCouponlist(['c.store_id' => $store['id']], 10, $field);
//        print_r($coupon->toArray());
        $this->assign('coupon', $coupon->toArray());
        $this->assign('page', $coupon->render());
        return $this->fetch();
    }

    public function coupon_add() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $res = couponModel::couponAddmd($store['id']);
            if ($res) {
                Tobesuccess("添加成功");
            } else {
                Tiperror("添加失败");
            }
        }
        $start_time = date('Y-m-d H:i:s');
        $this->assign('start_time', $start_time);
        return $this->fetch();
    }

    public function getGoodsList() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $goods_where = input('get.goods_where');
            if (is_numeric($goods_where)) {
                $where = ['goods_id' => $goods_where];
            } else {
                $where['goods_name'] = array('like', '%' . $goods_where . '%');
            }
            $where['store_id'] = $store['id'];

            $field = 'goods_id,goods_name,goods_price,thecover';
            $goodsList = goodsModel::getGoodsList($where, $field, 0, 20);
            exit(json_encode($goodsList['list']));
        }
    }

    public function coupon_details() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $res = couponModel::couponEditmd($store['id']);
            if ($res) {
                Tobesuccess("编辑成功");
            } else {
                Tiperror("编辑失败");
            }
        }
        $info = couponModel::get(input('cop_id'));
        if ($info['type'] == 1) {
            $goodsInfo = goodsModel::getInfo(['goods_id' => $info['type_id']], 'goods_id,goods_name,goods_price');
            $this->assign('goodsInfo', $goodsInfo);
        }
        if ($info['type'] == 2) {
            $this->assign('storeInfo', $store);
        }

        $this->assign('info', $info);
        return $this->fetch();
    }
    
    /**
     * 删除优惠券
     */
    public function delCoupon() {
        if ($this->request->isAjax()) {
            $copid_str = input('copid_str');
            $copid_arr = array_filter(explode(",", $copid_str));

            if (empty($copid_arr)) {
                Tiperror("您未选择！");
            }
            $list = BrandModel::all($copid_arr);
            foreach ($list as $val) {
                if (!empty($val['cop_img'])) {
                    if (file_exists(ROOT_PATH . "public/static/" . $val['cop_img'])) {
                        unlink(ROOT_PATH . "public/static/" . $val['cop_img']);
                    }
                }
            }
            $result = couponModel::destroy($copid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
