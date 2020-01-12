<?php

/**
 * 权限信息
 */

namespace app\admin\model;

use \think\Request;
use \think\Db;
use app\admin\model\Commons;

class Permissions extends Commons {

    //验证操作权限
    public static function permissions() {
        $user_id = session('user_id');
        $request = Request::instance();
        $app = strtolower($request->module());
        $model = uncamelize($request->controller());
        $action = $request->action();
        $name2 = "$app/$model/$action";
        $where = [
            'ru.user_id' => $user_id,
            'ac.role_name' => $name2,
        ];
        $where2 = [
            'user_id' => $user_id,
        ];
        $res = self::role_users($where);
        $res2 = self::role_users2($where2);
        $userMenuCount = db::name("user_menu")->where(['app' => $app, 'controller' => $model, 'action' => $action])->count();
//        print_r(array($app, $model, $action));
        if ((!$res && $res2['role_id'] != 1) || (in_array($res2['role_id'], array(1)) && $userMenuCount < 1)) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {//判断ajax
                Tiperror("不好意思，您无权访问！");
            } else {
                echo '<script type="text/javascript" src="/static/h-admin/lib/jquery/1.9.1/jquery.min.js"></script>
                      <script type="text/javascript" src="/static/h-admin/lib/layer/2.4/layer.js"></script>
                      <script type="text/javascript">$(function(){ 
                      layer.msg("不好意思，您无权访问！", {icon: 5}); 
                      setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                      }, 1000); 
                      })</script>';
            }
            exit();
        }
    }

    public static function role_users($where) {
        $pre = config('DB_PREFIX');
        $res = db::name("role_user")->alias('ru')
                        ->join("{$pre}auth_access ac", 'ac.role_id=ru.role_id', 'LEFT')
                        ->where($where)->find();
        return $res;
    }

    public static function role_users2($where2) {
        $res = db::name("role_user")->where($where2)->find();
        return $res;
    }

}
