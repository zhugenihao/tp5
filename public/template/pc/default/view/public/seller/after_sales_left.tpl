<div class="floatleft member-list">
    <ul class="mblist-ul">
        <li class="{if input('type')==1}mblist-active{/if}">
            <a href="{:url('seller_after_sales.returns_replacement/retplt_list',['top'=>7,'type'=>1])}">
                <i class="Hui-iconfont">{$small_icon[36]['icon']}</i><span>退换货管理</span>
            </a>
        </li>
        <li class="{if input('type')==2}mblist-active{/if}">
            <a href="{:url('seller_after_sales.complaints/complaints_list',['top'=>7,'type'=>2])}">
                <i class="Hui-iconfont">{$small_icon[9]['icon']}</i><span>投诉管理</span>
            </a>
        </li>
        <li class="{if input('type')==3}mblist-active{/if}">
            <a href="{:url('seller_after_sales.comments/comments_list',['top'=>7,'type'=>3])}">
                <i class="Hui-iconfont">{$small_icon[9]['icon']}</i><span>评论管理</span>
            </a>
        </li>

    </ul>
</div>