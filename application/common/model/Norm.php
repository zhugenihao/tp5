<?php

/**
 * 商品规格信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Norm extends Commons {

    protected $pk = 'n_id';
    protected $name = "norm";

    public static function getNormList($where = [], $limit = 10) {
        $search = trim(input('search'));
        $dirId = trim(input('dir_id'));
        if (!empty($search)) {
            $where['c.cate_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($dirId)) {
            $where['c.dir_id'] = $dirId;
        }
        $map['query'] = [
            'search' => $search,
        ];
        $join = [
            ["mz_cates c", 'c.cate_id=n.cate_id', 'LEFT'],
            ["mz_goods_color gc", 'gc.id=n.goodscolor_id', 'LEFT']
        ];
        $list['count'] = self::alias('n')->join($join)->where($where)->count();
        $list['list'] = self::alias('n')->join($join)
                        ->field("n.*,c.cate_name,gc.color_name")->where($where)->order(['n.sort' => 'asc', 'n.n_id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'n_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $where['is_show'] = 1;
        $list = self::field($field)->where($where)->find();
        return $list;
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function normAdd($goods_id, $goodscolor_id, $key) {
        $post = input('post.');
        $count = self::where(['goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id])->count();
        if ($count) {
            return false;
        }
        $data = [
            'goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id, 'create_time' => time(),
        ];
        if ($data) {
            $result = self::create($data);
            if ($result) {
                return array('norm_id' => $result->n_id, 'goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function normEdit($goods_id, $goodscolor_id, $key = 0) {
        $post = input('post.');
        $orgprice = $post['orgprice'][$key];
        $zhong = $post['zhong'][$key];
        $sort = $post['sort'][$key];
        $count = self::where(['goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id])->count();
        if ($count) {
            return false;
        }
        $data = [
            'goods_id' => $goods_id, 'orgprice' => $orgprice,
            'zhong' => $zhong, 'goodscolor_id' => $goodscolor_id,
            'is_show' => 1, 'sort' => $sort, 'create_time' => time(),
        ];
        if ($data) {
            $result = self::where(['n_id' => $post['n_id']])->update($data);
            if ($result) {
                return array('norm_id' => $result['n_id'], 'goods_id' => $goods_id, 'goodscolor_id' => $goodscolor_id);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
