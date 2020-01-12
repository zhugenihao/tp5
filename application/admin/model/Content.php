<?php

/**
 * 内容信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use app\admin\model\Directory as directoryModel;
use \think\Db;

class Content extends Commons {

    protected $pk = 'id';
    protected $name = "content";

    public function getContentlist($limit) {
        $search = trim(input('search'));
        $directory_id = trim(input('directory_id'));
        $directorypid_id = trim(input('directorypid_id'));
        $where = [];
        if (!empty($search)) {
            $where['c.title'] = array('like', "%" . $search . "%");
        }
        if (!empty($directorypid_id)) {
            $where['c.directory_id'] = $directorypid_id;
        } else if (!empty($directory_id)) {
            $menuIdarr = directoryModel::get_category($directory_id);
            $menuIdstr = implode(',', $menuIdarr);
            $where['c.directory_id'] = array('in', $menuIdstr);
        }
        $map['query'] = [
            'search' => $search,
            'directory_id' => $directory_id,
        ];
        $order = ['sort' => 'asc', 'create_time' => 'desc'];
        $pre = config('DB_PREFIX');
        $join = [["{$pre}directory d", 'd.id=c.directory_id', 'LEFT']];
        $list['count'] = $this->alias('c')->join($join)->where($where)->count();
        $list['list'] = $this->alias('c')->join($join)
                        ->field("c.*,d.title as di_title")->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        $info = self::field($field)->where($where)->find();
        return $info;
    }

    public function Contentaddeditmd() {
        if (request()->isAjax()) {
            $post = input('post.');
            $id = (int) ($post['id']);
            $data = [
                'title' => $post['title'], 'directory_id' => $post['directorypid_id'], 'subtitle' => $post['subtitle'], 'content' => $post['content'],
                'seo_title' => $post['seo_title'], 'keywords' => $post['keywords'], 'details' => $post['details'], 'recommend_type' => $post['recommend_type'],
                'is_show' => $post['is_show'], 'sort' => $post['sort'], 'create_time' => time(),
            ];
            $file = request()->file("images");
            if ($file) {
                // 移动到框架应用根目录public/static/images/advert/ 目录下
                $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/content');
                if ($info) {
                    $infos = $this->where(['id' => $id])->find();
                    if (!empty($infos)) {
                        if (file_exists(ROOT_PATH . "public/static/images/content/" . $infos['images'])) {
                            unlink(ROOT_PATH . "public/static/images/content/" . $infos['images']);
                        }
                    }
                    $time = date("Ymd");
                    $data['images'] = $time . "/" . $info->getFilename();
                } else {
//                echo $file->getError();
                    return false;
                }
            }

            if ($data) {
                if ($id) {
                    $result = $this->where(['id' => $id])->update($data);
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

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getDelete() {
        $post = input('post.');
        $id_arr = explode(",", $post['idstr']);
        if (empty($post['idstr'])) {
            Tiperror("您未选择！");
        }
        foreach ($id_arr as $val) {
            $images = self::getValue(['id' => $val], 'images');
            if (!empty($images)) {
                if (file_exists(ROOT_PATH . "public" . $images)) {
                    unlink(ROOT_PATH . "public" . $images);
                }
            }
        }
        $result = self::destroy($id_arr);
        $ret = !empty($result) ? true : false;
        return $ret;
    }

}
