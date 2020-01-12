<?php

namespace app\socket\controller;

use app\socket\controller\Common;
use \think\Db;
use \think\Request;
use app\common\model\Goods as goodsModel;
use app\common\model\Kefu as kefuModel;
use app\common\model\Member as memberModel;
use app\common\model\KefuMemberOnline as kefuMemberOnlineModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\KefuStatements as kefuStatementsModel;

class Index extends Common {

    public function index() {
        $kefu_id = input('kefu_id', 0, 'intval');
        $goods_id = input('goods_id', 0, 'intval');
        $order_no = input('order_no', 0, 'trim');

        $orderGoods = orderGoodsModel::where(['order_no' => $order_no])->find();
        $this->assign('orderGoods', $orderGoods);

        $kefu = kefuModel::getInfo(['id' => $kefu_id]);
        $this->assign('kefu', $kefu);

        $goods = goodsModel::get($goods_id);
        $this->assign('goods', $goods);
        $member = memberModel::getMemberInfo(['id' => $this->mid]);
        $this->assign('member', $member);

        $kefuStatements = kefuStatementsModel::getInfo(['kefu_id_str' => ['like', "%[" . $kefu_id . "]%"]]);
        $this->assign('kefuStatements', $kefuStatements);

        $kefuMemberOnline = kefuMemberOnlineModel::getCount(['member_id' => $this->mid, 'kefu_id' => $kefu_id]);
        //用户在线状态操作
        if (!$kefuMemberOnline) {
            kefuMemberOnlineModel::add(['member_id' => $this->mid, 'member_name' => $member['member_name'], 'avatar' => $member['photo'],
                'kefu_id' => $kefu_id, 'member_online' => 1]);
        } else {
            kefuMemberOnlineModel::updates(['member_id' => $this->mid, 'kefu_id' => $kefu_id], ['member_online' => 1]);
        }
        if (Request()->isMobile()) {
            return $this->fetch('index/mobile_index');
        } else {
            return $this->fetch('index/pc_index');
        }
    }

}
