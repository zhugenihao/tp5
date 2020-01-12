<?php

/**
 * 聊天记录信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use \think\Db;
use app\common\model\KefuChat as kefuChatModel;

class KefuChat extends Common {

    public function kefu_chat_list() {
        $kefuChat = kefuChatModel::getKefuChatList(['store_id' => 0], 10);
        $this->assign('list', $kefuChat->toArray());
        $this->assign('page', $kefuChat->render());
        return $this->fetch();
    }

    public function kefu_chat_details() {
        $info = kefuChatModel::get(input('id'));
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 删除聊天记录
     */
    public function del() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = kefuChatModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
