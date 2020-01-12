<?php

/**
 * 用户信息
 */

namespace app\admin\model;

use \think\Exception;
use \think\Image;
use app\admin\model\Commons;

class SellerQualification extends Commons {

    protected $pk = 'id';
    protected $name = "seller_qualification";

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        $res = self::field($field)->where($where)->find();
        return $res;
    }

    public static function getValue($where = [], $value = 'id') {
        $res = self::where($where)->value($value);
        return $res;
    }

    public static function getList($where = [], $field = '*') {
        $res = self::field($field)->where($where)->order("id", 'desc')->select();
        return $res;
    }

    public static function updates($where = [], $data = []) {
        $res = self::where($where)->update($data);
        return $res;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    /**
     * 添加数据
     * @param type $mId
     * @return boolean
     */
    public static function addMd($mId) {
        $post = input('post.');

        $business_attachment = '';
        $trc_copy = '';
        $koc_copy = '';
        $panlpicop_copy = '';
        $shoticcot_front = '';
        $file_list = request()->file("file");
        if ($file_list) {
            // 移动到框架应用根目录public/static/images/photo/ 目录下
            $path = ROOT_PATH . 'public/static/images/qualification/';
            foreach ($file_list as $file_key => $file_val) {
                $info = $file_val->validate(['size' => 10000000, 'ext' => 'jpg,png,gif'])->move($path);
                $image = Image::open($path . $info->getSaveName());
                $image->thumb(400, 400)->save($path . $info->getSaveName(), null, 80); //图片压缩
                if ($info) {
                    if ($file_key === 0) {
                        $business_attachment = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 1) {
                        $trc_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 2) {
                        $koc_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 3) {
                        $panlpicop_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 4) {
                        $shoticcot_front = 'images/qualification/' . $info->getSaveName();
                    }
                } else {
                    Tiperror("上传失败", $file_val->getError());
                }
            }
        }
        $data = [
            'business_attachment' => $business_attachment,
            'trc_copy' => $trc_copy,
            'koc_copy' => $koc_copy,
            'panlpicop_copy' => $panlpicop_copy,
            'shoticcot_front' => $shoticcot_front,
            'member_id' => $mId,
            'card_or_passport' => $post['card_or_passport'],
            'store_card' => $post['store_card'],
            'create_time' => time(),
        ];

        if ($data) {
            try {
                $result = self::create($data);
            } catch (\Exception $e) {
                Tiperror("出现其他异常", $e->getMessage());
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

    /**
     * 修改数据
     * @param type $mId
     * @return boolean
     */
    public static function updatesMd($where = []) {
        $post = input('post.');

        $business_attachment = $post['business_attachment'];
        $trc_copy = $post['trc_copy'];
        $koc_copy = $post['koc_copy'];
        $panlpicop_copy = $post['panlpicop_copy'];
        $shoticcot_front = $post['shoticcot_front'];
        $file_list = request()->file("file");
        if ($file_list) {
            // 移动到框架应用根目录public/static/images/photo/ 目录下
            $path = ROOT_PATH . 'public/static/images/qualification/';
            foreach ($file_list as $file_key => $file_val) {
                $info = $file_val->validate(['size' => 10000000, 'ext' => 'jpg,png,gif'])->move($path);
                $image = Image::open($path . $info->getSaveName());
                $image->thumb(400, 400)->save($path . $info->getSaveName(), null, 80); //图片压缩
                if ($info) {
                    if ($file_key === 0) {
                        $qualification = self::getValue($where, 'business_attachment');
                        $business_attachment = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 1) {
                        $qualification = self::getValue($where, 'trc_copy');
                        $trc_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 2) {
                        $qualification = self::getValue($where, 'koc_copy');
                        $koc_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 3) {
                        $qualification = self::getValue($where, 'panlpicop_copy');
                        $panlpicop_copy = 'images/qualification/' . $info->getSaveName();
                    } elseif ($file_key === 4) {
                        $qualification = self::getValue($where, 'shoticcot_front');
                        $shoticcot_front = 'images/qualification/' . $info->getSaveName();
                    }
                    $pathDel = ROOT_PATH . "public/static/";
                    if (!empty($qualification)) {
                        if (file_exists($pathDel . $qualification)) {
                            unlink($pathDel . $qualification);
                        }
                    }
                } else {
                    Tiperror("上传失败", $file_val->getError());
                }
            }
        }
        $data = [
            'business_attachment' => $business_attachment,
            'trc_copy' => $trc_copy,
            'koc_copy' => $koc_copy,
            'panlpicop_copy' => $panlpicop_copy,
            'shoticcot_front' => $shoticcot_front,
            'card_or_passport' => $post['card_or_passport'],
            'store_card' => $post['store_card'],
            'create_time' => time(),
        ];

        if ($data) {
            try {
                $result = self::where($where)->update($data);
            } catch (\Exception $e) {
                Tiperror("出现其他异常", $e->getMessage());
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
