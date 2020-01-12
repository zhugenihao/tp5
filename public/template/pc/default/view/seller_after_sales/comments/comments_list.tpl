
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>商品评论管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>评论时间</label>
                <div class="layui-input-inline">
                    <input type="text" value="{:input('start_time')}" id="start_time" name="start_time" size="15" class="member_text"/>-
                    <input type="text" value="{:input('end_time')}" id="end_time" name="end_time" size="15" class="member_text"/>
                </div>
                <label>显示</label>
                <div class="layui-input-inline">
                    <select name="is_show" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>是</option>
                        <option value="2" {eq name=":input('is_show')" value="2"} selected {/eq}>否</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" size="30" class="member_text" placeholder="商品名称/用户名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="7" name="top"/>
                <input type="hidden" value="1" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delComments(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除商品评论
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>商品名称</th>
                    <th>商品评论内容</th>
                    <th>用户名称</th>
                    <th width="170">商品评论时间</th>
                    <th width="100">显示</th>
                    <th width="180">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="comments['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>
                        <div class="goods-names">{$vo['goods_name']}</div>
                    </td>
                    <td> 
                        <div class="goods-names">{$vo['texts']}</div>
                    </td>
                    <td>{$vo['member_name']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">是</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="2"}
                        <span class="color-red">否</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="tablediv-btn">
                            <a href="javascript:;" class="btn-blue" onclick="commentsDetails(this)" url="{:url('seller_after_sales.comments/comments_details',['id'=>$vo['id']])}">详情</a>
                            <a href="javascript:;" class="btn-green" onclick="modifyShow(this)" data-id="{$vo['id']}">显示</a>
                            <a href="javascript:;" class="btn-red" onclick="delComments(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $comments['total'] < 1}
                    <tr class="tbcenter"><td colspan="10">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_after_sales/comments/comments_list.js"></script>
