<?php

/**
 * 通知记录信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SystemInforms extends Commons {

    protected $pk = 'id';
    protected $name = "system_informs";

    public static function getList($where, $start = 0, $limit = 10) {
        $where['s.is_show'] = 1;
        $time = "DATE_FORMAT(FROM_UNIXTIME(s.create_time),'%Y-%m-%d') as s_create_time";
        if ($where['s.type'] == 1) {//作品类通知
            $field = "s.si_title,s.si_url,$time,w.cartoon_name,w.id as works_id,w.cross_img";
            $join[] = ['dm_works w', 'w.id = s.type_id', 'left'];
        }
        if ($where['s.type'] == 3) {//阅读券类通知
            $field = "s.si_title,$time,m.id as m_id,r.id as rn_id,r.imgurl,r.period_of_validity";
            $join[] = ['dm_reading_notes r', 'r.id = s.type_id', 'left'];
            $join[] = ['dm_member m', 'm.id = r.m_id', 'left'];
        }
        $join[] = ['dm_user u', 'u.id = s.user_id', 'left'];
        $count = self::alias('s')->join($join)->where($where)->count();
        $list = self::alias('s')->join($join)->field($field)
                        ->where($where)->order('s.create_time', 'desc')->limit($start, $limit)->select();
        $countType = $count < $limit ? 1 : 0;
        return array('list' => $list, 'counttype' => $countType, 'sfcount' => $count);
    }

    public static function getValue($id, $value = 'id') {
        $res = self::where('id', '=', $id)->value($value);
        return $res;
    }

}
