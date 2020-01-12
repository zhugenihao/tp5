<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Directory as directoryModel;

class Directory extends Common {

    public function index() {
        return $this->fetch();
    }

    public function getDirectory() {
        $pid = input('pid');
        $pid = !empty($pid) ? $pid : 0;
        $dirfield = 'id,title,home_template_p,small_icon';
        $dirWhere = ['type' => 3, 'pid' => $pid, 'id' => ['not in', '61,62,1']];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 50);
        exit($directoryList);
    }

}
