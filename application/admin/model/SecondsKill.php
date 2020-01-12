<?php

/**
 * 商品秒杀信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class SecondsKill extends Commons {

    protected $pk = 'id';
    protected $name = "seconds_kill";

    public static function getSecondsKilllist($limit = 10, $where = []) {
        $search = trim(input('search'));
        $catetype = trim(input('catetype'));
        $every_day = trim(input('every_day'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($catetype)) {
            $where['catetype'] = $catetype;
        }
        if (!empty($every_day)) {
            $where['every_day'] = $every_day;
        }
        $map['query'] = ['search' => $search, 'catetype' => $catetype, 'every_day' => $every_day,];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field("s.*,g.goods_name,g.thecover,g.goods_price")->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    /*
     * 添加商品秒杀
     */

    public static function secondsKillAddmd() {
        $post = input('post.');
        $data = [
            'goods_id' => $post['goods_id'], 'sk_num' => $post['sk_num'], 'sk_price' => $post['sk_price'], 'discount' => $post['discount'],
            'start_time' => $post['start_time'], 'end_time' => $post['end_time'], 'sort' => $post['sort'], 'every_day' => $post['every_day'],
            'is_show' => $post['is_show'], 'create_time' => time(),
        ];
        $secondsKillCount = self::where('goods_id', $post['goods_id'])->count();
        if ($secondsKillCount > 0) {
            Tiperror("秒杀商品已存在，请直接编辑！");
        }
        if (!$post['goods_id'] || !$post['sk_num'] || !$post['sk_price'] || !$post['start_time'] || !$post['end_time']) {
            Tiperror("商品、秒杀数量、秒杀价格、开始时间、结束时间都缺一不可！");
        }
        if ((int) $post['discount'] > 10) {
            Tiperror("折扣不能大于10");
        }
        if ($post['start_time'] >= $post['end_time']) {
            Tiperror("开始时间不能大于结束时间！");
        }
        if ($data) {
            $result = self::insert($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * 编辑商品秒杀
     */

    public static function secondsKillEditmd() {
        $post = input('post.');
        $secondsKillCount = self::where('goods_id', $post['goods_id'])->count();
        if ($secondsKillCount < 1 && $post['id'] == '') {
            self::secondsKillAddmd();
        }
        $data = [
            'id' => $post['id'],
            'goods_id' => $post['goods_id'], 'sk_num' => $post['sk_num'], 'sk_price' => $post['sk_price'], 'discount' => $post['discount'],
            'start_time' => $post['start_time'], 'end_time' => $post['end_time'], 'sort' => $post['sort'], 'every_day' => $post['every_day'],
            'is_show' => $post['is_show'],
        ];
        if (!$post['goods_id'] || !$post['sk_num'] || !$post['sk_price'] || !$post['start_time'] || !$post['end_time']) {
            Tiperror("商品、秒杀数量、秒杀价格、开始时间、结束时间都缺一不可！");
        }
        if ((int) $post['discount'] > 10) {
            Tiperror("折扣不能大于10");
        }
        if ($post['start_time'] >= $post['end_time']) {
            Tiperror("开始时间不能大于结束时间！");
        }
        if ($data) {
            $result = self::update($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
