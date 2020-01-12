
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>退换货管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>状态</label>
                <div class="layui-input-inline">
                    <select name="state" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('state')" value="1"} selected {/eq}>审核中</option>
                        <option value="2" {eq name=":input('state')" value="2"} selected {/eq}>审核通过</option>
                        <option value="3" {eq name=":input('state')" value="3"} selected {/eq}>审核不通过</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" size="30" class="member_text" placeholder="订单编号/用户名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="7" name="top"/>
                <input type="hidden" value="1" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delRetplt(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除退换货
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>订单编号</th>
                    <th>数量*商品名称</th>
                    <th>退款金额</th>
                    <th>服务类型</th>
                    <th>用户名称</th>
                    <th width="170">申请时间</th>
                    <th width="100">状态</th>
                    <th width="180">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="retplt['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['order_no']}</td>
                    <td>
                        <div class="goods-names">
                            {$vo['goods_num']}*{$vo['goods_name']}
                        </div>
                    </td>
                    <td>{$vo['refund_amount']}</td>
                    <td>
                        {eq name="vo['service_type']" value="1"}
                        <span class="color-blue">退货</span> 
                        {/eq}
                        {eq name="vo['service_type']" value="2"}
                        <span class="color-green">换货</span> 
                        {/eq}
                    </td>
                    <td>{$vo['member_name']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['state']" value="1"}
                        <span class="color-blue">审核中</span> 
                        {/eq}
                        {eq name="vo['state']" value="2"}
                        <span class="color-green">审核通过</span> 
                        {/eq}
                        {eq name="vo['state']" value="3"}
                        <span class="color-red">审核不通过</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="tablediv-btn">
                            <a href="javascript:;" class="btn-blue" onclick="retpltDetails(this)" url="{:url('seller_after_sales.returns_replacement/retplt_details',['id'=>$vo['id']])}">详情</a>
                            <a href="javascript:;" class="btn-green" onclick="modifyAudit(this)" data-id="{$vo['id']}">审核</a>
                            <a href="javascript:;" class="btn-red" onclick="delRetplt(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $retplt['total'] < 1}
                    <tr class="tbcenter"><td colspan="10">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_after_sales/returns_replacement/retplt_list.js"></script>
