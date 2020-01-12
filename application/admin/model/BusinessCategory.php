<?php

/**
 * 经营类目信息
 */

namespace app\admin\model;

use \think\Exception;
use app\admin\model\Commons;
use app\common\model\Directory as directoryModel;
use app\admin\model\Store as storeModel;

class BusinessCategory extends Commons {

    protected $pk = 'id';
    protected $name = "business_category";

    public static function getBcategoryList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $audit = trim(input('audit'));
        if (!empty($search)) {
            $where['directory1_name|directory2_name|directory3_name|s.store_name|m.member_name'] = array('like', "%" . $search . "%");
        }
        if ($audit) {
            $where['b.audit'] = $audit;
        }
        $map['query'] = [
            'search' => $search,
            'audit' => $audit,
        ];
        $join = [
            ["mz_store s", 's.id=b.store_id', 'LEFT'],
            ["mz_member m", 'm.id=b.member_id', 'LEFT'],
        ];
        $list = self::alias('b')->join($join)->field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

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

    public static function addBcategoryMd() {
        $post = input('post.');
        $directory1 = directoryModel::getInfo(['id' => $post['directory1_id']]);
        $directory2 = directoryModel::getInfo(['id' => $post['directory2_id']]);
        $directory3 = directoryModel::getInfo(['id' => $post['directory3_id']]);
        $member_id = storeModel::getValue(['id' => $post['store_id']], 'member_id');
        if ($post['directory3_id'] < 1) {
            Tiperror("类目不能为空！");
        }
        if ($post['store_id'] < 1) {
            Tiperror("店铺不能为空！");
        }
        $count = self::getCount(['store_id' => $post['store_id'], 'directory3_id' => $post['directory3_id']]);
        if ($count) {
            Tiperror("该类目已存在！");
        }
        $data = [
            'member_id' => $member_id, 'directory1_name' => $directory1['title'], 'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'], 'directory1_id' => $directory1['id'], 'directory2_id' => $directory2['id'],
            'directory3_id' => $directory3['id'], 'store_id' => $post['store_id'], 'audit' => $post['audit'],
            'commission_rate' => $post['commission_rate'], 'add_time' => time(),
        ];
        $res = self::create($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public static function editBcategoryMd() {
        $post = input('post.');
        $directory1 = directoryModel::getInfo(['id' => $post['directory1_id']]);
        $directory2 = directoryModel::getInfo(['id' => $post['directory2_id']]);
        $directory3 = directoryModel::getInfo(['id' => $post['directory3_id']]);
        if ($post['directory3_id'] < 1) {
            Tiperror("类目不能为空！");
        }
        $info = self::getInfo(['store_id' => $post['store_id'], 'directory3_id' => $post['directory3_id']]);
        if ($info['id'] && $post['id'] != $info['id']) {
            Tiperror("该类目已存在！");
        }
        $data = [
            'id' => $post['id'],
            'directory1_name' => $directory1['title'], 'directory2_name' => $directory2['title'],
            'directory3_name' => $directory3['title'], 'directory1_id' => $directory1['id'], 'directory2_id' => $directory2['id'],
            'directory3_id' => $directory3['id'], 'audit' => $post['audit'],
            'commission_rate' => $post['commission_rate'], 'add_time' => time(),
        ];
        $res = self::update($data);
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
