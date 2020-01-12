<?php
/**
 * 用户反馈信息
 */
namespace app\common\model;

use app\common\model\Commons;
use \think\Db;

class Feedback extends Commons {

    protected $pk = 'id';
    protected $name = "feedback";

    public static function getFeedbacklistmd($mId, $start, $limit) {
        $list = self::where("m_id", $mId)->order("create_time", "desc")->limit($start, $limit)->select()->toArray();
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date("Y-m-d", strtotime($value['create_time']));
        }
        $count = self::getCount($mId);
        $countType = $count < $limit ? 1 : 0;
        return array('list' => $list, 'count_type' => $countType);
    }

    public static function getCount($mId) {
        return self::where("m_id", $mId)->count();
    }

    public static function feedbackSubmitmd($mId) {
        $post = input('post.');
        $data = ['m_id' => $mId, 'text' => $post['text'], 'contact' => $post['contact'], 'create_time' => time()];
        $info = self::get(['text' => $post['text'], 'm_id' => $mId]);
        if (!empty($info))
            Tiperror("反馈信息已经存在！");
        $res = self::create($data);
        if ($res) {
            Tobesuccess("提交成功");
        } else {
            Tiperror("提交失败！");
        }
    }

}
