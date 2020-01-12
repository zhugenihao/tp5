<?php

/**
 * 内容信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Content as ContentModel;
use app\admin\model\Directory as directoryModel;
use app\admin\model\Language as languageModel;
use app\admin\model\Language_content as languageContentModel;
use \think\Db;

class Content extends Common {

    public function content_list() {
        $limit = 10;
        $Contents = new ContentModel();
        $list = $Contents->getContentlist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("catetype", input('search'));
        $this->assign('page', $list['list']->render());
        $this->assign("directory_id", input('directory_id'));
        $this->assign("directorypid_id", input('directorypid_id'));
        $directorypid_list = directoryModel::directoryListOne_md(0);
        $this->assign("directorypid_list", $directorypid_list);
        return $this->fetch();
    }

    public function content_add() {
        $id = (int) (input('id'));
        $info = ContentModel::getInfo(['id' => $id]);
        $this->assign("info", $info);
        $this->directorypid_list();

        return $this->fetch();
    }

    public function directorypid_list() {
        $id = input('directory_id');
        $directorypid_list = directoryModel::directoryListOne_md($id);
        $this->assign("directorypid_list", $directorypid_list);
    }

    public function content_addedit() {
        $Contents = new ContentModel();
        $res = $Contents->Contentaddeditmd();
        if ($res) {
            Tobesuccess("操作成功");
        } else {
            Tiperror("操作失败");
        }
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info = ContentModel::get($id);
            if ($info['is_show'] == '1') {
                $info->is_show = '0';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            if ($res) {
                Tobesuccess('操作成功', $info);
            } else {
                Tiperror("操作失败");
            }
        }
    }


    public function datadel() {
        if ($this->request->isAjax()) {
            $result = ContentModel::getDelete();
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    public function language_content() {
        $info = ContentModel::getInfo(['id' => input('content_id')]);
        $this->assign("info", $info);
        $languageList = languageModel::getList(20);
        $this->assign("languageList", $languageList['list']);
        $languageContent = languageContentModel::getList();
        $this->assign("languageContent", $languageContent['list']);
        $this->assign("content_id", input('content_id'));
        return $this->fetch();
    }

    public function language_content_add() {
        $languageList = languageModel::getList(20);
        $this->assign("languageList", $languageList['list']);
        $contentInfo = ContentModel::getInfo(['id' => input('content_id')]);
        $this->assign("title", $contentInfo['title']);
        $this->assign("content_id", $contentInfo['id']);
        $info = languageContentModel::get(input('id'));
        $this->assign("info", $info);
        return $this->fetch();
    }

    public function languageContentSubmit() {
        if ($this->request->isAjax()) {
            $res = languageContentModel::languageContentSubmitMd();
            if ($res) {
                Tobesuccess('操作成功');
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function languageContentDatadel() {
        if ($this->request->isAjax()) {
            $id_str = input('idstr');
            $id_arr = explode(",", $id_str);
            if (empty($id_str)) {
                Tiperror("您未选择！");
            }
            $result = languageContentModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

}
