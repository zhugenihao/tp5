<?php

/**
 * 商家信息
 */

namespace app\index\model;

use app\common\model\Seller as sellerModel;
use app\common\model\SellerGroup as sellerGroupModel;
use \think\Db;

class Seller extends sellerModel {

    public static function getSellerList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $seller_delete = trim(input('seller_delete'));
        if (!empty($search)) {
            $where['seller_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($seller_delete)) {
            $where['seller_delete'] = $seller_delete;
        }

        $map['query'] = [
            'search' => $search,
            'seller_delete' => $seller_delete,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function sellerAddMd($seller_id = 0) {
        $post = input('post.');
        $count = self::where(['seller_name' => $post['seller_name']])->count();
        if ($count) {
            Tiperror("账号名称已存在！");
        }
        $password = passwordEncryption($post['seller_password']);
        $sellerGroup = sellerGroupModel::getInfo(['id' => $post['group_id']]);
        $data = ['seller_name' => $post['seller_name'], 'seller_password' => $password['password'],
            'salt' => $password['salt'], 'group_id' => $post['group_id'], 'seller_delete' => $post['seller_delete'],
            'parent_id' => $seller_id, 'group_name' => $sellerGroup['group_name'], 'seller_state' => 2,
            'checkin_time' => time()];
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

    public static function sellerEditMd() {
        $post = input('post.');
        $seller = self::where(['id' => $post['seller_id']])->find();
        $sellerGroup = sellerGroupModel::getInfo(['id' => $post['group_id']]);
        $data = ['seller_delete' => $post['seller_delete'], 'group_name' => $sellerGroup['group_name'],
            'group_id' => $post['group_id'], 'checkin_time' => time()];
        if (!empty($post['seller_password'])) {
            $password = passwordEncryption($post['seller_password']);
            $data['seller_password'] = $password['password'];
            $data['salt'] = $password['salt'];
        }
        if ($seller['seller_name'] != $post['seller_name']) {
            $count = self::where(['seller_name' => $post['seller_name']])->count();
            if ($count) {
                Tiperror("账号名称已存在！");
            }
            $data['seller_name'] = $post['seller_name'];
        }
        if ($data) {
            $res = self::where(['id' => $post['seller_id']])->update($data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function sellerSettingsMd($seller_id = 0) {
        $data = [];
        $post = input('post.');
        $seller = self::where(['id' => $seller_id])->find();
        if ($seller['seller_name'] != $post['seller_name']) {
            $count = self::where(['seller_name' => $post['seller_name']])->count();
            if ($count) {
                Tiperror("账号名称已存在！");
            }
            $data['seller_name'] = $post['seller_name'];
        }
        if (!empty($post['new_password'])) {
            if (empty($post['seller_password'])) {
                Tiperror("请输入原登录密码！");
            }
            $passwords = md5(md5($seller['salt']) . md5($post['seller_password']));
            $passwordCount = self::where(['id' => $seller_id, 'seller_password' => $passwords])->count();
            if (!$passwordCount) {
                Tiperror("原登录密码错误！");
            }
            if (empty($post['queren_password'])) {
                Tiperror("请输入确认新密码！");
            }
            if ($post['queren_password'] != $post['new_password']) {
                Tiperror("确认新密码不一致！");
            }
            $password = passwordEncryption($post['new_password']);
            $data['seller_password'] = $password['password'];
            $data['salt'] = $password['salt'];
        }

        if ($data) {
            $res = self::where(['id' => $seller_id])->update($data);
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
