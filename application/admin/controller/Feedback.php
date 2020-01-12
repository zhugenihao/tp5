<?php
/**
 * 用户反馈信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Feedbacks;
use \think\Db;

class Feedback extends Common {

    public function feedback_list() {
        $limit = 5;
        $Feedbacks = new Feedbacks();
        $list = $Feedbacks->getFeedbacklist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        
        $role_list = db::name("role")->where('id','<>','1')->select();
        foreach($role_list as $key=>$val){
            $user_id_arr = db::name('role_user')->field('user_id')->where('role_id',$val['id'])->select();
            $user_id_arr2 = array();
            foreach($user_id_arr as $val2){
                $user_id_arr2[] = $val2['user_id'];
            }
            $user_id_str = implode(",", $user_id_arr2);
            $role_list[$key]['user_list'] = db::name('user')->where(['state'=>1,'id'=>array('in',$user_id_str)])->select();
        }
        $this->assign('role_list',$role_list);
        return $this->fetch();
    }

    public function feedback_edit() {
        $Feedbacks = new Feedbacks();
        $info = $Feedbacks->feedback_editmd(input("id"));
        
        $this->assign("info", $info);
        $this->assign("reply", input("reply"));
        $role_name = db::name("role")->where('id','=',$info['department'])->value('name');
        $this->assign("role_name", $role_name);
        return $this->fetch();
    }
    public function submitTheAllocation(){
        if ($this->request->isAjax()) {
            $post = input('post.');
            $res = Feedbacks::submitTheAllocationMd(['id'=>$post['id']],['user_id'=>$post['user_id']]);
            if ($res) {
                Tobesuccess('分配成功');
            } else {
                Tiperror("分配失败");
            }
        }
    }

    public function feedbackSubmit() {
        if ($this->request->isAjax()) {
            $res = Feedbacks::feedbackSubmitMd();
            if ($res) {
                Tobesuccess('回复成功');
            } else {
                Tiperror("回复失败");
            }
        }
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = Feedbacks::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
