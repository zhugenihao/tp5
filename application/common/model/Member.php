<?php

/**
 * 用户信息
 */

namespace app\common\model;

use \think\Exception;
use \think\Image;
use app\common\model\Commons;
use app\common\model\CouponReceive as CouponReceiveModel;
use app\common\model\Givealike as givealikeModel;
use app\common\model\WatchHistory as watchHistoryModel;
use app\common\model\Collection as collectionModel;
use app\common\model\OrderGoods as orderGoodsModel;

class Member extends Commons {

    protected $pk = 'id';
    protected $name = "member";

    public static function add($data) {
        return self::create($data);
    }

    public static function getByOpenID($openid) {
        $res = self::where("openid", "=", $openid)->find();
        return $res;
    }

    public static function getInfo($mId, $field = '*') {
        $where = ['id' => $mId, 'state' => 1, 'delete' => 1];
        $res = self::field($field)->where($where)->find();
        $res['coupon_count'] = CouponReceiveModel::getCount(['m_id' => $mId]); //获取用户优惠券列表
        $res['givealike_count'] = givealikeModel::getCount(['m_id' => $mId, 'givealike' => 1]); //用户点赞数量
        $res['watch_history_count'] = watchHistoryModel::getCount(['m_id' => $mId, 'is_show' => 1]); //用户商品足迹
        $res['collection_count'] = collectionModel::getCount(['m_id' => $mId, 'is_show' => 1]); //用户商品足迹
        $res['orderSecondsKill_count'] = orderGoodsModel::getCount(['m_id' => $mId, 'activity' => 'seconds_kill']); //用户的秒杀
        $res['orderSpellGroup_count'] = orderGoodsModel::getCount(['m_id' => $mId, 'activity' => 'spell_group']); //用户的拼团
        $res['orderComdysalesp_count'] = orderGoodsModel::getCount(['m_id' => $mId, 'activity' => 'comdysalesp']); //用户的促销订单
        return $res;
    }

    public static function getMemberInfo($where = [], $field = '*') {
        $where['state'] = 1;
        $where['delete'] = 1;
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
        $where['state'] = 1;
        $where['delete'] = 1;
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
