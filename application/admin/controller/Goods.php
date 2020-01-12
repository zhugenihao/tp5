<?php

/**
 * 商品信息
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Directory as DirectoryModel;
use app\admin\model\Cates as CatesModel;
use app\admin\model\GoodsColor as GoodsColorModel;
use app\admin\model\Gallery as GalleryModel;
use app\admin\model\Brand as brandModel;
use app\admin\model\Freight as freightModel;
use \think\Db;
use think\cache;

class Goods extends Common {

    public function GoodsList() {
        $page = input('get.page');
        $search = input('search');
        $dir_id = input('dir_id');
        $list = cache::get('goods_list' . $page . $search . $dir_id);
        if (empty($list)) {
            $list = GoodsModel::getGoodsList(10, ['store_id' => 0]);
            cache::set('goods_list' . $page . $search . $dir_id, $list);
        }
        $this->assign("list", $list['list']);
        $this->assign("limit", 10);
        $this->assign("allcount", $list['count']);
        $this->assign("search", input('search'));
        $this->assign("dirId", input('dir_id'));
        $this->assign("datemin", input('datemin'));
        $this->assign("datemax", input('datemax'));
        $this->assign('page', $list['list']->render());
        $directory = directoryModel::getList(50);
        $this->assign("directoryList", $directory['list']);
        return $this->fetch();
    }

    /**
     * 销售排行
     * @return type
     */
    public function sales_ranking() {
        $store_id = input('store_id');
        $where = !empty($store_id) ? ['g.store_id' => $store_id] : [];
        $field = 'g.goods_id,g.thecover,g.goods_name,g.goods_sku,g.sales,g.goods_price,s.store_name';
        $goodsList = GoodsModel::getGoodsList(10, $where, $field, ['g.sales' => 'desc']);
        $this->assign('list', $goodsList['list']->toArray());
        $this->assign('page', $goodsList['list']->render());
        return $this->fetch();
    }

    public function goodsAdd() {
        $brandlist = brandModel::getBrandList(['store_id' => 0], 20);
        $this->assign("brandList", $brandlist['list']);
        if ($this->request->isAjax()) {
            $res = GoodsModel::goodsAdd();
            if ($res) {
                Tobesuccess("商品添加成功");
            } else {
                Tiperror("商品添加失败！");
            }
        }
        $freightList = freightModel::getList(['store_id' => 0], 'id,freight_name', 0, 50);
        $this->assign('freightList', $freightList);
        return $this->fetch();
    }

    public function catesList() {
        $dirId = input('get.dir_id');
        $catesList = CatesModel::getCatesList(['dir_id' => $dirId, 'c.is_show' => 1]);
        $GoodsColorList = GoodsColorModel::getList(['dir_id' => $dirId, 'color_show' => 1]);
        Tobesuccess('获取数据', array('cates_list' => $catesList['list'], 'goods_color_list' => $GoodsColorList['list']));
    }

    public function goodsEdit() {
        $info = GoodsModel::get(input('get.goods_id'));
        $this->assign('info', $info);
        $brandlist = brandModel::getBrandList(['store_id' => 0], 20);
        $this->assign("brandList", $brandlist['list']);

        if ($this->request->isAjax()) {
            $res = GoodsModel::goodsEdit();
            if ($res) {
                Tobesuccess("商品修改成功");
            } else {
                Tiperror("商品修改失败！");
            }
        }
        $freightList = freightModel::getList(['store_id' => 0], 'id,freight_name', 0, 50);
        $this->assign('freightList', $freightList);

        $directory2_id = DirectoryModel::getValue(['id' => $info['dir_id']], "pid");
        $directory1_id = DirectoryModel::getValue(['id' => $directory2_id], "pid");
        $this->assign(['directory1_id' => $directory1_id, 'directory2_id' => $directory2_id]);
        return $this->fetch();
    }

    public function singletopic_point_praise_list() {
        if ($this->request->isAjax()) {
            $cyf_id = input('post.cyf_id');
            $list = GoodsModel::singletopic_point_praise_list($cyf_id);
            echo json_encode($list);
        }
    }

    public function GoodsShow() {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $id = $post['id'];
            $info = GoodsModel::get($id);
            if ($info['is_show'] == '1') {
                $info->is_show = '2';
            } else {
                $info->is_show = '1';
            }
            $res = $info->save();
            $info2 = GoodsModel::get($id);
            if ($res) {
                Tobesuccess('操作成功', $info2);
            } else {
                Tiperror("操作失败");
            }
        }
    }

    public function Goodsdetel() {
        if ($this->request->isAjax()) {
            $Goods = GoodsModel::get(input('id'));
            $res = $Goods->delete();
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
            $result = GoodsModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

    /**
     * 商品多图管理
     * @return type
     */
    public function goodsimageslist() {
        if ($this->request->isAjax()) {
            $res = GalleryModel::galleryGoodsAdd();
            if ($res) {
                Tobesuccess("添加成功");
            } else {
                Tiperror("添加失败！");
            }
        }
        $goodsId = input('get.goods_id');
        $galleryList = GalleryModel::getGalleryList(['goods_id' => $goodsId]);
        $info = GoodsModel::get($goodsId);
        $this->assign("galleryList", $galleryList['list']);
        $this->assign('page', $galleryList['list']->render());
        $this->assign("info", $info);
        $this->assign("allcount", $galleryList['count']);
        $this->assign("limit", 10);
        return $this->fetch();
    }

}
