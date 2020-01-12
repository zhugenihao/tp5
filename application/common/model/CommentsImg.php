<?php

/**
 * 评论图片信息
 */

namespace app\common\model;

use \think\Exception;
use \think\Image;
use \think\Db;
use app\common\model\Commons;
use app\common\model\TemporaryImg as temporaryImgModel;

class CommentsImg extends Commons {

    protected $pk = 'id';
    protected $name = "comments_img";

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
    public static function getDel($where = []) {
        return self::where($where)->delete();
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    /**
     * 上传图片
     * @param type $mId
     * @return boolean
     */
    public static function submitCimg($mId) {
        $img_url = '';
        $result = false;
        $file = request()->file("comimg");
        if ($file) {
            // 移动到框架应用根目录public/static/images/comments/ 目录下
            $path = ROOT_PATH . 'public/static/images/comments/';
            $info = $file->validate(['size' => 10000000, 'ext' => 'jpg,png,gif'])->move($path);
            $image = Image::open($path . $info->getSaveName());
            $image->thumb(800, 800)->save($path . $info->getSaveName(), null, 60); //图片压缩
            if ($info) {
                $img_url = 'images/comments/' . $info->getSaveName();
            } else {
                Tiperror("上传失败", $file->getError());
            }
        }
        if ($img_url) {
            try {
                $result = temporaryImgModel::create(['m_id' => $mId, 'img_url' => $img_url]);
            } catch (\Exception $e) {
                Tiperror("出现其他异常", $e->getMessage());
            }
            if ($result) {
                return $img_url;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
