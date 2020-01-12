<?php
/**
 * 系统配置信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Systems extends Commons {

    public function getLoginredlist($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $where = [];
        if (!empty($search)) {
            $where['user_name|login_ip'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['create_time'] = ['between', [$datemin, $datemax]];
        }
//        print_r($where);die();
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $loginred = db::name("loginred");
        $list['count'] = $loginred->where($where)->count();
        $list['list'] = $loginred->where($where)->order('create_time', 'desc')->paginate($limit, false, $map);
        return $list;
    }

    public function getsystem_baseInfo() {
        $info = db::name("system_base")->where("id", 1)->find();
        return $info;
    }

    public function system_baseUpdatemd() {
        $data = $_POST;
        $file = request()->file("images");
        if ($file) {
            // 移动到框架应用根目录public/static/images/advert/ 目录下
            $path = ROOT_PATH . 'public' . DS . 'static/images/logo/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($path);
            if ($info) {
                $infos = db::name("system_base")->where(['id' => 1])->find();

                if (!empty($infos['logo_images'])) {
                    if (file_exists(ROOT_PATH .'public/static/'. $infos['logo_images'])) {
                        unlink(ROOT_PATH .'public/static/'. $infos['logo_images']);
                    }
                }
                $data['logo_images'] = '/images/logo/' . $info->getSaveName();
            } else {
//                echo $file->getError();
                return false;
            }
        }
        $res = Db::name("system_base")->where(['id' => 1])->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function getDirectorylist() {
        $search = trim(input('search'));
        $where = [];
        if (!empty($search)) {
            $where['id|title'] = $search;
        }
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $directory = db::name("directory");
        $list = $directory->where($where)->order($order)->select();
        $list['list'] = $this->unlimitedForLevel($list);
        $list['count'] = $directory->where($where)->count();
        return $list;
    }

    public function directoryListOne() {
        $directory = db::name("directory");
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = $directory->where('pid', '0')->field('id,pid,title')->order($order)->select();
        return $list;
    }

    // 分类树
    function unlimitedForLevel($cate, $html = '--', $pid = 0, $level = 0) {
        $arr = array();
        foreach ($cate as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['hierarchy'] = $level + 1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }

    public function directory_Dddeditmd() {
        $post = input("post.");
        $id = (int) $post['id'];
        $hiehy = (int) $post['hiehy'];
        $pid = (int) $post['pid'];
        $data = $_POST;
        $directory = Db::name("directory");
        $hierarchy = $directory->where('id', $pid)->value("hierarchy");
        $data['hierarchy'] = $hierarchy + 1;
//        print_r($data);die();
        try {
            if ($id && !$hiehy) {
                $directory->update($data);
            } else {
                $data['create_time'] = time();
                $directory->insert($data);
            }
        } catch (\Exception $e) {
            Tiperror("操作失败", $e->getMessage());
        }
        Tobesuccess("操作成功");
    }

    public function block_wordUpdatemd() {
        $data = $_POST;
        $data['upload_time'] = time();
        $res = Db::name("block_word")->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function template_submit_md() {
        $post = input('post.');
        $template_list = Db::name("template_list");
        $data = ['create_time' => time(), 'tmp_type' => $post['tmp_type'], 'tmp_name' => $post['tmp_name']];
        if ($post['id']) {
            $res = $template_list->where('id', $post['id'])->update($data);
        } else {
            $res = $template_list->insert($data);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
