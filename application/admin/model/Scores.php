<?php
/**
 * 商品评分信息
 */
namespace app\admin\model;
use app\admin\model\Commons;
use \think\Db;
class Scores extends Commons {

    protected $pk = 'id';
    protected $name = "score";
    public function getScorelist($limit) {
        $search = trim(input('search'));
        $datemin = strtotime(input('datemin'));
        $datemax = strtotime(input('datemax'));
        $where = [];
        if (!empty($search)) {
            $where['s.score|m.name|w.cartoon_name'] = array('like',"%".$search."%");
        }
        if (!empty($datemin)) {
            $where['s.create_time'] = ['>= time', $datemin];
        }
        if (!empty($datemax)) {
            $where['s.create_time'] = ['<= time', $datemax];
        }
        if (!empty($datemin) && !empty($datemax)) {
            $where['s.create_time'] = ['between', [$datemin, $datemax]];
        }
        $map['query'] = [
            'search' => $search,
            'datemin' => input('datemin'),
            'datemax' => input('datemax'),
        ];
        $pre = config('DB_PREFIX');
        $list['count'] = $this->alias('s')
                        ->join("{$pre}member m", 'm.id=s.m_id', 'LEFT')
                        ->join("{$pre}goods g", 'g.goods_id=s.goods_id', 'LEFT')
                        ->field("s.*,m.name as uname,g.goods_name,thecover")->where($where)->count();
        $list['list'] = $this->alias('s')
                        ->join("{$pre}member m", 'm.id=s.m_id', 'LEFT')
                        ->join("{$pre}goods g", 'g.goods_id=s.goods_id', 'LEFT')
                        ->field("s.*,m.name as uname,m.photo,m.id as m_id,m.avatarUrl,g.goods_name,g.thecover")->where($where)->order('create_time', 'desc')->paginate($limit, false, $map);
        return $list;
    }
    

}
