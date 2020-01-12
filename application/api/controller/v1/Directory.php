<?php
/**
 * 导航信息
 */
namespace app\api\controller\v1;

use app\api\controller\v1\Common;
use \think\Db;
use app\common\model\Directory as directoryModel;
use app\common\model\Advert as advertModel;

class Directory extends Common {

    public function index() {
        $dirfield = 'id,title,home_template_m,small_icon,alias';
        $dirWhere = ['type' => 3, 'pid' => 0];
        $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 12)->toArray();
        $list = array();
        foreach($directoryList as $val){
            if(!in_array($val['id'],array(1,61,62))){
                $list[] = $val;
            }
        }
        $this->assign('directoryList',$list);
        return $this ->fetch();
    }
    /**
     * 某个导航的子导航
     */
    public function directoryPider(){
        if ($this->request->isAjax()) {
            $get = input('get.');
            $dirWhere = ['type' => 3, 'pid' => $get['dir_id']];
            $dirfield = 'id,title,home_template_m,small_icon,alias,images';
            $directoryList = directoryModel::getDirectoryList($dirWhere, $dirfield, 10)->toArray();
            foreach($directoryList as $key=>$val){
                $direrWhere = ['type' => 3, 'pid' => $val['id']];
                $directoryList[$key]['directory_er'] = directoryModel::getDirectoryList($direrWhere, $dirfield, 10)->toArray();
            }
            $advert = advertModel::getInfo(['dir_id'=>$get['dir_id'],'ad_types'=>2],'dir_id,adv_link,dire');
            $advert = !empty($advert) ? $advert : array('adv_link'=>'','dire'=>'');
            $list = array('directory_list'=>$directoryList,'advert'=>$advert);
            exit(json_encode($list));
        }
    }

}
