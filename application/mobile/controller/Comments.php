<?php

/**
 * 商品评论信息
 */

namespace app\mobile\controller;

use app\mobile\controller\Common;
use \think\Db;
use app\common\model\CommentsImg as commentsImgModel;
use app\common\model\Comments as commentsModel;
use app\common\model\Goods as goodsModel;
use app\common\model\BesidesContent;
use app\common\model\OrderGoods as orderGoodsModel;

class Comments extends Common {

    public function index() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $commentsList = commentsModel::getCommentslist(['goods_id' => $get['goods_id']], $get['start'], $get['limit']);
            exit(json_encode($commentsList));
        }
        $goods = goodsModel::getInfo(['goods_id' => input('goods_id')], 'thecover,goods_name,goods_price');
        $this->assign('goods', $goods);
        $this->assign('comments_count', commentsModel::getCount(['goods_id' => input('goods_id')]));
        return $this->fetch();
    }

    public function add() {

        $BesidesContent = BesidesContent::getScore();
        $this->assign('BesidesContent', $BesidesContent);
        $orderGoods = orderGoodsModel::where(['id' => input('order_id')])->find();
        $this->assign('orderGoods', $orderGoods);
        return $this->fetch();
    }

    public function imgFileas() {
        if ($this->request->isAjax()) {
            $img_url = commentsImgModel::submitCimg($this->mid);
            if ($img_url) {
                Tobesuccess('上传成功', $img_url);
            } else {
                Tiperror("上传失败！");
            }
        }
    }

    public function commentsAdd() {
        if ($this->request->isAjax()) {
            $result = commentsModel::add($this->mid);
            if ($result) {
                Tobesuccess('发布成功');
            } else {
                Tiperror("发布失败！");
            }
        }
    }

    public function commentsDel() {
        if ($this->request->isAjax()) {
            $result = commentsModel::getDel(['id' => input('get.comid')]);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

}
