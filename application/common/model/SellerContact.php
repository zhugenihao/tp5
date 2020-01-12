<?php

/**
 * 商家联系方式信息
 */

namespace app\common\model;

use \think\Exception;
use app\common\model\Commons;

class SellerContact extends Commons {

    protected $pk = 'id';
    protected $name = "seller_contact";

    public static function add($data) {
        return self::create($data);
    }

    public static function addMd($mId) {
        $post = input('post.');
        $data = [
            'member_id' => $mId, 'contact_name' => $post['contact_name'], 'contact_mobile' => $post['contact_mobile'],
            'contact_email' => $post['contact_email'], 'application_type' => $post['application_type'],
            'create_time' => time(),
        ];
        $res = self::create($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public static function updatesMd($where = []) {
        $post = input('post.');
        $data = [
            'contact_name' => $post['contact_name'], 'contact_mobile' => $post['contact_mobile'],
            'contact_email' => $post['contact_email'], 'application_type' => $post['application_type'],
            'create_time' => time(),
        ];
        $res = self::where($where)->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public static function getInfo($where = [], $field = '*') {
        $res = self::field($field)->where($where)->find();
        return $res;
    }

    public static function getValue($where = [], $value = 'id') {
        $res = self::where($where)->value($value);
        return $res;
    }

    public static function getList($where = [], $field = '*') {
        $res = self::field($field)->where($where)->order("id", 'desc')->select();
        return $res;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
