<?php

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Themetemplate extends Commons {

    protected $pk = 'id';
    protected $name = "themetemplate";

    public static function getThemetemplateList($where = [], $limit = 50) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['brand_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function themetemplateAddmd() {
        $post = input('post.');
        $data = [
            'template_name' => $post['template_name'], 'style_name' => $post['style_name'],
            'sort' => $post['sort'], 'is_show' => $post['is_show'], 'update_time' => time(),
        ];
        $file = request()->file("cover_address");
        if (!fileJudge("cover_address")) {
            Tiperror("图片出错或过大，图片最大为1M。");
        }
        if ($file) {
            // 移动到框架应用根目录public/static/images/themetemplate/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/templateimg');
            if ($info) {
                $data['cover_address'] = "/images/templateimg/" . $info->getSaveName();
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

    public static function themetemplateEditmd() {
        $post = input('post.');
        $file = request()->file("cover_address");
        $cover_address = $post['cover_address'];
        fileJudge("cover_address");
        if ($file) {
            // 移动到框架应用根目录public/static/images/brand/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/templateimg');
            if ($info) {
                $get_img = self::where(['id' => $post['tpl_id']])->value('cover_address');
                if (!empty($get_img)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $get_img)) {
                        unlink(ROOT_PATH . "public/static/" . $get_img);
                    }
                }
                $cover_address = "/images/templateimg/" . $info->getSaveName();
            } else {
                Tiperror("修改失败！", $file->getError());
            }
        }
        $data = [
            'id' => $post['tpl_id'],
            'template_name' => $post['template_name'], 'style_name' => $post['style_name'], 'cover_address' => $cover_address,
            'sort' => $post['sort'], 'is_show' => $post['is_show'], 'update_time' => time(),
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
