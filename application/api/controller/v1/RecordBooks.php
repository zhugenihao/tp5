<?php

/**
 * 商品优惠券信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Session as sessionModel;
use app\common\model\RecordBooks as recordBooksModel;

class RecordBooks extends Common {

    public function _initialize() {
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
        $this->mid = session('member_id');
    }

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $where = ['member_id'=>$this->mid,'books_type'=>$get['books_type']];
            $list = recordBooksModel::getList($where, '*', $get['start'], $get['limit']);
            exit(json_encode($list));
        }
        return $this->fetch();
    }

}
