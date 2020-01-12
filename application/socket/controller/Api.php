<?php

/**
 * 接口信息
 */

namespace app\socket\controller;

use app\socket\controller\Common;
use \think\Db;
use app\common\model\Member as memberModel;
use app\common\model\Kefu as kefuModel;
use app\common\model\KefuChat as kefuChatModel;
use app\common\model\KefuMemberOnline as kefuMemberOnlineModel;

class Api extends Common {

    public $kefu_id = 0;

    public function _initialize() {
        parent::_initialize();
        $this->kefu_id = session('kefu_id');
    }

    public function getToken() {
        $mytoken = null;
        $type = input('type', '', 'trim');
        $go_type = input('go_type', '', 'trim');
        $id = input('id', 0, 'intval');
        $content = input('content');
        $member_id = input('member_id', 0, 'intval');
        $kefu_id = input('kefu_id', 0, 'intval');
        $member = memberModel::getMemberInfo(['id' => $member_id]);
        $kefu = kefuModel::getInfo(['id' => $kefu_id]);
        if ($member['id']) {
            if ($go_type == 'goods') {
                $goods = db::name('goods')->find($id);
                $url = url('Index/Goods/goods_details', 'goods_id=' . $goods['goods_id'], true, true);

                $content = json_encode(['goods_name' => $goods['goods_name'], 'url' => $url,
                    'thecover' => url('static/' . $goods['thecover'], '', false, true),
                    'goods_price' => $goods['goods_price']]);
            }
            if ($go_type == 'order') {
                $orderGoods = db::name('order_goods')->find($id);

                $content = json_encode(['goods_img' => url('static/' . $orderGoods['goods_img'], '', false, true),
                    'order_no' => $orderGoods['order_no'], 'total_price' => $orderGoods['total_price']]);
            }

            $kefuChat = kefuChatModel::add(['member_id' => $member_id, 'kefu_id' => $kefu_id,
                        'content' => $content, 'create_time' => time(), 'type' => $type,
                        'go_type' => $go_type, 'member_name' => $member['member_name'], 'kefu_name' => $kefu['kefu_name'],
                        'store_id' => $kefu['store_id']]);
            $kefu_chat_id = $kefuChat->id;

            $data = [
                'member_id' => $member_id,
                'kefu_id' => $kefu_id,
                'go_type' => $go_type,
                'type' => $type,
                'id' => $id,
                'kefu_chat_id' => $kefu_chat_id,
            ];
            $mytoken = base64_encode(json_encode($data));
        }

        return $this->result(['mytoken' => $mytoken], 200, '获取成功', 'json');
    }

    public function getTokenInfo() {

//        $ip = $_SERVER['REMOTE_ADDR'];
//        $ip_allow = [
//            $_SERVER['SERVER_ADDR']
//        ];
//        if(!in_array($ip,$ip_allow)){
//            return $this->result([],300,'非法请求','json');
//        }

        $mytoken = input('mytoken', '', 'trim');
        $result = null;
        if ($mytoken) {
            $data = json_decode(base64_decode($mytoken), true);

            if ($data['member_id']) {
                $member = memberModel::where('id', $data['member_id'])->find();
                $kefu = kefuModel::getInfo(['id' => $data['kefu_id']]);
                $result['member'] = [
                    'member_id' => $member['id'],
                    'member_name' => $member['member_name'],
                    'member_avatar' => url('static/' . $member['photo'], '', false, true),
                    'kefu_avatar' => url('static/' . $kefu['images'], '', false, true),
                    'chat_count' => kefuChatModel::getCount(['member_id' => $member['id'], 'kefu_id' => $data['kefu_id'], 'reads_status' => 1]),
                ];
            }
            if ($data['id']) {
                $result['go_type'] = $data['go_type'];
            }
            $result['kefu_id'] = $data['kefu_id'];
            $result['type'] = $data['type'];
            $result['content'] = kefuChatModel::getValue(['id' => $data['kefu_chat_id']], 'content');
        }
        return $this->result($result, 200, '获取成功', 'json');
    }

    public function getMemberOnlineList() {
        $mytoken = input('mytoken', '', 'trim');
        $result = null;
        if ($mytoken) {
            $data = json_decode(base64_decode($mytoken), true);
            $member = kefuMemberOnlineModel::getInfo(['member_id' => $data['member_id'], 'kefu_id' => $this->kefu_id, 'member_online' => 1]);
            $result['member'] = $member;
            $result['type'] = $data['type'];
            $result['chat_count'] = kefuChatModel::getCount(['member_id' => $data['member_id'], 'kefu_id' => $this->kefu_id, 'reads_status' => 1]);
        }
        return $this->result($result, 200, '获取成功', 'json');
    }

    public function getkefuChatList() {
        if ($this->request->isAjax()) {
            $member_id = input('member_id', 0, 'intval');
            $kefu_id = input('kefu_id', 0, 'intval');
            //更新读取状态
            kefuChatModel::updates(['member_id' => $member_id, 'kefu_id' => $this->kefu_id], ['reads_status' => 2]);

            $count = kefuChatModel::getCount(['member_id' => $member_id, 'kefu_id' => $kefu_id]);
            $limit = 10;
            $start = !empty($count > $limit) ? ($count - $limit) : 0;
            $kefuChat = kefuChatModel::getList(['member_id' => $member_id, 'kefu_id' => $kefu_id], $start, $limit);
            $kefuChat['data'] = $kefuChat->toArray();

            $kefuChat['member_avatar'] = kefuMemberOnlineModel::getValue(['member_id' => $member_id], 'avatar');
            $kefuChat['kefu_avatar'] = kefuModel::getValue(['id' => $this->kefu_id], "images");
            $kefuChat['chat_count'] = kefuChatModel::getCount(['member_id' => $member_id, 'kefu_id' => $this->kefu_id, 'reads_status' => 1]);

            return $this->result($kefuChat, 200, '获取成功', 'json');
        }
    }

}
