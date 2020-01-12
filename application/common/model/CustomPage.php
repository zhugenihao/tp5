<?php

/**
 * 自定义分页
 */

namespace app\common\model;

class CustomPage {

    public static function page($array = array(), $pagesize = 10, $pageArray = array()) {
        $_return = array();
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $total = ceil(Count($array) / $pagesize); //求总页数

        $prev = (($page - 1) <= 0 ? "1" : ($page - 1)); //确定上一页，如果当前页是第一页，点击显示第一页
        $next = (($page + 1) >= $total ? $total : $page + 1); //确定下一页，如果当前页是最后一页，点击下页显示最后一页
        $page = ($page > ($total) ? ($total) : $page); //当前页如果大于总页数，当前页为最后一页
        $start = ($page - 1) * $pagesize; //分页显示时，应该从多少条信息开始读取

        for ($i = $start; $i < ($start + $pagesize); $i++) {
            array_push($_return, $array[$i]); //将该显示的信息放入数组 $_return 中
        }
        foreach ($_return as $k => $v) {
            if (!$v)
                unset($_return[$k]);
        }
        $pageStr = '';
        foreach ($pageArray as $key => $val) {
            if ($val) {
                $pageStr .= "&" . $key . "=" . $val;
            }
        }
        $pagearray["source"] = $_return;
        $str .= $page == 1 ? "<ul class=\"pagination\"><li><span>首页</span></li>" : "<ul class=\"pagination\"><li><a href=\"?page=1{$pageStr}\">首页</a></li>";
        $str .= $page == $prev ? "<li><span>上一页</span></li> " : "<li><a href=\"?page={$prev}{$pageStr}\">上一页</a></li> ";
        for ($j = 1; $j < $total + 1; $j++) {
            if ($j == $page) {
                $str .= "<li class=\"active\"><span>$j</span>\n\n </li>";
            } else {
                $str .= "<li><a href=\"?page=$j{$pageStr}\">$j</a>\n\n </li>";
            }
        }
        $str .= $next == $page ? "<li><span>下一页</span></li>" : "<li><a href=\"?page={$next}{$pageStr}\">下一页</a></li>";
        $str .= $next == $page ? "<li><span>最后一页</span></li></ul>" : "<li><a href=\"?page={$total}{$pageStr}\">最后一页</a></li></ul>";
        $pagearray["page"] = $str;
        return $pagearray;
    }

}
