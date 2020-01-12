<?php

/**
 * 导航分类
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\common\model\CustomPage as CustomPageModel;

class Directory extends Commons {

    protected $pk = 'id';
    protected $name = "directory";

    public static function getList($limit = 10) {
        $search = trim(input('search'));
        $onePid = trim(input('one_pid'));
        $isNavigation = trim(input('is_navigation'));
        $where = [];
        if (!empty($search)) {
            $where['id|title'] = $search;
        }
        if (!empty($onePid)) {
//            $where['pid|id'] = $onePid;
            $dirId = self::getChildrenIds($onePid);
            $dirId .= $onePid;
            $where['id'] = ['in', $dirId];
        }
        if (!empty($isNavigation)) {
            $where['is_navigation'] = $isNavigation;
        }
        $pageArray = [
            'search'=>$search,
            'one_pid'=>$onePid,
        ];
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $getlist = self::where($where)->order($order)->select()->toArray();
        $listas = self::unlimitedForLevel($getlist);
        $list = CustomPageModel::page($listas, $limit,$pageArray);
        if (!empty($search)) {
            $list['source'] = $getlist;
        }
        $list['list'] = $list['source'];
        $list['page'] = $list['page'];
        $list['count'] = self::where($where)->count();
        return $list;
    }

    public static function getLister($where = [], $limit = 10, $field = '*') {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select()->toArray();
        $listas = self::unlimitedForLevel($list);
        return $listas;
    }

    public static function getSelectList($where = [], $limit = 10, $field = '*') {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($limit)->select()->toArray();
        return $list;
    }

    public static function getdirList() {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::order($order)->select()->toArray();
        $listas = self::unlimitedForLevel($list);
        return $listas;
    }

    public static function getInfo($id) {
        return self::where(['id' => $id])->find();
    }

    public static function directoryListOne($id = 0) {
        $where['id'] = $id;
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field('id,pid,title,sort,hierarchy')->where($where)->order($order)->limit(20)->select();
        return $list;
    }

    public static function getDirectoryList($where = [], $field = '*', $limit = 20, $start = 0) {
        $where['is_show'] = 1;
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function directoryPid($id = 0) {
        $result = self::where(['pid' => $id])->limit(20)->select();
        return $result;
    }

    //获取指定的所有父类id
    public static function get_category($id = '0') {
        $result = self::directoryPid($id);
        $menuIdarr[] = $id;
        foreach ($result as $key => $val) {
            $menuIdarr[] = $val['id'];
            $result = self::directoryPid($val['id']);
            if ($result) {
                $menuIdarr[] = $result['id'];
                $menuIdarr = array_merge($menuIdarr, self::get_category($val['id']));
            }
        }
        return array_unique($menuIdarr);
    }

    public static function directoryListOne_md($id) {
        $menuIdarr = self::get_category($id);
        $menuIdstr = implode(',', $menuIdarr);
        $where['id'] = array('in', $menuIdstr);
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $list = self::field('id,pid,title,sort,hierarchy')->where($where)->order($order)->select();
        $list = self::unlimitedForLevel($list);
        return $list;
    }

    // 分类树
    public static function unlimitedForLevel($cate, $html = '--', $pid = 0, $level = 0) {
        $arr = array();
        foreach ($cate as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['hierarchy'] = $level + 1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $order = ['sort' => 'asc', 'id' => 'asc'];
                $list = self::where(['pid' => $v['id']])->order($order)->select();
                $arr = array_merge($arr, self::unlimitedForLevel($list, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }

    public static function directory_Dddeditmd() {
        $post = input("post.");
        $data = $_POST;
        $hierarchy = self::where('id', $post['pid'])->value("hierarchy");
        $data['hierarchy'] = $hierarchy + 1;
        unset($data['language_id']);
        $file = request()->file("images");
        if ($file) {
            // 移动到框架应用根目录public/static/images/advert/ 目录下
            $directory = ROOT_PATH . 'public' . DS . 'static/images/directory';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($directory);
            if ($info) {
                $infos = self::where(['id' => $post['id']])->find();
                if (!empty($infos['images'])) {
                    if (file_exists(ROOT_PATH . 'public' . $infos['images'])) {
                        unlink(ROOT_PATH . 'public' . $infos['images']);
                    }
                }
                $data['images'] = '/static/images/directory/' . $info->getSaveName();
            } else {
//                echo $file->getError();
                return false;
            }
        }
        try {
            if ($post['id'] && !$post['hiehy']) {
                self::update($data);
            } else {
                $data['create_time'] = time();
                self::insert($data);
            }
        } catch (\Exception $e) {
            Tiperror("操作失败", $e->getMessage());
        }
        return true;
    }

    public static function template_submit_md() {
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

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->value($value);
    }

    public static function getDirLister($where = '', $field = '*', $limit = 20) {
        $result = self::field($field)->where($where)->limit($limit)->select();
        return $result;
    }

    public static function getDelete() {
        $post = input('post.');
        $id_arr = explode(",", $post['idstr']);
        if (empty($post['idstr'])) {
            Tiperror("您未选择！");
        }
        foreach ($id_arr as $val) {
            $infoCount = self::where(['pid' => $val])->count();
            if ($infoCount > 0) {
                Tiperror("你选择的分类还有子分类！");
            }
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

    //获取指定分类的所有子分类ID号
    public static function getChildrenIds($dirId) {
        $ids = '';
        $result = self::where(['pid' => $dirId])->limit(20)->select();
        if ($result) {
            foreach ($result as $key => $val) {
                $ids .= $val['id'] . ',';
                $ids .= self::getChildrenIds($val['id']);
            }
        }
        return $ids;
    }

}
