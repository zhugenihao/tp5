<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('seller_store.store/store_setupshop',['top'=>6,'type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>店铺设置</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('seller_store.category/category_list',['top'=>6,'type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[9]['icon']}</i><span>店铺导航</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('seller_store.business_category/bcategory_list',['top'=>6,'type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>经营类目</span>
            </a>
        </li>
        <li class="{if input('type')==4}mblist-active{/if}">
            <a href="{:url('seller_store.store/store_information',['top'=>6,'type'=>4])}">
                <i class="Hui-iconfont">{$small_icon[35]['icon']}</i><span>店铺信息</span>
            </a>
        </li>
        <li class="{if input('type')==5}mblist-active{/if}">
            <a href="{:url('seller_store.supplier/supplier_list',['top'=>6,'type'=>5])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>供货商</span>
            </a>
        </li>
        <li class="{if input('type')==6}mblist-active{/if}">
            <a href="{:url('seller_store.seller_address/seller_address_list',['top'=>6,'type'=>6])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>地址管理</span>
            </a>
        </li>
        
    </ul>
</div>