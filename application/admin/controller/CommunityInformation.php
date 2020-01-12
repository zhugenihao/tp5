<?php

/**
 * 社区信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\CommunityInformation as CommunityInformationModel;
use \think\Db;

class CommunityInformation extends Common {

    public function community_information_list() {
        $limit = 10;
        $list = CommunityInformationModel::getCommunityInformationlist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function community_information_addedit() {
        $info = CommunityInformationModel::getCommunityInformationInfo(input('id'));
        $singletopic_point_praise_list = CommunityInformationModel::singletopic_point_praise_list(input('id'));
        $info['picture_url'] = json_decode($info['picture_url'], true);
        $this->assign('stpplcount', count($singletopic_point_praise_list));
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function singletopic_point_praise_list() {
        if ($this->request->isAjax()) {
            $cyf_id = input('post.cyf_id');
            $list = CommunityInformationModel::singletopic_point_praise_list($cyf_id);
            echo json_encode($list);
        }
    }

    public function CommunityInformationShow() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $id = $post['id'];
            $info = CommunityInformationModel::get($id);
            if ($info['is_show'] == '1') {
                $info->is_show = '2';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            $info2 = CommunityInformationModel::get($id);
            if ($res) {
                Tobesuccess('操作成功', $info2);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function CommunityInformationdetel() {
        if ($this->request->isAjax()) {
            $CommunityInformation = CommunityInformationModel::get(input('id'));
            $res = $CommunityInformation->delete();
            if ($res) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
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
            $result = CommunityInformationModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
