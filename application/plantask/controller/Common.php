<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\plantask\controller;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;

class Common extends Controller {

    public function _initialize() {
        
    }

    /**
     * 延时处理
     * @param type $time 延时间隔时间(s)
     * @param type $responsetime 响应时间(s)
     * $type 延时类型
     */
    public function TimeDelay($time = 1, $responsetime = 60, $type = 1) {
        if (ob_get_level() > 0) {
            ob_end_flush(); //关闭缓存
        }
        echo str_repeat(" ", 256); //ie下 需要先发送256个字节
//        set_time_limit($responsetime);
        flush();
        if ($type == 1) {
            sleep($time); //单位为秒
        } else {
            usleep($time); //重新开始 ,微妙为单位， usleep()单位是微秒，1秒 = 1000毫秒 ，1毫秒 = 1000微秒，即1微秒等于百万分之一秒
        }
    }

}
