<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('member/index',['type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[22]['icon']}</i><span>个人首页</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('member/account_settings',['type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[24]['icon']}</i><span>我的头像</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('member/member_name',['type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[23]['icon']}</i><span>我的用户名</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('member/member_mobile',['type'=>4])}">
                <i class="Hui-iconfont">{$small_icon[37]['icon']}</i><span>我的手机号码</span>
            </a>
        </li>
        <li class="{if input('type')==5}mblist-active{/if}">
            <a href="{:url('member/member_password',['type'=>5])}">
                <i class="Hui-iconfont">{$small_icon[54]['icon']}</i><span>修改登录密码</span>
            </a>
        </li>
        <li class="{if input('type')==6}mblist-active{/if}">
            {if $memberInfo['pay_password']==''}
                <a href="{:url('member/setupthe_pay_password',['type'=>6])}">
                    <i class="Hui-iconfont">{$small_icon[45]['icon']}</i><span>设置支付密码</span>
                </a>
            {else/}
                <a href="{:url('member/pay_password',['type'=>6])}">
                    <i class="Hui-iconfont">{$small_icon[45]['icon']}</i><span>修改支付密码</span>
                </a>
            {/if}
        </li>
        <li class="{if input('type')==7}mblist-active{/if}">
            <a href="{:url('member/member_address',['type'=>7])}">
                <i class="Hui-iconfont">{$small_icon[47]['icon']}</i><span>我的收货地址</span>
            </a>
        </li>
        <li><a href="javascript:;" onclick="mLogout(this)">
                <i class="Hui-iconfont">{$small_icon[55]['icon']}</i><span>退出登录</span>
            </a></li>
    </ul>
</div>
<script type="text/javascript" src="__PC__/js/public/account_settings_left.js"></script>