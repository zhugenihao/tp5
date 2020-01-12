<?php

/**
 * 运费信息
 */

namespace app\index\model;

use app\common\model\Freight as freightModel;
use \think\Db;

class Freight extends freightModel {

    public static function getSellerfgList($where = [], $limit = 50, $field = "*") {
        $search = trim(input('search'));
        $billing_way = trim(input('billing_way'));
        if (!empty($search)) {
            $where['freight_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($billing_way)) {
            $where['billing_way'] = $billing_way;
        }
        $map['query'] = [
            'search' => $search,
            'billing_way' => $billing_way,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function addMd($store_id = 0) {
        $post = input('post.');
        $dtionAreaArr = array();
        $countyIdArr = array();
        if (is_array($post['county_id'])) {
            foreach ($post['county_id'] as $key => $county_id) {
                $county_text = $post['county_text'][$key];
                $dtionAreaArr[] = ['county_id' => $county_id, 'county_text' => $county_text];
                $countyIdArr[$county_id] = $county_id;
            }
        }

        $list = self::where(['store_id' => $store_id, 'billing_way' => $post['billing_way']])->select();
        $listArray = $list->toArray();
        if ($listArray) {
            foreach ($listArray as $key => $val) {
                $dtionAreaList = json_decode($val['dtion_area'], true);
                foreach ($dtionAreaList as $key2 => $val2) {
                    if (isset($countyIdArr[$val2['county_id']])) {
                        Tiperror("地区[" . $val2['county_text'] . "]已经存在于运费模板中！");
                    }
                }
            }
        }
        $dtionAreaStr = json_encode($dtionAreaArr);
        if ($post['billing_way'] == 1) {//件数
            if (!trim($post['first_number']) || !trim($post['first_fee']) || !trim($post['tocontinue_number']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首件、首运费、续件、续运费！");
            }
        }
        if ($post['billing_way'] == 2) {//重量
            if (!trim($post['first_heavy']) || !trim($post['first_fee']) || !trim($post['tocontinue_heavy']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首重、首运费、续重、续运费！");
            }
        }
        if ($post['billing_way'] == 3) {//体积
            if (!trim($post['first_volume']) || !trim($post['first_fee']) || !trim($post['tocontinue_volume']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首体积、首运费、续体积、续运费！");
            }
        }
        $data = ['store_id' => $store_id, 'freight_name' => $post['freight_name'], 'billing_way' => $post['billing_way'],
            'is_default' => $post['is_default'], 'first_number' => $post['first_number'], 'first_fee' => $post['first_fee'],
            'tocontinue_number' => $post['tocontinue_number'], 'tocontinue_fee' => $post['tocontinue_fee'], 'dtion_area' => $dtionAreaStr,
            'first_heavy' => $post['first_heavy'], 'tocontinue_heavy' => $post['tocontinue_heavy'], 'first_volume' => $post['first_volume'],
            'tocontinue_volume' => $post['tocontinue_volume'], 'is_use' => $post['is_use'], 'create_time' => time()];
        $res = self::create($data);
        if ($res) {
            return true;
        } else {
            return true;
        }
    }

    public static function editMd($store_id = 0) {
        $post = input('post.');
        $dtionAreaArr = array();
        $countyIdArr = array();
        foreach ($post['county_id'] as $key => $county_id) {
            $county_text = $post['county_text'][$key];
            $dtionAreaArr[] = ['county_id' => $county_id, 'county_text' => $county_text];
            $countyIdArr[$county_id] = $county_id;
        }
        $list = self::where(['store_id' => $store_id, 'billing_way' => $post['billing_way'], 'id' => ['neq', $post['freight_id']]])->select();
        $listArray = $list->toArray();
        if ($listArray) {
            foreach ($listArray as $key => $val) {
                $dtionAreaList = json_decode($val['dtion_area'], true);
                foreach ($dtionAreaList as $key2 => $val2) {
                    if (isset($countyIdArr[$val2['county_id']])) {
                        Tiperror("地区[" . $val2['county_text'] . "]已经存在于运费模板中！");
                    }
                }
            }
        }
        $dtionAreaStr = json_encode($dtionAreaArr);
        if ($post['billing_way'] == 1) {//件数
            if (!trim($post['first_number']) || !trim($post['first_fee']) || !trim($post['tocontinue_number']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首件、首运费、续件、续运费！");
            }
        }
        if ($post['billing_way'] == 2) {//重量
            if (!trim($post['first_heavy']) || !trim($post['first_fee']) || !trim($post['tocontinue_heavy']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首重、首运费、续重、续运费！");
            }
        }
        if ($post['billing_way'] == 3) {//体积
            if (!trim($post['first_volume']) || !trim($post['first_fee']) || !trim($post['tocontinue_volume']) ||
                    !trim($post['tocontinue_fee']) || !$dtionAreaArr) {
                Tiperror("配送区域、首体积、首运费、续体积、续运费！");
            }
        }
        $data = [
            'id' => $post['freight_id'], 'freight_name' => $post['freight_name'], 'billing_way' => $post['billing_way'],
            'is_default' => $post['is_default'], 'first_number' => $post['first_number'], 'first_fee' => $post['first_fee'],
            'tocontinue_number' => $post['tocontinue_number'], 'tocontinue_fee' => $post['tocontinue_fee'], 'dtion_area' => $dtionAreaStr,
            'first_heavy' => $post['first_heavy'], 'tocontinue_heavy' => $post['tocontinue_heavy'], 'first_volume' => $post['first_volume'],
            'tocontinue_volume' => $post['tocontinue_volume'], 'is_use' => $post['is_use']];
        $res = self::update($data);
        if ($res) {
            return true;
        } else {
            return true;
        }
    }

}
