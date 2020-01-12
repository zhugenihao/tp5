<?php

/**
 * 用户的公用类
 */

namespace app\index\controller;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;
use think\Config;
use app\common\model\System as systemModel;
use app\common\model\Directory as directoryModel;
use app\common\model\Cart as cartModel;
use app\common\model\BesidesContent as besidesContentModel;
use app\common\model\Goods as GoodsModel;
use app\common\model\Member as memberModel;
use app\common\model\Category as categoryModel;

class Common extends Controller {

    protected $mid = '';
    protected $member_mobile = '';

    public function _initialize() {

        $this->mid = session('member_id');
        $this->member_mobile = session('member_mobile');
        $type = isMobilemobileVersion();
        if ($type) {
            //跳转到手机端
            header("Location:" . MODEL_URL);
        }
        //购物车数量
        $cartCount = cartModel::getCount(['m_id' => $this->mid]);
        $this->assign('cartCount', $cartCount);
        //网站logo
        $logo_images = systemModel::systemBaseValue('logo_images');
        $this->assign('logo_images', $logo_images);
        //头部栏目
        $dirfield = 'id,title,home_template_p,small_icon';
        $dirWhere = ['type' => 3, 'pid' => 0, 'is_navigation' => 1, 'id' => ['not in', '61,62']];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 10)->toArray();
        $this->assign('directoryList_top', $directoryList);
        
        //头部栏目
        $category = categoryModel::getCategorylist(['store_id' => 0, 'equipment' => 2], "*", 20);

        $this->assign('category', $category);

        //热门商品
        $dgoodsfield = 'goods_id,goods_name,goods_price,thecover,number_payment';
        $paymentGoodsList = GoodsModel::getGoodsList([], $dgoodsfield, 0, 10, ['number_payment' => 'desc']);
        $this->assign('paymentGoodsList', $paymentGoodsList['list']);
        $this->assign('memberInfo', memberModel::getMemberInfo(['id' => $this->mid], '*'));
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

    public function mId() {
        $mid = !empty($this->mid) ? intval($this->mid) : Tiperror("请登录再操作");
        return $mid;
    }

    public function isLogin() {
        if (Request()->isAjax()) {
            if (empty($this->mid)) {
                Tiperror("请登录再操作");
            } else {
                Tobesuccess('已有账号登录', $this->mid);
            }
        }
    }

    /**
     * 用户退出登录操作
     */
    public function mLogout() {
        if ($this->request->isAjax()) {
            $member_id = session('member_id', null);
            $member_name = session('member_name', null);
            $member_mobile = session('member_mobile', null);
            if (!$member_id && !$member_name && !$member_mobile) {
                Tobesuccess("登录退出成功");
            } else {
                Tiperror("登录退出失败");
            }
        }
    }

    //获取手机验证码
    public function verificationCode() {
//        header("Content-type: text/html; charset=utf-8");
        $host = "https://cxkjsms.market.alicloudapi.com";
        $path = "/chuangxinsms/dxjk";
        $method = "POST";
        $appcode = "438ad1caf0ef46ab9262fcbdb7c21583"; //你的AppCode
        $headers = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $Getcode = $this->Getcode(4);
        $mobile = '13207873103';
        $Template = "";
        $content = "【电商科技】验证码为：{$Getcode}，欢迎注册平台！";
        $querys = "Template=" . $Template . "&content=" . $content . "&mobile=" . $mobile;
//        $querys = "Template=%E7%9F%AD%E4%BF%A1%E6%A8%A1%E6%9D%BF%E4%B8%AD%E7%AD%BE%E5%90%8D%E5%92%8C%E5%86%85%E5%AE%B9%E8%87%AA%E5%AE%9A%E4%B9%89%EF%BC%8C%E8%AF%B7%E8%81%94%E7%B3%BB%E6%97%BA%E6%97%BA%E5%AE%A2%E6%9C%8D%E6%88%96qq%EF%BC%9A726980650%E6%8A%A5%E5%A4%87%E3%80%82&content=%E3%80%90%E6%88%90%E9%83%BD%E5%88%9B%E4%BF%A1%E4%BF%A1%E6%81%AF%E3%80%91%E9%AA%8C%E8%AF%81%E7%A0%81%E4%B8%BA%EF%BC%9A{$Getcode}%2C%E6%AC%A2%E8%BF%8E%E6%B3%A8%E5%86%8C%E5%B9%B3%E5%8F%B0%EF%BC%81&mobile=13534054857";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $_SESSION['time'] = date("Y-m-d H:i:s"); //保存当前时间
        $_SESSION['getcode'] = $Getcode; //将mcode的值保存在session中
        var_dump(curl_exec($curl));
    }

    /**
     * @param int $len
     * @return string
     * 随机生成验证码
     */
    private function Getcode($len = 6) {
        return str_pad(mt_rand(1, pow(10, $len) - 1), $len, STR_PAD_LEFT);
    }

}
