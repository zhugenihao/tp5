<?php

ini_set("session.cookie_httponly", 1);
header("Set-Cookie: hidden=value; httpOnly");
header("Content-type: text/html; charset=utf-8");
header('X-Frame-Options:Deny');
header('X-Frame-Options:SAMEORIGIN');


function Tobesuccess($prompt, $content) {//提示成功
    $data = array(
        "types" => 1,
        "prompt" => $prompt,
        "content" => $content,
    );
    echo json_encode($data);
    exit;
}

function Tiperror($prompt, $content) {//提示失败
    $data = array(
        "types" => 0,
        "prompt" => $prompt,
        "content" => $content,
    );
    echo json_encode($data);
    exit;
}

//判断手机版本
function isMobile() {
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($agent, "NetFront") || strpos($agent, "iPhone") || strpos($agent, "MIDP-2.0") || strpos($agent, "Opera Mini") || strpos($agent, "UCWEB") || strpos($agent, "Android") || strpos($agent, "Windows CE") || strpos($agent, "SymbianOS")) {
        // header("Location:http://wap.yjcom.com/");
        return true;
    } else {
        return false;
    }
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

//密码加密
function passwordEncryption($password) {
    $salt = mt_rand(0, 999) . substr(time(), -4);
    $array = array('password' => md5(md5($salt) . md5($password)), 'salt' => $salt);
    return $array;
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
