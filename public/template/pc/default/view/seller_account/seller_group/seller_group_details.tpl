{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>添加账号组</span></div>

    <form action="" method="post" name="submitfrom" enctype="multipart/form-data">
        <div class="fromtext_auto">
            <div class="div_texts">
                <label class="form_title2">
                    <i class="Hui-iconfont color-red">&#xe630;</i>
                    账号组名称：
                </label>
                <div class="form_text">
                    <input type="text" name="group_name" value="{$info['group_name']}" placeholder="账号组名称" class="mall_input" id="group_name" size="20">
                </div>
            </div>
            <div class="div_texts">
                <label class="form_title2">
                    <i class="Hui-iconfont color-red">&#xe630;</i>
                    排序：
                </label>
                <div class="form_text">
                    <input type="text" name="sort" value="{$info['sort']}" placeholder="排序" class="mall_input" id="sort" size="20">
                </div>
            </div>

            <div class="div_texts">
                <label class="form_title2">
                    <i class="Hui-iconfont color-red">&#xe630;</i>
                    状态：
                </label>
                <div class="form_text">
                    <select name="state" class="">
                        <option value="1" {eq name="info['state']" value="1"}selected{/eq}>启用</option>
                        <option value="2" {eq name="info['state']" value="2"}selected{/eq}>禁用</option>
                    </select>
                </div>
            </div>
            <div class="div_texts">
                <label class="form_title2">
                    <i class="Hui-iconfont color-red">&#xe630;</i>
                    权限选择：
                </label>
                <div class="form_text" id="table_click">
                    <label>
                        <input type="checkbox" id="checkedAll"/>
                        全选
                    </label>
                    {volist name="menuList" id="vo"}
                    <table border="1" class="churuzhang-tb floatfalse">
                        <thead class="churuzhang-te">
                            <tr class="textleft">
                                <th width="200">
                                    <div class="goods-names">
                                        <label>
                                            <input type="checkbox" value="{$vo['id']}" name="menu_id[]" class="checkedAll"
                                                   {if isset($menuid_arris[$vo['id']])}checked{/if}/>
                                            {$vo['menu_name']}
                                        </label>
                                    </div>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="churuzhang-ty">
                            {volist name="vo['lister']" id="vo2"}
                            <tr class="tbcenter checketr">
                                <td >
                                    <div class="goods-names textright">
                                        <label><input type="checkbox" value="{$vo2['id']}" name="menu_id[]" class="checkboxzi"
                                                      {if isset($menuid_arris[$vo2['id']])}checked{/if}/>
                                            {$vo2['menu_name']}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="tablediv-name2">
                                        {volist name="vo2['lister2']" id="vo3"}
                                        <div class="goods-names floatleft">
                                            <label><input type="checkbox" value="{$vo3['id']}" name="menu_id[]" class="checkboxzi"
                                                          {if isset($menuid_arris[$vo3['id']])}checked{/if}/>
                                                {$vo3['menu_name']}
                                            </label>
                                        </div>
                                        {/volist}
                                    </div>
                                </td>
                            </tr>
                            {/volist}
                        </tbody>
                    </table>
                    {/volist}
                </div>
            </div>

            <div class="goodsbtn_div formdiv_btn">
                <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
                <botton class="goods_btn goodsbtn_act" onclick="detailsSellerGroup(this)">添加</botton>
            </div>
        </div>
        <input type="hidden" value="{$info['id']}" name="group_id" />
    </form>
</div>

<script type="text/javascript" src="__PC__/js/seller_account/seller_group/seller_group_details.js"></script>
