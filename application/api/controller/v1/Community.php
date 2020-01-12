<?php

/**
 * 社区信息
 */

namespace app\api\controller\v1;

use app\api\controller\v1\Common;
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
