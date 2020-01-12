<?php

/**
 * 接口信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Member as memberModel;

class Api extends Common {

    public function _initialize() {
        parent::_initialize();
    }
    public function getToken() {

        $member = memberModel::getMemberInfo(['id' => $this->mid]);
        $mytoken = null;
        $type = input('type', '', 'trim');
        $id = input('id', 0, 'intval');
        if ($member['token'] && $type && $id) {
            $data = [
                'token' => $member['token'],
                'type' => $type,
                'id' => $id
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
            if ($data['token']) {
                $member = memberModel::where('token', $data['token'])->find();
                $result['user'] = [
                    'user_id' => $member['id'],
                    'nickname' => $member['member_name'],
                    'avatar' => url($member['photo'], '', false, true),
                ];
            }

            if ($data['id']) {
                $result['type'] = $data['type'];

                if ($data['type'] == 'goods') {

                    $goods = Db::name('goods')->find($data['id']);
//                    $thumb = goods_thum_images($goods['goods_id'], 240, 240);
                    $result['goods'] = [
                        'goods_id' => $goods['goods_id'],
                        'goods_name' => $goods['goods_name'],
                        'shop_price' => $goods['cost_price'],
                        'market_price' => $goods['goods_price'],
                        'thumb' => url($goods['thecover'], '', false, true),
                        'url' => url('Index/Goods/goods_details', 'goods_id=' . $goods['goods_id'], true, true)
                    ];
                } else if ($data['type'] == 'order') {

                    $order = Db::name('order')->find($data['id']);
                    $order_goods = Db::name('order_goods')->where('order_id', $order['id'])->select();

                    foreach ($order_goods as $k => $v) {
//                        $thumb = goods_thum_images($v['goods_id'], 240, 240);
                        $goods = Db::name('goods')->find($v['goods_id']);
                        $v['thumb'] = url($goods['thecover'], '', false, true);
                        $v['url'] = url('Index/Goods/goods_details', 'id=' . $v['goods_id'], true, true);
                        $order_goods[$k] = $v;
                    }

                    $result['order'] = [
                        'info' => $order,
                        'list' => $order_goods
                    ];
                }
            }
        }


        return $this->result($result, 200, '获取成功', 'json');
    }

}
