<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('seller_statselement.withdrawal/withdrawal_list',['top'=>8,'type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>提现申请</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('seller_statselement.store_settlement/storelemt_list',['top'=>8,'type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[9]['icon']}</i><span>店铺结算记录</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('seller_store.business_category/bcategory_list',['top'=>6,'type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>未结算订单</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('seller_store.store/store_information',['top'=>6,'type'=>4])}">
                <i class="Hui-iconfont">{$small_icon[35]['icon']}</i><span>店铺情况</span>
            </a>
        </li>
        <li class="{if input('type')==5}mblist-active{/if}">
            <a href="{:url('seller_store.supplier/supplier_list',['top'=>6,'type'=>5])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>运营报告</span>
            </a>
        </li>
        <li class="{if input('type')==6}mblist-active{/if}">
            <a href="{:url('seller_store.seller_address/seller_address_list',['top'=>6,'type'=>6])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>销售排行</span>
            </a>
        </li>

    </ul>
</div>