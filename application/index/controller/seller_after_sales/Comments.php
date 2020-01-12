<?php

/**
 * 评论信息
 */

namespace app\index\controller\seller_after_sales;

use app\index\controller\SellerCommon;
use \think\Db;
use app\common\model\Comments as commentsModel;
use app\common\model\CommentsImg as commentsImgModel;

class Comments extends SellerCommon {

    public function comments_list() {
        $store = $this->store;
        $comments = commentsModel::getList(['store_id' => $store['id']], 10);
        $this->assign('comments', $comments->toArray());
        $this->assign('page', $comments->render());
        return $this->fetch();
    }

    public function comments_details() {
        $store = $this->store;
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
            $result = commentsModel::updates(['id' => $get['id']], ['is_show' => $get['is_show']]);
            if ($result) {
                if ($get['is_show'] == 1) {
                    Tobesuccess('显示操作成功');
                } else {
                    Tobesuccess('隐藏操作成功');
                }
            } else {
                Tiperror("操作失败！");
            }
        }
        return $this->fetch();
    }

    /**
     * 删除投诉
     */
    public function delComments() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = commentsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
