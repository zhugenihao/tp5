<?php

/**
 * 拼团信息
 */

namespace app\mobile\controller;

use app\mobile\controller\Common;
use \think\Db;
use app\common\model\SpellGroup as spellGroupModel;

class SpellGroup extends Common {

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $field = 's.*,g.goods_name,g.thecover,g.goods_price';
            $spellGroupList = spellGroupModel::getSpellGrouplist([], $get['start'], $get['limit'],$field);
            exit(json_encode($spellGroupList));
        }
        return $this->fetch();
    }

}
