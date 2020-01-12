<?php

/**
 * 用户登录注册信息
 */

namespace app\api\controller\v1;

use think\Controller;
use \think\Db;
use app\api\model\Member as memberModel;
use app\api\model\Session as sessionModel;

class Login extends Controller {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if ($isLogin) {
            $this->redirect('Index/index');
        }
    }

    public function registered() {
        return $this->fetch();
    }

    public function login() {
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
        $api = !empty($post['api']) ? trim($post['api']) : Tiperror("手机号不能为空");
        $api = (Mobile_validation($post['api'])) ? trim($post['api']) : Tiperror("手机号不正确");
        if (memberModel::getCount(['api' => $api])) {
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
                        'api' => $api, 'password' => $arrPassword['password'], 'salt' => $arrPassword['salt'],
                        'member_name' => $api,'m_ip' => request()->ip(), 'create_time' => time()]);
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
        $apiname = !empty($post['name_api']) ? trim($post['name_api']) : Tiperror("手机号或用户名不能为空");
        $countMobilename = memberModel::getCount(['api|member_name' => $apiname]);
        if (empty($countMobilename))
            Tiperror("用户不存在");
        $password = !empty($post['password']) ? trim($post['password']) : Tiperror("密码不能为空");
        $salt = memberModel::getwhereValue(['api|member_name' => $apiname], 'salt');
        $passwords = md5(md5($salt) . md5($password));
        try {
            $count = memberModel::getCount(['api|member_name' => $apiname, 'password' => $passwords]);
            if (empty($count))
                Tiperror("密码不正确");
            $res = memberModel::updates(['api|member_name' => $apiname], ['last_time' => time()]);
            if (!empty($res)) {
                session('member_id', memberModel::getwhereValue(['api|member_name' => $apiname], 'id')); //缓存用户ID 
                session('member_name', memberModel::getwhereValue(['member_name' => $apiname], 'member_name'));  //缓存用户名
                session('member_api', memberModel::getwhereValue(['api' => $apiname], 'api'));  //缓存手机号码
                Tobesuccess('登录成功！');
            } else {
                Tiperror("登录失败！");
            }
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

}
