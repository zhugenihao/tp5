<?php

/**
 * 拼团信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Store as storeModel;
use \think\Db;
use app\admin\model\Directory as directoryModel;
use app\admin\model\SellerContact as sellerContactModel;
use app\admin\model\SellerCompany as sellerCompanyModel;
use app\admin\model\OnethinkDistrict as onethinkDistrictModel;
use app\admin\model\SellerQualification as sellerQualificationModel;
use app\admin\model\Seller as sellerModel;
use app\admin\model\Member as memberModel;
use app\admin\model\BusinessCategory as businessCategoryModel;

class Store extends Common {

    public function store_list() {
        $limit = 10;
        $list = storeModel::getList($limit);
        $this->assign("list", $list['list']);
        $this->assign("limit", $limit);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign('page', $list['list']->render());
        return $this->fetch();
    }

    public function store_add() {
        if ($this->request->isAjax()) {

            $res = storeModel::addMd($this->user_id);
            if ($res) {
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $directory1_list = directoryModel::getSelectList(['pid' => 0], 50, 'id,title');
        $this->assign("directory1_list", $directory1_list);

        $onethinkDistrict = onethinkDistrictModel::getLister(['upid' => 0]);
        $this->assign("onethinkDistrict", $onethinkDistrict);

        return $this->fetch();
    }

    /**
     * 过滤商家相同名称
     * @return type
     */
    public function seller_name() {
        $seller_name = randStr(8, 'all');
        $sellerCount = sellerModel::getCount(['seller_name' => $seller_name]);
        if ($sellerCount) {
            $this->seller_name();
        } else {
            return $seller_name;
        }
    }

    /**
     * 店铺详情 
     * @return type
     */
    public function store_edit() {

        if ($this->request->isAjax()) {
            $post = input('post.');
            $info = storeModel::get($post['store_id']);
            $sellerCount = 0;
            if ($info['member_id'] > 0) {
                $sellerCount = sellerModel::getCount(['member_id' => $info['member_id']]);
            }
            if ($info['user_id'] > 0) {
//                $sellerCount = sellerModel::getCount(['user_id' => $info['user_id']]);
            }
            if ($sellerCount) {
                Tiperror("商家账号已存在！");
            }
            $res = storeModel::updates(['id' => $post['store_id']], ['audit' => $post['audit']]);
            if ($res) {
                if ($info['member_id'] > 0) {
                    sellerCompanyModel::updates(['member_id' => $info['member_id']], ['audit' => $post['audit']]);
                    sellerQualificationModel::updates(['member_id' => $info['member_id']], ['audit' => $post['audit']]);
                }
                if ($post['audit'] == '20' && $sellerCount < 1) {
                    //生成商家账号密码
                    $member_name = memberModel::getValue($info['member_id'], 'member_name');
                    $seller_name = "seller_" . $this->seller_name();
                    $initial_password = randStr(8, 'all');
                    $password = passwordEncryption($initial_password);
                    $sellerRes = sellerModel::add(['seller_name' => $seller_name, 'initial_password' => $initial_password,
                                'seller_password' => $password['password'], 'salt' => $password['salt'], 'member_id' => $info['member_id'],
                                'member_name' => $member_name, 'user_id' => $info['user_id'], 'checkin_time' => time(),
                                'group_name' => "超级管理员"]);
                    storeModel::updates(['id' => $info['id']], ['seller_id' => $sellerRes->id, 'level' => 1, 'level_name' => "一星"]);
                    //更新经营类目
                    if ($info['user_id'] > 0) {
                        $bcupwhere = ['user_id' => $info['user_id']];
                    } else {
                        $bcupwhere = ['member_id' => $info['member_id']];
                    }
                    businessCategoryModel::updates($bcupwhere, ['store_id' => $info['id']]);
                }
                Tobesuccess("操作成功");
            } else {
                Tiperror("操作失败");
            }
        }
        $get = input('get.');
        $info = storeModel::get($get['id']);
        $this->assign("info", $info);
        $directory1_list = directoryModel::getSelectList(['pid' => 0], 50, 'id,title');
        $this->assign("directory1_list", $directory1_list);
        $sellerContact = sellerContactModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerContact", $sellerContact);
        $sellerCompany = sellerCompanyModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerCompany", $sellerCompany);

        $sellerCompanyProvince = onethinkDistrictModel::getInfo(['id' => $sellerCompany['province_id']], 'id,name');
        $sellerCompanyCity = onethinkDistrictModel::getInfo(['id' => $sellerCompany['city_id']], 'id,name');
        $sellerCompanyCounty = onethinkDistrictModel::getInfo(['id' => $sellerCompany['county_id']], 'id,name');
        $this->assign(['sellerCompanyProvince' => $sellerCompanyProvince, 'sellerCompanyCity' => $sellerCompanyCity,
            'sellerCompanyCounty' => $sellerCompanyCounty]);

        $infoProvince = onethinkDistrictModel::getInfo(['id' => $info['province_id']], 'id,name');
        $infoCity = onethinkDistrictModel::getInfo(['id' => $info['city_id']], 'id,name');
        $this->assign(['infoProvince' => $infoProvince, 'infoCity' => $infoCity]);

        $sellerQualification = sellerQualificationModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerQualification", $sellerQualification);

        if ($info['user_id'] > 0) {
            $bcwhere = ['store_id' => $info['id']];
        } else {
            $bcwhere = ['member_id' => $info['member_id']];
        }
        $businessCategory = businessCategoryModel::getList($bcwhere, '*');
        $this->assign("businessCategory", $businessCategory);
        return $this->fetch();
    }

    public function datadel() {
        if ($this->request->isAjax()) {
            $idStr = input('idstr');
            $idArr = explode(",", $idStr);
            if (empty($idArr)) {
                Tiperror("您未选择！");
            }
            $result = storeModel::destroy($idArr);
            if ($result) {
                Tobesuccess('批量删除成功');
            } else {
                Tiperror("批量删除失败");
            }
        }
    }

    public function getStoreList() {
        if ($this->request->isAjax()) {
            $store_where = input('get.store_where');
            if (is_numeric($store_where)) {
                $where = ['id' => $store_where];
            } else {
                $where['store_name'] = array('like', '%' . $store_where . '%');
            }
            $storeList = storeModel::getStoreList($where, 'id,store_name', 0, 20);
            echo json_encode($storeList);
        }
    }

}
