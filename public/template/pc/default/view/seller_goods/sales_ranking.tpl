
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>销售排行</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">

                <input type="text" value="{:input('search')}" name="search" size="30" class="member_text" placeholder="商品名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>商品封面</th>
                    <th>商品名称</th>
                    <th>货号</th>
                    <th>销量</th>
                    <th>价格</th>
                    <th width="80">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="goods['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['goods_id']}" /></td>
                    <td>{$vo['goods_id']}</td>
                    <td>
                        <div class="goods-img">
                            <img src="__STATIC__/{$vo['thecover']}" width="50" height="40">
                        </div>
                    </td>
                    <td>{$vo['goods_name']}</td>
                    <td>{$vo['goods_sku']}</td>
                    <td>{$vo['sales']}</td>
                    <td>{$vo['goods_price']}</td>
                    <td>
                        <div class="tablediv-btn">

                        </div>
                    </td>
                </tr>
                {/volist}
                {if $goods['total'] < 1}
                    <tr class="tbcenter"><td colspan="8">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_goods/sales_ranking.js"></script>
