<?php

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Gallery extends Commons {

    protected $pk = 'gallery_id';
    protected $name = "Gallery";

    public static function getGalleryList($where = [], $limit = 10) {
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field("*")->where($where)->order(['sort' => 'desc', 'gallery_id' => 'desc'])->paginate($limit);
        return $list;
    }

    public static function galleryAdd() {
        $post = input('post.');
        $count = self::where('n_id', $post['n_id'])->count();
        if ($count >= 10) {
            Tiperror("一个规格只能添加十张图片！");
        }
        $file = request()->file("gallery");
        $gallery = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/gallery/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/gallery/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $gallery = '/images/goods/gallery/' . $info->getSaveName();
            } else {
                Tiperror("图片添加失败！", $file->getError());
            }
        }
        $data = ['goods_id' => $post['goods_id'], 'n_id' => $post['n_id'], 'img_big' => $gallery,
            'img_center' => $gallery, 'img_small' => $gallery, 'sort' => $post['sort']];
        if ($data) {
            $result = self::insert($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function galleryGoodsAdd() {
        $post = input('post.');
        $count = self::where('goods_id', $post['goods_id'])->count();
        if ($count >= 10) {
            Tiperror("一个商品只能添加十张图片！");
        }
        $file = request()->file("gallery");
        $gallery = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/gallery/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/gallery/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $gallery = '/images/goods/gallery/' . $info->getSaveName();
            } else {
                Tiperror("图片添加失败！", $file->getError());
            }
        }
        $data = ['goods_id' => $post['goods_id'], 'img_big' => $gallery, 'img_center' => $gallery, 'img_small' => $gallery,
            'sort' => $post['sort']];
        if ($data) {
            $result = self::insert($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function galleryImg() {
        $post = input('post.');
        $file = request()->file("galleryimg" . $post['gallery_id']);
        $gallery = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/gallery/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/gallery/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $img_big = self::where(['gallery_id' => $post['gallery_id']])->value('img_big');
                if (!empty($img_big)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $img_big)) {
                        unlink(ROOT_PATH . "public/static/" . $img_big);
                    }
                }
                $gallery = '/images/goods/gallery/' . $info->getSaveName();
            } else {
                Tiperror("图片添加失败！", $file->getError());
            }
        }
        $data = ['gallery_id' => $post['gallery_id'], 'img_big' => $gallery, 'img_center' => $gallery, 'img_small' => $gallery];
        if ($data) {
            $result = self::update($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 图片删除
     * @param type $idArr
     * @return boolean
     */
    public static function getDestroy($idArr) {
        $list = self::all($idArr)->toArray();
        foreach ($list as $key => $val) {
            if (!empty($val['img_big'])) {
                if (file_exists(ROOT_PATH . "public/static/" . $val['img_big'])) {
                    unlink(ROOT_PATH . "public/static/" . $val['img_big']);
                }
            }
        }
        $res = self::destroy($idArr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
