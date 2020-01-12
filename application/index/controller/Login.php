<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Member as memberModel;
use app\index\model\Session as sessionModel;

class Login extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        
        if ($isLogin) {
            $this->redirect('Index/index');
        }
    }
    public function login() {
        return $this->fetch();
    }

    public function registered() {
        return $this->fetch();
    }

    public function forgotpassword() {
        return $this->fetch();
    }
    

    /**
     * 验证码自定义
     * @return type
     */
    public function verify_code() {
        $captcha = new \think\captcha\Captcha();
        //验证码过期时间（s）
        $captcha->expire = 1800;
        //验证码位数
        $captcha->length = 4;
        //验证成功后是否重置
        $captcha->reset = true;
        //验证码字体大小
        $captcha->fontSize = 50;
        return $captcha->entry();
    }

    //用户注册
    public function registeredSubmit() {
        $post = input('post.');
        $mobile = !empty($post['mobile']) ? trim($post['mobile']) : Tiperror("手机号不能为空");
        $mobile = (Mobile_validation($post['mobile'])) ? trim($post['mobile']) : Tiperror("手机号不正确");
        if (memberModel::getCount(['mobile' => $mobile])) {
            Tiperror("此手机号已经注册过");
        }
        $password = !empty($post['password']) ? trim($post['password']) : Tiperror("密码不能为空");
        $password = (strlen($post['password']) >= 6 && strlen($post['password']) <= 10) ? trim($post['password']) : Tiperror("密码密码长度必须6到10");
        $confirm_password = !empty($post['confirm_password']) ? trim($post['confirm_password']) : Tiperror("确认密码不能为空");
        if ($password != $confirm_password) {
            Tiperror("确认密码不一样");
        }
        $code_img = !empty($post['code_img']) ? trim($post['code_img']) : Tiperror("图形验证码不能为空");
        if (!captcha_check($code_img)) {//验证方法captcha_check()为助手函数
            Tiperror('验证码错误！');
        }
//        $code = !empty($post['code']) ? trim($post['code']) : Tiperror("手机验证码不能为空");
//        if($code != $_SESSION['getcode']) Tiperror("验证码不正确！");

        if (!isset($post['agreement']) || $post['agreement'] != 'on')
            Tiperror("注册协议没有勾选");
//        if ((strtotime($_SESSION['time']) + 60) < time()) {//将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
//            session_destroy();
//            unset($_SESSION);
//            Tiperror("验证码已过期，请重新获取！");
//        }
        $arrPassword = passwordEncryption($password);
        try {
            $res = memberModel::add([
                        'mobile' => $mobile, 'password' => $arrPassword['password'], 'salt' => $arrPassword['salt'],
                        'member_name' => $mobile, 'm_ip' => request()->ip(), 'create_time' => time()]);
            if (!empty($res)) {
                Tobesuccess('注册成功，前往登录！');
            } else {
                Tiperror("注册失败！");
            }
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    //用户登录
    public function loginSubmit() {
        $post = input('post.');
        $mobilename = !empty($post['name_mobile']) ? trim($post['name_mobile']) : Tiperror("手机号或用户名不能为空");
        $countMobilename = memberModel::getCount(['mobile|member_name' => $mobilename]);
        if (empty($countMobilename))
            Tiperror("用户不存在");
        $password = !empty($post['password']) ? trim($post['password']) : Tiperror("密码不能为空");
        $salt = memberModel::getwhereValue(['mobile|member_name' => $mobilename], 'salt');
        $passwords = md5(md5($salt) . md5($password));
        try {
            $count = memberModel::getCount(['mobile|member_name' => $mobilename, 'password' => $passwords]);
            if (empty($count))
                Tiperror("密码不正确");
            $res = memberModel::updates(['mobile|member_name' => $mobilename], ['last_time' => time()]);
            if (!empty($res)) {
                session('member_id', memberModel::getwhereValue(['mobile|member_name' => $mobilename], 'id')); //缓存用户ID 
                session('member_name', memberModel::getwhereValue(['member_name' => $mobilename], 'member_name'));  //缓存用户名
                session('member_mobile', memberModel::getwhereValue(['mobile' => $mobilename], 'mobile'));  //缓存手机号码
                Tobesuccess('登录成功！');
            } else {
                Tiperror("登录失败！");
            }
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

}
