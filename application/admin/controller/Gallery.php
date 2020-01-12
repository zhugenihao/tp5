<?php

/**
 * 广告信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Gallery as GalleryModel;
use \think\Db;

class Gallery extends Common {

    public function galleryDatadel() {
        if ($this->request->isAjax()) {
            $galleryid_str = input('idstr');
            $galleryid_arr = explode(",", $galleryid_str);
            if (empty($galleryid_arr)) {
                Tiperror("您未选择！");
            }
            $result = GalleryModel::getDestroy($galleryid_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function gallerySort() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $res = GalleryModel::where(['gallery_id' => $get['gallery_id']])->update(['sort' => $get['sort']]);
            if ($res) {
                Tobesuccess("修改成功");
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    public function galleryImg() {
        if ($this->request->isAjax()) {
            $res = GalleryModel::galleryImg();
            if ($res) {
                Tobesuccess("修改成功");
            } else {
                Tiperror("修改失败！");
            }
        }
    }

}
