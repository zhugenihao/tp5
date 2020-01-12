<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('PUBLIC_TPL', __DIR__ . '/../public/template/');

// 开启调试模式
define('APP_DEBUG', true);
define('SITE_URL', 'http://mallz.cn/');

//电脑端url
define('PC_URL', 'http://mallz.cn/');
//手机端url
define('MODEL_URL', 'http://mallz.cn/mobile/');

require __DIR__ . '/../public/constant.php';

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

// 自动生成admin模块
//\think\Build::module('admin');