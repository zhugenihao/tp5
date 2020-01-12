
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>出售中的商品</span></div>

    <div class="churuzhang">
        <form class="" action="{:url('seller_goods/sell_list')}" method="post" id="order_from">
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
                <input type="hidden" value="2" name="type"/>
            </div>
        </form>
        <table border="1" class="churuzhang-tb">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" /></th>
                    <th>编号</th>
                    <th>商品封面</th>
                    <th>商品名称</th>
                    <th>价格</th>
                    <th width="70">推荐类型</th>
                    <th width="50">排序</th>
                    <th width="170">更新时间</th>
                    <th width="80">状态</th>
                    <th width="120">操作</th>
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
                    <td><div class="goods-price">￥{$vo['goods_price']}</div></td>
                    <td>
                        {eq name="vo['recommended']" value="1"}
                        <span class="color-green">热门推荐</span> 
                        {/eq}
                        {eq name="vo['recommended']" value="0"}
                        <span class="color-red">不推荐</span> 
                        {/eq}
                    </td>
                    <td>{$vo['sort']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">已上架</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="0"}
                        <span class="color-red">已下架</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <div><a href="{:url('seller_goods/goods_details',['goods_id'=>$vo['goods_id']])}">商品详情</a></div>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if count($goodsList) < 1}
                    <tr class="tbcenter"><td colspan="10">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__PC__/js/seller/index.js"></script>

