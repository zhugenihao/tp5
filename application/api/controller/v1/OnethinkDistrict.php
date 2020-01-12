<?php
/**
 * 区域信息
 */
namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
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
