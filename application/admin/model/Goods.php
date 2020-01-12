<?php

/**
 * 商品信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\admin\model\Directory as DirectoryModel;
use app\admin\model\Norm as normModel;
use app\admin\model\Inventory as inventoryModel;

class Goods extends Commons {

    protected $pk = 'goods_id';
    protected $name = "Goods";

    public static function getGoodsList($limit, $where = [], $field = 'g.*,s.store_name,s.member_id,s.member_name', $order = []) {
        $search = trim(input('search'));
        $dirId = trim(input('dir_id'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));

        if (!empty($search)) {
            $where['g.goods_name|s.store_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($dirId)) {
            $dirIdArr = DirectoryModel::getChildrenIds($dirId);
            $dirIdArr .= $dirId;
            $where['g.dir_id'] = ['in', $dirIdArr];
        }
        if (!empty($datemin)) {
            $where['g.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['g.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['g.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $order['g.sort'] = 'asc';
        $order['g.create_time'] = 'desc';
        $list['count'] = self::count();
        $list['list'] = self::alias('g')
                        ->join("mz_store s", 's.id=g.store_id', 'LEFT')
                        ->field($field)->where($where)->order($order)->paginate($limit, false, $map);
        return $list;
    }

    public static function getGoodsInfo($id) {
        $info = self::alias('c')
                        ->join("mz_store s", 's.id=g.store_id', 'LEFT')
                        ->join("mz_topic_point_praise t", 't.cyf_id=c.id', 'LEFT')
                        ->field("c.*,s.store_name,count(t.id) as allpraise")->where('c.id', $id)->find();
        return $info;
    }

    public static function singletopic_point_praise_list($cyf_id) {
        $list = db::name('singletopic_point_praise as s')
                        ->join("mz_member m", 'm.id=s.m_id', 'LEFT')
                        ->field("s.*,m.name as uname,m.id as m_id")->where('cyf_id', '=', $cyf_id)->limit(20)->select();
        foreach ($list as $key => $val) {
            $list[$key]['create_time'] = date("Y-m-d", $val['create_time']);
        }
        return $list;
    }

    public static function goodsAdd() {
        $post = input('post.');
        $file = request()->file("thecover");
        $thecover = $post['thecover'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/cover/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/cover';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $thecover = '/images/goods/cover/' . $info->getSaveName();
            } else {
                Tiperror("商品添加失败！", $file->getError());
            }
        }
        $data = [
            'billing_num' => $post['billing_num'],
            'billing_way' => $post['billing_way'],
            'freight_id' => $post['freight_id'],
            'dir_id' => $post['dir_id'],
            'goods_name' => $post['goods_name'],
            'goods_stock' => $post['goods_stock'],
            'goods_price' => $post['goods_price'],
            'goods2_name' => $post['goods2_name'],
            'goods_sku' => $post['goods_sku'],
            'goods_desc' => $post['goods_desc'],
            'goods_desc2' => $post['goods_desc2'],
            'recommended' => $post['recommended'],
            'sort' => $post['sort'],
            'is_show' => $post['is_show'],
            'thecover' => $thecover,
            'sales' => $post['sales'],
            'region' => $post['region'],
            'brand_id' => $post['brand_id'],
            'cost_price' => $post['cost_price'],
            'setup_norm' => !empty($post['setup_norm']) ? $post['setup_norm'] : 'off',
            'create_time' => time()
        ];
        if ($data) {
            $result = self::insert($data);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function goodsEdit() {
        $post = input('post.');
        $file = request()->file("thecover");
        $thecover = $post['thecover'];
        if ($file) {
            // 移动到框架应用根目录public/static/images/goods/cover/ 目录下
            $PATH = ROOT_PATH . 'public' . DS . 'static/images/goods/cover/';
            $info = $file->validate(['size' => 15678 * 1024, 'ext' => 'jpg,png,gif'])->move($PATH);
            if ($info) {
                $thecover = self::where(['goods_id' => $post['goods_id']])->value('thecover');
                if (!empty($thecover)) {
                    if (file_exists(ROOT_PATH . "public/static/" . $thecover)) {
                        unlink(ROOT_PATH . "public/static/" . $thecover);
                    }
                }
                $thecover = '/images/goods/cover/' . $info->getSaveName();
            } else {
                Tiperror("商品添加失败！", $file->getError());
            }
        }
        $data = [
            'billing_num' => $post['billing_num'],
            'billing_way' => $post['billing_way'],
            'freight_id' => $post['freight_id'],
            'dir_id' => $post['dir_id'],
            'goods_name' => $post['goods_name'],
            'goods_price' => $post['goods_price'],
            'goods_stock' => $post['goods_stock'],
            'goods2_name' => $post['goods2_name'],
            'goods_sku' => $post['goods_sku'],
            'goods_desc' => $post['goods_desc'],
            'goods_desc2' => $post['goods_desc2'],
            'recommended' => $post['recommended'],
            'sort' => $post['sort'],
            'is_show' => $post['is_show'],
            'thecover' => $thecover,
            'sales' => $post['sales'],
            'region' => $post['region'],
            'brand_id' => $post['brand_id'],
            'cost_price' => $post['cost_price'],
            'setup_norm' => !empty($post['setup_norm']) ? $post['setup_norm'] : 'off',
        ];
        if ($data) {
            $result = self::where(['goods_id' => $post['goods_id']])->update($data);
            if ($result) {
                self::delRedundantNorm($post['goods_id']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //删除多余规格颜色
    public static function delRedundantNorm($goods_id = 0) {
        $norm = normModel::getList(['goods_id' => $goods_id]);
        $normIdArr = [];
        foreach ($norm as $val) {
            $inventory = inventoryModel::getCount(['goods_id' => $goods_id, 'n_id' => $val['n_id']]);
            if (!$inventory) {
                $normIdArr[] = $val['n_id'];
            }
        }
        //删除多余规格颜色
        normModel::destroy($normIdArr);
    }

    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }

    public static function getValue($where = [], $value = '') {
        return self::where($where)->value($value);
    }

}
