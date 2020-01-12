<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>品牌管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>状态</label>
                <div class="layui-input-inline">
                    <select name="is_show" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>上架</option>
                        <option value="0" {eq name=":input('is_show')" value="0"} selected {/eq}>下架</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="品牌名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="3" name="top"/>
                <input type="hidden" value="5" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delBrand(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除品牌
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('brand/brand_add',['top'=>3,'type'=>5])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加品牌
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>品牌logo</th>
                    <th>品牌名称</th>
                    <th width="170">更新时间</th>
                    <th width="80">状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="brandList" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>
                        <div class="goods-img">
                            <img src="__STATIC__/{$vo['brand_logo']}" width="50" height="50">
                        </div>
                    </td>
                    <td>{$vo['brand_name']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">已上架</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="0"}
                        <span class="color-red">已下架</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('brand/brand_details',['top'=>3,'type'=>5,'brand_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delBrand(this)" data-brandid="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if count($brandList) < 1}
                    <tr class="tbcenter"><td colspan="7">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/brand/brand_list.js"></script>
