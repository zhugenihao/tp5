<?php

/**
 * 商家的公用类
 */

namespace app\index\controller;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;
use think\Cache;
use app\common\model\BesidesContent as besidesContentModel;
use app\common\model\Seller as sellerModel;
use app\common\model\SellerMenu as sellerMenuModel;
use app\common\model\SellerGroup as sellerGroupModel;
use app\index\model\Permissions as permissionsModel;
use app\common\model\System as systemModel;

class SellerCommon extends Controller {

    protected $seller_id = '';
    protected $seller_name = '';
    protected $seller_mobile = '';
    protected $store = array();

    public function _initialize() {
        $this->seller_id = session('seller_id');
        $this->seller_name = session('seller_name');
        $this->seller_mobile = session('seller_mobile');
        $this->store = session('store');
        $type = isMobilemobileVersion();
        if ($type) {
            //跳转到手机端
            header("Location:" . MODEL_URL);
        }
        if (!$this->seller_id) {
            $this->redirect('seller/login');
        }

        $permissionsModel = new permissionsModel();
        $permissionsModel->getPermissions();
//        session('seller_id',null);
        $seller = sellerModel::get($this->seller_id);
        $this->assign('seller', $seller);

        $store = $this->store;
        $sellerMenu = Cache::get("sellerMenu");
        if (empty($sellerMenu)) {
            $sellerMenu = sellerMenuModel::getMenuList(['pid' => 0], 20);
            $sellerMenu = $sellerMenu->toArray();
            Cache::set("sellerMenu", $sellerMenu);
        }
        $this->assign('sellerMenu', $sellerMenu);

        $sellerGroup = sellerGroupModel::getInfo(['store_id' => $store['id'], 'id' => $seller['group_id']], '*');
        $menuid_arr = json_decode($sellerGroup['menuid_str'], true);
        $menuid_is_arr = array();
        if ($menuid_arr) {
            foreach ($menuid_arr as $key => $menu_id) {
                $menuid_is_arr[$menu_id] = $menu_id;
            }
        }
        $this->assign('menuid_is_arr', $menuid_is_arr);
        $this->tplImages();

        //底部版权信息
        $copyright = systemModel::systemBaseValue('copyright');
        $this->assign('copyright', $copyright);
        //备案号
        $for_the_record = systemModel::systemBaseValue('for_the_record');
        $this->assign('for_the_record', $for_the_record);
    }

    public function tplImages() {
        $memberimg_errurl = 'images/icon/mberr.gif'; //无图头像
        $errUrl = "images/error.png"; //无图图片
        $errUserUrl = "images/user.png"; //无头像图片
        $this->assign('errUserUrl', $errUserUrl);
        $this->assign('errUrl', $errUrl);
        $this->assign('memberimg_errurl', $memberimg_errurl);

        $small_icon = besidesContentModel::small_icon_list();
        $this->assign('small_icon', $small_icon);
    }

    /**
     * 用户退出登录操作
     */
    public function sellerLogout() {
        if ($this->request->isAjax()) {
            $seller_id = session('seller_id', null);
            $seller_name = session('seller_name', null);
            $seller_mobile = session('seller_mobile', null);
            $store = session('store', null);
            if (!$seller_id && !$seller_name && !$seller_mobile && !$store) {
                Tobesuccess("登录退出成功");
            } else {
                Tiperror("登录退出失败");
            }
        }
    }
    /**
     * 更新缓存
     */
    public function updatesCache() {
        if ($this->request->isAjax()) {
            Cache::clear(); //清除缓存
            Tobesuccess("更新缓存成功");
        }
    }

}
