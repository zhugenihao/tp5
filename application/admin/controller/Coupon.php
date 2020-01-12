<?php

/**
 * 优惠券信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Coupon as CouponModel;
use app\admin\model\Goods as goodsModel;
use app\admin\model\Store as storeModel;
use \think\Db;

class Coupon extends Common {

    public function couponList() {
        $limit = 10;
        $list = CouponModel::getCouponlist($limit, ['c.store_id' => 0]);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("type", input('type'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function couponAdd() {
        if ($this->request->isAjax()) {
            $res = CouponModel::couponAddmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $start_time = date('Y-m-d H:i:s');
        $this->assign('start_time', $start_time);

        return $this->fetch();
    }

    public function getGoodsList() {
        if ($this->request->isAjax()) {
            $goods_where = input('get.goods_where');
            if (is_numeric($goods_where)) {
                $where = ['goods_id' => $goods_where];
            } else {
                $where['goods_name'] = array('like', '%' . $goods_where . '%');
            }
            $goodsList = goodsModel::field('goods_id,goods_name,goods_price')->where($where)->limit(20)->select();
            echo json_encode($goodsList);
        }
    }

    public function getStoreList() {
        if ($this->request->isAjax()) {
            $store_where = input('get.store_where');
            if (is_numeric($store_where)) {
                $where = ['store_id' => $store_where];
            } else {
                $where['store_name'] = array('like', '%' . $store_where . '%');
            }
            $storeList = storeModel::getList($where, 'id,store_name', 0, 20);
            echo json_encode($storeList);
        }
    }

    public function couponEdit() {
        if ($this->request->isAjax()) {
            $res = CouponModel::couponEditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $get = input('get.');
        $info = CouponModel::getInfo(['cop_id' => $get['cop_id']], 'c.*,g.goods_name,g.thecover,g.goods_price,s.store_name');
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $info = CouponModel::get(input("get.cop_id"));
            if ($info['cop_show'] == 1) {
                $info->cop_show = 2;
            } else {
                $info->cop_show = 1;
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $idStr = input('idstr');
            $idArr = explode(",", $idStr);
            if (empty($idArr)) {
                Tiperror("您未选择！");
            }
            $result = CouponModel::destroy($idArr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
