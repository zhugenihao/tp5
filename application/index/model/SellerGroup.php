<?php

/**
 * 商家账号组信息
 */

namespace app\index\model;

use app\common\model\SellerGroup as sellerGroupModel;
use \think\Db;

class SellerGroup extends sellerGroupModel {

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['seller_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list = self::field($field)->where($where)->order(['sort'=>'asc','id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function AddMd($store_id = 0) {
        $post = input('post.');
        $menuid_str = json_encode($post['menu_id']);
        $data = ['group_name' => $post['group_name'], 'state' => $post['state'], 'sort' => $post['sort'],
            'store_id' => $store_id, 'menuid_str' => $menuid_str, 'create_time' => time()];
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

    public static function editMd() {
        $post = input('post.');
        $menuid_str = json_encode($post['menu_id']);
        $data = ['group_name' => $post['group_name'], 'state' => $post['state'], 'sort' => $post['sort'],
            'menuid_str' => $menuid_str, 'create_time' => time()];
        if ($data) {
            $res = self::where(['id' => $post['group_id']])->update($data);
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
