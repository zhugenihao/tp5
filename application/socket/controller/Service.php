<?php

namespace app\socket\controller;

use \think\Db;
use \think\Request;
use app\common\model\Kefu as kefuModel;
use app\common\model\KefuChat as kefuChatModel;
use app\common\model\KefuMemberOnline as kefuMemberOnlineModel;
use app\common\model\KefuStatements as kefuStatementsModel;

class Service extends Common {

    public $kefu_id = 0;

    public function _initialize() {
        parent::_initialize();
        $this->kefu_id = session('kefu_id');
    }

    /**
     * 客服登陆
     * @return type
     */
    public function login() {
        if ($this->kefu_id) {
            $this->redirect('service/index');
        }

        if ($this->request->isAjax()) {
            $post = input('post.');
            $kefuAccount = !empty($post['kefu_account']) ? trim($post['kefu_account']) : Tiperror("账号不能为空");
            $countKefuAccount = kefuModel::getCount(['kefu_account' => $kefuAccount]);
            if (empty($countKefuAccount))
                Tiperror("账号不存在");
            $password = !empty($post['password']) ? trim($post['password']) : Tiperror("密码不能为空");

            try {
                $count = kefuModel::getCount(['kefu_account' => $kefuAccount, 'kefu_password' => md5($password)]);
                if (empty($count))
                    Tiperror("密码不正确");
                $res = kefuModel::updates(['kefu_account' => $kefuAccount], ['last_time' => time(),
                            'login_ip' => request()->ip(),
//                    'region' => getCity(request()->ip()),
                            'is_online' => 1]);
                if (!empty($res)) {
                    $kefu = kefuModel::getInfo(['kefu_account' => $kefuAccount]);
                    session('kefu_id', $kefu['id']); //缓存用户ID 
                    session('kefu_name', $kefu['kefu_name']);  //缓存用户名
                    session('kefu_account', $kefu['kefu_account']);  //缓存用户账号
                    Tobesuccess('登录成功！');
                } else {
                    Tiperror("登录失败！");
                }
            } catch (\Exception $e) {
                Tiperror("出现其他异常", $e->getMessage());
            }
        }
        return $this->fetch();
    }

    /**
     * 客服工作聊天界面
     * @return type
     */
    public function index() {
        if (!$this->kefu_id) {
            $this->redirect('service/login');
        }
        $kefu = kefuModel::get($this->kefu_id);
        $this->assign('kefu', $kefu);

        $kefuMemberOnline = kefuMemberOnlineModel::getList(['kefu_id' => $this->kefu_id], 10);
        $kefuMemberOnline = $kefuMemberOnline->toArray();
        foreach ($kefuMemberOnline['data'] as $key => $val) {
            $kefuMemberOnline['data'][$key]['chat_count'] = kefuChatModel::getCount(['member_id' => $val['member_id'], 'kefu_id' => $this->kefu_id, 'reads_status' => 1]);
        }
        $this->assign('kefuMemberOnline', $kefuMemberOnline);

        $member_id = 0;
        if ($kefuMemberOnline['total'] > 0) {
            $member_id = $kefuMemberOnline['data'][0]['member_id'];
        }
        $this->assign('member_id', $member_id);

        $kefuStatements = kefuStatementsModel::getList(['store_id' => $kefu['store_id']], 10);
        $kefuStatements = $kefuStatements->toArray();
        if ($kefuStatements['total'] > 0) {
            foreach ($kefuStatements['data'] as $kskey => $skval) {
                $is_use = 0;
                $kefu_id_arr = explode(',', $skval['kefu_id_str']);
                if (in_array('[' . $this->kefu_id . ']', $kefu_id_arr)) {
                    $is_use = 1;
                }
                $kefuStatements['data'][$kskey]['is_use'] = $is_use;
            }
        }
        $this->assign('kefuStatements', $kefuStatements);

        return $this->fetch();
    }

    /**
     * 使用常用语操作
     */
    public function statementsUse() {
        if ($this->request->isAjax()) {
            $input = input('get.');
            $kefu = kefuModel::get($this->kefu_id);
            $info = kefuStatementsModel::get($input['id']);
            $kefu_id_arr = explode(',', $info['kefu_id_str']);
            if (in_array('[' . $this->kefu_id . ']', $kefu_id_arr)) {
                Tiperror("你已使用该常用语！");
            }
            $kefuStatements = kefuStatementsModel::where(['store_id' => $kefu['store_id']])->select();
            $kefuStatements = $kefuStatements->toArray();
            if ($kefuStatements) {
                $data = [];
                foreach ($kefuStatements as $key => $val) {
                    $kefuid_arr = explode(',', $val['kefu_id_str']);
                    if (in_array('[' . $this->kefu_id . ']', $kefuid_arr)) {
                        $kefuid_key = array_search('[' . $this->kefu_id . ']', $kefuid_arr);
                        unset($kefuid_arr[$kefuid_key]);
                        $kefuid_str = implode(',', $kefuid_arr);
                        $data[] = ['id' => $val['id'], 'kefu_id_str' => $kefuid_str];
                    }
                }
                //更新常用语清除本客服id的数据
                $kefuStatementsModel = new kefuStatementsModel();
                $kefuStatementsModel->saveAll($data);
            }

            $kefu_id_str = $info['kefu_id_str'] . ',[' . $this->kefu_id . ']';
            $res = kefuStatementsModel::updates(['id' => $input['id']], ['kefu_id_str' => $kefu_id_str]);
            if ($res) {
                Tobesuccess('操作成功！');
            } else {
                Tiperror("操作失败！");
            }
        }
    }

    /**
     * 登录退出
     */
    public function loginOut() {
        //更新下线状态
        kefuModel::updates(['id' => $this->kefu_id], ['is_online' => 2]);
        session('kefu_id', null);
        session('kefu_name', null);
        session('kefu_account', null);
        $this->redirect('service/index');
    }

}
