
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<div class="seller-allas">
    <div class="seller_auto">
        <div class="member-yue">
            <span>店铺</span>

        </div>
        <div class="churuzhang">
            <div class="member-photo"><img src="__STATIC__/{$store['logo']}" onerror="imgExists(this)"/></div>
            <div class="sas" style="display: none;"><img src="__STATIC__/{$store['logo']}" onerror="imgExists(this)" id="photoimg"/></div>

            <div class="membertext_1">
                <div class="member-uname">店铺名称：{$store['store_name']}</div>
                <div class="member-uname">
                    <span class="margin-left10">店铺性质：
                        {eq name="store['store_nature']" value="1"}旗舰店{/eq}
                        {eq name="store['store_nature']" value="2"}专卖店{/eq}
                        {eq name="store['store_nature']" value="3"}专营店{/eq}
                    </span>
                    <span class="margin-left10">店铺等级：{$store['level_name']}</span>
                    <span class="margin-left10">用户名：{$seller['seller_name']}</span>
                    <span class="margin-left10">最后登录时间：{$seller['last_time']|date="Y-m-d H:i:s",###}</span>
                </div>
            </div>

            <div class="div_texts">
                <a class="goods_btn goodsbtn_act" href="{:url('socket/service/index')}" target="_blank">
                    <i class="Hui-iconfont">&#xe6d0;</i>&nbsp;客服登录
                </a>
                <a class="goods_btn bacg-huang" href="javascript:;" onclick="updatesCache(this)">
                    <i class="Hui-iconfont">&#xe68f;</i>&nbsp;更新缓存
                </a>
                <div class="form_text goodstjdiv floatfalse">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200"><div class="goods-names">商品信息</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td >
                                    <div class="goods-names textright">商品统计</div>
                                </td>
                                <td>
                                    <div class="goods-tj">
                                        <div class="mall_btn goodsbtn_act">全部商品（{$goodsCountAll}）</div>
                                        <div class="mall_btn goodsbtn_act">出售中的商品（{$goodsCountSell}）</div>
                                        <div class="mall_btn bacg-blue">仓库中的商品（{$goodsCountWarehouse}）</div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="form_text goodstjdiv">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200"><div class="goods-names">订单信息</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td >
                                    <div class="goods-names textright">订单统计</div>
                                </td>
                                <td>
                                    <div class="goods-tj">
                                        <div class="mall_btn goodsbtn_act">全部订单({$orderCountAll})</div>
                                        <div class="mall_btn bacg-blue">秒杀订单({$orderCountSkill})</div>
                                        <div class="mall_btn bacg-blue">拼团订单({$orderCountSgroup})</div>
                                        <div class="mall_btn bacg-blue">促销订单({$orderCountCsalesp})</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form_text goodstjdiv">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200"><div class="goods-names">促销信息</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td >
                                    <div class="goods-names textright">促销统计</div>
                                </td>
                                <td>
                                    <div class="goods-tj">
                                        <div class="mall_btn goodsbtn_act">商品促销（{$goodsCountCsalesp}）</div>
                                        <div class="mall_btn goodsbtn_act">商品拼团（{$goodsCountSgroup}）</div>
                                        <div class="mall_btn bacg-blue">商品秒杀（{$goodsCountSkill}）</div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="form_text goodstjdiv">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200"><div class="goods-names">售后信息</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td >
                                    <div class="goods-names textright">售后统计</div>
                                </td>
                                <td>
                                    <div class="goods-tj">
                                        <div class="mall_btn bacg-blue">总评论（{$commentsAll}）</div>
                                        <div class="mall_btn bacg-red">投诉（{$complaintsAll}）</div>
                                        <div class="mall_btn bacg-huang">退换货（{$retpltAll}）</div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="form_text goodstjdiv">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200"><div class="goods-names">系统信息</div></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td >
                                    <div class="goods-names textright">系统内容</div>
                                </td>
                                <td>
                                    <div class="goods-tj">
                                        <div class="mall_btn goodsbtn_act"><i class="Hui-iconfont">&#xe62f;</i>系统消息（{$noticeAll}）</div>
                                        <div class="mall_btn goodsbtn_act">遵守规则说明</div>
                                        <div class="mall_btn goodsbtn_act">假货说明</div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="form_text goodstjdiv">
                    <table border="1" class="churuzhang-tb">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="150"><div class="goods-names">销售排行</div></th>
                                <th width="270"></th>
                                <th width="150"></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            <tr class="tbcenter">
                                <td>排名</td>
                                <td>商品名称</td>
                                <td>销量</td>
                            </tr>
                            {volist name="goodsList" id="vo"}
                            <tr class="tbcenter">
                                <td>{$i}</td>
                                <td>
                                    <div class="tablediv-name">{$vo['goods_name']}</div>
                                </td>
                                <td>{$vo['sales']}</td>
                            </tr>
                            {/volist}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>


<script type="text/javascript" src="__PC__/js/seller/index.js"></script>
