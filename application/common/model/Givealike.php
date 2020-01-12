<?php

/**
 * 商品点赞信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Givealike extends Commons {

    protected $pk = 'id';
    protected $name = "givealike";

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['givealike'] = 1;
        $order = ['gl.id' => 'desc'];
        $join = [['mz_goods g', 'g.goods_id=gl.goods_id', 'left']];
        $list['count'] = self::alias('gl')->join($join)->where($where)->count();
        $list['list'] = self::alias('gl')->field($field)->join($join)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function getInfo($where) {
        return self::where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        $where['givealike'] = 1;
        return self::where($where)->count();
    }

    public static function updates($where = [], $date = []) {
        return self::where($where)->update($date);
    }

    public static function submitGivealikeMd($where = [], $data = []) {
        $info = self::getInfo($where);
        if ($info) {
            $givealike = $info['givealike'] == 1 ? 2 : 1;
            $res = self::updates($where, ['givealike' => $givealike]);
        } else {
            $res = self::create($data);
        }
        return $res;
    }

}
