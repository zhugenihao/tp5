<?php

/**
 * 商品评论信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Comments extends Commons {

    protected $pk = 'id';
    protected $name = "comments";

    public function getCommentslist($limit, $where = []) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        if (!empty($search)) {
            $where['c.texts|m.member_name|g.goods_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['c.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['c.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['c.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $pre = config('DB_PREFIX');
        $join = [
            ["{$pre}member m", 'm.id=c.m_id', 'LEFT'],
            ["{$pre}goods g", 'g.goods_id=c.goods_id', 'LEFT']
        ];
        $list = $this->alias('c')->join($join)
                        ->field("c.*,m.member_name,m.photo,m.avatarUrl,m.id as m_id,g.goods_name,g.thecover")->where($where)->order('create_time', 'desc')->paginate($limit, false, $map);
        return $list;
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

}
