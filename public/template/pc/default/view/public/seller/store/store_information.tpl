<div class="div_texts">
    <table border="1" class="churuzhang-tb floatfalse">
        <thead class="churuzhang-te">
            <tr class="textleft">
                <th width="200"><div class="goods-names">店铺信息</div></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="churuzhang-ty">
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">店铺名称</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info.store_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">用户名</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info.member_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">店铺性质</div>
                </td>
                <td>
                    <div class="tablediv-name">
                        {if $info['store_nature']==1}旗舰店
                        {elseif $info['store_nature']==2/}专卖店
                        {elseif $info['store_nature']==3/}专营店
                        {else/}其他{/if}
                    </div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">店铺负责人姓名</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info['head_name']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">负责人手机号码</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info['head_mobile']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">负责人QQ号码</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info['head_qq']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">电子邮箱</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info['email']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">店铺详细地址</div>
                </td>
                <td>
                    <div class="tablediv-name">{$info['store_address']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">店铺主营大类</div>
                </td>
                <td>
                    <div class="tablediv-name">{$directory_big_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">经营类目</div>
                </td>
                <td>
                    <div class="tablediv-name">
                        {volist name="businessCategory" id="vo"}
                        {$vo.directory1_name}/
                        {/volist}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<div class="div_texts">
    <table border="1" class="churuzhang-tb floatfalse">
        <thead class="churuzhang-te">
            <tr class="textleft">
                <th width="250"><div class="goods-names">银行卡信息</div></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="churuzhang-ty">
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">银行开户名</div>
                </td>
                <td>
                    <div class="goods-names">{$info['bank_name']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">银行账号</div>
                </td>
                <td>
                    <div class="goods-names">{$info['bank_account']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">开户银行支行名称</div>
                </td>
                <td>
                    <div class="goods-names">{$info['bank_branch_name']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">开户银行支行所在地</div>
                </td>
                <td>
                    <div class="goods-names">{$infoProvince['name']}，{$infoCity['name']}</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="div_texts">
    <table border="1" class="churuzhang-tb floatfalse">
        <thead class="churuzhang-te">
            <tr class="textleft">
                <th width="250"><div class="goods-names">经营情况</div></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="churuzhang-ty">
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">近一年主营渠道</div>
                </td>
                <td>
                    <div class="goods-names">
                        {if $info['main_channel']==1}商场/卖场
                        {elseif $info['main_channel']==2/}批发市场
                        {elseif $info['main_channel']==3/}超市/连锁店/商业中心
                        {elseif $info['main_channel']==4/}电商网站
                        {elseif $info['main_channel']==5/}其他
                        {/if}
                    </div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">近一年销售额</div>
                </td>
                <td>
                    <div class="goods-names">{$info['sales']}万元</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">同类电子商务网站经验</div>
                </td>
                <td>
                    <div class="goods-names">
                        {if $info['experience']==1}有
                        {else/}没有
                        {/if}
                    </div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">可网售商品数量</div>
                </td>
                <td>
                    <div class="goods-names">{$info['sales_quantity']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">预计平均客单价</div>
                </td>
                <td>
                    <div class="goods-names">{$info['average_price']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">仓库情况</div>
                </td>
                <td>
                    <div class="goods-names">
                        {if $info['warehouse']==1}自有仓库
                        {elseif $info['warehouse']==2/}第三方仓库
                        {elseif $info['warehouse']==3/}无仓库
                        {/if}
                    </div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">是否有实体店</div>
                </td>
                <td>
                    <div class="goods-names">
                        {if $info['there_is_store']==1}有
                        {else/}无
                        {/if}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>