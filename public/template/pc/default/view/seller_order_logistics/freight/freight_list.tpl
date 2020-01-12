
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>运费模板管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>计费方式</label>
                <div class="layui-input-inline">
                    <select name="billing_way" class="selectpad">
                        <option value="0">请选择</option>
                        <option value="1" {eq name=":input('billing_way')" value="1"} selected {/eq}>件数</option>
                        <option value="2" {eq name=":input('billing_way')" value="2"} selected {/eq}>重量</option>
                        <option value="3" {eq name=":input('billing_way')" value="3"} selected {/eq}>体积</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="运费模板名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="5" name="top"/>
                <input type="hidden" value="5" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delFreight(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除运费模板
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_order_logistics.freight/freight_add',['top'=>5,'type'=>5])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加运费模板
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>运费模板名称</th>
                    <th>计费方式</th>
                    <th>首项</th>
                    <th width="100">首项运费(￥)</th>
                    <th>续项</th>
                    <th width="100">续项运费(￥)</th>
                    <th width="80">使用</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="freight['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['freight_name']}</td>
                    <td>
                        {eq name="vo['billing_way']" value="1"}件数{/eq}
                        {eq name="vo['billing_way']" value="2"}重量{/eq}
                        {eq name="vo['billing_way']" value="3"}体积{/eq}
                    </td>
                    <td>
                        {eq name="vo['billing_way']" value="1"}首件数(件)：{$vo['first_number']}{/eq}
                        {eq name="vo['billing_way']" value="2"}首重量(kg)：{$vo['first_heavy']}{/eq}
                        {eq name="vo['billing_way']" value="3"}首体积(立方米)：{$vo['first_volume']}{/eq}

                    </td>
                    <td>{$vo['first_fee']}</td>
                    <td>
                        {eq name="vo['billing_way']" value="1"}续件数(件)：{$vo['tocontinue_number']}{/eq}
                        {eq name="vo['billing_way']" value="2"}续重量(kg)：{$vo['tocontinue_heavy']}{/eq}
                        {eq name="vo['billing_way']" value="3"}续体积(立方米)：{$vo['tocontinue_volume']}{/eq}
                    </td>
                    <td>{$vo['tocontinue_fee']}</td>
                    <td>
                        {eq name="vo['is_use']" value="1"}
                        <span class="color-green">是</span> 
                        {/eq}
                        {eq name="vo['is_use']" value="2"}
                        <span class="color-red">否</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_order_logistics.freight/freight_details',['top'=>5,'type'=>5,'freight_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delFreight(this)" data-freightid="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $freight['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller_order_logistics/freight/freight_list.js"></script>
