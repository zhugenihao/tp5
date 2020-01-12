<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\mobile\model\Member as memberModel;
use app\common\model\RecordBooks as recordBooksModel;

class RecordBooks extends Common {

    public function index() {
        //用户信息
        $memberInfo = memberModel::getInfo($this->mid, 'id,member_name,mobile,photo,forehead,integral');
        $this->assign('memberInfo', $memberInfo);

        $where = ['member_id' => $this->mid];
        if (input('books_type')) {
            $where['books_type'] = input('books_type');
        }
        $recordBooksList = recordBooksModel::getListPc($where, '*', 10);
        $this->assign('recordBooksList', $recordBooksList['list']);
        $this->assign('books_type', input('books_type'));
        $this->assign('page', $recordBooksList['list']->render());
        return $this->fetch();
    }

}
