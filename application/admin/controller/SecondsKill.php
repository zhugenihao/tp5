<?php

/**
 * 商品秒杀信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\SecondsKill as SecondsKillModel;
use app\admin\model\Goods as goodsModel;
use \think\Db;

class SecondsKill extends Common {

    public function secondskilllist() {
        $limit = 5;
        $list = SecondsKillModel::getSecondsKilllist($limit, ['s.store_id' => 0]);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("every_day", input('every_day'));
        $this->assign("catetype", input('catetype'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function secondsKilladd() {
        if ($this->request->isAjax()) {
            $res = SecondsKillModel::secondsKillAddmd();
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

    public function secondsKilledit() {
        if ($this->request->isAjax()) {
            $res = SecondsKillModel::secondsKillEditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $get = input('get.');
        $info = SecondsKillModel::get($get['id']);
        $goodsInfo = goodsModel::field('goods_id,goods_name,goods_price')->where('goods_id', $info['goods_id'])->find();
        $start_time = $info['start_time'];
        if ($get['goods_id'] > 0) { //在商品管理设置秒杀时的操作
            $info = SecondsKillModel::where('goods_id', $get['goods_id'])->find();
            $goodsInfo = goodsModel::field('goods_id,goods_name,goods_price')->where('goods_id', $get['goods_id'])->find();
            $start_time = date('Y-m-d H:i:s');
        }
        $goods_id = $goodsInfo['goods_id'];
        $this->assign([
            'goods_id' => $goods_id, 'goodsInfo' => $goodsInfo, 'start_time' => $start_time
        ]);
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $info = SecondsKillModel::get(input("get.id"));
            if ($info['is_show'] == 1) {
                $info->is_show = 0;
            } else {
                $info->is_show = 1;
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
            $result = SecondsKillModel::destroy($idArr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
