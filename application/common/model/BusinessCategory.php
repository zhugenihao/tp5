<?php

/**
 * 经营类目信息
 */

namespace app\common\model;

use \think\Exception;
use app\common\model\Commons;
use app\common\model\Directory as directoryModel;

class BusinessCategory extends Commons {

    protected $pk = 'id';
    protected $name = "business_category";

    public static function add($data) {
        return self::create($data);
    }

    public static function addMd($mId) {
        $post = input('post.');
        $directory1 = directoryModel::getInfo(['id' => $post['directory1_id']]);
        $directory2 = directoryModel::getInfo(['id' => $post['directory2_id']]);
        $directory3 = directoryModel::getInfo(['id' => $post['directory3_id']]);
        $data = [
            'member_id' => $mId, 'directory1_name' => $directory1['title'], 'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'], 'directory1_id' => $directory1['id'], 'directory2_id' => $directory2['id'],
            'directory3_id' => $directory3['id'], 'add_time' => time(),
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
        $directory1 = directoryModel::getInfo(['id' => $post['directory1_id']]);
        $directory2 = directoryModel::getInfo(['id' => $post['directory2_id']]);
        $directory3 = directoryModel::getInfo(['id' => $post['directory3_id']]);
        $data = [
            'directory1_name' => $directory1['title'], 'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'], 'directory1_id' => $directory1['id'], 'directory2_id' => $directory2['id'],
            'directory3_id' => $directory3['id'], 'add_time' => time(),
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

    public static function getList($where = [], $field = '*', $start = 0, $limit = 50) {
        $res = self::field($field)->where($where)->order("id", 'desc')->limit($start, $limit)->select()->toArray();
        return $res;
    }

    public static function getListGroup($where = [], $group = 'id', $field = '*', $start = 0, $limit = 50) {
        $res = self::field($field)->where($where)->order("id", 'desc')->group($group)->limit($start, $limit)->select();
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
