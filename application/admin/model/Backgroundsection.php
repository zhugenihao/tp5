<?php

/**
 * 后台栏目信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\common\model\CustomPage as CustomPageModel;

class Backgroundsection extends Commons {

    protected $pk = 'id';
    protected $name = "background_section";

    public static function getlist($limit = 15) {
        $search = trim(input('search'));
        $oneId = trim(input('oneid'));
        $where = [];
        if (!empty($search) && $oneId == 0) {
            $where['section_name'] = array('like', "%" . $search . "%");
        }
        if (empty($search) && $oneId > 0) {
            $menuIdarr = self::get_category($oneId);
            $menuIdstr = implode(',', $menuIdarr);
            $where['id'] = array('in', $menuIdstr);
        }
        if (!empty($search) && $oneId > 0) {
            $menuIdarr = self::get_category($oneId);
            $menuIdstr = implode(',', $menuIdarr);
            $where['id'] = array('in', $menuIdstr);
            $where['section_name'] = $search;
        }
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $getlist = self::where($where)->order($order)->select()->toArray();
        $listas = self::unlimitedForLevel($getlist);
        $pageArray = ['search' => $search, 'oneid' => $oneId];
        $list = CustomPageModel::page($listas, $limit, $pageArray);
        if (!empty($search)) {
            $list['source'] = $getlist;
        }
        $list['list'] = $list['source'];
        $list['page'] = $list['page'];
        $list['count'] = self::where($where)->count();

        return $list;
    }

    public static function getPidlist($id) {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $result = self::where(['pid' => $id])->order($order)->select()->toArray();
        return $result;
    }

    public static function getPidlister($id) {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $result = self::where(['pid' => $id, 'is_show' => 1])->order($order)->select()->toArray();
        return $result;
    }

    //获取指定的所有父类id
    public static function get_category($oneId) {
        $result = self::getPidlist($oneId);
        $menuIdarr[] = $oneId;
        foreach ($result as $key => $val) {
            $menuIdarr[] = $val['id'];
            $result = self::getPidlist($val['id']);
            if ($result) {
                $menuIdarr[] = $result['id'];
                $menuIdarr = array_merge($menuIdarr, self::get_category($val['id']));
            }
        }
        return array_unique($menuIdarr);
    }

    // 分类树
    public static function unlimitedForLevel($cate, $html = '--', $pid = 0, $level = 0) {
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

    public static function editmd() {
        $post = input('post.');
        $hierarchy = self::where(['id' => $post['pid']])->value('hierarchy');
        $hierarchy = isset($post['hierarchy']) ? $post['hierarchy'] : $hierarchy + 1;
        $data = [
            'section_name' => $post['section_name'], 'column_method' => $post['column_method'], 'parameter' => $post['parameter'],
            'sort' => $post['sort'], 'is_show' => $post['is_show'], 'small_icon' => $post['small_icon'], 'create_time' => time(),
            'hierarchy' => $hierarchy,
        ];
        $data['pid'] = $post['pid'];
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

    public static function mpSubmitMd() {
        $num = 0;
        $post = input('post.');
        $id_arr = explode(",", $post['idstr']);
        $id_arrer = explode(",", $post['idstrer']);
        $module_permissions = db::name('module_permissions');
        $idArrList = array();
        foreach ($id_arr as $idVal) {
            $idArrList[$idVal] = $idVal;
        }
        foreach ($id_arrer as $idarrVal) {
            $state = $idArrList[$idarrVal] ? 1 : 0;
            $info = $module_permissions->where(['user_id' => $post['user_id'], 'bgs_id' => $idarrVal])->find();
            if ($info['id']) {
                $res = $module_permissions->where(['user_id' => $post['user_id'], 'bgs_id' => $idarrVal])->update(['state' => $state]);
                $resas = !empty($res) ? $num++ : 0;
            } else {
                $res = $module_permissions->insert(['user_id' => $post['user_id'], 'bgs_id' => $idarrVal, 'state' => $state]);
                $resas = !empty($res) ? $num++ : 0;
            }
        }
        $ret = $num > 0 ? true : false;
        return $ret;
    }

}
