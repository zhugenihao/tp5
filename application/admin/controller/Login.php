<?php

/**
 * 管理员登录注册信息
 */

namespace app\admin\controller;

use think\Controller;
use think\Cache;
use app\admin\model\Backgroundsection as backgroundsectionModel;

class Login extends Controller {

    public function login() {
        $user_id = session('user_id');
        $user_name = session('user_name');
        $user_type = session('user_type');
        if (empty($user_id) || empty($user_name) || ($user_type != '1')) {
            //显示保持登录状态的用户信息
            $user_name1 = session('user_name1');
            $user_password1 = session('user_password1');
            if ($user_name1 && $user_password1) {
                $this->assign([
                    'user_name1' => $user_name1,
                    'user_password1' => $user_password1,
                    'online' => 1,
                ]);
            } else {
                $this->assign([
                    'user_name1' => "",
                    'user_password1' => "",
                    'online' => 0,
                ]);
            }
            return $this->fetch();
        } else {
            $backgroundsection = backgroundsectionModel::getlist(1);
            $this->redirect('Index/index', ['id' => $backgroundsection['list'][0]['id']]);
        }
    }

    public function dllogin() {
        $dbuser = db('user');
        $userName = input("user_name");
        $userPassword = input("user_password");
        $code = input('captcha');

        if (!captcha_check($code)) {//验证方法captcha_check()为助手函数
            Tiperror('验证码错误！');
        }

        $user = $dbuser->where(array("name" => $userName))->find();

        $password = md5(md5($user['salt']) . md5($userPassword));
        $userInfo = $dbuser->where(["name" => $userName, "password" => $password])->find();
        if ($userInfo) {
            session('user_id', $user['id']); //类型ID 
            session('user_name', $userName);  //类型名 
            session('user_type', 1); //类型
            $data['lg_time'] = time();
            $res = $dbuser->where("id", $user['id'])->update($data);
            $online = input("online");
            if ($online == "1") {//保持登录状态
                session('user_name1', $userName);
                session('user_password1', $userName);
            } else {
                session('user_name1', null);
                session('user_password1', null);
            }

            if ($res) {
                //登录日记数据存储
                $texts = '登录成功！';
                $where = array(
                    'user_name' => $userName,
                    'login_ip' => request()->ip(),
                    'create_time' => time(),
                    'texts' => $texts,
                );

                db("loginred")->insert($where);
                $backgroundsection = backgroundsectionModel::getlist(1);
                Tobesuccess($texts, $backgroundsection['list'][0]['id']);
            }
        } else {
            Tiperror('登录失败！');
        }
    }

    public function Logout() {
        if ($this->request->isAjax()) {
            $user_id = session('user_id', null);
            $user_name = session('user_name', null);
            $user_type = session('user_type', null);
            if (!$user_id && !$user_name && !$user_type) {
                Cache::clear(); //清除缓存
                Tobesuccess("登录退出成功");
            } else {
                Tiperror("登录退出失败");
            }
        }
    }

}
