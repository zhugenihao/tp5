<?php

/**
 * 店铺信息
 */

namespace app\common\model;

use \think\Exception;
use app\common\model\Commons;
use app\common\model\Member as memberModel;

class Store extends Commons {

    protected $pk = 'id';
    protected $name = "store";

    public static function add($data) {
        return self::create($data);
    }

    public static function addMd($mId) {
        $post = input('post.');
        $member_name = memberModel::getValue($mId, 'member_name');
        $data = [
            'member_id' => $mId,'member_name'=>$member_name, 'store_name' => $post['store_name'], 'directory_big_id' => $post['directory_big_id'],
            'store_nature' => $post['store_nature'], 'head_name' => $post['head_name'], 'head_mobile' => $post['head_mobile'],
            'head_qq' => $post['head_qq'], 'email' => $post['email'], 'store_address' => $post['store_address'],
            'bank_name' => $post['bank_name'], 'bank_account' => $post['bank_account'], 'bank_branch_name' => $post['bank_branch_name'],
            'province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'main_channel' => $post['main_channel'],
            'sales' => $post['sales'], 'experience' => $post['experience'], 'sales_quantity' => $post['sales_quantity'],
            'average_price' => $post['average_price'], 'warehouse' => $post['warehouse'], 'there_is_store' => $post['there_is_store'],
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
            'store_name' => $post['store_name'], 'directory_big_id' => $post['directory_big_id'],
            'store_nature' => $post['store_nature'], 'head_name' => $post['head_name'], 'head_mobile' => $post['head_mobile'],
            'head_qq' => $post['head_qq'], 'email' => $post['email'], 'store_address' => $post['store_address'],
            'bank_name' => $post['bank_name'], 'bank_account' => $post['bank_account'], 'bank_branch_name' => $post['bank_branch_name'],
            'province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'main_channel' => $post['main_channel'],
            'sales' => $post['sales'], 'experience' => $post['experience'], 'sales_quantity' => $post['sales_quantity'],
            'average_price' => $post['average_price'], 'warehouse' => $post['warehouse'], 'there_is_store' => $post['there_is_store'],
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
