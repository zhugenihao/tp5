<?php
/**
 * 快递信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Courier extends Commons {

    protected $pk = 'id';
    protected $name = "courier";

    public static function getCourierList($where = [], $limit = 10) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['cou_name'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['sort' => 'asc', 'id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function add() {
        $post = input('post.');
        $data = [
            'cou_name' => $post['cou_name'],
            'cou_mark' => $post['cou_mark'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
            'add_time' => time(),
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

    public static function updates() {
        $post = input('post.');
        $id = (int) ($post['id']);
        $data = [
            'cou_name' => $post['cou_name'],
            'cou_mark' => $post['cou_mark'],
            'is_show' => $post['is_show'],
            'sort' => $post['sort'],
        ];
        if ($data) {
            $result = self::where(['id' => $id])->update($data);
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
