<?php

/**
 * 权限信息
 */

namespace app\index\model;

use think\controller;
use \think\Request;
use \think\Db;
use app\common\model\Seller as sellerModel;
use app\common\model\SellerGroup as sellerGroupModel;
use app\common\model\SellerMenu as sellerMenuModel;

class Permissions extends controller {

    private $seller_id = 0;
    private $store = array();

    public function _initialize() {
        parent::_initialize();
        $this->seller_id = session('seller_id');
        $this->store = session('store');
    }

    //验证操作权限
    public function getPermissions() {
        $store = $this->store;
        $request = Request::instance();
        $app = $request->module();
        $model = uncamelize($request->controller(), '_');
        $action = $request->action();
        $methods = "$model/$action";
        $seller = sellerModel::getInfo(['id' => $this->seller_id]);
        $sellerGroup = sellerGroupModel::getInfo(['store_id' => $store['id'], 'id' => $seller['group_id']]);
        $menuid_arr = json_decode($sellerGroup['menuid_str'], true);
        $sellerMenu = sellerMenuModel::where(['id' => ['in', $menuid_arr], 'methods' => $methods])->select();
        if ($seller['group_id'] > 0 && count($sellerMenu) < 1) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {//判断ajax
                Tiperror("不好意思，您无权访问！");
            } else {
                echo '<script type="text/javascript" src="/static/h-admin/lib/jquery/1.9.1/jquery.min.js"></script>
                      <script type="text/javascript" src="/static/h-admin/lib/layer/2.4/layer.js"></script>
                      <script type="text/javascript">$(function(){ 
                      layer.msg("不好意思，您无权访问！", {icon: 5}); 
                      setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                      }, 1000);
                      })</script>';
            }
            exit();
        }
    }

}
