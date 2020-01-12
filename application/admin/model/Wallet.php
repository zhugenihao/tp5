<?php

/**
 * 钱包信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Wallet extends Commons {

    protected $pk = 'id';
    protected $name = "wallet";

    public static function getList($limit = 10) {
        $search = trim(input('search'));
        $where = [];
        if (!empty($search)) {
            $where['adv_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search
        ];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function Walletaddeditmd() {
        if (request()->isAjax()) {
            $post = input('post.');
            $data = [
                'wallet_name' => $post['wallet_name'],
                'wallet_url' => $post['wallet_url'],
                'sort' => $post['sort'],
                'is_show' => $post['is_show'],
                'create_time' => time(),
            ];
            $file = request()->file("wallet_images");
            if ($file) {
                // 移动到框架应用根目录public/static/images/advert/ 目录下
                $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/wallet');
                if ($info) {
                    $infos = self::where(['id' => $post['id']])->find();
                    if (!empty($infos['wallet_images'])) {
                        if (file_exists(ROOT_PATH . "public" . $infos['wallet_images'])) {
                            unlink(ROOT_PATH . "public" . $infos['wallet_images']);
                        }
                    }
                    $data['wallet_images'] = '/static/images/wallet/' . $info->getSaveName();
                } else {
//                echo $file->getError();
                    return false;
                }
            }

            if ($data) {
                if ($post['id']) {
                    $result = self::where(['id' => $post['id']])->update($data);
                } else {
                    $result = self::insert($data);
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

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function walletDelete() {
        $post = input('post.');
        $id_arr = explode(",", $post['idstr']);
        if (empty($post['idstr'])) {
            Tiperror("您未选择！");
        }
        foreach ($id_arr as $val) {
            $wallet_images = self::getValue(['id' => $val], 'wallet_images');
            if (!empty($wallet_images)) {
                if (file_exists(ROOT_PATH . "public" . $wallet_images)) {
                    unlink(ROOT_PATH . "public" . $wallet_images);
                }
            }
        }
        $result = self::destroy($id_arr);
        $ret = !empty($result) ? true : false;
        return $ret;
    }

}
