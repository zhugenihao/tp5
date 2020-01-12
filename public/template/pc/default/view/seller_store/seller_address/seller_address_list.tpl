
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>地址管理</span></div>

    <div class="churuzhang">
        <form class="" action="" method="post" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>地址类型</label>
                <div class="layui-input-inline">
                    <select name="address_type" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('address_type')" value="1"} selected {/eq}>发货地址</option>
                        <option value="2" {eq name=":input('address_type')" value="2"} selected {/eq}>收货地址</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="联系人/手机/邮政编码"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="6" name="top"/>
                <input type="hidden" value="6" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSellerAddress(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除导航
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_store.seller_address/seller_address_add',['top'=>6,'type'=>6])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加导航
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th width="80">编号</th>
                    <th>联系人</th>
                    <th>手机</th>
                    <th>邮政编码</th>
                    <th width="100">地址类型</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="sellerAddress['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['contact_name']}</td>
                    <td>{$vo['mobile']}</td>
                    <td>{$vo['zip_code']}</td>
                    <td>
                        {eq name="vo['address_type']" value="1"}
                        <span class="color-green">发货地址</span> 
                        {/eq}
                        {eq name="vo['address_type']" value="2"}
                        <span class="color-green">收货地址</span> 
                        {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_store.seller_address/seller_address_details',['top'=>6,'type'=>6,'id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delSellerAddress(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $sellerAddress['total'] < 1}
                    <tr class="tbcenter"><td colspan="8">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/seller_address/seller_address_list.js"></script>
