<?php

namespace app\api\controller\v1;

use app\api\service\MemberToken;
use app\api\validate\TokenGet;
use \think\Request;

/**
 * 获取令牌，相当于登录
 */
class Token {

    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code = '') {
        (new TokenGet())->goCheck();
        $mt = new MemberToken($code);
        $token = $mt->get();
        Tobesuccess("成功获取token", $token);
//        $data['token'] = $token;
//        return json_encode($data);
    }

    public function getMid() {
        $token = input('post.token');
        $tokenValue = Cache_arr($token);
        $mid = $tokenValue['mid'];
        Tobesuccess("获取mid", $mid);
    }

}
