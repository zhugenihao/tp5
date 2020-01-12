<?php

/**
 * 用户优惠券信息
 */

namespace app\api\controller\v1;

use \think\Db;
use app\api\controller\v1\Common;
use app\common\model\CouponReceive as couponReceiveModel;
use app\common\model\Coupon as couponModel;

class CoponReceive extends Common {

    public function addCoponReceive() {
        if ($this->request->isGet()) {
            $cop_id = input('cop_id', 0, 'intval');
            $mid = $this->mId();
            $count = couponReceiveModel::getCount(['m_id' => $mid, 'cop_id' => $cop_id]);
            if ($count) {
                Tiperror("你已经领取了，快去购买吧！");
            }
            $coupon = couponModel::getInfo(['cop_id' => $cop_id]);
            if ($coupon['cop_num'] < 1) {
                Tiperror("优惠券已被领完！");
            }
            $result = couponReceiveModel::add(['m_id' => $mid, 'cop_id' => $coupon['cop_id'], 'receive_time' => time(),
                        'type' => $coupon['type'], 'type_id' => $coupon['type_id'], 'cop_price' => $coupon['cop_price'], 'copa_time' => $coupon['copa_time'],
                        'copb_time' => $coupon['copb_time'], 'full_amount' => $coupon['full_amount']]);
            if ($result) {
                couponModel::setDecs(['cop_id' => $cop_id], 'cop_num', 1);
                Tobesuccess('领取成功，快去购买吧！');
            } else {
                Tiperror("领取失败！");
            }
        }
    }

}
