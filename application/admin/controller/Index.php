<?php

/**
 * 后台首页信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Db;
use app\common\model\Time as timeModel;

class Index extends Common {

    public function index() {
        return $this->fetch();
    }

    public function welcome() {
        $user_name = session('user_name');
        $loginredCount = db::name('loginred')->where(['user_name' => $user_name])->count();
        $this->assign('loginredCount', $loginredCount);
        //获取上一次登录信息
        $loginredList = db::name('loginred')->where(['user_name' => $user_name])->order('id desc')->limit(2)->select();
        $this->assign('login_last', $loginredList[1]);
        //信息统计
        $allIndexWe = $this->index_we(); //总数���
        $todayTime = timeModel::today();
        $todayIndexWe = $this->index_we(['create_time' => ['between time', [$todayTime[0], $todayTime[1]]]]); //����
        $yesterdayTime = timeModel::yesterday();
        $YdayIndexWe = $this->index_we(['create_time' => ['between time', [$yesterdayTime[0], $yesterdayTime[1]]]]); //����
        $weekTime = timeModel::week();
        $weekIndexWe = $this->index_we(['create_time' => ['between time', [$weekTime[0], $weekTime[1]]]]); //����
        $monthTime = timeModel::month();
        $monthIndexWe = $this->index_we(['create_time' => ['between time', [$monthTime[0], $monthTime[1]]]]); //����

        $list = array(
            array('title' => '总数', 'directoryCount' => $allIndexWe['directoryCount'], 'advertCount' => $allIndexWe['advertCount'],
                'goodsCount' => $allIndexWe['goodsCount'], 'memberCount' => $allIndexWe['memberCount'], 'userCount' => $allIndexWe['userCount']),
            array('title' => '今日', 'directoryCount' => $todayIndexWe['directoryCount'], 'advertCount' => $todayIndexWe['advertCount'],
                'goodsCount' => $todayIndexWe['goodsCount'], 'memberCount' => $todayIndexWe['memberCount'], 'userCount' => $todayIndexWe['userCount']),
            array('title' => '昨日', 'directoryCount' => $YdayIndexWe['directoryCount'], 'advertCount' => $YdayIndexWe['advertCount'],
                'goodsCount' => $YdayIndexWe['goodsCount'], 'memberCount' => $YdayIndexWe['memberCount'], 'userCount' => $YdayIndexWe['userCount']),
            array('title' => '本周', 'directoryCount' => $weekIndexWe['directoryCount'], 'advertCount' => $weekIndexWe['advertCount'],
                'goodsCount' => $weekIndexWe['goodsCount'], 'memberCount' => $weekIndexWe['memberCount'], 'userCount' => $weekIndexWe['userCount']),
            array('title' => '本月', 'directoryCount' => $monthIndexWe['directoryCount'], 'advertCount' => $monthIndexWe['advertCount'],
                'goodsCount' => $monthIndexWe['goodsCount'], 'memberCount' => $monthIndexWe['memberCount'], 'userCount' => $monthIndexWe['userCount']),
        );
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function index_we($where = []) {
        $list['directoryCount'] = db::name('directory')->where($where)->count();
        $list['advertCount'] = db::name('advert')->where($where)->count();
        $list['goodsCount'] = db::name('goods')->where($where)->count();
        $list['memberCount'] = db::name('member')->where($where)->count();
        $list['userCount'] = db::name('user')->where($where)->count();
        return $list;
    }

    public function article_list() {
        return $this->fetch();
    }

}
