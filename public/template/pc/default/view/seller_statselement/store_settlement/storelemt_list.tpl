
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>店铺结算记录管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">

                <span>
                    <label>申请时间</label>
                    <input type="text" value="{:input('start_time')}" id="start_time" name="start_time" size="15" class="member_text"/>-
                    <input type="text" value="{:input('end_time')}" id="end_time" name="end_time" size="15" class="member_text"/>
                </span>
                <input type="text" value="{:input('search')}" name="search" size="30" class="member_text" placeholder="银行账号/银行账户名"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="7" name="top"/>
                <input type="hidden" value="2" name="type"/>
            </div>
        </form>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>商品订单编号</th>
                    <th>订单实付金额</th>
                    <th>运费</th>
                    <th>平台抽成</th>
                    <th>平台抽取金额</th>
                    <th>店铺实获金额</th>
                    <th width="170">创建时间</th>
                    <th width="80">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="storelemt['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['order_no']}</td>
                    <td>{$vo['total_price']}</td>
                    <td>{$vo['courier_price']}</td>
                    <td>{$vo['platformasa']}%</td>
                    <td>{$vo['platforme_amount']}</td>
                    <td>{$vo['shouldbe_amount']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="tablediv-btn">

                        </div>
                    </td>
                </tr>
                {/volist}
                {if $storelemt['total'] < 1}
                    <tr class="tbcenter"><td colspan="11">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_statselement/store_settlement/storelemt_list.js"></script>
