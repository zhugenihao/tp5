<?php

namespace app\index\controller\seller_sales_promotion;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\ComdysalesPromotion as somdysalesPromotionModel;
use app\common\model\Goods as goodsModel;

class ComdysalesPromotion extends SellerCommon {

    public function comdsption_list() {
        $store = $this->store;
        $list = somdysalesPromotionModel::getList(['c.store_id' => $store['id']], 10);
        $this->assign('comdsption', $list->toArray());
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function comdsption_add() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $res = somdysalesPromotionModel::addmd($store['id']);
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

    public function comdsption_details() {
        if ($this->request->isAjax()) {
            $res = somdysalesPromotionModel::editmd();
            if ($res) {
                Tobesuccess("编辑成功");
            } else {
                Tiperror("编辑失败");
            }
        }
        $info = somdysalesPromotionModel::get(input('comdsption_id'));
        $goodsInfo = goodsModel::getInfo(['goods_id' => $info['goods_id']], 'goods_id,goods_name,goods_price');
        $this->assign([
            'goodsInfo' => $goodsInfo, 'info' => $info
        ]);
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
    /**
     * 删除秒杀
     */
    public function delComdsption() {
        if ($this->request->isAjax()) {
            $comdsptionid_str = input('comdsptionid_str');
            $comdsptionid_arr = array_filter(explode(",", $comdsptionid_str));

            if (empty($comdsptionid_arr)) {
                Tiperror("您未选择！");
            }
            $result = somdysalesPromotionModel::destroy($comdsptionid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
