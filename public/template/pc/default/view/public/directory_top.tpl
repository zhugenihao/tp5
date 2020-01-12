<div class="index-categoty">
    <div class="categoty-auto pcdiv-auto">
        <ul class="categoty-ul">
            <li class="categoty-li">
                <a href="{:url('index/index')}">首页</a>
            </li>
            {volist name="directoryList_top" id="vo"}
            <li class="categoty-li">
                <a href="{:url($vo['home_template_p'],['dir_id'=>$vo.id])}">{$vo.title}</a>
            </li>
            {/volist}
        </ul>
    </div>
</div>