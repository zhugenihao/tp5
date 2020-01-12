<?php
/**
 * 付款记录信息
 */
namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;
use app\common\model\Time as timeModel;

class PaymentLog extends Commons {

    protected $pk = 'id';
    protected $name = "payment_log";

    public static function getPaymentLogList($where = [], $field = '*', $limit = 10) {
        $search = trim(input('search'));
        $pay_state = trim(input('pay_state'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        if (!empty($search)) {
            $where['order_number|m.name|m.mobile'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['pl.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['pl.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['pl.create_time'] = ['between', [$datemin, $datemax]];
        }
        if (!empty($pay_state)) {
            $where['pl.state'] = $pay_state;
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
            'datemax' => $pay_state,
        ];
        $join = [
            ['mz_member m', 'm.id=pl.m_id', 'left'],
            ['mz_payment p', 'p.payment_mark=pl.payment_type', 'left'],
        ];
        $list['count'] = self::alias('pl')->join($join)->where($where)->count();
        $list['list'] = self::alias('pl')->field($field)->join($join)->where($where)->order(['create_time' => 'desc'])->paginate($limit, false, $map);
        $list['amount'] = self::getAmount($where,$join);
        return $list;
    }
    public static function getAmount($where,$join){
        $monthTime = timeModel::month();
        $yearTime = timeModel::year();
        $monthWhere['create_time'] = ['between', [$monthTime[0], $monthTime[1]]];
        $yearWhere['create_time'] = ['between', [$yearTime[0], $yearTime[1]]];
        $where['pl.state'] = TOSG_STATUS;
        $monthWhere['state'] = TOSG_STATUS;
        $yearWhere['state'] = TOSG_STATUS;
        //总入账
        $list['booked_all'] = sprintf('%.2f',self::alias('pl')->join($join)->where($where)->sum('amount'));
        //今年入账
        $list['booked_year'] = sprintf('%.2f',self::sums($monthWhere, 'amount'));
        //本月入账
        $list['booked_month'] = sprintf('%.2f',self::sums($yearWhere, 'amount'));
        return $list;
    }

    public static function updates($where = [], $data = []) {
        $result = self::where($where)->update($data);
        return $result;
    }

    public static function sums($where = [], $value='amount') {
        return self::where($where)->sum($value);
    }

}
