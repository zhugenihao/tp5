<?php

/**
 * 商品信息
 */

namespace app\common\model;

use \think\Db;
use app\common\model\Commons;
use app\common\model\Gallery as galleryModel;
use app\common\model\Comments as commentsModel;
use app\common\model\Givealike as givealikeModel;
use app\common\model\Coupon as couponModel;
use app\common\model\GoodsColor as goodsColorModel;
use app\common\model\Cates as catesModel;
use app\common\model\Norm as NormModel;
use app\common\model\Inventory as inventoryModel;
use app\common\model\Givealike as civealikeModel;
use app\common\model\WatchHistory as watchHistoryModel;
use app\common\model\Collection as collectionModel;
use \think\Image;

class Goods extends Commons {

    protected $pk = 'goods_id';
    protected $name = "Goods";

    public static function getGoodsList($where = [], $field = '*', $start = 0, $limit = 10, $order = []) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        $where['is_show'] = 1;
        $order['sort'] = 'asc';
        $order['create_time'] = 'desc';
        $list['count'] = self::where($where)->order($order)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->limit($start, $limit)->select();
        return $list;
    }

    public static function getGoodsListPc($where = [], $field = '*', $limit = 10, $order = []) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        $where['is_show'] = 1;
        $order['sort'] = 'asc';
        $order['create_time'] = 'desc';

        $map['query'] = [
            'type' => input('type'), 'screening' => input('screening'), 'pricesegment' => input('pricesegment'),
            'price_low' => input('price_low'), 'price_high' => input('price_high')
        ];
        $list['count'] = self::where($where)->order($order)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);
        foreach ($list['list'] as $key => $val) {
            $list['list'][$key]['givealike_count'] = civealikeModel::getCount(['goods_id' => $val['goods_id']]);
        }
        return $list;
    }

    public static function getGoodserList($where = [], $field = '*', $start = 0, $limit = 10, $order = []) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        $where['is_show'] = 1;
        $order['sort'] = 'asc';
        $order['create_time'] = 'desc';
        $list['count'] = self::where($where)->count();
        $list['list'] = self::field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        foreach ($list['list'] as $key => $val) {
            $list['list'][$key]['givealike_count'] = civealikeModel::getCount(['goods_id' => $val['goods_id']]);
        }
        return $list;
    }

    public static function getGoodserListPc($where = [], $field = '*', $limit = 10, $order = []) {
        $search = trim(input('search'));
        if (!empty($search)) {
            $where['goods_name'] = array('like', "%" . $search . "%");
        }
        $where['is_show'] = 1;
        $order['sort'] = 'asc';
        $order['create_time'] = 'desc';
        $list['count'] = self::where($where)->count();
        $map['query'] = [
        ];
        $list['list'] = self::field($field)->where($where)->order($order)->paginate($limit, false, $map);

        foreach ($list['list'] as $key => $val) {
            $list['list'][$key]['givealike_count'] = civealikeModel::getCount(['goods_id' => $val['goods_id']]);
        }

        return $list;
    }

    public static function getInfo($where = [], $field = '*') {
        return self::field($field)->lock(true)->where($where)->find();
    }

    /**
     * 商品详情
     * @param type $where
     * @param type $field
     * @return type
     */
    public static function getGoodsInfo($where = [], $field = '*') {
        $mid = session('member_id');
        $info = self::field($field)->where($where)->find();
        //商品多图
        $info['is_collection'] = collectionModel::getCount(['goods_id' => $info['goods_id'], 'm_id' => $mid, 'state' => 1]);
        $info['gallery_list'] = galleryModel::getGalleryList(['goods_id' => $info['goods_id']], '*', 9);
        //商品点赞
        $info['is_givealike'] = givealikeModel::getCount(['m_id' => $mid, 'goods_id' => $where['goods_id']]);
        //商品评论
        $info['comments_list'] = commentsModel::getCommentslist(['goods_id' => $info['goods_id']], 0, 2);
        //猜你喜欢商品
        $salesfield = 'goods_id,goods_name,goods_price,thecover,sales';
        $info['sales_goods_list'] = self::getGoodsList([], $salesfield, 0, 3, ['sales' => 'desc']);
        //商品优惠券
        $todayTime = date("Y-m-d H:i:s");

        $cuoponWhere1 = ['type_id' => $info['goods_id'], 'type' => 1, 'copb_time' => array('egt', $todayTime), 'cop_num' => ['egt', 1]]; //取指定商品的优惠券
        $cuoponWhere2 = ['type_id' => $info['store_id'], 'type' => 2, 'copb_time' => array('egt', $todayTime), 'cop_num' => ['egt', 1]]; //取指定商铺的优惠券
        $coupon1 = couponModel::getList($cuoponWhere1, '*', 0, 10);
        $coupon2 = couponModel::getList($cuoponWhere2, '*', 0, 10);
        $info['coupon_list'] = array_merge($coupon1, $coupon2);

        //商品颜色
        $GoodsColor = NormModel::getList(['goods_id' => $info['goods_id']], 'goodscolor_id');
        $GoodsColorArr = [];
        foreach ($GoodsColor as $colorVal) {
            $GoodsColorArr[] = $colorVal['goodscolor_id'];
        }
        $info['goods_color_list'] = goodsColorModel::getGoodsColor(['id' => ['in', $GoodsColorArr]], "*", 0, 10);
        //默认的商品规格
        $goodsColorId0 = isset($info['goods_color_list'][0]) ? $info['goods_color_list'][0]['id'] : 0;
        $normWhere = ['goods_id' => $info['goods_id'], 'goodscolor_id' => $goodsColorId0];
        $info['default_norm_info'] = NormModel::getInfo($normWhere, "*");
        //商品版本
        $inventoryArr = inventoryModel::getList(['n_id' => $info['default_norm_info']['n_id']])->toArray();
        $cateid = array();
        $cate_price_arr = array();
        if ($inventoryArr) {
            foreach ($inventoryArr as $inval) {
                $cateid[] = $inval['cate_id'];
                $cate_price_arr[$inval['cate_id']] = $inval['inty_price'];
            }
        }
        $catesList = !empty($cateid) ? catesModel::all($cateid) : array();
        if ($catesList) {
            foreach ($catesList as $catelKey => $catelVal) {
                $catesList[$catelKey]['cate_price'] = $cate_price_arr[$catelVal['cate_id']];
            }
        }
        $info['cates_list'] = !empty($inventoryArr) ? $catesList : '';
        //默认商品封面
        $info['default_gallery'] = galleryModel::getValue(['n_id' => $info['default_norm_info']['n_id']], 'img_small');
        //添加商品足迹
        if ($mid && empty(watchHistoryModel::getCount(['goods_id' => $info['goods_id'], 'm_id' => $mid]))) {
            watchHistoryModel::add(['goods_id' => $info['goods_id'], 'm_id' => $mid]);
        }
        return $info;
    }

    public static function getValue($where = [], $value = 'id') {
        return self::where($where)->lock(true)->value($value);
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

    public static function setIncs($where = [], $value = '', $num = '') {
        return self::where($where)->setInc($value, $num);
    }

    public static function setDecs($where = [], $value = '', $num = '') {
        return self::where($where)->setDec($value, $num);
    }

    /**
     * 获取商品成本
     * @param type $goods_id
     */
    public static function getCostPrice($goods_id = 0, $n_id = 0, $cate_id = 0) {
        $goods = self::where('goods_id', '=', $goods_id)->find();

        if ($goods['setup_norm'] == 'on') {
            $inventory = inventoryModel::getInfo(['goods_id' => $goods_id, 'n_id' => $n_id, 'cate_id' => $cate_id]);
            $CostPrice = $inventory['orgprice'];
        } else {
            $CostPrice = $goods['cost_price'];
        }
        return $CostPrice;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

}
