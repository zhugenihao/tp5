<?php

namespace app\index\controller;

use \think\Exception;
use \think\Db;
use app\index\controller\Common;
use app\common\model\Seller as sellerModel;
use app\common\model\SellerContact as sellerContactModel;
use app\common\model\SellerCompany as sellerCompanyModel;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;
use app\common\model\Store as storeModel;
use app\common\model\Directory as directoryModel;
use app\common\model\SellerQualification as sellerQualificationModel;
use app\common\model\SellerMenu as sellerMenuModel;
use app\common\model\SellerLoginred as sellerLoginredModel;

class Seller extends Common {

    protected $seller_id = '';

    public function _initialize() {

        parent::_initialize();
        $this->seller_id = session('seller_id');
        $seller = sellerModel::getInfo(['member_id' => $this->mid], "*");
        $this->assign('seller', $seller);
//        session('seller_id',null);
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

    //商家登录
    public function login() {
        if ($this->seller_id) {
            $this->redirect('seller.index/home');
        }
        if ($this->request->isAjax()) {
            $post = input('post.');
            $mobilename = !empty($post['name_mobile']) ? trim($post['name_mobile']) : Tiperror("手机号或用户名不能为空");
            $countMobilename = sellerModel::getCount(['seller_mobile|seller_name' => $mobilename]);
            if (empty($countMobilename)) {
                Tiperror("用户不存在");
            }
            $password = !empty($post['password']) ? trim($post['password']) : Tiperror("密码不能为空");
            $code_img = !empty($post['code_img']) ? trim($post['code_img']) : Tiperror("图形验证码不能为空");
            if (!captcha_check($code_img)) {//验证方法captcha_check()为助手函数
                Tiperror('验证码错误！');
            }
            $salt = sellerModel::getwhereValue(['seller_mobile|seller_name' => $mobilename], 'salt');
            $passwords = md5(md5($salt) . md5($password));
            try {
                $count = sellerModel::getCount(['seller_mobile|seller_name' => $mobilename, 'seller_password' => $passwords]);
                if (empty($count))
                    Tiperror("密码不正确");
                $res = sellerModel::updates(['seller_mobile|seller_name' => $mobilename], ['seller_ip' => request()->ip(), 'last_time' => time()]);
                if (!empty($res)) {
                    $seller = sellerModel::getInfo(['seller_mobile|seller_name' => $mobilename], 'id,seller_name,seller_mobile,parent_id');
                    $parent_id = !empty($seller['parent_id'] > 0) ? $this->topBusinessId($seller['parent_id']) : $seller['id'];

                    $storeInfo = storeModel::getInfo(['seller_id' => $parent_id], '*');
                    $store = $storeInfo->toArray();

                    session('seller_id', $seller['id']); //缓存用户ID 
                    session('seller_name', $seller['seller_name']);  //缓存用户名
                    session('seller_mobile', $seller['seller_mobile']);  //缓存手机号码
                    session('store', $store); //缓存店铺信息 
                    //登录录日志
                    sellerLoginredModel::add(['seller_id' => $seller['id'], 'seller_name' => $seller['seller_name'],
                        'login_ip' => request()->ip(), 'texts' => '登录成功！', 'create_time' => time(), 'store_id' => $store['id']]);

                    $sellerMenu = sellerMenuModel::getList(['pid' => 0], 1);
                    Tobesuccess('登录成功！', $sellerMenu[0]['id']);
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
     * 查找顶级商家id
     * @param type $seller_id
     * @return type
     */
    public function topBusinessId($seller_id = 0) {
        $seller = sellerModel::getInfo(['id' => $seller_id], 'id,parent_id');
        $parent_id = $seller['parent_id'];
        if ($parent_id > 0) {
            $seller_id = $this->topBusinessId($parent_id);
        }
        return $seller_id;
    }

    public function seller_index() {
        if (!$this->mid) {
            $this->redirect('login/login');
        }
        $store = storeModel::getInfo(['member_id' => $this->mid]);
        $this->assign('store', $store);
        return $this->fetch();
    }

    /**
     * 提交联系方式信息
     * @return type
     */
    public function seller_contact() {
        if (!$this->mid) {
            $this->redirect('login/login');
        }
        $info = sellerContactModel::getInfo(['member_id' => $this->mid]);
        if ($this->request->isAjax()) {
            if ($info['id']) {
                $result = sellerContactModel::updatesMd(['id' => $info['id']]);
            } else {
                $result = sellerContactModel::addMd($this->mid);
            }
            if ($result) {
                Tobesuccess('提交成功');
            } else {
                Tiperror("提交失败！");
            }
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 提交公司信息
     * @return type
     */
    public function seller_company() {
        $contact = sellerContactModel::getInfo(['member_id' => $this->mid]);
        if (!$contact['id']) {
            $this->redirect('seller/seller_contact');
        }
        $info = sellerCompanyModel::getInfo(['member_id' => $this->mid]);
        if ($this->request->isAjax()) {
            if ($info['id']) {
                $result = sellerCompanyModel::updatesMd(['id' => $info['id']]);
            } else {
                $result = sellerCompanyModel::addMd($this->mid);
            }
            if ($result) {
                Tobesuccess('提交成功');
            } else {
                Tiperror("提交失败！");
            }
        }
        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);

        if ($info['id']) {
            $cityList = onethinkDistrictModel::getList(['upid' => $info['province_id']]);
            $this->assign('cityList', $cityList);

            $countyList = onethinkDistrictModel::getList(['upid' => $info['city_id']]);
            $this->assign('countyList', $countyList);
        }

        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 提交店铺信息
     * @return type
     */
    public function seller_store() {
        if (!$this->seller_id) {
            $this->redirect('seller/login');
        }
        $application_type = input('application_type'); //1:个人，2=企业
        $company = sellerCompanyModel::getInfo(['member_id' => $this->mid]);
        if (!$company['id'] && $application_type == 2) {
            $this->redirect('seller/seller_company');
        }
        $info = storeModel::getInfo(['member_id' => $this->mid]);
        if ($this->request->isAjax()) {
            if ($info['id']) {
                $result = storeModel::updatesMd(['id' => $info['id']]);
            } else {
                $result = storeModel::addMd($this->mid);
            }
            if ($result) {
                Tobesuccess('提交成功');
            } else {
                Tiperror("提交失败！");
            }
        }
        $provinceList = onethinkDistrictModel::getList(['upid' => 0]);
        $this->assign('provinceList', $provinceList);

        if ($info['id']) {
            $cityList = onethinkDistrictModel::getList(['upid' => $info['province_id']]);
            $this->assign('cityList', $cityList);

            $countyList = onethinkDistrictModel::getList(['upid' => $info['city_id']]);
            $this->assign('countyList', $countyList);
        }
        $dirfield = 'id,title,home_template_p,small_icon';
        $dirWhere = ['type' => 3, 'pid' => 0, 'id' => ['not in', '1,61,62']];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 50)->toArray();
        $this->assign('directoryBigList', $directoryList);

        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 提交资质信息
     * @return type
     */
    public function seller_qualification() {
        $store = storeModel::getInfo(['member_id' => $this->mid]);
        if (!$store['id']) {
            $this->redirect('seller/seller_store');
        }
        $info = sellerQualificationModel::getInfo(['member_id' => $this->mid]);
        if ($this->request->isAjax()) {
            if ($info['id']) {
                $result = sellerQualificationModel::updatesMd(['id' => $info['id']]);
            } else {
                $result = sellerQualificationModel::addMd($this->mid);
            }
            if ($result) {
                Tobesuccess('提交成功');
            } else {
                Tiperror("提交失败！");
            }
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function seller_audit() {
        $store = storeModel::getInfo(['member_id' => $this->mid]);
        if (!$store['id']) {
            $this->redirect('seller/seller_contact');
        }
        $this->assign("store", $store);
        return $this->fetch();
    }

    /**
     * 账号退出
     */
    public function accountOut() {
        if ($this->request->isAjax()) {
            $seller_id = session('seller_id', null); //清除用户ID 
            $seller_name = session('seller_name', null);  //清除用户名
            $seller_mobile = session('seller_mobile', null);  //清除手机号码
            $store = session('store', null); //清除店铺信息 
            if (!$seller_id && !$seller_name && !$seller_mobile && !$store) {
                Tobesuccess("退出成功");
            } else {
                Tiperror("退出失败");
            }
        }
    }

}
