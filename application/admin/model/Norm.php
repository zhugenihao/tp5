<?php

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\admin\model\Inventory as InventoryModel;
use app\admin\model\Goods as goodsModel;

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
            ["mz_goods_color gc", 'gc.id=n.goodscolor_id', 'LEFT']
        ];
        $list['count'] = self::alias('n')->join($join)->where($where)->count();
        $list['list'] = self::alias('n')->join($join)
                        ->field("n.*,gc.color_name")->where($where)->order(['n.sort' => 'asc', 'n.n_id' => 'desc'])->paginate($limit, false, $map);

        return $list;
    }

    
    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }
    public static function getList($where = [], $field = '*') {
        return self::field($field)->where($where)->select();
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

}
