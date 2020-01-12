<?php

/**
 * 品牌信息
 */

namespace app\index\model;

use app\common\model\Store as storeModel;
use \think\Db;

class Store extends storeModel {

    public static function storeModifyMd() {
        $post = input('post.');
        $file_logo = request()->file("logo");
        $file_banner = request()->file("banner");
        $file_image = request()->file("image");
        $logo = $post['logo'];
        $banner = $post['banner'];
        $image = $post['image'];
        if ($file_logo) {
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/store/logo';
            $info = $file_logo->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $get_img = self::where(['id' => $post['store_id']])->value('logo');
                if (!empty($get_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_img);
                    }
                }
                $logo = "/images/store/logo/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file_logo->getError());
            }
        }
        if ($file_banner) {
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/store/banner';
            $info = $file_banner->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $get_img = self::where(['id' => $post['store_id']])->value('banner');
                if (!empty($get_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_img);
                    }
                }
                $banner = "/images/store/banner/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file_banner->getError());
            }
        }
        if ($file_image) {
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/store/image';
            $info = $file_image->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $get_img = self::where(['id' => $post['store_id']])->value('image');
                if (!empty($get_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_img);
                    }
                }
                $image = "/images/store/image/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file_image->getError());
            }
        }

        $data = [
            'id' => $post['store_id'],
            'store_name' => $post['store_name'], 'main_products' => $post['main_products'], 'logo' => $logo,
            'banner' => $banner, 'image' => $image, 'head_qq' => $post['head_qq'], 'head_mobile' => $post['head_mobile'],
            'email' => $post['email'], 'store_address' => $post['store_address'], 'inventory_warning' => $post['inventory_warning'],
            'pm_quota' => $post['pm_quota'], 'seo_keyword' => $post['seo_keyword'], 'seo_description' => $post['seo_description'],
        ];
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

}
