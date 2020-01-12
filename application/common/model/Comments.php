<?php

/**
 * 商品评论信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use app\common\model\TemporaryImg as temporaryImgModel;
use app\common\model\CommentsImg as commentsImgModel;
use app\common\model\OrderGoods as orderGoodsModel;
use app\common\model\Goods as goodsModel;
use app\common\model\Member as memberModel;
use app\common\model\BesidesContent;

class Comments extends Commons {

    protected $pk = 'id';
    protected $name = "comments";

    public static function updates($where = [], $data = []) {
        return self::where($where)->update($data);
    }

    public function commentsImg() {
        $field = '*';
        return $this->hasMany('CommentsImg', 'comments_id', 'id')->field($field)->order('id', 'desc');
    }

    public function member() {
        return $this->hasOne('Member', 'id', 'm_id')->field('id,photo,member_name');
    }

    public static function getList($where = [], $limit = 10, $field = '*') {
        $search = trim(input('search'));
        $is_show = trim(input('is_show'));
        $start_time = strtotime(input('start_time'));
        $end_time = strtotime(input('end_time'));
        if (!empty($search)) {
            $where['goods_name|member_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($is_show)) {
            $where['is_show'] = $is_show;
        }
        if (!empty($start_time)) {
            $where['create_time'] = ['>= time', $start_time];
        }
        if (!empty($end_time)) {
            $where['create_time'] = ['<= time', $end_time];
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where['create_time'] = ['between', [$start_time, $end_time]];
        }
        $map['query'] = [
            'search' => $search,
            'is_show' => $is_show,
        ];
        $list = self::field($field)->where($where)->order(['id' => 'desc'])->paginate($limit, false, $map);
        return $list;
    }

    public static function getCommentslist($where = [], $start = 0, $limit = 10, $field = '*', $order = []) {
        $order['create_time'] = 'desc';
        $list['count'] = self::where($where)->count();
        $list['list'] = self::with(['commentsImg', 'member'])->field($field)->where($where)->order($order)->limit($start, $limit)->select()->toArray();
        $list['mid'] = member_id();
        return $list;
    }

    public static function getCount($where = []) {
        return self::where($where)->count();
    }

    public static function add($mId) {
        $post = input('post.');
        $result = false;
        $orderNo = orderGoodsModel::getValue(['id' => $post['order_id']], "order_no");
        $goodsName = goodsModel::getValue(['goods_id' => $post['goods_id']], 'goods_name');
        $memberName = memberModel::getwhereValue(['id' => $mId], 'member_name');
        $besidesContent = BesidesContent::getScore();
        foreach ($besidesContent as $val) {
            $besidesContent[$val['score']] = $val['name'];
        }
        $data = ['m_id' => $mId, 'goods_id' => $post['goods_id'], 'texts' => $post['texts'],
            'order_no' => $orderNo, 'score' => $post['score'], 'goods_name' => $goodsName,
            'member_name' => $memberName, 'score_name' => $besidesContent[$post['score']],
            'create_time' => time()];
        try {
            $result = self::create($data);
            if (isset($post['comimg'])) {
                $imgData = array();
                foreach ($post['comimg'] as $imgKey => $imgVal) {
                    $imgData[$imgKey]['m_id'] = $mId;
                    $imgData[$imgKey]['comments_id'] = $result->id;
                    $imgData[$imgKey]['img_url'] = $imgVal;
                }
                $commentsImgModel = new commentsImgModel();
                $commentsImgModel->saveAll($imgData);
            }
            self::delTemporaryImg($mId);
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除临时图片
     * @param type $mId
     */
    public static function delTemporaryImg($mId) {
        $temporaryImgList = temporaryImgModel::getList(['m_id' => $mId])->toArray();
        foreach ($temporaryImgList as $tepVal) {
            $pathDel = ROOT_PATH . "public/static/";
            $comCount = commentsImgModel::getCount(['m_id' => $mId, 'img_url' => $tepVal['img_url']]);
            if (!empty($tepVal['img_url']) && empty($comCount)) {
                if (file_exists($pathDel . $tepVal['img_url'])) {
                    unlink($pathDel . $tepVal['img_url']);
                }
            }
            temporaryImgModel::getDel(['id' => $tepVal['id']]);
        }
    }

    public static function getDel($where = []) {
        $commentsImgList = commentsImgModel::getList(['comments_id' => $where['id']])->toArray();
        foreach ($commentsImgList as $cimgVal) {
            $pathDel = ROOT_PATH . "public/static/";
            if (!empty($cimgVal['img_url'])) {
                if (file_exists($pathDel . $cimgVal['img_url'])) {
                    unlink($pathDel . $cimgVal['img_url']);
                }
            }
            commentsImgModel::getDel(['id' => $cimgVal['id']]);
        }
        return self::where($where)->delete();
    }

}
