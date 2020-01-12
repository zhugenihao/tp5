<div class="div_texts">
    <table border="1" class="churuzhang-tb floatfalse">
        <thead class="churuzhang-te">
            <tr class="textleft">
                <th width="200"><div class="goods-names">联系信息</div></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="churuzhang-ty">
            <tr class="tbcenter">
                <td >
                    <div class="goods-names textright">联系人姓名</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerContact.contact_name}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">联系人手机</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerContact.contact_mobile}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">联系人电子邮箱</div>
                </td>
                <td>
                    <div class="tablediv-name">{$sellerContact.contact_email}</div>
                </td>
            </tr>
            <tr class="tbcenter">
                <td>
                    <div class="goods-names textright">申请类型</div>
                </td>
                <td>
                    <div class="tablediv-name">{if $sellerContact['application_type']==1}个人入驻{else/}企业入驻{/if}</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>