<?php

/**
 * 用户签到信息
 */

namespace app\api\controller\v1;

use app\api\controller\v1\Common;
use \think\Db;
use app\common\model\SignIn as signInModel;
use app\common\model\BesidesContent as besidesContentModel;
use app\common\model\Member as memberModel;
use app\common\model\RecordBooks as recordBooksModel;

class SignIn extends Common {

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $where = ['member_id' => $this->mid];
            $list = signInModel::getList($where, '*', $get['start'], $get['limit']);
            exit(json_encode($list));
        }
        $SignInGold = signInModel::getSum(['member_id' => $this->mid]);
        $this->assign("SignInGold", $SignInGold);
        $singnInInfo = signInModel::getInfo(['member_id' => $this->mid], '*', ['signin_time' => 'desc']);
        $this->assign("continuousDay", $singnInInfo['continuous_day']);
        $this->assign("today", date('Y-m-d'));

        return $this->fetch();
    }

    /**
     * 用户签到
     */
    public function addSignIn() {
        if ($this->request->isAjax()) {
            $today = date('Y-m-d');
            $count = signInModel::getCount(['member_id' => $this->mId(), 'signin_time' => $today]);
            if ($count) {
                Tiperror("你已签到过！");
            }
            $dayNum = signInModel::continuousDay(['member_id' => $this->mId(), 'signin_time' => $today]);
            $singnInSetUp = besidesContentModel::singnInSetUp();
            $singnInSetUp2 = array();
            foreach ($singnInSetUp as $key => $val) {
                $singnInSetUp2[$val['day_num']] = $val['gold_coins'];
            }
            $gold_coins = $singnInSetUp2[$dayNum];
            $data = ['member_id' => $this->mId(), 'gold_coins' => $gold_coins, 'continuous_day' => $dayNum,
                'signin_time' => $today, 'create_time' => time()];
            $result = signInModel::add($data);
            if ($result) {
                //添加积分
                memberModel::setIncs(['id' => $this->mId()], 'integral', $gold_coins);
                recordBooksModel::add(['member_id' => $this->mId(), 'books_text' => '签到获积分', 'books_type' => 'into', 'amount' => $gold_coins,
                    'rdbook_type'=>2,'create_time' => time()]);
                Tobesuccess('签到成功');
            } else {
                Tiperror("签到失败！");
            }
        }
    }

}
