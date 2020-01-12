<?php

/**
 * 店铺信息
 */

namespace app\admin\model;

use \think\Exception;
use app\admin\model\Commons;
use app\admin\model\Member as memberModel;
use app\admin\model\Users as usersModel;
use app\admin\model\BusinessCategory as businessCategoryModel;
use app\admin\model\Directory as directoryModel;

class Store extends Commons {

    protected $pk = 'id';
    protected $name = "store";

    public static function add($data) {
        return self::create($data);
    }

    public static function addMd($userId) {
        $post = input('post.');
        $data = [
            'user_id' => $userId, 'store_name' => $post['store_name'], 'directory_big_id' => $post['directory_big_id'],
            'store_nature' => $post['store_nature'], 'head_name' => $post['head_name'], 'head_mobile' => $post['head_mobile'],
            'head_qq' => $post['head_qq'], 'email' => $post['email'], 'store_address' => $post['store_address'],
            'bank_name' => $post['bank_name'], 'bank_account' => $post['bank_account'], 'bank_branch_name' => $post['bank_branch_name'],
            'province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'main_channel' => $post['main_channel'],
            'sales' => $post['sales'], 'experience' => $post['experience'], 'sales_quantity' => $post['sales_quantity'],
            'average_price' => $post['average_price'], 'warehouse' => $post['warehouse'], 'there_is_store' => $post['there_is_store'],
            'create_time' => time(),
        ];
        $res = self::create($data);
        $bcategoryData = array();
        foreach ($post['directory1_id'] as $key => $directory1_id) {
            $directory2_id = $post['directory2_id'][$key];
            $directory3_id = $post['directory3_id'][$key];
            $directory1 = directoryModel::getInfo($directory1_id);
            $directory2 = directoryModel::getInfo($directory2_id);
            $directory3 = directoryModel::getInfo($directory3_id);
            $bcategoryData[] = [
                'store_id' => $res->id, 'directory1_name' => $directory1['title'], 'directory2_name' => $directory2['title'],
                'directory3_name' => $directory3['title'], 'directory1_id' => $directory1['id'], 'directory2_id' => $directory2['id'],
                'directory3_id' => $directory3['id'], 'user_id' => $userId, 'add_time' => time(),
            ];
        }
        if ($res) {
            $businessCategoryModel = new businessCategoryModel();
            $businessCategoryModel->saveAll($bcategoryData);
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

    public static function getList($limit = 10, $where = [], $field = '*') {
        $map['query'] = [
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order("id", 'desc')->paginate($limit, false, $map);
        return $list;
    }

    public static function getStoreList($where = [], $field = '*', $start = 0, $limit = 10) {
        $list = self::field($field)->where($where)->order("id", 'desc')->limit($start, $limit)->select();
        return $list;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
