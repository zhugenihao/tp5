<?php

/**
 * 商品库存信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\admin\model\Goods as goodsModel;
use app\admin\model\Norm as normModel;
use app\admin\model\GoodsColor as goodsColorModel;

class Inventory extends Commons {

    protected $pk = 'id';
    protected $name = "inventory";

    public static function add($data) {
        return self::create($data);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $res = self::field($field)->where($where)->order("id", 'desc')->limit($start, $limit)->select();
        return $res;
    }

    public static function getInventoryList($where = [], $field = '*', $limit = 10) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['in.inty_price'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $join = [
            ['mz_norm no', 'no.n_id=in.n_id', 'left'],
        ];
        $res = self::alias('in')->join($join)->field($field)->where($where)->order("id", 'asc')->paginate($limit, false, $map);
        return $res;
    }

    public static function getInventoryAjaxaList($where = [], $field = '*', $start = 0, $limit = 10) {
        $join = [
            ['mz_norm no', 'no.n_id=in.n_id', 'left'],
            ['mz_cates ct', 'ct.cate_id=in.cate_id', 'left'],
            ['mz_goods_color gc', 'gc.id=no.goodscolor_id', 'left'],
        ];
        $res = self::alias('in')->join($join)->field($field)->where($where)->order("id", 'asc')->limit($start, $limit)->select();
        return $res;
    }

    public static function inventoryAddMd() {
        $post = input('post.');

        $norm = normModel::getInfo(['goods_id' => $post['goods_id'], 'goodscolor_id' => $post['goodscolor_id']]);
        $color_name = goodsColorModel::getValue(['id' => $post['goodscolor_id']], 'color_name');
        $n_id = $norm['n_id'];
        if (!$norm['n_id']) {
            $normRes = normModel::create(['goods_id' => $post['goods_id'], 'goodscolor_id' => $post['goodscolor_id'],
                        'color_name' => $color_name, 'create_time' => time()]);
            $n_id = $normRes->n_id;
        }
        $data = ['n_id' => $n_id, 'cate_id' => $post['cate_id'], 'goods_id' => $post['goods_id'], 'inty_price' => $post['inty_price'],
            'inventory' => $post['inventory'], 'orgprice' => $post['orgprice'], 'type_num' => $post['type_num'],
            'type' => $post['type'], 'sort' => $post['sort'], 'create_time' => time()];

        if ($data) {
            $res = self::create($data);
            if ($res) {
                goodsModel::delRedundantNorm($post['goods_id']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public static function inventoryEditMd() {
        $post = input('post.');
        $norm = normModel::getInfo(['goods_id' => $post['goods_id'], 'goodscolor_id' => $post['goodscolor_id']]);
        $color_name = goodsColorModel::getValue(['id' => $post['goodscolor_id']], 'color_name');
        $n_id = $norm['n_id'];
        if (!$norm['n_id']) {
            $normRes = normModel::create(['goods_id' => $post['goods_id'], 'goodscolor_id' => $post['goodscolor_id'],
                        'color_name' => $color_name, 'create_time' => time()]);
            $n_id = $normRes->n_id;
        }
        $data = ['n_id' => $n_id, 'cate_id' => $post['cate_id'], 'inty_price' => $post['inty_price'],
            'inventory' => $post['inventory'], 'orgprice' => $post['orgprice'], 'type_num' => $post['type_num'],
            'type' => $post['type'], 'sort' => $post['sort'], 'create_time' => time()];

        if ($data) {
            $res = self::updates(['id' => $post['inventory_id']], $data);
            if ($res) {
                goodsModel::delRedundantNorm($post['goods_id']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function getDelete($where = []) {
        return self::where($where)->delete();
    }

}
