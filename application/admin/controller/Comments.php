<?php

/**
 * 商品评论信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Comments as commentsModel;
use app\common\model\CommentsImg as commentsImgModel;

class Comments extends Common {

    public function Comments_list() {
        $limit = 10;
        $Comments = new commentsModel();
        $list = $Comments->getCommentslist($limit, ['c.store_id' => 0]);
        $this->assign("list", $list->toArray());
        $this->assign("limit", $limit);
        $this->assign('page', $list->render());
        return $this->fetch();
    }

    public function comments_edit() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $result = commentsModel::updates(['id' => $post['id']], ['is_show' => $post['is_show']]);
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
        $info = commentsModel::get(input('id'));
        $commentsImgList = commentsImgModel::getList(['comments_id' => $info['id']], 'img_url');
        $info['commentsImgList'] = $commentsImgList;
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function modifyShow() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = commentsModel::where("id", '=', $get['id'])->update(['is_show' => $get['is_show']]);
            if ($res) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = commentsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
