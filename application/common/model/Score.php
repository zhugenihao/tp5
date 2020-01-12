<?php

/**
 * 商品评分信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Score extends Commons {

    protected $pk = 'id';
    protected $name = "score";

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->where($where)->find();
    }

    public static function getValue($where = [], $value = '') {
        return self::where($where)->value($value);
    }

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public static function scoreSubmitmd($mId) {
        $ret = false;
        $post = input('post.');
        $works_id = !empty($post['works_id']) ? (int) $post['works_id'] : Tiperror("获取不到作品");
        $score = !empty($post['score']) ? (int) $post['score'] : Tiperror("获取不到星星");
        $info = self::getInfo(['m_id' => $mId, 'works_id' => $works_id], 'id');
        if ($info) {
            $res = self::updates(['m_id' => $mId, 'works_id' => $works_id], ['score' => $score]);
            $ret = !empty($res) ? true : false;
        } else {
            $res = self::add(['m_id' => $mId, 'works_id' => $works_id, 'score' => $score, 'create_time' => time()]);
            $ret = !empty($res) ? true : false;
        }
        return $ret;
    }

}
