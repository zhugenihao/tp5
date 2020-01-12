<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\mobile\model\Session as sessionModel;
use app\mobile\model\Member as memberModel;
use app\mobile\model\Goods as GoodsModel;
use app\common\model\Address as addressModel;
use app\common\model\SpellGroup as spellGroupModel;
use app\common\model\AddressSign as addressSignModel;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;
use app\index\model\Givealike as givealikeModel;
use app\index\model\WatchHistory as watchHistoryModel;
use app\index\model\Collection as collectionModel;

class Member extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
        //用户信息
        $memberInfo = memberModel::getInfo($this->mid, '*');
        $this->assign('memberInfo', $memberInfo);
    }

    public function index() {
        //用户信息
        $memberInfo = memberModel::getInfo($this->mid, 'id,member_name,mobile,photo,forehead,integral');
        $this->assign('memberInfo', $memberInfo);

        return $this->fetch();
    }

    /**
     * 修改头像
     * @return type
     */
    public function account_settings() {
        if ($this->request->isAjax()) {
            $result = memberModel::submitPhoto($this->mid);
            if ($result) {
                Tobesuccess('头像修改成功');
            } else {
                Tiperror("头像修改失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 用户名修改
     * @return type
     */
    public function member_name() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = memberModel::updates(['id' => $this->mid], ['member_name' => $get['member_name']]);
            if ($result) {
                Tobesuccess('用户名修改成功');
            } else {
                Tiperror("用户名修改失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 手机号码修改
     * @return type
     */
    public function member_mobile() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            if (!isset($_SESSION['time']) || !isset($_SESSION['getcode'])) {
                Tiperror("请发送手机验证码！");
            }
            //将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
            if ((strtotime($_SESSION['time']) + 60) < time()) {
                Tiperror("验证码已过期，请重新获取！");
            }
            if ($get['code'] != $_SESSION['getcode']) {
                Tiperror("验证码不正确！");
            }
            $result = memberModel::updates(['id' => $this->mid], ['mobile' => $get['member_mobile']]);
            if ($result) {
                Tobesuccess('手机号修改成功');
            } else {
                Tiperror("手机号修改失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 修改登录密码
     * @return type
     */
    public function member_password() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $salt = memberModel::getwhereValue(['id' => $this->mid], 'salt');
            $password_old = md5(md5($salt) . md5($post['password_old']));
            $count = memberModel::getCount(['id' => $this->mid, 'password' => $password_old]);
            if (!$count) {
                Tiperror("原始登录密码不正确！");
            }
            $arrPassword = passwordEncryption($post['password_new']);
            $result = memberModel::updates(['id' => $this->mid], ['password' => $arrPassword['password'], 'salt' => $arrPassword['salt']]);
            if ($result) {
                Tobesuccess('登录密码修改成功');
            } else {
                Tiperror("登录密码修改失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 修改支付密码
     * @return type
     */
    public function pay_password() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $pay_password_old = md5($post['pay_password_old']);
            $count = memberModel::getCount(['id' => $this->mid, 'pay_password' => $pay_password_old]);
            if (!$count) {
                Tiperror("原始支付密码不正确！");
            }
            $pay_password_new = md5($post['pay_password_new']);
            $result = memberModel::updates(['id' => $this->mid], ['pay_password' => $pay_password_new]);
            if ($result) {
                Tobesuccess('支付密码修改成功');
            } else {
                Tiperror("支付密码修改失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 设置支付密码
     * @return type
     */
    public function setupthe_pay_password() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $pay_password = md5($post['pay_password']);
            $result = memberModel::updates(['id' => $this->mid], ['pay_password' => $pay_password]);
            if ($result) {
                Tobesuccess('支付密码设置成功');
            } else {
                Tiperror("支付密码设置失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 收货地址列表
     * @return type
     */
    public function member_address() {
        $addressList = addressModel::getList(['m_id' => $this->mid], '*');
        $this->assign('addressList', $addressList);
        return $this->fetch();
    }

    /**
     * 添加收货地址信息
     * @return type
     */
    public function address_add() {
        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);

        $AddressSignList = addressSignModel::getList(['sign_type' => 1], '*', 0, 4);
        $this->assign('AddressSignList', $AddressSignList);

        $memberAddressSignList = addressSignModel::getList(['sign_type' => 1, 'm_id' => $this->mid], '*', 0, 10);
        $this->assign('memberAddressSignList', $memberAddressSignList);
        return $this->fetch();
    }

    /**
     * 修改收货地址信息
     * @return type
     */
    public function address_modify() {
        $ads_id = input('ads_id');
        

        $AddressSignList = addressSignModel::getList(['sign_type' => 1], '*', 0, 4);
        $this->assign('AddressSignList', $AddressSignList);

        $memberAddressSignList = addressSignModel::getList(['sign_type' => 1, 'm_id' => $this->mid], '*', 0, 10);
        $this->assign('memberAddressSignList', $memberAddressSignList);

        $addressInfo = addressModel::getInfo($ads_id);
        $this->assign('addressInfo', $addressInfo);
        
        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);
        
        $cityList = onethinkDistrictModel::getList(['upid' => $addressInfo['province_id']]);
        $this->assign('cityList', $cityList);
        
        $countyList = onethinkDistrictModel::getList(['upid' => $addressInfo['city_id']]);
        $this->assign('countyList', $countyList);
        
        $townList = onethinkDistrictModel::getList(['upid' => $addressInfo['county_id']]);
        $this->assign('townList', $townList);

        return $this->fetch();
    }

    /**
     * 添加标志
     */
    public function addSign() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $count = addressSignModel::getCount(['m_id' => $this->mid, 'sign_name' => $get['sign_name']]);
            if ($count) {
                Tiperror("该标志已存在！");
            }
            $countAll = addressSignModel::getCount(['m_id' => $this->mid]);
            if ($countAll >= 10) {
                Tiperror("只能添加10个标志！");
            }
            $result = addressSignModel::add(['m_id' => $this->mid, 'sign_name' => $get['sign_name'], 'create_time' => time()]);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 删除标志
     */
    public function delSign() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = addressSignModel::getDelete($get['id']);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

    /**
     * 点赞中心
     * @return type
     */
    public function goods_give_like() {
        $field = "gl.*,g.goods_name,g.thecover,g.goods_price,g.number_payment";
        $list = givealikeModel::getListPc(['gl.m_id' => $this->mid], $field, 12);
        $this->assign('list', $list['list']);
        $this->assign('page', $list['list']->render());
        $this->assign('count_all', givealikeModel::getCount(['m_id' => $this->mid]));
        return $this->fetch();
    }

    /**
     * 我的足迹
     * @return type
     */
    public function watch_history() {
        $field = "w.*,g.goods_name,g.thecover,g.goods_price,g.number_payment";
        $list = watchHistoryModel::getListPc(['w.m_id' => $this->mid], $field, 12);
        $this->assign('list', $list['list']);
        $this->assign('page', $list['list']->render());
        $this->assign('count_all', watchHistoryModel::getCount(['m_id' => $this->mid]));
        return $this->fetch();
    }

    /**
     * 我的收藏
     * @return type
     */
    public function collection() {
        $field = "c.*,g.goods_name,g.thecover,g.goods_price,g.number_payment";
        $list = collectionModel::getListPc(['c.m_id' => $this->mid], $field, 12);
        $this->assign('list', $list['list']);
        $this->assign('page', $list['list']->render());
        $this->assign('count_all', collectionModel::getCount(['m_id' => $this->mid]));
        return $this->fetch();
    }

}
