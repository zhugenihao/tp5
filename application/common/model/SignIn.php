<?php

/**
 * 用户出入账信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class SignIn extends Commons {

    protected $pk = 'id';
    protected $name = "sign_in";

    public static function add($data) {
        return self::create($data);
    }

    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $order = ['create_time' => 'desc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        return $list;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function getSum($where = [], $value = "gold_coins") {
        return self::where($where)->sum($value);
    }

    public static function getInfo($where = [], $field = '*',$order=[]) {
        return self::field($field)->where($where)->order($order)->find();
    }

    /**
     * 获取连续签到的天数
     * @param type $where
     */
    public static function continuousDay($where = []) {
        $dayNum = 1;
        $oneday = isset($where['signin_time']) ? $where['signin_time'] : date("Y-m-d");
        $oneday = strtotime($oneday) - 86400; //上一天
        $twoday = self::where(['member_id' => $where['member_id'], 'signin_time' => date("Y-m-d", $oneday)])->value('signin_time');

        if ($twoday) {
            $dayNum = self::continuousDay(['member_id' => $where['member_id'], 'signin_time' => $twoday]);
            //最多连续签到7天
            if ($dayNum >= 7) {
                return $dayNum;
            }
            ++$dayNum;
        }

        return $dayNum;
    }

}
