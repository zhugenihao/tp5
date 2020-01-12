<?php

/**
 * 商家信息
 */

namespace app\common\model;

use \think\Exception;
use \think\Image;
use app\common\model\Commons;

class Seller extends Commons {

    protected $pk = 'id';
    protected $name = "seller";

    public static function add($data) {
        return self::create($data);
    }

    public static function getInfo($where = [], $field = '*') {
        $where['seller_delete'] = 1;
        $res = self::field($field)->where($where)->find();
        return $res;
    }

    public static function getValue($mId, $value = 'id') {
        $res = self::where(['id' => $mId])->value($value);
        return $res;
    }

    public static function getwhereValue($where = [], $value = 'id') {
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

    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function imgUpload_md($mId) {
//        print_R($_FILES);print_R($_POST);die();
        $post = input('post.');
        $data = [
            'name' => $post['name'],
            'gender' => $post['gender'],
            'mobile' => $post['mobile'],
            'personality_lg' => $post['personality_lg'],
            'birthday' => $post['birthday'],
        ];
        $file = request()->file("file");
        if ($file) {
            // 移动到框架应用根目录public/static/images/photo/ 目录下
            $info = $file->validate(['size' => 10000000, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/photo');
            if ($info) {
                $infos = self::getInfo($mId);
                if (!empty($infos['photo'])) {
                    if (file_exists(ROOT_PATH . "public/static/images/photo/" . $infos['photo'])) {
                        unlink(ROOT_PATH . "public/static/images/photo/" . $infos['photo']);
                    }
                }
                $time = date("Ymd");
                $data['photo'] = $time . "/" . $info->getFilename();
            } else {
//                echo $file->getError();
                return false;
            }
        }

        if ($data) {
            try {
                $result = self::where(['id' => $mId])->update($data);
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
     * 上传头像
     * @param type $mId
     * @return boolean
     */
    public static function submitPhoto($mId) {
        $photo = '';
        $result = 0;
        $file = request()->file("photo");
        if ($file) {
            // 移动到框架应用根目录public/static/images/photo/ 目录下
            $path = ROOT_PATH . 'public/static/images/photo/';
            $info = $file->validate(['size' => 10000000, 'ext' => 'jpg,png,gif'])->move($path);
            $image = Image::open($path . $info->getSaveName());
            $image->thumb(400, 400)->save($path . $info->getSaveName(), null, 80); //图片压缩
            if ($info) {
                $getPhoto = self::getValue($mId, 'photo');
                $pathDel = ROOT_PATH . "public/static/";
                if (!empty($getPhoto)) {
                    if (file_exists($pathDel . $getPhoto)) {
                        unlink($pathDel . $getPhoto);
                    }
                }
                $photo = 'images/photo/' . $info->getSaveName();
            } else {
                Tiperror("上传失败", $file->getError());
            }
        }
        if ($photo) {
            try {
                $result = self::updates(['id' => $mId], ['photo' => $photo]);
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
