<?php
/**
 * 用户反馈信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Feedbacks extends Commons {

    protected $pk = 'id';
    protected $name = "feedback";

    public function getFeedbacklist($limit = 10) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $where = [];
        if (!empty($search)) {
            $where['m.member_name|f.text|f.reply_text|f.repair_order'] = array('like',"%".$search."%");
        }
        if (!empty($datemin)) {
            $where['f.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['f.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['f.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $where['f.create_time'] = ['>= time', $datemin];
        $role = $this->rolename();
        if($role['role_id'] != 1){
            $where['f.user_id'] = session('user_id');
        }
        
        $pre = config('DB_PREFIX');
        $list['count'] = $this->alias('f')
                        ->join("{$pre}member m", 'm.id=f.m_id', 'LEFT')
                        ->where($where)->count();
        $list['list'] = $this->alias('f')
                        ->join("{$pre}member m", 'm.id=f.m_id', 'LEFT')
                        ->field("f.*,m.member_name,m.photo,m.id as m_id")->where($where)->order('id', 'desc')->paginate($limit, false, $map);
                        
        return $list;
    }

    public function feedback_editmd($id) {
        $pre = config('DB_PREFIX');
        $where['f.id'] = $id;
        $info = $this->alias('f')
                        ->join("{$pre}member m", 'm.id=f.m_id', 'LEFT')
                        ->field("f.*,m.member_name,m.photo,m.id as m_id")->where($where)->find();
        return $info;
    }
    public static function feedbackSubmitMd(){
        $post = input('post.');
        $data = ['reply_text'=>$post['reply_text'],'user_name'=>session('user_name'),'create_time2'=>time()];
            $res = self::where(['id'=>$post['id']])->update($data);
        $ret = !empty($res) ? true : false;
        return $ret;
    }
    public static function submitTheAllocationMd($where=[],$update=[]){
        return self::where($where)->update($update);
    }

}
