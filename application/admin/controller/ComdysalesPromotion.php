<?php

/**
 * 商品促销
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\admin\model\ComdysalesPromotion as somdysalesPromotionModel;
use app\admin\model\Goods as goodsModel;

class ComdysalesPromotion extends Common {

    public function comdsption_list() {
        $list = somdysalesPromotionModel::getList(['c.store_id' => 0], 10);
        $this->assign('comdsption', $list->toArray());
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function comdsption_add() {
        if ($this->request->isAjax()) {
            $res = somdysalesPromotionModel::addmd();
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
        $info = somdysalesPromotionModel::get(input('id'));
        $goodsInfo = goodsModel::field('goods_id,goods_name,goods_price')->where(['goods_id' => $info['goods_id']])->find();
        $this->assign([
            'goodsInfo' => $goodsInfo, 'info' => $info
        ]);
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
            $field = 'goods_id,goods_name,goods_price,thecover';
            $goodsList = goodsModel::field($field)->where($where)->limit(20)->select();
            exit(json_encode($goodsList));
        }
    }

    /**
     * 删除促销
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
