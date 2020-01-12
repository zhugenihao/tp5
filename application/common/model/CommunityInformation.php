<?php

/**
 * 社区信息
 */

namespace app\common\model;

use app\common\model\Commons;
use \think\Db;
use \think\Cache;
use \think\Image;
use \think\Log;

class CommunityInformation extends Commons {

    protected $pk = 'id';
    protected $name = "community_information";

    public static function getCommunityInformationlistmd($start = 0, $limit = 10, $mId = 0) {
        $list = self::alias('c')
                        ->join("dm_member m", 'm.id=c.m_id', 'LEFT')
                        ->field("c.*,m.name as uname,m.photo,m.id as m_id")
                        ->where('c.is_show', '=', 1)->order(['c.create_time' => 'desc'])->limit($start, $limit)->select();
        $count = self::alias('c')->join("dm_member m", 'm.id=c.m_id', 'LEFT')->where('c.is_show', '=', 1)->count();
        foreach ($list as $key => $val) {
            $list[$key]['alltcpraise'] = db::name("topic_point_praise")->where(['cyf_id' => $val['id'], 'state' => 1])->count();
            $list[$key]['allslpraise'] = db::name("singletopic_point_praise")->where(['cyf_id' => $val['id'], 'is_show' => 1])->count();
            $list[$key]['picture_url'] = json_decode($val['picture_url'], true);
            $list[$key]['is_focus_on_author'] = db::name("focus_on_author")->where(['user_m_id' => $mId, 'author_m_id' => $val['m_id'], 'state' => 1])->count();
        }
        return array('list' => $list, 'count' => $count);
    }

