<?php

namespace app\api\service;

use app\api\model\v1\Topuprecord;
use think\Exception;
use think\Loader;
use think\Log;

require_once "../extend/WxPay/WxPay.Api.php";

//  extend/WxPay/WxPay.Aip.php
//Loader::import('WxPay.WxPay', EXTEND_PATH, '.Aip.php');
class Pays {

    function __construct() {
        
    }

    public function WxPay($data, $openid, $TopuprecordId) {
        $wxOrderDate = new \WxPayUnifiedOrder();
        $wxOrderDate->SetOut_trade_no($data['number']);
        $wxOrderDate->SetTrade_type('JSAPI');
        $wxOrderDate->SetTotal_fee($data['amount'] * 100);
        $wxOrderDate->SetBody('抖漫科技');
        $wxOrderDate->SetOpenid($openid);
        $wxOrderDate->SetNotify_url(config('secure.pay_back_url'));
        return $this->getWxPaytrue($wxOrderDate, $TopuprecordId);
    }

    private function getWxPaytrue($wxOrderDate, $TopuprecordId) {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderDate);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        $this->TopuprecordUpdate($wxOrder, $TopuprecordId);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    private function TopuprecordUpdate($wxOrder, $TopuprecordId) {
        $data = [
            'prepay_id' => $wxOrder['prepay_id']
        ];
        Topuprecord::where("id", $TopuprecordId)->update($data);
    }
    
     // 签名
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }
    
    

}
