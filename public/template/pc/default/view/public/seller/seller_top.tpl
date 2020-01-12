
<div class="member-top">
    <ul class="membertop-ul" id="sellerul-top">
        <li>
            <a href="{:url('index/index')}">商城首页</a>
        </li>
        {volist name="sellerMenu" id="vo"}
        {if isset($menuid_is_arr[$vo['id']])||in_array($seller['group_id'],array(0))}
            <li>
                <a href="{:url($vo['methods'],['smenu_id'=>$vo['id']])}?{$vo['parameter']}">{$vo['menu_name']}</a>
            </li>
        {/if}
        {/volist}

        <li class="zhanghao-right">
            <a href="javascript:;">
                <img src="" class="seller-img" onerror="imgExists(this)"/>
                {$seller['seller_name']}
                <i class="Hui-iconfont">&#xe6d5;</i>
            </a>
            <div class="zhanghao-list">
                <div>
                    <a href="javascript:;" onclick="accountSettings(this)" url="{:url('seller_account.seller/account_settings')}">账号设置</a>
                </div>
                <div><a href="javascript:;" onclick="accountOut(this)">退出账号</a></div>
            </div>
        </li>
        <li class="zhanghao-right">
            <a href="{:url('store/index',['store_id'=>$store['id']])}" target="_blank">
                <i class="Hui-iconfont">&#xe625;</i>
                店铺
            </a>
        </li>
    </ul>
</div>
<script type="text/javascript">
    
    function captchaSrc(obj) {
        $('.login-yanzhengma').attr("src", "{:url('seller/verify_code')}?'+Math.random();");
    }
    var seller_name1 = "{$seller['seller_name']}";
    var seller_name2 = "{$seller_name}";
    
    if (seller_name1 != seller_name2) {
        accountOutAjax();
    }
</script>





