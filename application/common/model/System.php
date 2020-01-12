<?php
/**
 * 系统配置信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class System extends Commons {

    protected $pk = 'id';
    protected $name = "system_base";
    
    public static function systemBaseValue($value=''){
        $info = self::where("id","1")->value($value);
        return $info;
    }
}
