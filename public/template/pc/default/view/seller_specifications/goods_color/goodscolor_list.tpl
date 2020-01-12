
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue floatleft top-btns">
        <div><a href="{:url('seller_specifications.cates/cates_list')}" class="mall_btn">版本管理</a></div>
        <div><a href="{:url('seller_specifications.goods_color/goodscolor_list')}" class="mall_btn goodsbtn_act">颜色管理</a></div>
    </div>

    <div class="churuzhang floatfalse">
        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>状态</label>
                <span>
                    <select name="kefu_type" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>显示</option>
                        <option value="0" {eq name=":input('is_show')" value="0"} selected {/eq}>隐藏</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="颜色名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delGoodsColor(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除颜色
                </a>
            </div>
            <div class="floatright">
                <a href="javascript:;" onclick="goodsColorAdd(this)" url="{:url('seller_specifications.goods_color/goodsColor_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加颜色
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>颜色名称</th>
                    <th>一级类目名称</th>
                    <th>二级类目名称</th>
                    <th>三级类目名称</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="goodsColor['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['color_name']}</td>
                    <td>【{$vo['directory1_name']}】</td>
                    <td>【{$vo['directory2_name']}】</td>
                    <td>【{$vo['directory3_name']}】</td>
                    <td>【{$vo['sort']}</td>
                    <td>
                        {eq name="vo['color_show']" value="1"} 显示 {/eq}
                        {eq name="vo['color_show']" value="0"} 隐藏 {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="goodsColorDetails(this)" url="{:url('seller_specifications.goods_color/goodsColor_details',['id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delGoodsColor(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $goodsColor['total'] < 1}
                    <tr class="tbcenter"><td colspan="10">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_specifications/goodscolor/goodscolor_list.js"></script>
