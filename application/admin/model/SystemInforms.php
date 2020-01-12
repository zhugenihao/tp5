<?php
/**
 * 通知记录信息
 */
namespace app\admin\model;
use app\admin\model\Commons;
use \think\Db;
class SystemInforms extends Commons {

    protected $pk = 'id';
    protected $name = "system_informs";

    public static function getSystemInformslist($limit=10) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['s.si_title'] = array('like',"%".$search."%");
        }
        $map['query'] = [
            'search' => $search,
        ];
        $join = [
            ['mz_goods g','g.goods_id = s.type_id','left'],
            ['mz_coupon c','c.cop_id = s.type_id','left'],
            ['mz_user u','u.id = s.user_id','left']
        ];
        $list['count'] = self::alias('s')->join($join)->where($where)->count();
        $list['list'] = self::alias('s')->join($join)
                ->field("s.*,g.goods_name,u.name as user_name")
                ->where($where)->order('s.create_time', 'desc')->paginate($limit, false, $map);
        return $list;
    }
    public static function getInfo($id){
        $pre = config('DB_PREFIX');
        $join = [
            ["{$pre}goods g",'g.goods_id = s.type_id','left'],
            ["{$pre}mz_coupon c",'c.cop_id = s.type_id','left'],
            ["{$pre}user u",'u.id = s.user_id','left']
        ];
        $info = self::alias('s')->join($join)
                ->field("s.*,g.goods_name,g.goods_id,u.name as user_name")
                ->where('s.id','=',$id)->find();
        return $info;
    }

    public static function SystemInformsaddeditmd() {
        $post = input('post.');
        $id = (int) ($post['id']);
        $data = ['type' => $post['type'],'si_title' => $post['si_title'],'type_id' => $post['worksid'],
            'is_show' => $post['is_show'],'user_id'=>session('user_id'),'create_time' => time()
        ];
        $file = request()->file("si_url");
        if ($file) {
            // 移动到框架应用根目录public/static/images/gift/ 目录下
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/system_informs');
            if ($info) {
                $infos = self::where(['id' => $id])->find();
                if (!empty($infos)) {
                    if (file_exists(ROOT_PATH . "public/static/images/system_informs/" . $infos['si_url'])) {
                        unlink(ROOT_PATH . "public/static/images/system_informs/" . $infos['si_url']);
                    }
                }
                $time = date("Ymd");
                $data['si_url'] = $time . "/" . $info->getFilename();
            } else {
//                echo $file->getError();
                return false;
            }
        }

        if ($data) {
            if ($id) {
                $result = self::where(['id' => $id])->update($data);
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

}
