<?php

/**
 * 拼团信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class SpellGroup extends Commons {

    protected $pk = 'id';
    protected $name = "SpellGroup";

    public static function getSpellGrouplist($limit, $where = []) {
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
        $map['query'] = ['search' => $search, 'catetype' => $catetype, 'every_day' => $every_day];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $join = [["mz_goods g", 'g.goods_id=s.goods_id', 'left']];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                        ->field("s.*,g.goods_name,g.thecover,g.goods_price")->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    /*
     * 添加商品拼团
     */

    public static function spellGroupAddmd() {
        $post = input('post.');
        $data = [
            'goods_id' => $post['goods_id'], 'sg_num' => $post['sg_num'], 'sg_price' => $post['sg_price'], 'sg_members_num' => $post['sg_members_num'],
            'discount' => $post['discount'], 'start_time' => $post['start_time'], 'end_time' => $post['end_time'], 'sort' => $post['sort'],
            'every_day' => $post['every_day'], 'is_show' => $post['is_show'], 'create_time' => time(),
        ];
        $spellGroupCount = self::where('goods_id', $post['goods_id'])->count();
        if ($spellGroupCount > 0) {
            Tiperror("拼团商品已存在，请直接编辑！");
        }
        if (!$post['goods_id'] || !$post['sg_num'] || !$post['sg_price'] || !$post['sg_members_num'] || !$post['start_time'] || !$post['end_time']) {
            Tiperror("商品、拼团商品数量、拼团价格、拼团人数、开始时间、结束时间都缺一不可！");
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
     * 编辑商品拼团
     */

    public static function spellGroupEditmd() {
        $post = input('post.');
        $spellGroupCount = self::where('goods_id', $post['goods_id'])->count();
        if ($spellGroupCount < 1) {
            self::spellGroupAddmd();
        }
        $data = [
            'id' => $post['id'],
            'goods_id' => $post['goods_id'], 'sg_num' => $post['sg_num'], 'sg_price' => $post['sg_price'], 'sg_members_num' => $post['sg_members_num'],
            'discount' => $post['discount'], 'start_time' => $post['start_time'], 'end_time' => $post['end_time'], 'sort' => $post['sort'],
            'every_day' => $post['every_day'], 'is_show' => $post['is_show'],
        ];
        if (!$post['goods_id'] || !$post['sg_num'] || !$post['sg_price'] || !$post['sg_members_num'] || !$post['start_time'] || !$post['end_time']) {
            Tiperror("商品、拼团商品数量、拼团价格、拼团人数、开始时间、结束时间都缺一不可！");
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
