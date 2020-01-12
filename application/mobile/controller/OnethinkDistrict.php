<?php
/**
 * 区域信息
 */
namespace app\mobile\controller;

use \think\Db;
use app\mobile\controller\Common;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;

class OnethinkDistrict extends Common {

    //获取区域信息
    public function otDisList() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $otDisList = onethinkDistrictModel::getList(['upid' => $get['upid']]);
            exit(json_encode($otDisList));
        }
    }
    

}
