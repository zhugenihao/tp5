<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.order/order_list',['top'=>5,'type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[11]['icon']}</i><span>全部订单</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.order/order_list',['top'=>5,'type'=>2,'activity'=>'seconds_kill'])}">
                <i class="Hui-iconfont">{$small_icon[21]['icon']}</i><span>秒杀订单</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.order/order_list',['top'=>5,'type'=>3,'activity'=>'spell_group'])}">
                <i class="Hui-iconfont">{$small_icon[30]['icon']}</i><span>拼团订单</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.order/order_list',['top'=>5,'type'=>4,'activity'=>'comdysalesp'])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>促销订单</span>
            </a>
        </li>
        <li class="{if input('type')==5}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.freight/freight_list',['top'=>5,'type'=>5])}">
                <i class="Hui-iconfont">{$small_icon[43]['icon']}</i><span>运费设置</span>
            </a>
        </li>
        <li class="{if input('type')==6}mblist-active{/if}">
            <a href="{:url('seller_order_logistics.courier/courier_index',['top'=>5,'type'=>6])}">
                <i class="Hui-iconfont">{$small_icon[47]['icon']}</i><span>快递公司</span>
            </a>
        </li>

    </ul>
</div>