<?php

/**
 * 客服信息
 */

namespace app\index\model;

use app\common\model\Kefu as kefuModel;
use \think\Db;

class Kefu extends kefuModel {

    public static function kefuAddMd($store_id = 0) {
        $post = input('post.');
        if (kefuModel::getCount(['kefu_account' => $post['kefu_account']])) {
            Tiperror("账号已存在！");
        }
        $data = ['kefu_name' => $post['kefu_name'], 'kefu_account' => $post['kefu_account'],
            'tel' => $post['tel'], 'kefu_tool' => $post['kefu_tool'], 'store_id' => $store_id,
            'kefu_type' => $post['kefu_type'], 'kefu_password' => md5($post['kefu_password']), 'create_time' => time()];
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

    public static function kefuEditMd() {
        $post = input('post.');
        $kefu = self::get($post['kefu_id']);
        if ($kefu['kefu_account'] != $post['kefu_account'] && kefuModel::getCount(['kefu_account' => $post['kefu_account']])) {
            Tiperror("账号已存在！");
        }
        $data = ['kefu_name' => $post['kefu_name'], 'kefu_account' => $post['kefu_account'],
            'tel' => $post['tel'], 'kefu_tool' => $post['kefu_tool'],
            'kefu_type' => $post['kefu_type'], 'create_time' => time()];
        if (!empty($post['kefu_password'])) {
            $data['kefu_password'] = md5($post['kefu_password']);
        }
        if ($data) {
            $res = self::where(['id' => $post['kefu_id']])->update($data);
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
