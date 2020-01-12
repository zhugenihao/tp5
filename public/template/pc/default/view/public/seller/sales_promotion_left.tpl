<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('seller_sales_promotion.seconds_kill/secondskill_list',['top'=>4,'type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[21]['icon']}</i><span>秒杀管理</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('seller_sales_promotion.spell_group/spell_group_list',['top'=>4,'type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[30]['icon']}</i><span>拼团管理</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('seller_sales_promotion.comdysales_promotion/comdsption_list',['top'=>4,'type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>商品促销</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('seller_sales_promotion.coupon/coupon_list',['top'=>4,'type'=>4])}">
                <i class="Hui-iconfont">{$small_icon[50]['icon']}</i><span>优惠券管理</span>
            </a>
        </li>
        
    </ul>
</div>