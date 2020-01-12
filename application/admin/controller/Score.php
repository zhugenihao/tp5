<?php
/**
 * 商品评分信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Scores;
use \think\Db;

class Score extends Common {

    public function score_list() {
        $limit = 10;
        $Scores = new Scores();
        $list = $Scores->getScorelist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }


    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = Scores::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
