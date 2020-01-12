<?php

/**
 * 社区信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class CommunityInformation extends Commons {

    protected $pk = 'id';
    protected $name = "community_information";

    public static function getCommunityInformationlist($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $where = [];
        if (!empty($search)) {
            $where['c.content|m.member_name'] = array('like', "%" . $search . "%");
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
        $count = self::alias('c')
                        ->join("mz_member m", 'm.id=c.m_id', 'LEFT')->where($where)->order('c.create_time', 'desc')->select();
        $list['count'] = count($count);
        $list['list'] = self::alias('c')
                        ->join("mz_member m", 'm.id=c.m_id', 'LEFT')
                        ->field("c.*,m.member_name,m.photo,m.id as m_id,avatarUrl")->where($where)->order('c.create_time', 'desc')->paginate($limit, false, $map);
        foreach ($list['list'] as $key => $val) {
            $list['list'][$key]['allpraise'] = db::name("topic_point_praise")->where('cyf_id', '=', $val['id'])->count();
        }
        return $list;
    }

    public static function getCommunityInformationInfo($id) {
        $info = self::alias('c')
                        ->join("mz_member m", 'm.id=c.m_id', 'LEFT')
                        ->join("mz_topic_point_praise t", 't.cyf_id=c.id', 'LEFT')
                        ->field("c.*,m.member_name,m.photo,m.id as m_id,count(t.id) as allpraise")->where('c.id', $id)->find();
        return $info;
    }

    public static function singletopic_point_praise_list($cyf_id) {
        $list = db::name('singletopic_point_praise as s')
                        ->join("mz_member m", 'm.id=s.m_id', 'LEFT')
                        ->field("s.*,m.member_name,m.id as m_id")->where('cyf_id', '=', $cyf_id)->limit(20)->select();
        foreach ($list as $key => $val) {
            $list[$key]['create_time'] = date("Y-m-d", $val['create_time']);
        }
        return $list;
    }

}
