<?php

namespace app\admin\model;
use app\admin\model\Commons;
use \think\Db;
class Brand extends Commons {

    protected $pk = 'id';
    protected $name = "Brand";

    public static function getBrandList($where = [],$limit = 50) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['brand_name'] = array('like',"%".$search."%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function brandAddmd() {
        $post = input('post.');
        $data = [
            'brand_name' => $post['brand_name'], 'brand_url' => $post['brand_url'], 'sort' => $post['sort'], 
            'is_show' => $post['is_show'],'create_time' => time(),
        ];
        $file = request()->file("brand_logo");
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/brandimg');
            if ($info) {
                $data['brand_logo'] = "/images/brandimg/" . $info->getSaveName();
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

    public static function brandEditmd() {
        $post = input('post.');
        $file = request()->file("brand_logo");
        $brand_logo = $post['brand_logo'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/brandimg');
            if ($info) {
                $direOld = self::where(['id' => $post['brand_id']])->value('brand_logo');
                if (!empty($direOld)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $direOld)) {
                        unlink(ROOT_PATH . "public/static/" . $direOld);
                    }
                }
                $brand_logo = "/images/brandimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data = [
            'id'=>$post['brand_id'],
            'brand_name' => $post['brand_name'], 'brand_url' => $post['brand_url'], 'sort' => $post['sort'], 
            'brand_logo' => $brand_logo,'is_show' => $post['is_show'],'create_time' => time(),
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
