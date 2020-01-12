<?php

/**
 * 商品喜欢信息
 */

namespace app\index\controller;

use app\index\controller\Common;
use \think\Db;
use app\common\model\Gallery as galleryModel;
use app\common\model\Inventory as inventoryModel;

class Gallery extends Common {

    public function addGallery() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $result = galleryModel::add(['goods_id' => $get['goods_id']]);
            if ($result) {
                Tobesuccess('添加成功', $result->gallery_id);
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 删除图片
     */
    public function delGallery() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $img_big = galleryModel::getValue(['gallery_id' => $get['gallery_id']], 'img_big');
            if (!empty($img_big)) {
                if (file_exists(ROOT_PATH . "public/static/" . $img_big)) {
                    unlink(ROOT_PATH . "public/static/" . $img_big);
                }
            }
            $result = galleryModel::destroy($get['gallery_id']);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败！");
            }
        }
    }

    public function editGallery() {
        if ($this->request->isAjax()) {
            $gallery = galleryModel::galleryEdit();
            if ($gallery) {
                Tobesuccess('修改成功', $gallery);
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    public function getGallery() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $gallery = galleryModel::getGalleryList(['goods_id' => $get['goods_id']], '*', 50);
            $n_id = inventoryModel::getValue(['id' => $get['inventory_id']], 'n_id');
            foreach ($gallery as $key => $val) {
                $gallery[$key]['is_there'] = 0;
                if ($val['n_id'] == $n_id) {
                    $gallery[$key]['is_there'] = 1;
                }
            }
            exit(json_encode($gallery));
        }
    }

    public function submitGallery() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            
            $dataSet = array();
            $n_id = inventoryModel::getValue(['id' => $post['inventory_id']], 'n_id');
            $ngallery_id_arr = array_filter($post['ngallery_id']);
            foreach ($ngallery_id_arr as $key => $val) {
                $dataSet[] = ['gallery_id' => $val, 'n_id' => $n_id];
            }
            
            $galleryModel = new galleryModel();
            $res = $galleryModel->saveAll($dataSet);
            if ($res) {
                Tobesuccess('修改成功');
            } else {
                Tiperror("修改失败！");
            }
        }
    }

}
