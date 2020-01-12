<?php

/**
 * 社区信息
 */

namespace app\mobile\controller;

use app\mobile\controller\Common;
use \think\Db;

class Community extends Common {

    public function index() {
        return $this->fetch();
    }

    public function comrelease() {
        return $this->fetch();
    }

    public function btn() {
        $file = $_FILES['files']; //得到传输的数据
        print_r($file);
    }

    public function singletopicpointpraise() {
        return $this->fetch();
    }

    public function topicreviewsubmit() {
        return $this->fetch();
    }

}
