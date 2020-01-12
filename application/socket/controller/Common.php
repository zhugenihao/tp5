<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\socket\controller;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;

class Common extends Controller {

    protected $mid = '';
    protected $member_mobile = '';

    public function _initialize() {
        $this->mid = session('member_id');
        $this->member_mobile = session('member_mobile');
    }

}
