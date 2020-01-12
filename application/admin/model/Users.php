<?php

/**
 * 管理员信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\common\model\CustomPage as CustomPageModel;

class Users extends Commons {

    protected $pk = 'id';
    protected $name = "user";

    //获取所有用户信息
    public function getUserlist($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        if (!empty($search)) {
            $where['u.name'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['u.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['u.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['u.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $pre = config('DB_PREFIX');
        $list['count'] = $this->alias('u')
                        ->join("{$pre}role_user ru", 'ru.user_id=u.id', 'LEFT')
                        ->join("{$pre}role r", 'r.id=ru.role_id', 'LEFT')
                        ->field("u.*,r.name as rname,ru.role_id")
                        ->where($where)->count();
        $list['list'] = $this->alias('u')
                        ->join("{$pre}role_user ru", 'ru.user_id=u.id', 'LEFT')
                        ->join("{$pre}role r", 'r.id=ru.role_id', 'LEFT')
                        ->field("u.*,r.name as rname,ru.role_id")
                        ->where($where)->order('id', 'desc')->paginate($limit, false, $map);          // 查询所有用户的所有字段资料
        return $list;   // 返回修改后的数据
    }

    //获取用户个人信息
    public function getUserInfo($uid) {
        $pre = config('DB_PREFIX');
        $info = $this->alias('u')
                        ->join("{$pre}role_user ru", 'ru.user_id=u.id', 'LEFT')
                        ->field("u.*,ru.role_id")
                        ->where("u.id", $uid)->find();
        return $info;
    }

    /**
     * 更新缓存
     * @param  $data
     * @return array
     */
    public function menuCache($data = null) {
        $Menu = Db::name('UserMenu');
        if (empty($data)) {
            $data = $Menu->order("list_order", "ASC")->column('');
            Cache::set('Menu', $data, 0);
        } else {
            Cache::set('Menu', $data, 0);
        }
        return $data;
    }

    // 分类树
    public static function unlimitedForLevel($cate, $html = '--', $pid = 0, $level = 0) {
        $arr = array();
        $user_menu = Db::name('user_menu');
        foreach ($cate as $k => $v) {
            if ($v['parent_id'] == $pid) {
                $v['fpid'] = $level + 1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $list = $user_menu->where(['parent_id' => $v['id']])->order(['list_order' => 'ASC', "id" => "ASC"])->select();
                $arr = array_merge($arr, self::unlimitedForLevel($list, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }

    public static function parentid_user_menu($id) {
        $result = Db::name('user_menu')->where(['parent_id' => $id])->select();
        return $result;
    }

    //获取指定的所有父类id
    public static function get_category($oneId) {
        $result = self::parentid_user_menu($oneId);
        $menuIdarr[] = $oneId;
        foreach ($result as $key => $val) {
            $menuIdarr[] = $val['id'];
            $result = self::parentid_user_menu($val['id']);
            if ($result) {
                $menuIdarr[] = $result['id'];
                $menuIdarr = array_merge($menuIdarr, self::get_category($val['id']));
            }
        }
        return array_unique($menuIdarr);
    }

    public function user_menu_list($limit = 15) {

        $search = trim(input('search'));
        $oneId = trim(input('oneid'));
        $user_menu = Db::name('user_menu');
        $where = [];
        $ret = 0;

        if (!empty($search) && $oneId == 0) {
            $where['instructions'] = $search;
            $ret = 1;
        }
        if (empty($search) && $oneId > 0) {

            $menuIdarr = array_filter(self::get_category($oneId));
            $menuIdstr = implode(',', $menuIdarr);
            $where['id'] = array('in', $menuIdstr);
        }
        if (!empty($search) && $oneId > 0) {
            $menuIdarr = array_filter(self::get_category($oneId));
            $menuIdstr = implode(',', $menuIdarr);
            $where['id'] = array('in', $menuIdstr);
            $where['instructions'] = $search;
            $ret = 1;
        }
        $result = $user_menu->where($where)->order(['list_order' => 'ASC', "id" => "ASC"])->select();
        $listas = self::unlimitedForLevel($result);
        $pageArray = ['search' => $search, 'oneid' => $oneId];
        $list = CustomPageModel::page($listas, $limit, $pageArray);
        if ($ret == 1) {
            $list = $result;
        }
        $result['list'] = $list['source'];
        $result['result'] = $listas;
        $result['page'] = $list['page'];
        $result['count'] = $user_menu->where($where)->count();
        return $result;
    }

    public function user_menu_info($um_id) {
        $result = Db::name('user_menu')->where(['id' => $um_id])->find();
        return $result;
    }

    public static function user_menu_listOne() {
        $result = Db::name('user_menu')->where(['fpid' => 1])->order(["list_order" => 'asc', "id" => "ASC"])->select();
        return $result;
    }

    public static function getValue($userId, $value = 'id') {
        $res = self::where(['id' => $userId])->value($value);
        return $res;
    }

}
