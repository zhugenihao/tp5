<?php

/**
 * 公共模型信息
 */

namespace app\admin\controller;

use think\Controller;
use think\Paginator;
use \think\Request;
use \think\Exception;
use think\Db;
use think\Cache;
use app\admin\model\Permissions;
use app\admin\model\Systems;
use app\admin\model\Backgroundsection as backgroundsectionModel;
use app\common\model\BesidesContent as besidesContentModel;
use app\admin\model\Users;

class Common extends Controller {

    public $user_id = '';
    public $user_name = '';

    public function _initialize() {
        $this->user_id = session('user_id');
        $this->user_name = session('user_name');
        $this->check_session();
        $this->permissions();
        $this->roleids();
        $this->rolename();
        $this->srcerrorUrl();
        $this->_menu();
        $this->backgroundsectionList();
        
    }

    public function backgroundsectionList() {
        $this->backgroundsectionLister();
        $get = input('get.');
        $backgroundsection = backgroundsectionModel::getlist(1);
        $pid0 = $backgroundsection['list'][0]['id'];
        $pid = isset($get['id']) ? $get['id'] : $pid0;
        //读取目录缓存
        $list = Cache::get('backgroundsectionList' . $pid);
        if (empty($list)) {
            $list = backgroundsectionModel::getPidlister($pid);
            //设置目录缓存
            Cache::set('backgroundsectionList' . $pid, $list);
        }
        $module_permissions = db::name('module_permissions');
        $listas = array();
        $roleids = Permissions::role_users2(['user_id' => $this->user_id]);
        foreach ($list as $key => $val) {
            $module_permissions_info = $module_permissions->where(['user_id' => $this->user_id, 'bgs_id' => $val['id'], 'state' => 1])->find();
            if ($module_permissions_info || $roleids['role_id'] == 1) {
                $is_href = 0;
                $listas[$key] = $val;
                $listas[$key]['backgroundsectionPidList2'] = backgroundsectionModel::getPidlister($val['id']);
                foreach ($listas[$key]['backgroundsectionPidList2'] as $key2 => $val2) {
                    $module_permissions_info2 = $module_permissions->where(['user_id' => $this->user_id, 'bgs_id' => $val2['id'], 'state' => 1])->find();
                    if ($module_permissions_info2 || $roleids['role_id'] == 1) {
                        $listas[$key]['backgroundsectionPidList'][] = $val2;
                    }
                }
                if ($listas[$key]['backgroundsectionPidList2']) {
                    $listas[$key]['is_href'] = 1;
                }
                unset($listas[$key]['backgroundsectionPidList2']);
            }
        }


        $this->assign('bgsId', $pid);
        $this->assign('backgroundsectionList', $listas);
        $small_icon = besidesContentModel::small_icon_list();
        $this->assign('small_icon', $small_icon);
    }

    public function backgroundsectionLister($pid = 0) {
        //读取目录缓存
        $list = Cache::get('backgroundsectionLister');
        if (empty($list)) {
            //设置目录缓存
            Cache::set('backgroundsectionLister', $list);
        }
        $list = array();
        $module_permissions = db::name('module_permissions');
        $roleids = Permissions::role_users2(['user_id' => $this->user_id]);
        $backgroundsectionPidList = backgroundsectionModel::getPidlister($pid);
        foreach ($backgroundsectionPidList as $key => $val) {
            $module_permissions_info = $module_permissions->where(['user_id' => $this->user_id, 'bgs_id' => $val['id'], 'state' => 1])->find();
            if ($module_permissions_info || $roleids['role_id'] == 1) {
                $list[$key] = $val;
            }
        }

        $this->assign('backgroundsectionLister', $list);
    }

    //无图片显示的图片
    public function srcerrorUrl() {
        $errUrl = "h-admin/static/h-ui/images/ucnter/avatar-default-S.gif";
        $errUrl2 = "images/error.png";
        $this->assign('errUrl', $errUrl);
        $this->assign('errUrl2', $errUrl2);
    }

    public function check_session() {
        $user_id = session('user_id');
        $user_name = session('user_name');
        $user_type = session('user_type');
        $user = Users::where(['id'=>$user_id])->find();
        $this->assign("user", $user);
        $this->assign("user_id", $user_id);
        $this->assign("user_name", $user_name);
        $this->assign("user_type", $user_type);
        if (empty($user_id) || empty($user_name) || ($user_type != '1')) {
            $this->redirect('Login/login');
        }
    }

    public function publics() {
        return $this->fetch();
    }

    public function welcome() {

        return $this->fetch();
    }

    public function rolename() {
        $adid = session('user_id');
        $where3['ru.user_id'] = $adid;
        $pre = config('DB_PREFIX');
        $res = db::name("role_user")->alias('ru')
                        ->join("{$pre}role r", 'r.id=ru.role_id', 'LEFT')
                        ->where($where3)->find();

        $this->assign("rolename", $res['name']);
    }

    public function roleids() {

        $adid = session('user_id');
        $roleids = Permissions::role_users2(['user_id' => $adid]);

        $this->assign("roleids", $roleids['role_id']);
    }

    public function permissions() {
        Permissions::permissions();
    }

    public function _menu() {
        $Systems = new Systems();
        $directory_list = $Systems->directoryListOne();
        $this->assign("directory_list", $directory_list);
    }

    /**
     * 更新缓存
     */
    public function updatesCache() {
        if ($this->request->isAjax()) {
            Cache::clear(); //清除缓存
            Tobesuccess("更新缓存成功");
        }
    }

    /**
     * 获取模板文件名
     * @param type $directory
     * @return string
     */
    public function template_files_list($directory = '') {
        $file_array = scandir_list(PUBLIC_TPL . $directory);
        $file_list = array();
        foreach ($file_array as $val) {
            if ($val != 'public') {
                $listfile = scandir_list(PUBLIC_TPL . $directory . $val);
                foreach ($listfile as $key1 => $val1) {
                    $file_list[] = $val . '/' . $val1;
                }
            }
        }
        return $file_list;
    }

}
