<?php

namespace app\api\service;

use \think\Exception;
use app\api\model\Member;
use app\api\service\Tokens;
use app\lib\exception\Token;
use app\lib\exception\WeChat;
use \think\Cache;

class MemberToken extends Tokens {

    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get() {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->loginError($wxResult);
            } else {
                $res = $this->grantToken($wxResult);
                return $res;
            }
        }
    }

    private function grantToken($wxResult) {

        //拿到openid检查数据库是否存在
        //不存在则新增member记录，并写入缓存
        $openid = $wxResult['openid'];
        $member = Member::getByOpenID($openid);
        if ($member) {
            $mid = $member->id;
        } else {
            $mid = $this->addMember($openid);
        }
        $cachedValue = $this->cachedValue($wxResult, $mid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expixe_in');
        $requset = cache($key, $value, $expire_in);
        if (!$requset) {
            throw new Token([
        'msg' => '服务器缓存异常',
        'errorCode' => 10005,
            ]);
        }
        return $key;
    }

    private function cachedValue($wxResult, $mid) {
        $cachedValue = $wxResult;
        $cachedValue['mid'] = $mid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    private function addMember($openid) {
        $post = input('post.');
        $avatarUrl = $post['avatarUrl'];
        $nickName = $post['nickName'];
        $member = Member::create([
                    'openid' => $openid,
                    'avatarUrl' => $avatarUrl,
                    'nickName' => $nickName,
                    'create_time' => time(),
        ]);
        return $member->id;
    }

    private function loginError($wxResult) {
        throw new WeChat([
    'msg' => $wxResult['errmsg'],
    'errorCode' => $wxResult['errcode'],
        ]);
    }

}
