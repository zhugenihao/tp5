<?php

/**
 * 公司信息表
 */

namespace app\admin\model;

use \think\Exception;
use app\admin\model\Commons;

class SellerCompany extends Commons {

    protected $pk = 'id';
    protected $name = "seller_company";

    public static function add($data) {
        return self::create($data);
    }

    public static function addMd($mId) {
        $post = input('post.');
        $data = [
            'member_id' => $mId, 'company_name' => $post['company_name'], 'company_nature' => $post['company_nature'],
            'company_url' => $post['company_url'], 'company_url' => $post['company_url'],
            'province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'county_id' => $post['county_id'],
            'detaddress' => $post['detaddress'], 'fixed_telephone' => $post['fixed_telephone'], 'email' => $post['email'],
            'fax' => $post['fax'], 'thezipcode' => $post['thezipcode'], 'registered_capital' => $post['registered_capital'],
            'credit_code' => $post['credit_code'], 'legal_rep_name' => $post['legal_rep_name'], 'a_yard_merchants' => $post['a_yard_merchants'],
            'effective_start_time' => $post['effective_start_time'], 'effective_end_time' => $post['effective_end_time'],
            'scope_business' => $post['scope_business'], 'taxpayers_type' => $post['taxpayers_type'], 'taxtypetaxcode' => $post['taxtypetaxcode'],
            'create_time' => time(),
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
        $data = [
            'company_name' => $post['company_name'], 'company_nature' => $post['company_nature'],
            'company_url' => $post['company_url'], 'company_url' => $post['company_url'],
            'province_id' => $post['province_id'], 'city_id' => $post['city_id'], 'county_id' => $post['county_id'],
            'detaddress' => $post['detaddress'], 'fixed_telephone' => $post['fixed_telephone'], 'email' => $post['email'],
            'fax' => $post['fax'], 'thezipcode' => $post['thezipcode'], 'registered_capital' => $post['registered_capital'],
            'credit_code' => $post['credit_code'], 'legal_rep_name' => $post['legal_rep_name'], 'a_yard_merchants' => $post['a_yard_merchants'],
            'effective_start_time' => $post['effective_start_time'], 'effective_end_time' => $post['effective_end_time'],
            'scope_business' => $post['scope_business'], 'taxpayers_type' => $post['taxpayers_type'], 'taxtypetaxcode' => $post['taxtypetaxcode'],
            'create_time' => time(),
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