    public static function cyfUpload($mId) {
        $post = input('post.');
        $CacheimgStr = "";
        $picture_url_str = "";
        $retArr = array('type' => 0, 'prompt' => '');
        $file = request()->file("file");
        // Log::init(['type' => 'File', 'path' => APP_PATH . 'logs/', 'apart_level' => ['error', 'sql'],]);
        if ($file) {
            // 移动到框架应用根目录public/static/images/cyf_picture/ 目录下
            $info = $file->validate(['size' => 1567800 * 1024, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static/images/cyf_picture');
            if ($info) {
                $time = date("Ymd");
                $CacheimgStr = $time . "/" . $info->getFilename();
//                print_r($CacheimgStr);
            } else {
                Tiperror("上传失败", $file->getError());
            }
        }
        $temporary_img = db::name('temporary_img');
        if ($post['i'] == 0 || $CacheimgStr == '') {//删除残余
            $picture_url_arrOne = $temporary_img->field('id,url')->where('m_id', $mId)->select();
            if ($picture_url_arrOne) {
                foreach ($picture_url_arrOne as $val) {
                    if ($val['url'] && file_exists(ROOT_PATH . "public/static/images/cyf_picture/" . $val['url'])) {
                        unlink(ROOT_PATH . "public/static/images/cyf_picture/" . $val['url']); //删除文件
                    }
                    $temporary_img->where('id', $val['id'])->delete();
                }
            }
        }

        if ($CacheimgStr) {
            $temporary_img->insert(['m_id' => $mId, 'url' => $CacheimgStr]);
            // Log::record('远程调试insert');
        }
        try {
            if ($post['i'] == ($post['length'] - 1)) {
                if (!empty($CacheimgStr))
                    time_sleep_until(time() + 3);
                $picture_url_arr = $temporary_img->field('url')->where('m_id', $mId)->select();
                $picture_url_str = json_encode($picture_url_arr);
                $data = ['content' => $post['content'], 'm_id' => $mId, 'picture_url' => $picture_url_str, 'is_show' => 1, 'create_time' => time()];
                $result = self::create($data);
                $temporary_img->where('m_id', $mId)->delete();
                $ret = !empty($result) ? true : false;
                $retArr = array('type' => 1, 'prompt' => $ret);
                return $retArr;
            }
            return $retArr;
        } catch (\Exception $e) {
            ///Log::record($e->getMessage());
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    public static function uploadPhotosmder($mId) {
        $post = input('post.');
        $CacheimgStr = array();
        $content = !empty($post['content']) ? $post['content'] : '';
        $file = request()->file("files");
        if ($file) {
            $path = ROOT_PATH . 'public' . DS . 'static/images/cyf_picture/';
            foreach ($file as $key => $val) {// 移动到框架应用根目录public/static/images/cyf_picture/ 目录下
                $info = $val->validate(['size' => 8000000, 'ext' => 'jpg,png,gif'])->move($path);
                $image = Image::open($path . $info->getSaveName());
                $image->thumb(800, 800)->save($path . $info->getSaveName(), null, 60); //图片压缩
                if ($info) {
                    $CacheimgStr[]['url'] = $info->getSaveName();
                } else {
                    Tiperror("上传失败", $file->getError());
                }
            }
        }
        try {
            $picture_url_str = json_encode($CacheimgStr);
            $data = ['content' => $content, 'm_id' => $mId, 'picture_url' => $picture_url_str, 'is_show' => 1, 'create_time' => time()];
            $result = self::create($data);
            return $result;
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    //图片上传
    public static function uploadPhotosmd($mId) {
        $post = input('post.');
//      print_r($_FILES);die();
        $type = $_FILES["file"]["type"];
        $size = $_FILES["file"]["size"];
        if (($type == "image/png" || $type == "image/jpeg") && $size < 1024000) {
            $base64_string = explode(',', $post['imgurl']);
            ;
            $data = base64_decode($base64_string[1]);
            $fileName = date('YmdHis') . '-' . mt_rand(100, 999);
            $path = ROOT_PATH . 'public' . DS . 'static/images/cyf_picture/' . date("Ymd");
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $filename = $path . "/" . $fileName . '.jpg';
            $filename = iconv("UTF-8", "gb2312", $filename);
            $fp = fopen($filename, 'w');
            fwrite($fp, trim($data));
            fclose($fp);
        } else {
            echo"文件类型不对";
        }
        try {
            $CacheimgStr = date("Ymd") . "/" . $fileName . '.jpg';
            $temporary_img = db::name('temporary_img');
            $temporary_img->insert(['m_id' => $mId, 'url' => $CacheimgStr]);
//            echo "图片上传成功(".$CacheimgStr.")";
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    public static function cyfUploader($mId) {
        $post = input('post.');
        $temporary_img = db::name('temporary_img');
        $picture_url_arr = $temporary_img->field('url')->where('m_id', $mId)->select();
        try {
            $picture_url_str = json_encode($picture_url_arr);
            $data = ['content' => $post['content'], 'm_id' => $mId, 'picture_url' => $picture_url_str, 'is_show' => 1, 'create_time' => time()];
            $result = self::create($data);
            $temporary_img->where('m_id', $mId)->delete();
            $ret = !empty($result) ? 1 : 0;
            $retArr = array('type' => $ret, 'prompt' => '');
            return $retArr;
        } catch (\Exception $e) {
            Tiperror("出现其他异常", $e->getMessage());
        }
    }

    //社区话题删除
    public static function cyfDel($idStr) {
        $idArr = explode(',', $idStr);
        foreach ($idArr as $key => $val) {
            $info = self::where('id', '=', $val)->find();
            $picture_urlArr = json_decode($info['picture_url'], true);
            foreach ($picture_urlArr as $k => $v) {
                if ($v['url'] && file_exists(ROOT_PATH . "public/static/images/cyf_picture/" . $v['url'])) {
                    unlink(ROOT_PATH . "public/static/images/cyf_picture/" . $v['url']); //删除文件
                }
            }
            db::name("topic_point_praise")->where('cyf_id', $val)->delete(); //删除点赞
            db::name("singletopic_point_praise")->where('cyf_id', $val)->delete(); //删除评论
        }
        $res = self::destroy($idArr);
        $ret = !empty($res) ? true : false;
        return $ret;
    }

    //点赞
    public static function topicPointPraisemd($id, $mId) {
        $res = false;
        $topicPointPraise = db::name("topic_point_praise");
        $info = $topicPointPraise->where(['m_id' => $mId, 'cyf_id' => $id])->find();
        if ($info) {
            $state = $info['state'] == 1 ? 2 : 1;
            $res = $topicPointPraise->where(['m_id' => $mId, 'cyf_id' => $id])->update(['state' => $state]);
            if ($info['state'] == 1 && $res) {
                $ret = !empty($res) ? 2 : false;
            } else if ($info['state'] == 2 && $res) {
                $ret = !empty($res) ? 1 : false;
            }
        } else {
            $res = $topicPointPraise->insert(['m_id' => $mId, 'cyf_id' => $id, 'state' => 1, 'create_time' => time()]);
            $ret = !empty($res) ? 1 : false;
        }

        return $ret;
    }

    public static function focusOnAuthormd($authorMid, $mId) {
        $res = false;
        $focusOnAuthor = db::name("focus_on_author");
        if ($authorMid == $mId)
            return 3;
        $info = $focusOnAuthor->where(['user_m_id' => $mId, 'author_m_id' => $authorMid])->find();
        if ($info) {
            $state = $info['state'] == 1 ? 2 : 1;
            $res = $focusOnAuthor->where(['user_m_id' => $mId, 'author_m_id' => $authorMid])->update(['state' => $state]);
            if ($info['state'] == 1 && $res) {
                $ret = !empty($res) ? 2 : false;
            } else if ($info['state'] == 2 && $res) {
                $ret = !empty($res) ? 1 : false;
            }
        } else {
            $res = $focusOnAuthor->insert(['user_m_id' => $mId, 'author_m_id' => $authorMid, 'state' => 1, 'create_time' => time()]);
            $ret = !empty($res) ? 1 : false;
        }
        return $ret;
    }

}
