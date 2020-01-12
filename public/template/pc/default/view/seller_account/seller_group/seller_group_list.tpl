
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>账号组管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="账号组名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSellerGroup(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除账号组
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_account.seller_group/seller_group_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加账号组
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>账号组名称</th>
                    <th>创建时间</th>
                    <th width="100">排序</th>
                    <th width="100">状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="sellerGroup['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['group_name']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>{$vo['sort']}</td>
                    <td>
                        {eq name="vo['state']" value="1"} 启用 {/eq}
                        {eq name="vo['state']" value="2"} 禁用 {/eq}
                    </td>

                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_account.seller_group/seller_group_details',['group_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delSellerGroup(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $sellerGroup['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_account/seller_group/seller_group_list.js"></script>
