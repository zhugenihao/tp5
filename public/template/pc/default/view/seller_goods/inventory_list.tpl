
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/inventory_list.css" />
<div class="seller-allas">
    <div class="member-yue"><span>商品库存管理</span></div>

    <div class="churuzhang">
        <form class="" action="{:url('seller_goods/warehouse_list')}" method="post" id="order_from">
            <div class="zhanglx zhanglxpad">
                <label>推荐类型</label>
                <div class="layui-input-inline">
                    <select name="recommended" lay-filter="recommended">
                        <option value="">请选择</option>
                        <option value="0" {eq name=":input('recommended')" value="0"} selected {/eq}>不推荐</option>
                        <option value="1" {eq name=":input('recommended')" value="1"} selected {/eq}>热门推荐</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="商品名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="3" name="top"/>
                <input type="hidden" value="3" name="type"/>
            </div>
        </form>
        <table border="1" class="churuzhang-tb">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" /></th>
                    <th>编号</th>
                    <th>商品封面</th>
                    <th>商品名称</th>
                    <th>商品规格</th>
                    <th>价格</th>
                    <th>库存数量</th>
                    <th width="80">状态</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="goodsList" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="goodsid[]" value="{$vo['goods_id']}"/></td>
                    <td>{$vo['goods_id']}</td>
                    <td>
                        <div class="goods-img">
                            <img src="__STATIC__/{$vo['thecover']}" width="50" height="50">
                        </div>
                    </td>
                    <td><div class="goods-names">{$vo['goods_name']}</div></td>
                    <td>
                        {eq name="vo['setup_norm']" value="on"}
                        <span class="color-green">有</span> 
                        {/eq}
                        {eq name="vo['setup_norm']" value="off"}
                        <span class="color-green">无</span> 
                        {/eq}
                    </td>
                    <td><div class="goods-price">￥{$vo['goods_price']}</div></td>
                    <td>
                        {eq name="vo['setup_norm']" value="on"}
                        <a href="javascript:;" class="guigekc" data-goodsid="{$vo['goods_id']}">规格库存</a>
                        {/eq}
                        {eq name="vo['setup_norm']" value="off"}
                        <input type="text" value="{$vo['goods_stock']}" oninput="modifyGoodsStock(this,{$vo['goods_id']})" size="10" />
                        {/eq}

                    </td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">已上架</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="0"}
                        <span class="color-red">已下架</span> 
                        {/eq}
                    </td>
                </tr>
                {/volist}
                {if count($goodsList) < 1}
                    <tr class="tbcenter"><td colspan="8">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<div class="goods_cos">
    <div class="goodscos_bacg"></div>
    <div class="goodscos_det">
        <div class="goodscos_auto">
            <div class="goodscos_auto2">
                <div class="goodscos_guanbi">X</div>
                <div class="goods-text1">
                    <div id="goods_name">商品名称</div>
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr>
                                <th>编号</th>
                                <th>颜色</th>
                                <th>版本</th>
                                <th>库存价格</th>
                                <th>重量(kg)</th>
                                <th>库存数量</th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty" id="inventorylist">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_goods/inventory_list.js"></script>
