<?php

/**
 * 商家菜单信息
 */

namespace app\admin\model;

use app\common\model\SellerMenu as SellerMenuModel;
use \think\Db;

class SellerMenu extends SellerMenuModel {

    public static function getPidlist($id) {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $result = self::where(['pid' => $id])->order($order)->limit(50)->select()->toArray();
        return $result;
    }

    public static function getPidlister($id) {
        $order = ['sort' => 'asc', 'id' => 'asc'];
        $result = self::where(['pid' => $id, 'is_show' => 1])->order($order)->select()->toArray();
        return $result;
    }

    public static function addMd() {
        $post = input('post.');
        $hierarchy = self::where(['id' => $post['pid']])->value('hierarchy');
        $hierarchy = !empty($hierarchy) ? $hierarchy + 1 : 1;
        $data = [
            'menu_name' => $post['menu_name'], 'methods' => $post['methods'], 'parameter' => $post['parameter'],
            'sort' => $post['sort'], 'is_show' => $post['is_show'], 'small_icon' => $post['small_icon'], 'create_time' => time(),
            'hierarchy' => $hierarchy, 'pid' => $post['pid'],
        ];
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

    public static function editMd() {
        $post = input('post.');
        $info = self::where(['id' => $post['pid']])->find();
        $hierarchy = !empty($info['hierarchy']) ? $info['hierarchy'] + 1 : 1;
        $pid = !empty($info['id']) ? $info['id'] : 0;
        $data = [
            'menu_name' => $post['menu_name'], 'methods' => $post['methods'], 'parameter' => $post['parameter'],
            'sort' => $post['sort'], 'is_show' => $post['is_show'], 'small_icon' => $post['small_icon'], 'create_time' => time(),
            'hierarchy' => $hierarchy, 'pid' => $pid,
        ];
        if ($data) {
            $result = self::where(['id' => $post['id']])->update($data);
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
