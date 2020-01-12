<?php

/**
 * 类目信息
 */

namespace app\index\model;

use app\common\model\BusinessCategory as businessCategoryModel;
use \think\Db;
use app\common\model\Directory as directoryModel;

class BusinessCategory extends businessCategoryModel {

    public static function getBcategoryList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $audit = trim(input('audit'));
        if (!empty($search)) {
            $where['directory1_name|directory2_name|directory3_name'] = array('like', "%" . $search . "%");
        }
        if ($audit) {
            $where['audit'] = $audit;
        }
        $map['query'] = [
            'search' => $search,
            'audit' => $audit,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function bcategoryAddMd($store_id = 0) {
        $post = input('post.');
        if (self::getValue(['directory3_id' => $post['directory3_id'], 'store_id' => $store_id], 'id')) {
            Tiperror("该类目已经添加过！");
        }
        $count = businessCategoryModel::getCount(['store_id' => $store_id]);
        if ($count >= 50) {
            Tiperror('只能添加50个类目！');
        }
        $directory1_name = directoryModel::getValue(['id' => $post['directory1_id']], 'title');
        $directory2_name = directoryModel::getValue(['id' => $post['directory2_id']], 'title');
        $directory3_name = directoryModel::getValue(['id' => $post['directory3_id']], 'title');
        $data = ['directory1_id' => $post['directory1_id'], 'directory2_id' => $post['directory2_id'], 'directory3_id' => $post['directory3_id'],
            'directory1_name' => $directory1_name, 'directory2_name' => $directory2_name, 'directory3_name' => $directory3_name,
            'store_id' => $store_id, 'audit' => 1, 'add_time' => time()];
        if ($data) {
            $res = self::create($data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
