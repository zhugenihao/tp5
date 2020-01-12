
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>商家账号管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>类型</label>
                <span>
                    <select name="seller_delete" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('seller_delete')" value="1"} selected {/eq}>启用</option>
                        <option value="2" {eq name=":input('seller_delete')" value="2"} selected {/eq}>禁用</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="商家账号名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSeller(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除商家账号
                </a>
            </div>
            <div class="floatright">
                <a href="javascript:;" onclick="sellerAdd(this)" url="{:url('seller_account.seller/seller_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加商家账号
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>账号名称</th>
                    <th>账号组</th>
                    <th>创建时间</th>
                    <th width="100">状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="seller['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['seller_name']}</td>
                    <td>{$vo['group_name']}</td>
                    <td>{$vo['checkin_time']}</td>
                    <td>
                        {eq name="vo['seller_delete']" value="1"} 启用 {/eq}
                        {eq name="vo['seller_delete']" value="2"} 禁用 {/eq}
                    </td>
                    
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="sellerDetails(this)" url="{:url('seller_account.seller/seller_details',['seller_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delSeller(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $seller['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_account/seller/seller_list.js"></script>
