<?php
/**
 * 支付方式信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use \think\Image;

class Payment extends Commons {

    protected $pk = 'id';
    protected $name = "payment";

    public static function getPaymentlist($limit, $field = '*', $where = []) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['cat_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function Add() {
        $post = input('post.');
        $file = request()->file("payment_img");
        $payment_img = $post['payment_img'];
        if ($file && $payment_img == '') {
            // 移动到框架应用根目录public/static/images/category/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/payment/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            $image = Image::open($PATH . $info->getSaveName());
            $image->thumb(800, 800)->save($PATH . $info->getSaveName(), null, 60); //图片压缩
            if ($info) {
                $payment_img = '/images/payment/' . $info->getSaveName();
            } else {
                Tiperror("支付方式添加失败！", $file->getError());
            }
        }
        $data = [
            'payment_name' => $post['payment_name'], 'payment_mark' => $post['payment_mark'], 'payment_img' => $payment_img,
            'app_id' => $post['app_id'], 'app_secret' => $post['app_secret'], 'merchants_id' => $post['merchants_id'],
            'merchants_key' => $post['merchants_key'], 'merchants_account' => $post['merchants_account'], 'sort' => $post['sort'],
            'is_show' => $post['is_show'], 'small_icon' => $post['small_icon'], 'create_time' => time(),
        ];
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

    public static function updates() {
        $post = input('post.');
        $file = request()->file("payment_img");
        $payment_img = $post['payment_img'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/category/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/payment/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            $image = Image::open($PATH . $info->getSaveName());
            $image->thumb(800, 800)->save($PATH . $info->getSaveName(), null, 60); //图片压缩
            if ($info) {
                $payment_img = self::where('id', $post['id'])->value('payment_img');
                if ($payment_img) {
                    if (file_exists(ROOT_PATH . "public/static/" . $payment_img)) {
                        unlink(ROOT_PATH . "public/static/" . $payment_img);
                    }
                }
                $payment_img = '/images/payment/' . $info->getSaveName();
            } else {
                Tiperror("支付方式修改失败！", $file->getError());
            }
        }
        $data = [
            'id' => $post['id'],
            'payment_name' => $post['payment_name'], 'payment_mark' => $post['payment_mark'], 'payment_img' => $payment_img,
            'app_id' => $post['app_id'], 'app_secret' => $post['app_secret'], 'merchants_id' => $post['merchants_id'],
            'merchants_key' => $post['merchants_key'], 'merchants_account' => $post['merchants_account'], 'sort' => $post['sort'],
            'is_show' => $post['is_show'], 'small_icon' => $post['small_icon'],
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
