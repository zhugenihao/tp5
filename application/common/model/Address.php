<?php
/**
 * 用户收货地址信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;

class Address extends Commons {

    protected $pk = 'ads_id';
    protected $name = "address";

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }
    public static function add($data) {
        return self::create($data);
    }
    public static function getList($where = [], $field = '*', $start = 0, $limit = 10) {
        $where['ads_show'] = 1;
        $order = ['ads_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }
    public static function getAddressInfo($where=[],$field = '*'){
        return self::field($field)->where($where)->find()->toArray();
    }

    public static function getInfo($id) {
        $info = self::where(['ads_id' => $id])->find();
        $info['province_name'] = onethinkDistrictModel::getValue(['id'=>$info['province_id']], 'name');//省级名称
        $info['city_name'] = onethinkDistrictModel::getValue(['id'=>$info['city_id']], 'name');//市级名称
        $info['county_name'] = onethinkDistrictModel::getValue(['id'=>$info['county_id']], 'name');//县级名称
        $info['town_name'] = onethinkDistrictModel::getValue(['id'=>$info['town_id']], 'name');//镇级名称
        return $info;
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
