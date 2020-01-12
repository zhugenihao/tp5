<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('member/index',['type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[22]['icon']}</i><span>个人首页</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('record_books/index',['type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[43]['icon']}</i><span>我的余额</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('coupon/index',['type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[50]['icon']}</i><span>我的优惠券</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('order/orderlist',['type'=>4])}">
                <i class="Hui-iconfont">{$small_icon[11]['icon']}</i><span>我的订单</span>
            </a>
        </li>
        <li class="{if input('type')==5}mblist-active{/if}">
            <a href="{:url('order/orderlist',['type'=>5,'activity'=>'seconds_kill'])}">
                <i class="Hui-iconfont">{$small_icon[21]['icon']}</i><span>我的秒杀</span>
            </a>
        </li>
        <li class="{if input('type')==6}mblist-active{/if}">
            <a href="{:url('order/orderlist',['type'=>6,'activity'=>'spell_group'])}">
                <i class="Hui-iconfont">{$small_icon[30]['icon']}</i><span>我的拼团</span>
            </a>
        </li>
        <li class="{if input('type')==7}mblist-active{/if}">
            <a href="{:url('member/goods_give_like',['type'=>7])}">
                <i class="Hui-iconfont">{$small_icon[51]['icon']}</i><span>商品点赞</span>
            </a>
        </li>
        <li class="{if input('type')==8}mblist-active{/if}">
            <a href="{:url('member/watch_history',['type'=>8])}">
                <i class="Hui-iconfont">{$small_icon[52]['icon']}</i><span>我的足迹</span>
            </a>
        </li>
        <li class="{if input('type')==9}mblist-active{/if}">
            <a href="{:url('member/collection',['type'=>9])}">
                <i class="Hui-iconfont">{$small_icon[53]['icon']}</i><span>我的收藏</span>
            </a>
        </li>
        <li class="{if input('type')==10}mblist-active{/if}">
            <a href="{:url('member/index',['type'=>10])}">
                <i class="Hui-iconfont">{$small_icon[42]['icon']}</i><span>我的反馈</span>
            </a>
        </li>
    </ul>
</div>