<?php

/**
 * 管理员信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Users;
use app\admin\model\Backgroundsection as backgroundsectionModel;
use \think\Db;
use app\admin\model\Permissions as permissionsModel;
use app\admin\model\Modulepermissions as modulepermissionsModel;
use think\cache;

class User extends Common {

    public function user_list() {
        $limit = 10;
        $User = new Users();
        $list = $User->getUserlist($limit);
        $this->assign('datemin', input('datemin'));
        $this->assign('datemax', input('datemax'));
        $this->assign('search', input('search'));
        $this->assign('list', $list['list']);
        $this->assign('allcount', $list['count']);
        $this->assign('limit', $limit);
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    /**
     * 后台所有菜单列表
     */
    public function user_menu() {

        $User = new Users();

        $page = input('get.page');
        $search = input('search');
        $oneid = input('oneid');
        $result = cache::get('menus' . $page . $search . $oneid);
        if (empty($result)) {
            $result = $User->user_menu_list();
            cache::set('menus' . $page . $search . $oneid, $result);
        }
        $usermenulistOne = Users::user_menu_listOne();
        $this->assign("usermenulistOne", $usermenulistOne);
        $this->assign("menus", $result['list']);
        $this->assign("allcount", $result['count']);
        $this->assign('page', $result['page']);
        return $this->fetch();
    }

    public function module_permissions() {
        $input = input('get.');
        $list = backgroundsectionModel::getPidlist(0);
        foreach ($list as $key => $val) {
            $list[$key]['state'] = modulepermissionsModel::getValue(['bgs_id' => $val['id'], 'user_id' => $input['u_id']], 'state');
            $list[$key]['pidlist'] = backgroundsectionModel::getPidlist($val['id']);
            foreach ($list[$key]['pidlist'] as $pidkey => $pidval) {
                $list[$key]['pidlist'][$pidkey]['state'] = modulepermissionsModel::getValue(['bgs_id' => $pidval['id'], 'user_id' => $input['u_id']], 'state');
            }
        }
//        print_r($list);
        $this->assign("list", $list);
        $this->assign("user_id", $input['u_id']);
        return $this->fetch();
    }

    /**
     * 检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param $privData
     * @return bool
     */
    private function _isChecked($menu, $privData) {
        $app = $menu['app'];
        $model = $menu['controller'];
        $action = $menu['action'];
        $name = strtolower("$app/$model/$action");
        if ($privData) {
            if (in_array($name, $privData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param array $array
     * @param int $i
     * @return int
     */
    protected function _getLevel($id, $array = [], $i = 0) {
        if ($array[$id]['parent_id'] == 0 || empty($array[$array[$id]['parent_id']]) || $array[$id]['parent_id'] == $id) {
            return $i;
        } else {
            $i++;
            return $this->_getLevel($array[$id]['parent_id'], $array, $i);
        }
    }

    /**
     * 后台菜单添加
     */
    public function user_menu_add() {
        $input = input('post.');
        $um_id = input('um_id');
        $secondary = input('secondary'); //添加次级
        $User = new Users();
        $selectCategory = $User->user_menu_list();
        $this->assign("select_category", $selectCategory['result']);

        $info = $User->user_menu_info($um_id);
        if (empty($secondary)) {
            $this->assign("info", $info);
            $this->assign("parent_id", $info['parent_id']);
        } else {
            $this->assign("parent_id", $info['id']);
        }

        if ($this->request->isPost()) {
            $data = [
                'name' => $input['name'],
                'instructions' => $input['instructions'],
                'app' => $input['app'],
                'controller' => $input['controller'],
                'action' => $input['action'],
                'param' => $input['param'],
                'remark' => $input['remark'],
                'status' => $input['status'],
                'parent_id' => $input['ums_id'],
                'list_order' => $input['list_order'],
            ];
            if ($data) {
                $fpid = Db::name('user_menu')->where(['id' => $input['ums_id']])->value("fpid");
                if ($um_id && !$secondary) {
                    if ($input['fpid']) {
                        $data['fpid'] = $input['fpid'];
                    } else {
                        $data['fpid'] = $fpid + 1;
                    }
                    $result = Db::name('user_menu')->where(['id' => $um_id])->update($data);
                } else {

                    $data['fpid'] = $fpid + 1;
                    $result = Db::name('user_menu')->insert($data);
                }

                if ($result) {
                    Tobesuccess("操作节点成功");
                } else {
                    Tiperror("操作节点失败");
                }
            }
        }

        return $this->fetch();
    }

    //节点删除
    public function umdetel() {
        $user_menu = Db::name('user_menu');
        if (request()->isAjax()) {
            $idstr = input('idstr');
            $id_arr = explode(",", $idstr);
            foreach ($id_arr as $val) {
                $infoCount = $user_menu->where(['fpid' => $val])->count();
                if ($infoCount > 0) {
                    Tiperror("你选择的权限还有子权限！");
                }
            }
            $res = $user_menu->where(['id' => ['in', $idstr]])->delete();
            if ($res) {
                Tobesuccess('删除成功,请更新缓存！');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function user_role() {
        $role = Db::name('role');
        $count = $role->count();
        $data = $role->order(["list_order" => "ASC", "id" => "ASC"])->select();
        $this->assign('allcount', $count);
        $this->assign('list', $data);
        return $this->fetch();
    }

    public function user_role_add() {
        $roleid = input('role_id');
        $userMenu = db::name('user_menu');
        $Info = Db::name('role')->where('id', $roleid)->find();
        $this->assign('Info', $Info);
        $userMenuRole = $userMenu->where(['status' => 1])->select();
        $userMenuRoleIs = array();
        foreach ($userMenuRole as $key => $val) {
            $name = strtolower("{$val['app']}/{$val['controller']}/{$val['action']}");
            $userMenuRoleIs[$val['id']] = db::name("auth_access")->where(['role_name' => $name])->count();
        }
        $user_menu = $userMenu->where(['status' => 1, 'parent_id' => 0])->order(['list_order' => 'asc', "id" => "ASC"])->select();
        $userMenuList = $this->userMenuList($user_menu, 0);
//        print_R($userMenuList);
        $this->assign('userMenuRoleIs', $userMenuRoleIs);
        $this->assign('user_menu', $userMenuList);
        if ($this->request->isPost()) {
            $input = input('post.');
            $data = [
                'name' => $input['name'],
                'remark' => $input['remark'],
                'status' => $input['status'],
            ];
            if ($data || $_POST['menuId']) {
                if ($roleid) {

                    if ($roleid == 1) {
                        Tiperror("超级管理员角色不能被修改！");
                    }
                    $result = Db::name('role')->where(['id' => $roleid])->update($data);
                    $this->authorizePost(); //角色授权
                } else {
                    $result = Db::name('role')->insert($data);
                }

                if (!$result) {
                    Tiperror("操作角色失败");
                } else {
                    Tobesuccess("成功角色");
                }
            }
        }
        return $this->fetch();
    }

    public function userMenuList($list = array(), $parent_id = 0, $level = 1) {
        $userMenu = db::name('user_menu');
        foreach ($list as $key => $val) {
            $val['fpid'] = $level;
            if ($val['parent_id'] == $parent_id) {
                $list2 = $userMenu->where(['parent_id' => $val['id']])->order(['list_order' => 'asc', 'id' => 'asc'])->select();
                $list[$key]['user_menu' . $level] = $this->userMenuList($list2, $val['id'], $level + 1);
            }
        }
        return $list;
    }

    /**
     * 角色授权提交
     */
    public function authorizePost() {
        $roleId = $this->request->param("role_id", 0, 'intval');
        if (!$roleId) {
            Tiperror("需要授权的角色不存在!");
        }
        if (is_array($this->request->param('menuId/a')) && count($this->request->param('menuId/a')) > 0) {
            //先删除后插入
            // print_r($roleId);die();
            Db::name("authAccess")->where(["role_id" => $roleId, 'type' => 'admin_url'])->delete();
            foreach ($_POST['menuId'] as $menuId) {
                $menu = Db::name("userMenu")->where(["id" => $menuId])->field("app,controller,action")->find();
                if ($menu) {
                    $app = $menu['app'];
                    $model = $menu['controller'];
                    $action = $menu['action'];
                    $name = strtolower("$app/$model/$action");
                    Db::name("authAccess")->insert(["role_id" => $roleId, "role_name" => $name, 'type' => 'admin_url']);
                }
            }

            // $this->success("授权成功！");
            Tobesuccess("授权成功！");
        } else {
            //当没有数据时，清除当前角色授权
            Db::name("authAccess")->where(["role_id" => $roleId])->delete();
            Tiperror("没有接收到数据，执行清除授权成功！");
        }
    }

    /**
     * 删除角色
     */
    public function roleDelete() {
        if ($this->request->isPost()) {
            $roleid = input('role_id');
            if ($roleid == 1) {
                Tiperror("超级管理员角色不能被删除！");
            }
            $count = Db::name('RoleUser')->where(['role_id' => $roleid])->count();
            if ($count > 0) {
                Tiperror("该角色已经有用户！");
            } else {
                $status = Db::name('role')->delete($roleid);
                if (!empty($status)) {
                    Tobesuccess("删除成功！");
                } else {
                    Tiperror("删除失败！");
                }
            }
        }
    }

    public function user_add() {
        $Users = new Users();
        $input = input('post.');
        $uid = input('u_id');
        $Info = $Users->getUserInfo($uid);
        $this->assign('Info', $Info);

        $roles = Db::name('role')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("roles", $roles);

        if (request()->isPost()) {
            $password = trim($input['password']);
            $salt = mt_rand(0, 999) . substr(time(), -4);
            $data = ['name' => $input['name']];
            $role_ids = $this->request->param('role_id/a');
            unset($_POST['role_id']);
            if ($data) {
                if ($uid) {
                    $passwords = $input['passwords'];
                    $datas = [
                        'id' => $uid,
                        'password' => md5(md5($Info['salt']) . md5($passwords)),
                    ];
                    // print_r($Info['salt']);die();
                    $passwords = Users::get($datas);
                    $roleids = permissionsModel::role_users2(['user_id' => session('user_id')]);
                    if (!$passwords && $roleids['role_id'] != '1') {
                        Tiperror("旧的密码不正确！");
                    }
                    if ($password != '') {
                        $data['salt'] = $salt;
                        $data['password'] = md5(md5($salt) . md5($password));
                    }
                    Users::where('id', $uid)->update($data);
                    $this->security($role_ids, $uid);
                } else {
                    $name = Users::get(['name' => trim($input['name'])]);
                    if ($name) {
                        Tiperror("管理员名称已存在");
                    }
                    $data['create_time'] = time();
                    $data['u_ip'] = request()->ip();
                    $data['state'] = 1;
                    $User = Users::create($data);
                    $uid = $User->id;
                    $this->security($role_ids, $uid);
                }


                Tobesuccess('操作成功', $uid);
            } else {
                Tiperror("操作失败");
            }
        }
        return $this->fetch();
    }

    public function security($role_ids, $uid) {
        $user_id = session('user_id');
        $role_user = Db::name('role_user')->where(['user_id' => $user_id])->find();
        if ($role_ids) {
            foreach ($role_ids as $role_id) {
                if ($role_user['role_id'] != 1 && $role_id == 1) {
                    Tiperror("为了网站的安全，非网站创建者不可创建超级管理员！");
                }
                DB::name("RoleUser")->where(["user_id" => $uid])->delete();
                DB::name("RoleUser")->insert(["role_id" => $role_id, "user_id" => $uid]);
            }
        }
    }

    public function userdetel() {
        if ($this->request->isAjax()) {
            $idStr = input('idstr');
            $idArr = explode(",", $idStr);
            if (empty($idStr)) {
                Tiperror("您未选择！");
            }
            $result = Users::destroy($idArr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function disable() {
        $uid = input("u_id");
        $Users = new Users();
        $Info = $Users->getUserInfo($uid);
        $Users = Users::get($uid);
        if ($Info['state'] == '1') {
            $Users->state = '0';
        } else {
            $Users->state = '1';
        }
        $res = $Users->save();
        if ($res) {
            Tobesuccess('操作成功', $Info);
        } else {
            Tiperror("操作失败");
        }
    }

}
