<?php

namespace app\api\service;

require_once "../extend/WxPay/WxPay.Api.php";

use app\api\model\v1\Topuprecord as TopuprecordModel;
use app\api\model\v1\ReadingNotes as ReadingNotesModel;
use app\api\model\v1\Member as MemberModel;
use think\Exception;
use think\Log;
use think\Db;

class WxNotify extends \WxPayNotify {

    //回调方法
    public function NotifyProcess($data, &$msg) {
        if ($data['result_code'] == 'SUCCESS') {
            $order_number = $data['out_trade_no'];
            Db::startTrans();
            try {
                $Topuprecord = TopuprecordModel::where("order_number", "=", $order_number)->find();
                if ($Topuprecord->state == 3) {
                    $this->TopuprecordUpdate($Topuprecord->id);
                    $this->readingNotesAdd($Topuprecord->m_id, $Topuprecord->rdnte_num);
                }
                Db::commit();
                return true;
            } catch (Exception $ex) {
                Db::rollback();
                Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }

    private function TopuprecordUpdate($id) {
        $data['state'] = 1;
        TopuprecordModel::where("id", "=", $id)->update($data);
    }
    //赠送漫画阅读券
    private function readingNotesAdd($mid,$number){
        $data = [ 'm_id'=>$mid, 'number'=>$number, 'create_time'=>time() ];
        $readingNotes = MemberModel::where(['id'=>$mid])->value('reading_notes');
        if(!empty($data)){
            ReadingNotesModel::create($data);
            $readingNotesAll = $readingNotes + $number;
            MemberModel::where(['id'=>$mid])->update(['reading_notes'=>$readingNotesAll]);
        }
    }

}
