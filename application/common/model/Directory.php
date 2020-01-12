<?php

/**
 * 导航分类
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Directory extends Commons {

    protected $pk = 'id';
    protected $name = "directory";

    public static function getDirectoryList($where = [], $field = '*', $limit = 20, $start = 0) {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function getInfo($where = []) {
        $where = !empty(is_array($where)) ? $where : ['id' => $where];
        return self::where($where)->find();
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    //获取指定分类的所有子分类ID号
    public static function getChildrenIds($dirId) {
        $ids = '';
        $result = self::where(['pid' => $dirId])->limit(20)->select();
        if ($result) {
            foreach ($result as $key => $val) {
                $ids .= $val['id'] . ',';
                $ids .= self::getChildrenIds($val['id']);
            }
        }
        return $ids;
    }

}
