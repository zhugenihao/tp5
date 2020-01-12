<?php

/**
 * 用户收货地址信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\api\model\Session as sessionModel;
use app\common\model\Address as addressModel;
use app\common\model\OnethinkDistrict as onethinkDistrictModel;

class Address extends Common {

    public function _initialize() {
        parent::_initialize();
        $isLogin = sessionModel::check_session();
        if (!$isLogin) {
            $this->redirect('Login/login');
        }
        $this->mid = session('member_id');
    }

    /**
     * 添加收货地址
     */
    public function addAddress() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $provinceName = onethinkDistrictModel::getValue(['id' => $post['province_id']], 'name');
            $cityName = onethinkDistrictModel::getValue(['id' => $post['city_id']], 'name');
            $countyName = onethinkDistrictModel::getValue(['id' => $post['county_id']], 'name');
            $townName = onethinkDistrictModel::getValue(['id' => $post['town_id']], 'name');
            $ads_default = isset($post['ads_default']) ? $post['ads_default'] : 'off';
            $data = [
                'm_id' => $this->mid,
                'tcgaddress' => $provinceName .'，'. $cityName .'，'. $countyName .'，'. $townName .'，'. $post['detaddress'],
                'detaddress' => $post['detaddress'],
                'ads_name' => $post['ads_name'],
                'ads_api' => $post['ads_api'],
                'ads_default' => $ads_default,
                'sign_id' => $post['sign_id'],
                'province_id' => $post['province_id'],
                'city_id' => $post['city_id'],
                'county_id' => $post['county_id'],
                'town_id' => $post['town_id'],
                'ads_time' => time(),
            ];
            if (isset($post['ads_default'])) {
                addressModel::updates(['m_id' => $this->mid], ['ads_default' => 'off']);
            }
            $result = addressModel::add($data);
            if ($result) {
                Tobesuccess('添加成功');
            } else {
                Tiperror("添加失败！");
            }
        }
    }

    /**
     * 修改收货地址
     */
    public function modifyAddress() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $provinceName = onethinkDistrictModel::getValue(['id' => $post['province_id']], 'name');
            $cityName = onethinkDistrictModel::getValue(['id' => $post['city_id']], 'name');
            $countyName = onethinkDistrictModel::getValue(['id' => $post['county_id']], 'name');
            $townName = onethinkDistrictModel::getValue(['id' => $post['town_id']], 'name');
            $ads_default = isset($post['ads_default']) ? $post['ads_default'] : 'off';
            $data = [
                'tcgaddress' => $provinceName .'，'. $cityName .'，'. $countyName .'，'. $townName .'，'. $post['detaddress'],
                'detaddress' => $post['detaddress'],
                'ads_name' => $post['ads_name'],
                'ads_api' => $post['ads_api'],
                'ads_default' => $ads_default,
                'sign_id' => $post['sign_id'],
                'province_id' => $post['province_id'],
                'city_id' => $post['city_id'],
                'county_id' => $post['county_id'],
                'town_id' => $post['town_id'],
                'ads_time' => time(),
            ];
            if (isset($post['ads_default'])) {
                addressModel::updates(['m_id' => $this->mid], ['ads_default' => 'off']);
            }
            $result = addressModel::updates(['ads_id' => $post['ads_id']], $data);
            if ($result) {
                Tobesuccess('修改成功');
            } else {
                Tiperror("修改失败！");
            }
        }
    }

    public function getInfo() {
        if ($this->request->isAjax()) {
            $get = input('get.');
            $info = addressModel::getAddressInfo(['ads_id' => $get['ads_id']], '*');
            exit(json_encode($info));
        }
    }

}
