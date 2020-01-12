<?php
/**
 * 通知记录信息
 */
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\SystemInforms as systemInformsModel;
use app\admin\model\Goods as GoodsModel;
use \think\Db;

class SystemInforms extends Common {

    public function system_informs_list() {
        $limit = 10;
        $list = systemInformsModel::getSystemInformslist($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }


    public function system_informs_edit() {

        $id = (int) (input('id'));
        $info = systemInformsModel::getInfo($id);
        $this->assign("info", $info);

        return $this->fetch();
    }
    //搜索作品
    public function getGoodsList(){
        if ($this->request->isAjax()) {
            $goods_where = input('get.goods_where');
            if (is_numeric($goods_where)) {
                $where = ['goods_id' => $goods_where];
            } else {
                $where['goods_name'] = array('like', '%' . $goods_where . '%');
            }
            $goodsList = GoodsModel::field('goods_id,goods_name')->where($where)->limit(20)->select();
            echo json_encode($goodsList);
        }
    }

    public function system_informs_addedit() {
        if ($this->request->isAjax()) {
            $res = systemInformsModel::systemInformsAddeditmd();
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function disable() {
        if ($this->request->isAjax()) {
            $id = (int) (input("id"));
            $info = systemInformsModel::get($id);
            if ($info['is_show'] == '1') {
                $info->is_show = '2';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            $info2 = systemInformsModel::get($id);
            if ($res) {
                Tobesuccess('操作成功', $info2);
            } else {
                Tiperror("操作失败");
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
            $result = systemInformsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }
}
