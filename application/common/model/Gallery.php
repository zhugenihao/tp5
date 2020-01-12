<?php

/**
 * 商品多图信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use \think\Image;

class Gallery extends Commons {

    protected $pk = 'gallery_id';
    protected $name = "Gallery";

    public static function add($data = array()) {
        return self::create($data);
    }

    public static function getGalleryList($where = [], $field = '*', $limit = 10) {
        $order = ['sort' => 'asc', 'gallery_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select()->toArray();
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $order = ['sort' => 'asc', 'gallery_id' => 'desc'];
        $list = self::field($field)->where($where)->order($order)->find()->toArray();
        return $list;
    }

    public static function getValue($where = [], $value = 'id') {
        $order = ['sort' => 'asc', 'gallery_id' => 'desc'];
        $list = self::where($where)->order($order)->value($value);
        return $list;
    }

    public function galleryAdd($goods_id) {
        $post = input('post.');
        $file = request()->file("gallery");
        $count = count($file);
        if ($count >= 50) {
            Tiperror("一个规格只能添加50张图片！");
        }
        $data = array();
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/gallery/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/gallery/';

            foreach ($file as $key => $val) {
                $info = $val->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
                $image = Image::open($PATH . $info->getSaveName());
                $image->thumb(600, 600)->save($PATH . $info->getSaveName(), null, 80); //图片压缩
                if ($info) {
                    $gallery = '/images/goods/gallery/' . $info->getSaveName();
                    $data[] = ['goods_id' => $goods_id, 'img_big' => $gallery,
                        'img_center' => $gallery, 'img_small' => $gallery];
                } else {
                    Tiperror("图片添加失败！", $file->getError());
                }
            }
        }

        if ($data) {
            $result = $this->saveAll($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function galleryEdit() {
        $post = input('post.');
        $file = request()->file("gallery");
        $gallery = '';
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/gallery/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/gallery/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            $image = Image::open($PATH . $info->getSaveName());
            $image->thumb(600, 600)->save($PATH . $info->getSaveName(), null, 80); //图片压缩
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
        $data = ['img_big' => $gallery, 'img_center' => $gallery, 'img_small' => $gallery];
        if ($data) {
            $result = self::where(['gallery_id' => $post['gallery_id']])->update($data);
            if ($result) {
                return $gallery;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
