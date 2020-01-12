
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>供货商管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="供货商名称/联系人/联系电话"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSupplier(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除供货商
                </a>
            </div>
            <div class="floatright">
                <a href="javascript:;" onclick="supplierAdd(this)" url="{:url('seller_store.supplier/supplier_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加供货商
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>供货商名称</th>
                    <th>联系人名称</th>
                    <th>联系电话</th>
                    <th>备注</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="supplier['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['supplier_name']}</td>
                    <td>{$vo['contact_name']}</td>
                    <td>{$vo['contact_phone']}</td>
                    <td>{$vo['note']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="supplierDetails(this)" url="{:url('seller_store.supplier/supplier_details',['supplier_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delSupplier(this)" data-supplierid="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $supplier['total'] < 1}
                    <tr class="tbcenter"><td colspan="8">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/supplier/supplier_list.js"></script>
