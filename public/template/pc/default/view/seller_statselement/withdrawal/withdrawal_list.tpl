
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>提现申请管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>申请时间</label>
                <span>
                    <input type="text" value="{:input('start_time')}" id="start_time" name="start_time" size="15" class="member_text"/>-
                    <input type="text" value="{:input('end_time')}" id="end_time" name="end_time" size="15" class="member_text"/>
                </span>
                <label>状态</label>
                <span>
                    <select name="state" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('state')" value="1"} selected {/eq}>申请中</option>
                        <option value="2" {eq name=":input('state')" value="2"} selected {/eq}>审核成功</option>
                        <option value="3" {eq name=":input('state')" value="3"} selected {/eq}>审核失败</option>
                        <option value="4" {eq name=":input('state')" value="4"} selected {/eq}>已关闭</option>
                        <option value="5" {eq name=":input('state')" value="5"} selected {/eq}>已转账</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" size="30" class="member_text" placeholder="银行账号/银行账户名"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="7" name="top"/>
                <input type="hidden" value="1" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">

            <div class="floatright">
                <a href="javascript:;" onclick="withdrawalAdd(this)" url="{:url('seller_statselement.withdrawal/withdrawal_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    立即提现
                </a>
            </div>
            <div class="tixian-yue">可提现(￥)：<span>{$seller['seller_forehead']}</span></div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>申请金额</th>
                    <th>银行名称</th>
                    <th>银行账号</th>
                    <th>银行账户名</th>
                    <th>余额</th>
                    <th width="170">申请时间</th>
                    <th>注释</th>
                    <th width="100">状态</th>
                    <th width="80">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="withdrawal['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['toapplyfor_amount']}</td>
                    <td>{$vo['bank_name']}</td>
                    <td>{$vo['bank_account']}</td>
                    <td>{$vo['account_name']}</td>
                    <td>{$vo['balance']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>{$vo['note']}</td>
                    <td>
                        {eq name="vo['state']" value="1"}
                        <span class="color-blue">申请中</span> 
                        {/eq}
                        {eq name="vo['state']" value="2"}
                        <span class="color-green">审核成功</span> 
                        {/eq}
                        {eq name="vo['state']" value="3"}
                        <span class="color-red">审核失败</span> 
                        {/eq}
                        {eq name="vo['state']" value="4"}
                        <span class="color-red">已关闭</span> 
                        {/eq}
                        {eq name="vo['state']" value="5"}
                        <span class="color-green">已转账</span> 
                        {/eq}
                    </td>

                    <td>
                        <div class="tablediv-btn">

                        </div>
                    </td>
                </tr>
                {/volist}
                {if $withdrawal['total'] < 1}
                    <tr class="tbcenter"><td colspan="11">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_statselement/withdrawal/withdrawal_list.js"></script>
