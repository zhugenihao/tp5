<?php

/**
 * 数据表以外的内容
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class BesidesContent extends Commons {

    //小图标
    public static function small_icon_list() {
        $list = array(
            '1' => array('icon' => '&#xe625;', 'title' => 'home'),
            '2' => array('icon' => '&#xe616;', 'title' => '新闻'),
            '3' => array('icon' => '&#xe613;', 'title' => '图片'),
            '4' => array('icon' => '&#xe60f;', 'title' => '音乐'),
            '5' => array('icon' => '&#xe64b;', 'title' => '标签'),
            '6' => array('icon' => '&#xe66f;', 'title' => '语音'),
            '7' => array('icon' => '&#xe62e;', 'title' => '系统'),
            '8' => array('icon' => '&#xe633;', 'title' => '帮助'),
            '9' => array('icon' => '&#xe634;', 'title' => '出库'),
            '10' => array('icon' => '&#xe681;', 'title' => '分类'),
            '11' => array('icon' => '&#xe687;', 'title' => '全部订单'),
            '12' => array('icon' => '&#xe691;', 'title' => '问题反馈'),
            '13' => array('icon' => '&#xe692;', 'title' => '意见反馈'),
            '14' => array('icon' => '&#xe623;', 'title' => '日志'),
            '15' => array('icon' => '&#xe63e;', 'title' => '文件'),
            '16' => array('icon' => '&#xe63c;', 'title' => '管理'),
            '17' => array('icon' => '&#xe627;', 'title' => '订单'),
            '18' => array('icon' => '&#xe72d;', 'title' => '模版'),
            '19' => array('icon' => '&#xe727;', 'title' => '节日'),
            '20' => array('icon' => '&#xe72b;', 'title' => '后台-网站'),
            '21' => array('icon' => '&#xe731;', 'title' => '闹钟'),
            '22' => array('icon' => '&#xe62c;', 'title' => '用户'),
            '23' => array('icon' => '&#xe60d;', 'title' => '用户'),
            '24' => array('icon' => '&#xe60a;', 'title' => '用户头像'),
            '25' => array('icon' => '&#xe705;', 'title' => '个人中心'),
            '26' => array('icon' => '&#xe607;', 'title' => '添加用户'),
            '27' => array('icon' => '&#xe62b;', 'title' => '群组'),
            '28' => array('icon' => '&#xe62d;', 'title' => '管理员'),
            '29' => array('icon' => '&#xe6cc;', 'title' => '会员'),
            '30' => array('icon' => '&#xe611;', 'title' => '群组'),
            '31' => array('icon' => '&#xe6d0;', 'title' => '客服'),
            '32' => array('icon' => '&#xe686;', 'title' => '累计评价'),
            '33' => array('icon' => '&#xe62f;', 'title' => '通知'),
            '34' => array('icon' => '&#xe63b;', 'title' => '消息管理'),
            '35' => array('icon' => '&#xe66a;', 'title' => '店铺'),
            '36' => array('icon' => '&#xe620;', 'title' => '商品'),
            '37' => array('icon' => '&#xe708;', 'title' => '安卓手机'),
            '38' => array('icon' => '&#xe64f;', 'title' => 'PC'),
            '39' => array('icon' => '&#xe690;', 'title' => '时间'),
            '40' => array('icon' => '&#xe609;', 'title' => '删除'),
            '41' => array('icon' => '&#xe667;', 'title' => '列表'),
            '42' => array('icon' => '&#xe70c;', 'title' => '用户反馈'),
            '43' => array('icon' => '&#xe735;', 'title' => '钱包'),
            '44' => array('icon' => '&#xe706;', 'title' => '关闭'),
            '45' => array('icon' => '&#xe60e;', 'title' => '锁定'),
            '46' => array('icon' => '&#xe672;', 'title' => '购物车满'),
            '47' => array('icon' => '&#xe669;', 'title' => '物流'),
            '48' => array('icon' => '&#xe730;', 'title' => '支付宝支付'),
            '49' => array('icon' => '&#xe719;', 'title' => '微信支付'),
            '50' => array('icon' => '&#xe6b6;', 'title' => '优惠券'),
            '51' => array('icon' => '&#xe66d;', 'title' => '点赞'),
            '52' => array('icon' => '&#xe6ce;', 'title' => '订阅'),
            '53' => array('icon' => '&#xe6ff;', 'title' => '收藏'),
            '54' => array('icon' => '&#xe63f;', 'title' => '密码'),
            '55' => array('icon' => '&#xe66b;', 'title' => '撤销'),
        );
        return $list;
    }

    /**
     * 商品秒杀时间
     */
    public static function getSecondGoodsTimeList() {
        $list = array(
            array('title' => '8点', 'time' => '08:00:00'),
            array('title' => '10点', 'time' => '10:00:00'),
            array('title' => '13点', 'time' => '13:00:00'),
            array('title' => '16点', 'time' => '16:00:00'),
            array('title' => '20点', 'time' => '20:00:00'),
            array('title' => '22点', 'time' => '22:00:00'),
            array('title' => '0点', 'time' => '00:00:00'),
        );
        return $list;
    }

    /**
     * 签到设置
     * @return array
     */
    public static function singnInSetUp() {
        //day_num:连续签到的天数，gold_coins:获得的金币
        $list = array(
            array('day_num' => 1, 'gold_coins' => 10),
            array('day_num' => 2, 'gold_coins' => 15),
            array('day_num' => 3, 'gold_coins' => 20),
            array('day_num' => 4, 'gold_coins' => 25),
            array('day_num' => 5, 'gold_coins' => 30),
            array('day_num' => 6, 'gold_coins' => 35),
            array('day_num' => 7, 'gold_coins' => 40),
        );
        return $list;
    }

    /**
     * 星星打分
     * @return array
     */
    public static function getScore() {
        $list = [
            ['score' => '1.0', 'name' => "非常差"],
            ['score' => '2.0', 'name' => "很差"],
            ['score' => '3.0', 'name' => "一般"],
            ['score' => '4.0', 'name' => "满意"],
            ['score' => '5.0', 'name' => "非常满意"],
        ];
        return $list;
    }

}
