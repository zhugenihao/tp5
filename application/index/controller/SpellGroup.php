<?php

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\SpellGroup as spellGroupModel;

class SpellGroup extends Common {

    public function index() {
        $field = 's.*,g.goods_name,g.thecover,g.goods_price,g.number_payment';
        $spellGroupList = spellGroupModel::getSpellGrouplistPc([], 10, $field);
        $this->assign('page', $spellGroupList['list']->render());
        $this->assign('spellGroupList', $spellGroupList['list']);
        return $this->fetch();
    }

}
