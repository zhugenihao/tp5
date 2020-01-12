<?php

ini_set("session.cookie_httponly", 1);
header("Set-Cookie: hidden=value; httpOnly");
header("Content-type: text/html; charset=utf-8");
header('X-Frame-Options:Deny');
header('X-Frame-Options:SAMEORIGIN');

function Tobesuccess($prompt = '', $content = '') {//提示成功
    $data = array(
        "types" => 1,
        "prompt" => $prompt,
        "content" => $content,
    );
    echo json_encode($data);
    exit;
}

function Tiperror($prompt = '', $content = '') {//提示失败
    $data = array(
        "types" => 0,
        "prompt" => $prompt,
        "content" => $content,
    );
    echo json_encode($data);
    exit;
}

/**
 * 随机字符串
 * @param $lenth
 * @return string
 */
function randStr($lenth = 1, $type = "all") {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    if ($type == 'digital') {
        $chars = "0123456789";
    } elseif ($type == 'lowlet') {
        $chars = "abcdefghijklmnopqrstuvwxyz";
    } elseif ($type == 'biglet') {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
    $password = '';
    for ($i = 0; $i < $lenth; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

//判断手机版本
function isMobilemobileVersion() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($agent, "NetFront") || strpos($agent, "iPhone") || strpos($agent, "MIDP-2.0") || strpos($agent, "Opera Mini") || strpos($agent, "UCWEB") || strpos($agent, "Android") || strpos($agent, "Windows CE") || strpos($agent, "SymbianOS")) {
        // header("Location:http://wap.yjcom.com/");
        return true;
    } else {
        return false;
    }
}

//密码加密
function passwordEncryption($password) {
    $salt = mt_rand(0, 999) . substr(time(), -4);
    $array = array('password' => md5(md5($salt) . md5($password)), 'salt' => $salt);
    return $array;
}

//参数：$arr 二维数组 ，$shortKey 需要排序的列，$short 排序方式 $shortType 排序类型
function array_sort($arr, $shortKey, $short = SORT_DESC, $shortType = SORT_REGULAR) {
    foreach ($arr as $key => $data) {
        $name[$key] = $data[$shortKey];
    }
    array_multisort($name, $shortType, $short, $arr);
    return $arr;
}

function checkIdCard($idcard) {//身份证号码验证
    if (strlen($idcard) != 18) {// 只能是18位  
        return false;
    }
    $idcard_base = substr($idcard, 0, 17); // 取出本体码  
    $verify_code = substr($idcard, 17, 1); // 取出校验码  
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); // 加权因子  
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); // 校验码对应值  
    $total = 0;
    for ($i = 0; $i < 17; $i++) {// 根据前17位计算校验码  
        $total += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $total % 11; // 取模  
    if ($verify_code == $verify_code_list[$mod]) { // 比较校验码  
        return true;
    } else {
        return false;
    }
}

function Mobile_validation($mobile) {//手机号码验证
    if (preg_match("/^1[34578]\d{9}$/", $mobile)) {
        return true;
    } else {
        return false;
    }
}

function funcphone($str) {//电话号码正则表达试
    return (preg_match("/^([0-9]{3,4}-)?[0-9]{7,8}$/", $str)) ? true : false;
}

function mobilephone($str) {//同时验证手机与电话号码
    if (Mobile_validation($str) || funcphone($str)) {
        return true;
    } else {
        return false;
    }
}

function is_email($email) {
    $pattern = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
    if (preg_match($pattern, $email)) {
        return true;
    } else {
        return false;
    }
}

//Orderlist数据表，用于保存用户的购买订单记录；
/* Orderlist数据表结构；
  CREATE TABLE `tb_orderlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,购买者userid
  `username` varchar(255) DEFAULT NULL,购买者姓名
  `ordid` varchar(255) DEFAULT NULL,订单号
  `ordtime` int(11) DEFAULT NULL,订单时间
  `productid` int(11) DEFAULT NULL,产品ID
  `ordtitle` varchar(255) DEFAULT NULL,订单标题
  `ordbuynum` int(11) DEFAULT '0',购买数量
  `ordprice` float(10,2) DEFAULT '0.00',产品单价
  `ordfee` float(10,2) DEFAULT '0.00',订单总金额
  `ordstatus` int(11) DEFAULT '0',订单状态
  `payment_type` varchar(255) DEFAULT NULL,支付类型
  `payment_trade_no` varchar(255) DEFAULT NULL,支付接口交易号
  `payment_trade_status` varchar(255) DEFAULT NULL,支付接口返回的交易状态
  `payment_notify_id` varchar(255) DEFAULT NULL,
  `payment_notify_time` varchar(255) DEFAULT NULL,
  `payment_buyer_email` varchar(255) DEFAULT NULL,
  `ordcode` varchar(255) DEFAULT NULL,       //这个字段不需要的，大家看我西面的修正补充部分的说明！
  `isused` int(11) DEFAULT '0',
  `usetime` int(11) DEFAULT NULL,
  `checkuser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
 */
//在线交易订单支付处理函数
//函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
//返回值：如果订单已经成功支付，返回true，否则返回false；
function checkorderstatus($ordid) {
    $Ord = M('Orderlist');
    $ordstatus = $Ord->where('ordid = ' . $ordid)->getField('ordstatus');
    if ($ordstatus == 1) {
        return true;
    } else {
        return false;
    }
}

//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter) {
    $ordid = $parameter['out_trade_no'];
    $data['payment_trade_no'] = $parameter['trade_no'];
    $data['payment_trade_status'] = $parameter['trade_status'];
    $data['payment_notify_id'] = $parameter['notify_id'];
    $data['payment_notify_time'] = $parameter['notify_time'];
    $data['payment_buyer_email'] = $parameter['buyer_email'];
    $data['ordstatus'] = 1;
    $Ord = M('Orderlist');
    $Ord->where('ordid = ' . $ordid)->save($data);
}

/* -----------------------------------
  2013.8.13更正
  下面这个函数，其实不需要，大家可以把他删掉，
  具体看我下面的修正补充部分的说明
  ------------------------------------ */

//获取一个随机且唯一的订单号；
function getordcode() {
    $Ord = M('Orderlist');
    $numbers = range(10, 99);
    shuffle($numbers);
    $code = array_slice($numbers, 0, 4);
    $ordcode = $code[0] . $code[1] . $code[2] . $code[3];
    $oldcode = $Ord->where("ordcode='" . $ordcode . "'")->getField('ordcode');
    if ($oldcode) {
        getordcode();
    } else {
        return $ordcode;
    }
}

/**
 * 微信扫码支付
 * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)
 */
function weixinpay($order) {
    $order['trade_type'] = 'NATIVE';
    Vendor('Weixinpay.Weixinpay');
    $weixinpay = new \Weixinpay();
    $weixinpay->pay($order);
}
