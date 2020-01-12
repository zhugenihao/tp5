<?php

/**
 * 秒杀信息
 */

namespace app\index\controller\seller_sales_promotion;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\SecondsKill as secondsKillModel;
use app\common\model\Goods as goodsModel;

class SecondsKill extends SellerCommon {

    public function secondskill_list() {
        $store = $this->store;
        $list = secondsKillModel::getSellerSklist(['s.store_id' => $store['id']], 10);
        $this->assign('secondsKill', $list->toArray());
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function secondskill_add() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $res = secondsKillModel::sellerSkAddmd($store['id']);
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

    public function secondskill_details() {
        if ($this->request->isAjax()) {
            $res = secondsKillModel::sellerSkEditmd();
            if ($res) {
                Tobesuccess("编辑成功");
            } else {
                Tiperror("编辑失败");
            }
        }
        $info = secondsKillModel::get(input('secondskill_id'));
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
    public function delSecondsKill() {
        if ($this->request->isAjax()) {
            $secondskillid_str = input('secondskillid_str');
            $secondskillid_arr = array_filter(explode(",", $secondskillid_str));

            if (empty($secondskillid_arr)) {
                Tiperror("您未选择！");
            }
            $result = secondsKillModel::destroy($secondskillid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
