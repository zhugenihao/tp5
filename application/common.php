<?php

// 应用公共文件

/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
use mailer\PHPMailer;
use Think\Db;

function curl_get($url, &$httpCode = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验，部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}

/**
 * 获取ip所在地区
 * @param type $ip
 * @return boolean|string
 */
function getCity($ip) {
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
//    print_r(file_get_contents($url));
    $ipinfo = json_decode(file_get_contents($url));
//        print_r($ipinfo);
    if ($ipinfo->code == '1') {
        return false;
    }
    $city = $ipinfo->data->country . $ipinfo->data->region . $ipinfo->data->city;
    return $city;
}

function getRandChar($length) {
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

//缓存数据转数组
function Cache_arr($value) {
    return json_decode(Cache($value), true);
}

// 公共发送邮件函数
function sendEmail($data = [], $desc_content = '', $desc_url = '') {
    $system_base = db::name('system_base')->where('id', '1')->find();
//    $mail = new PHPMailer();
//    $mail->isSMTP(); // 使用SMTP服务
//    $mail->CharSet = "utf8"; // 编码格式为utf8，不设置编码的话，中文会出现乱码
//    $mail->Host = "smtp.163.com"; // 发送方的SMTP服务器地址
//    $mail->SMTPAuth = false; // 是否使用身份验证
//    $mail->Username = "a544492962@163.com"; // 发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱</span><span style="color:#333333;">
//    $mail->Password = "a13534054857"; // 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！</span><span style="color:#333333;">
//    $mail->SMTPSecure = "ssl"; // 使用ssl协议方式</span><span style="color:#333333;">
//    $mail->Port = 994; // 163邮箱的ssl协议方式端口号是465/994
//    $mail->setFrom("", "Mailer"); // 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
//    $mail->addAddress($toemail, '入金通知'); // 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
//    $mail->addReplyTo("", "Reply"); // 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
//    //$mail->addCC("xxx@163.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
//    //$mail->addBCC("xxx@163.com");// 设置秘密抄送人(这个人也能收到邮件)
//    //$mail->addAttachment("bug0.jpg");// 添加附件
//    $mail->Subject = "入金通知!"; // 邮件标题
//    $mail->Body = "以下是小Q网络资源博客博主回复你的内容:" . $desc_content . "点击可以查看文章地址:" . $desc_url; // 邮件正文
//    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
//
//    if (!$mail->send()) {// 发送邮件
//        return $mail->ErrorInfo;
//        // echo "Message could not be sent.";
//        // echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
//    } else {
//        return 1;
//    }
    //投诉机制
    $mail = new PHPMailer();
    $mail->isSMTP(); // 使用SMTP服务
    $mail->CharSet = "utf8"; // 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = $system_base['smtp_server']; // 发送方的SMTP服务器地址
    $mail->SMTPAuth = true; // 是否使用身份验证
    $mail->Username = $system_base['email_address']; // 发送方的163邮箱用户名
    $mail->Password = $system_base['email_password']; // 客户端授权密码
    $mail->SMTPSecure = $system_base['email_del_mode']; // 使用ssl协议方式
    $mail->Port = $system_base['smtp_port']; // 163邮箱的ssl协议方式端口号是465/994

    $mail->setFrom($system_base['email_address'], "用户"); // 设置发件人信息
    $mail->addAddress($system_base['email_address'], '金融外汇'); // 设置收件人信息

    $mail->Subject = "入金通知!"; // 邮件标题
    $str = "用户：" . $data['mt4_account'] . "\n";
    $str .= "入金金额：" . $data['deposit_amount_er'] . '(' . $data['currency_conversion'] . "）" . "\n";
    $str .= "货币转换类型：" . $data['fromas'] . '/' . $data['currency_conversion'];
    $mail->Body = $str; // 邮件正文
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

    if (!$mail->send()) {// 发送邮件
//        echo "邮件发送失败<br><br>";
//        echo "邮件错误: " . $mail->ErrorInfo; // 输出错误信息
//        die();
        return false;
    } else {
        return true;
    }
}

function scandir_list($dir) {
    //判断目标目录是否是文件夹
    $file_arr = array();
    if (is_dir($dir)) {
        //打开
        if ($dh = @opendir($dir)) {
            //读取
            while (($file = readdir($dh)) !== false) {

                if ($file != '.' && $file != '..') {

                    $file_arr[] = $file;
                }
            }
            //关闭
            closedir($dh);
        }
    }
    $file_array = array();
    foreach ($file_arr as $val) {
        $valOne = explode('.', $val);
        $file_array[] = $valOne[0];
    }
    return $file_array;
}

//获取登录用户id
function member_id() {
    $member_id = !empty(session('member_id')) ? session('member_id') : '';
    return $member_id;
}

//获取登录用户手机号
function member_mobile() {
    $member_mobile = !empty(session('member_mobile')) ? session('member_mobile') : '';
    return $member_mobile;
}

//正整数
function is_pinteger($str = '') {
    if (!is_numeric($str) || strpos($str, ".") !== false) {
        return false;
    } else {
        return true;
    }
}

//文件判断
function fileJudge($fileName = '', $size = 1024 * 1024, $type_arr = ['jpg', 'jpeg', 'png', 'gif']) {
    $type_arr2 = [];
    $type_str = '';
    foreach ($type_arr as $key => $val) {
        $type_arr2[$key] = 'image/' . $val;
        $type_str .= $val . ',';
    }
    if (!empty($_FILES[$fileName]['name']) && $_FILES[$fileName]['size'] == 0) {
        Tiperror('文件出错或过大，图片最大为' . ($size / (1024 * 1024)) . 'M。');
    } elseif (!empty($_FILES[$fileName]['name']) && $_FILES[$fileName]['size'] >= $size) {
        Tiperror('文件出错或过大，图片最大为' . ($size / (1024 * 1024)) . 'M。');
    } elseif (!empty($_FILES[$fileName]['name']) && !in_array($_FILES[$fileName]['type'], $type_arr2)) {
        Tiperror('文件格式出错！仅支持格式[' . $type_str . ']');
    } else {
        return true;
    }
}

/**
 * 下划线转驼峰
 * 思路:
 * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
 * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
 */
function camelize($uncamelized_words, $separator = '_') {
    $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
}

/**
 * 驼峰命名转下划线命名
 * 思路:
 * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
 */
function uncamelize($camelCaps, $separator = '_') {
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
}
