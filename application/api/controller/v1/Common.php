<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;
use think\Cache;

class Common extends Controller {

    protected $mid;
    protected $openid;
    protected $pre;
    protected $data_time;
    protected $mids;

    public function _initialize() {
        $token = $this->request->header('token'); //令牌
//        Cache::rm($token); //清除令牌
        if ($token) {
            $tokenValue = Cache_arr($token);
            $this->mid = intval($tokenValue['mid']);
            $this->openid = trim($tokenValue['openid']);
            $member = db::name('member')->where(['id' => $this->mid, 'state' => 1, 'delete' => 1])->find();
            session('member_id', $this->mid);
            session('member_mobile', $member['mobile'] ? $member['mobile'] : 'none');
        }


        $this->pre = config('DB_PREFIX');
        $this->data_time = config('datalist.datalist_time');
    }

    public function isMid() {
        echo json_encode(array('mid' => session('user_id')));
    }

    //图片地址
    public function imgUrl() {
//        $request = Request::instance();
        $domain = $this->request->domain();
        $imgUrl = $domain . "/static/images";
        return $imgUrl;
    }

    public function mId() {
        $mid = !empty($this->mid) ? intval($this->mid) : Tiperror("请登录再操作");
        return $mid;
    }

    public function openId() {
        $openid = !empty($this->openid) ? trim($this->openid) : Tiperror("用户不存在");
        return $openid;
    }

    //临时社区图片删除
    public function temporary_img_delete() {
        if ($this->mid) {
            db::name('temporary_img')->where('m_id', $this->mid)->delete();
        }
    }

}
