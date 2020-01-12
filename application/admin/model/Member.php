<?php

/**
 * 用户信息
 */

namespace app\admin\model;

use app\admin\model\Commons;
use \think\Db;

class Member extends Commons {

    protected $pk = 'id';
    protected $name = "member";

    //获取所有用户信息
    public function getMemberlist($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        if (!empty($search)) {
            $where['member_name|mobile|email'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
            'delete' => input('delete'),
        ];
        $where['delete'] = input('delete');
        $list['count'] = $this->where($where)->count();
        $list['list'] = $this->where($where)->order('create_time', 'desc')->paginate($limit, false, $map);          // 查询所有用户的所有字段资料
        return $list;   // 返回数据
    }

    //获取用户个人信息
    public function getMemberInfo($mid) {
        $info = Member::get($mid);
        return $info;
    }

    public static function getValue($mId, $value = 'id') {
        $res = self::where(['id' => $mId])->value($value);
        return $res;
    }

    public function member_addeditmd($mid) {

        $input = input('post.');
        $data = $_POST;
        if ($data) {
            if ($mid) {
                Member::where('id', $mid)->update($data);
            } else {
                $name = Member::get(['name' => trim($input['name'])]);
                if ($name) {
                    Tiperror("用户名已存在");
                }
                $mobile = Member::get(['mobile' => trim($input['mobile'])]);
                if ($mobile) {
                    Tiperror("手机号已存在");
                }
                $email = Member::get(['email' => trim($input['email'])]);
                if ($email) {
                    Tiperror("邮箱已存在");
                }
                $data['create_time'] = time();
                $data['state'] = 1;
                $users = Member::create($data);
            }

            Tobesuccess('操作成功', $mid);
        } else {
            Tiperror("操作失败");
        }
    }

    public function getCollection_list($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $collection = db::name("collection");
        $where = [];
        if (!empty($search)) {
            $where['m.name|w.cartoon_name'] = array('like', "%" . $search . "%");
        }
        if (!empty($datemin)) {
            $where['c.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['c.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['c.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $pre = config('DB_PREFIX');
        $list['count'] = $collection->alias('c')
                        ->join("{$pre}member m", 'm.id=c.m_id', 'LEFT')
                        ->join("{$pre}works w", 'w.id=c.goods_id', 'LEFT')
                        ->where($where)->count();
        $field = "c.*,m.name as uname,m.photo,m.id as m_id,w.cartoon_name,w.cross_img";
        $list['list'] = $collection->alias('c')
                        ->join("{$pre}member m", 'm.id=c.m_id', 'LEFT')
                        ->join("{$pre}works w", 'w.id=c.goods_id', 'LEFT')
                        ->field($field)->where($where)->order('create_time', 'desc')->paginate($limit, false, $map);
        return $list;
    }

}
