<?php
/**
 * 配置信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Config extends Commons {

    protected $pk = 'id';
    protected $name = "config";

    public static function getConfiglist($limit) {
        $search = trim(input('search'));
        $where = [];
        if (!empty($search)) {
            $where['config_name|config_title'] = array('like', "%" . $search . "%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $list['count'] = self::where($where)->count();
        $list['list'] = self::where($where)->order(['id' => 'asc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getIndex($where=[]) {
        $list = self::where($where)->order(['id' => 'asc'])->limit(40)->select();
        return $list;
    }

    public static function ConfigAddeditmd() {
        $post = input('post.');
        $id = (int) ($post['id']);
        $data = [
            'config_name' => $post['config_name'],
            'config_title' => $post['config_title'],
            'config_type' => $post['config_type'],
            'title_type' => $post['title_type'],
            'create_time' => time(),
        ];

        if ($data) {
            if ($id) {
                $result = self::where(['id' => $id])->update($data);
            } else {
                $info = self::where('config_name', $post['config_name'])->count();
                if ($info) {
                    Tiperror("字段名称已存在！");
                }
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
    public static function indexSubmitMd(){
        $idstr = input('post.idstr');
        $config_text_str = input('post.config_text_str');
        $config_front_title_str = input('post.config_front_title_str');
        $idArr = explode('=', $idstr);
        $config_text_arr = explode('=', $config_text_str);
        $config_front_title_arr = explode('=', $config_front_title_str);
//        print_r($config_front_title_arr);die();
        $num = 0;
        foreach($idArr as $key => $val){
            $data = ['config_text'=>$config_text_arr[$key],'config_front_title'=>$config_front_title_arr[$key]];
            $res = self::where(['id'=>$val])->update($data);
            if($res){
               $num = 1; 
            }
        }
        if($num == 1){
            return true;
        }else{
            return false;
        }
        
    }
    

}
