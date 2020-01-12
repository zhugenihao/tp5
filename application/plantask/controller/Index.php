<?php

namespace app\plantask\controller;

use app\plantask\controller\Common;
use \think\Db;

class Index extends Common {

    public function index() {
        for ($i = 0; $i < 20; $i++) {
            $this->TimeDelay(1);
            echo $i.",";
        }
        return $this->fetch();
    }

}
