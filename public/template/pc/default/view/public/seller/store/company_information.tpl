<div class="div_texts">
    <table border="1" class="churuzhang-tb floatfalse">
        <thead class="churuzhang-te">
            <tr class="textleft">
                <th width="200"><div class="goods-names">公司信息</div></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="churuzhang-ty">
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">公司名称</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.company_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">公司性质</div>
                </td>
                <td>
                    <div class="tablediv-name">
                        {if $sellerCompany['company_nature']==1}个人独立企业{elseif $sellerCompany['company_nature']==1/}国企{else/}外企{/if}
                    </div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">公司官网地址</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.company_url}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">公司所在地</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompanyProvince['name']},{$sellerCompanyCity['name']},{$sellerCompanyCounty['name']}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">公司详细地址</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.detaddress}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">固定电话</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.fixed_telephone}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">电子邮箱</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.email}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">传真</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.fax}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">邮政编码</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.thezipcode}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">一证一码商家</div>
                </td>
                <td>
                    <div class="tablediv-name">{if $sellerCompany['a_yard_merchants']==1}是{else/}否{/if}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">注册资金</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.registered_capital}万元人民币</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">统一社会信用代码</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.credit_code}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">法定代表人姓名</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.legal_rep_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">营业执照有效期开始时间</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.effective_start_time}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">营业执照有效期结束时间</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.effective_end_time}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">营业执照经营范围</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerCompany.scope_business}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">纳税人类型</div>
                </td>
                <td>
                    <div class="tablediv-name">{if $sellerCompany['taxpayers_type']==1}一般纳税人{else/}其他{/if}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">纳税类型税码</div>
                </td>
                <td>
                    <div class="tablediv-name">
                        {if $sellerCompany['taxtypetaxcode']==1}0%
                        {elseif $sellerCompany['taxtypetaxcode']==2/}5%
                        {elseif $sellerCompany['taxtypetaxcode']==3/}10%
                        {elseif $sellerCompany['taxtypetaxcode']==4/}20%
                        {elseif $sellerCompany['taxtypetaxcode']==5/}30%
                        {else/}其他{/if}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>