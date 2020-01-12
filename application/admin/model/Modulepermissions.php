<?php

namespace app\admin\model;
use app\admin\model\Commons;
use \think\Db;
class Modulepermissions extends Commons {

    protected $pk = 'id';
    protected $name = "module_permissions";

    public static function getList() {
        return self::select();
    }
    public static function getInfo($where=[]) {
        return self::where($where)->find();
    }
    public static function getValue($where=[],$value='*') {
        return self::where($where)->value($value);
    }


}
