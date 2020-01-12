<?php

/**
 * 供货商信息
 */

namespace app\admin\model;

use app\common\model\Supplier as supplierModel;
use \think\Db;

class Supplier extends supplierModel {

    public static function supplierAddMd($store_id = 0) {
        $post = input('post.');
        $data = ['supplier_name' => $post['supplier_name'], 'contact_name' => $post['contact_name'],
            'contact_phone' => $post['contact_phone'], 'note' => $post['note'], 'store_id' => $store_id,
            'create_time' => time()];
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

    public static function supplierEditMd() {
        $post = input('post.');
        $data = ['supplier_name' => $post['supplier_name'], 'contact_name' => $post['contact_name'],
            'contact_phone' => $post['contact_phone'], 'note' => $post['note'],
            'create_time' => time()];
        if ($data) {
            $res = self::where(['id' => $post['supplier_id']])->update($data);
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
