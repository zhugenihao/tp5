<?php

/**
 * 客服信息
 */

namespace app\admin\model;

use app\common\model\SellerNotice as sellerNoticeModel;
use \think\Db;

class SellerNotice extends sellerNoticeModel {

    public static function addMd($user_id = 0) {
        $post = input('post.');
        $data = ['content' => $post['content'], 'store_id' => $post['store_id'], 'is_show' => $post['is_show'],
            'user_id' => $user_id, 'store_name' => $post['store_name'], 'create_time' => time()];
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
        $data = ['content' => $post['content'], 'store_id' => $post['store_id'],
            'store_name' => $post['store_name'], 'is_show' => $post['is_show'], 'create_time' => time()];
        if ($data) {
            $res = self::where(['id' => $post['id']])->update($data);
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
