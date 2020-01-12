<?php

/**
 * 店铺类目信息
 */

namespace app\index\controller\seller_store;

use app\index\controller\SellerCommon;
use \think\Db;
use app\index\model\BusinessCategory as businessCategoryModel;
use app\common\model\Directory as directoryModel;

class BusinessCategory extends SellerCommon {

    public function bcategory_list() {
        $store = $this->store;
        $bcategory = businessCategoryModel::getBcategoryList(['store_id' => $store['id']], 10);
        $this->assign('bcategory', $bcategory->toArray());
        $this->assign('page', $bcategory->render());
        return $this->fetch();
    }

    public function bcategory_add() {
        $store = $this->store;
        if ($this->request->isAjax()) {
            $result = businessCategoryModel::bcategoryAddMd($store['id']);
            if ($result) {
                Tobesuccess('类目审核提交成功');
            } else {
                Tiperror("类目审核提交失败！");
            }
        }
        $dirfield = 'id,title,home_template_p,small_icon';
        $dirWhere = ['type' => 3, 'pid' => 0,'id'=>['not in','1,61,62']];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 50)->toArray();
        $this->assign('directoryBigList', $directoryList);
        return $this->fetch();
    }


    /**
     * 删除类目
     */
    public function delBcategory() {
        if ($this->request->isAjax()) {
            $id_str = input('id_str');
            $id_arr = explode(",", $id_str);

            if (empty($id_arr)) {
                Tiperror("您未选择！");
            }
            $result = businessCategoryModel::destroy($id_arr);
            if ($result) {
                Tobesuccess('删除成功');
            } else {
                Tiperror("删除失败");
            }
        }
    }

}
