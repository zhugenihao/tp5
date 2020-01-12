<?php

/**
 * 广告信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use \think\Image;

class Advert extends Commons {

    protected $pk = 'adv_id';
    protected $name = "advert";

    public static function getAdvertlist($where = [], $limit, $field = '*') {
        $search = trim(input('search'));
        $adt_mark = trim(input('adt_mark'));
        $device_type = trim(input('device_type'));
        if (!empty($search)) {
            $where['a.adv_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($adt_mark)) {
            $where['a.adt_mark'] = $adt_mark;
        }
        if (!empty($device_type)) {
            $where['a.device_type'] = $device_type;
        }
        $map['query'] = [
            'search' => $search,
            'adt_mark' => $adt_mark,
            'device_type' => $device_type,
        ];
        $order = ['sort' => 'asc', 'a.create_time' => 'desc'];
        $join = [
            ['mz_advert_type at', 'at.adt_mark=a.adt_mark', 'left'],
            ['mz_directory d', 'd.id=a.dir_id', 'left']
        ];
        $list['count'] = self::alias('a')->join($join)->where($where)->count();
        $list['list'] = self::alias('a')->field($field)->join($join)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function advertAddmd() {
        $post = input('post.');
        $data = [
            'adv_name' => $post['adv_name'], 'adv_link' => $post['adv_link'], 'sort' => $post['sort'], 'adv_show' => $post['adv_show'],
            'adt_mark' => $post['adt_mark'], 'ad_types' => $post['ad_types'], 'dir_id' => $post['dir_id'],
            'device_type' => $post['device_type'], 'create_time' => time(),
        ];
        $file = request()->file("dire");
        if ($file) {
            // 移动到框架应用根目录public/static/images/advert/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'static/images/advertimg/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($path);
            if ($info) {
                $image = Image::open($path . $info->getSaveName());
                $image->thumb(400, 400)->save($path . $info->getSaveName(), null, 80); //图片压缩
                $data['dire'] = "/images/advertimg/" . $info->getSaveName();
            } else {
                Tiperror("添加失败！", $file->getError());
            }
        }
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

    public static function advertEditmd() {
        $post = input('post.');
        $file = request()->file("dire");
        $dire = $post['dire'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/advert/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'static/images/advertimg/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($path);
            if ($info) {
                $image = Image::open($path . $info->getSaveName());
                $image->thumb(400, 400)->save($path . $info->getSaveName(), null, 80); //图片压缩
                
                $direOld = self::where(['adv_id' => $post['adv_id']])->value('dire');
                if (!empty($direOld)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $direOld)) {
                        unlink(ROOT_PATH . "public/static/" . $direOld);
                    }
                }
                $dire = "/images/advertimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data = [
            'adv_id' => $post['adv_id'], 'adv_name' => $post['adv_name'], 'adv_link' => $post['adv_link'],
            'sort' => $post['sort'], 'adv_show' => $post['adv_show'], 'dire' => $dire, 'adt_mark' => $post['adt_mark'],
            'ad_types' => $post['ad_types'], 'dir_id' => $post['dir_id'], 'device_type' => $post['device_type'],
            'create_time' => time(),
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
