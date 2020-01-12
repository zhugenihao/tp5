<?php

/**
 * 广告信息
 */

namespace app\index\model;

use app\common\model\Advert as advertModel;
use \think\Db;

class Advert extends advertModel {

    public static function advertPcModifyMd($store_id = 0) {
        $post = input('post.');
        $adv1_id = isset($post['adv1_id']) ? $post['adv1_id'] : 0;
        $adv2_id = isset($post['adv2_id']) ? $post['adv2_id'] : 0;
        $adv3_id = isset($post['adv3_id']) ? $post['adv3_id'] : 0;
        $adv4_id = isset($post['adv4_id']) ? $post['adv4_id'] : 0;
        $adv5_id = isset($post['adv5_id']) ? $post['adv5_id'] : 0;
        $adv_link1 = isset($post['adv_link1']) ? $post['adv_link1'] : '';
        $adv_link2 = isset($post['adv_link2']) ? $post['adv_link2'] : '';
        $adv_link3 = isset($post['adv_link3']) ? $post['adv_link3'] : '';
        $adv_link4 = isset($post['adv_link4']) ? $post['adv_link4'] : '';
        $adv_link5 = isset($post['adv_link5']) ? $post['adv_link5'] : '';
        $advert[] = self::addImages("advert1", ['adv_id' => $adv1_id], 'dire', $store_id, $adv_link1);
        $advert[] = self::addImages("advert2", ['adv_id' => $adv2_id], 'dire', $store_id, $adv_link2);
        $advert[] = self::addImages("advert3", ['adv_id' => $adv3_id], 'dire', $store_id, $adv_link3);
        $advert[] = self::addImages("advert4", ['adv_id' => $adv4_id], 'dire', $store_id, $adv_link4);
        $advert[] = self::addImages("advert5", ['adv_id' => $adv5_id], 'dire', $store_id, $adv_link5);
        if ($advert) {
            return true;
        } else {
            return true;
        }
    }

    public static function advertMobileModifyMd($store_id = 0) {
        $post = input('post.');
        $adv1_id = isset($post['adv1_id']) ? $post['adv1_id'] : 0;
        $adv2_id = isset($post['adv2_id']) ? $post['adv2_id'] : 0;
        $adv3_id = isset($post['adv3_id']) ? $post['adv3_id'] : 0;
        $adv4_id = isset($post['adv4_id']) ? $post['adv4_id'] : 0;
        $adv5_id = isset($post['adv5_id']) ? $post['adv5_id'] : 0;
        $adv_link1 = isset($post['adv_link1']) ? $post['adv_link1'] : '';
        $adv_link2 = isset($post['adv_link2']) ? $post['adv_link2'] : '';
        $adv_link3 = isset($post['adv_link3']) ? $post['adv_link3'] : '';
        $adv_link4 = isset($post['adv_link4']) ? $post['adv_link4'] : '';
        $adv_link5 = isset($post['adv_link5']) ? $post['adv_link5'] : '';
        $advert[] = self::addImages("advert1", ['adv_id' => $adv1_id], 'dire', $store_id, $adv_link1, 2);
        $advert[] = self::addImages("advert2", ['adv_id' => $adv2_id], 'dire', $store_id, $adv_link2, 2);
        $advert[] = self::addImages("advert3", ['adv_id' => $adv3_id], 'dire', $store_id, $adv_link3, 2);
        $advert[] = self::addImages("advert4", ['adv_id' => $adv4_id], 'dire', $store_id, $adv_link4, 2);
        $advert[] = self::addImages("advert5", ['adv_id' => $adv5_id], 'dire', $store_id, $adv_link5, 2);
        if ($advert) {
            return true;
        } else {
            return true;
        }
    }

    public static function addImages($fileNmae = '', $where = [], $value = '', $store_id, $adv_link, $device_type = 1) {
        $post = input('post.');

        $images = isset($post[$fileNmae]) ? $post[$fileNmae] : '';

        $file_image = request()->file($fileNmae);
        if ($file_image) {
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/advertimg';
            $info = $file_image->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $get_img = self::where($where)->value($value);
                if (!empty($get_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_img);
                    }
                }
                $images = "/images/advertimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file_image->getError());
            }
        }
        $data = ['dire' => $images, 'adv_link' => $adv_link];
        if ($data) {
            if ($where['adv_id']) {
                $result = self::where($where)->update($data);
            } else {
                $data['store_id'] = $store_id;
                $data['adt_mark'] = $fileNmae;
                $data['ad_types'] = 1;
                $data['device_type'] = $device_type;
                $result = self::create($data);
            }
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
