<div class="floatleft member-list">
    <ul class="mblist-ul" id="sellermblist-ul">
        {volist name="sellerMenuEr" id="vo"}
        {if isset($menuid_is_arr[$vo['id']])||in_array($seller['group_id'],array(0))}
            <li>
                <a href="javascript:;" data-url="{:url($vo['methods'])}?{$vo['parameter']}">
                    <i class="Hui-iconfont">{$small_icon[$vo['small_icon']]['icon']}</i><span>{$vo['menu_name']}</span>
                </a>
            </li>
        {/if}
        {/volist}
    </ul>
</div>