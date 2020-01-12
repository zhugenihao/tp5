<?php

/**
 * 商家地址信息
 */

namespace app\admin\model;

use app\common\model\SellerAddress as sellerAddressModel;
use \think\Db;

class SellerAddress extends sellerAddressModel {

    public static function sellerAddressAddMd($store_id = 0) {
        $post = input('post.');
        $data = ['province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'county_id' => $post['county_id'],
            'detailed_address' => $post['detailed_address'], 'contact_name' => $post['contact_name'], 'store_id' => $store_id,
            'mobile' => $post['mobile'], 'zip_code' => $post['zip_code'], 'address_type' => $post['address_type'],
            'is_default' => $post['is_default'], 'create_time' => time()];
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

    public static function sellerAddressEditMd() {
        $post = input('post.');
        $data = ['province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'county_id' => $post['county_id'],
            'detailed_address' => $post['detailed_address'], 'contact_name' => $post['contact_name'],
            'mobile' => $post['mobile'], 'zip_code' => $post['zip_code'], 'address_type' => $post['address_type'],
            'is_default' => $post['is_default'], 'create_time' => time()];
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
