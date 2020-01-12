<?php

/**
 * 商品版本信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class AdvertType extends Commons {

    protected $pk = 'id';
    protected $name = "advert_type";

    public static function getAdvertTypeList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['adt_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $order = ['id' => 'desc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }
    public static function getAdvertTypeLister($where = [], $limit = 10, $field = '*') {
        $order = ['id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    public static function advertTypeAdd() {
        $post = input('post.');
        $count = self::where('adt_mark', '=', $post['adt_mark'])->count();
        if ($count) {
            Tiperror("广告标志已存在！");
        }
        $data = ['adt_name' => $post['adt_name'], 'adt_mark' => $post['adt_mark'], 'create_time' => time(),];
        if ($data) {
            $result = self::create($data);
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function advertTypeEdit() {
        $post = input('post.');
        $count = self::where('adt_mark', '=', $post['adt_mark'])->count();
        $info = self::get($post['id']);
        if ($count && $info['adt_mark'] != $post['adt_mark']) {
            Tiperror("广告标志已存在！");
        }
        $data = ['adt_name' => $post['adt_name'], 'adt_mark' => $post['adt_mark'],'create_time' => time(),];
        if ($data) {
            $result = self::where(['id' => $post['id']])->update($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
