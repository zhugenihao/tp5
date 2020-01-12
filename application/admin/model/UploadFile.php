<?php

/**
 * 文件上传信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class UploadFile extends Commons {

    public function goodsImages() {
        if (request()->isAjax()) {
            $adv_id = (int) (input('adv_id'));
            $data = [
                'adv_name' => input('adv_name'),
                'adv_link' => input('adv_link'),
                'catetype' => input('catetype'),
                'goods_id' => input('goods_id'),
                'sort' => input('sort'),
                'adv_show' => input('adv_show'),
                'create_time' => time(),
            ];
            $file = request()->file("dire");
            if ($file) {
                // 移动到框架应用根目录public/static/images/advert/ 目录下
                $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/advert');
                if ($info) {
                    $infos = $this->where(['adv_id' => $adv_id])->find();
                    if (!empty($infos)) {
                        if (file_exists(ROOT_PATH . "public/static/images/advert/" . $infos['dire'])) {
                            unlink(ROOT_PATH . "public/static/images/advert/" . $infos['dire']);
                        }
                    }
                    $time = date("Ymd");
                    $data['dire'] = $time . "/" . $info->getFilename();
                } else {
//                echo $file->getError();
                    return false;
                }
            }

            if ($data) {
                if ($adv_id) {
                    $result = $this->where(['adv_id' => $adv_id])->update($data);
                } else {
                    $result = $this->insert($data);
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

}
