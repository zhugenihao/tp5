<?php

/**
 * 留言信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Leaveamessage extends Commons {

    protected $pk = 'id';
    protected $name = "leave_a_message";

    public static function getList($limit = 10) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $where = [];
        if (!empty($search)) {
            $where['your_name|email'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $where['create_time'] = ['>= time', $datemin];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field("*")->where($where)->order('id', 'desc')->paginate($limit, false, $map);

        return $list;
    }

    public static function editmd($id) {
        $info = self::field("*")->where(['id' => $id])->find();
        return $info;
    }

}
