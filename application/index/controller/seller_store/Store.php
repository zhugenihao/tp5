<?php

/**
 * 商品品牌信息
 */

namespace app\index\controller\seller_store;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\Store as storeModel;
use app\index\model\Advert as advertModel;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;
use app\common\model\Themetemplate as themetemplateModel;
use app\common\model\Directory as directoryModel;
use app\common\model\SellerContact as sellerContactModel;
use app\common\model\SellerCompany as sellerCompanyModel;
use app\common\model\SellerQualification as sellerQualificationModel;
use app\common\model\BusinessCategory as businessCategoryModel;

class Store extends SellerCommon {

    public function store_setupshop() {
//        session('seller_id',null);
        $store = $this->store;
        $store = storeModel::get($store['id']);
        $this->assign('store', $store);
        //电脑幻灯片图片
        $advertPcList = advertModel::getList(['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'dire' => ['neq', '']]);
        $this->assign('advertPcList', $advertPcList);
        $whereAdvertPc1 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'adt_mark' => 'advert1'];
        $whereAdvertPc2 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'adt_mark' => 'advert2'];
        $whereAdvertPc3 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'adt_mark' => 'advert3'];
        $whereAdvertPc4 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'adt_mark' => 'advert4'];
        $whereAdvertPc5 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 1, 'adt_mark' => 'advert5'];
        $this->assign([
            'advertPcInfo1' => advertModel::getInfo($whereAdvertPc1, 'adv_id,dire,adv_link'),
            'advertPcInfo2' => advertModel::getInfo($whereAdvertPc2, 'adv_id,dire,adv_link'),
            'advertPcInfo3' => advertModel::getInfo($whereAdvertPc3, 'adv_id,dire,adv_link'),
            'advertPcInfo4' => advertModel::getInfo($whereAdvertPc4, 'adv_id,dire,adv_link'),
            'advertPcInfo5' => advertModel::getInfo($whereAdvertPc5, 'adv_id,dire,adv_link'),
        ]);
        //手机幻灯片图片
        $advertMobileList = advertModel::getList(['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'dire' => ['neq', '']]);
        $this->assign('advertMobileList', $advertMobileList);
        $whereAdvertMobile1 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'adt_mark' => 'advert1'];
        $whereAdvertMobile2 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'adt_mark' => 'advert2'];
        $whereAdvertMobile3 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'adt_mark' => 'advert3'];
        $whereAdvertMobile4 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'adt_mark' => 'advert4'];
        $whereAdvertMobile5 = ['store_id' => $store['id'], 'ad_types' => 1, 'device_type' => 2, 'adt_mark' => 'advert5'];
        $this->assign([
            'advertMobileInfo1' => advertModel::getInfo($whereAdvertMobile1, 'adv_id,dire,adv_link'),
            'advertMobileInfo2' => advertModel::getInfo($whereAdvertMobile2, 'adv_id,dire,adv_link'),
            'advertMobileInfo3' => advertModel::getInfo($whereAdvertMobile3, 'adv_id,dire,adv_link'),
            'advertMobileInfo4' => advertModel::getInfo($whereAdvertMobile4, 'adv_id,dire,adv_link'),
            'advertMobileInfo5' => advertModel::getInfo($whereAdvertMobile5, 'adv_id,dire,adv_link'),
        ]);
        $store_themetemplate = themetemplateModel::getInfo(['id' => $store['tpl_id']], "*");
        $themetemplate = themetemplateModel::getList([], 20);
//        print_r($store['tpl_id']);
        $this->assign("themetemplate", $themetemplate->toArray());
        $this->assign("themetemplate_page", $themetemplate->render());
        $this->assign("store_themetemplate", $store_themetemplate);
        return $this->fetch();
    }

    public function storeModify() {
        if ($this->request->isAjax()) {
            $result = storeModel::storeModifyMd();
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
    }

    public function advertPcModify() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $result = advertModel::advertPcModifyMd($store['id']);
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
    }

    public function advertMobileModify() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $result = advertModel::advertMobileModifyMd($store['id']);
            if ($result) {
                Tobesuccess('编辑成功');
            } else {
                Tiperror("编辑失败！");
            }
        }
    }

    /**
     * 模板使用
     */
    public function templateUse() {
        if ($this->request->isAjax()) {
            $store = $this->store;
            $get = input('get.');
            $result = storeModel::updates(['id' => $store['id']], ['tpl_id' => $get['tpl_id']]);
            if ($result) {
                Tobesuccess('使用成功');
            } else {
                Tiperror("使用失败！");
            }
        }
    }

    public function store_information() {
        $info = $this->store;
        $this->assign("info", $info);
        $directory_big_name = directoryModel::getValue(['pid' => 0], 'title');
        $this->assign("directory_big_name", $directory_big_name);
        $sellerContact = sellerContactModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerContact", $sellerContact);
        $sellerCompany = sellerCompanyModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerCompany", $sellerCompany);

        $sellerCompanyProvince = onethinkDistrictModel::getQdInfo(['id' => $sellerCompany['province_id']], 'id,name');
        $sellerCompanyCity = onethinkDistrictModel::getQdInfo(['id' => $sellerCompany['city_id']], 'id,name');
        $sellerCompanyCounty = onethinkDistrictModel::getQdInfo(['id' => $sellerCompany['county_id']], 'id,name');
        $this->assign(['sellerCompanyProvince' => $sellerCompanyProvince, 'sellerCompanyCity' => $sellerCompanyCity,
            'sellerCompanyCounty' => $sellerCompanyCounty]);

        $infoProvince = onethinkDistrictModel::getQdInfo(['id' => $info['province_id']], 'id,name');
        $infoCity = onethinkDistrictModel::getQdInfo(['id' => $info['city_id']], 'id,name');
        $this->assign(['infoProvince' => $infoProvince, 'infoCity' => $infoCity]);

        $sellerQualification = sellerQualificationModel::getInfo(['member_id' => $info['member_id']], '*');
        $this->assign("sellerQualification", $sellerQualification);
        
        $businessCategory = businessCategoryModel::getListGroup(['store_id'=>$info['id']],'directory1_id', '*');
        $this->assign("businessCategory", $businessCategory);

        return $this->fetch();
    }

}
