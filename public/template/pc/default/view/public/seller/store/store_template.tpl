<div class="div_texts">
    <div class="divtpl_all">
        <div class="divtpl_one">
            <div class="divtplone_auto">
                <img src="__STATIC__/{$store_themetemplate['cover_address']}"
                     class="yulianimg" data-id="{$store_themetemplate['id']}" data-title="{$store_themetemplate['style_name']}"/>
            </div>
        </div>
        <div class="divtpl_second">
            <ul class="divtpl_text">
                <li>当前模板</li>
                <li>店铺模版名称:{$store_themetemplate['template_name']}</li>
                <li>店铺风格名称：{$store_themetemplate['style_name']}</li>
                <li>店铺名称：{$store['store_name']}</li>
                <li><a href="" class="mall_btn" target="_blank">店铺首页</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="div_texts">
    <div>可用主题如下</div>
    <div class="form_text">
        <ul class="tplimglist-ul">
            {volist name="themetemplate['data']" id="vo"}
            <li class="tplimglist-li {eq name="vo['id']" value="$store['tpl_id']"}tpl-act{/eq}">
                <div class="tplimglist-auto">
                    <div class="tplimglist-img">
                        <img src="__STATIC__/{$vo['cover_address']}" class="yulianimg" data-id="{$vo['id']}" data-title="{$vo['style_name']}"/>
                    </div>
                    <div class="tplbtns">
                        <button class="malltpl_btn yulianimg" data-id="{$vo['id']}" data-title="{$vo['style_name']}">预览</button>
                    </div>
                    <div class="tplbtns"><button class="malltpl_btn" data-id="{$vo['id']}" onclick="templateUse(this)">使用</button></div>
                </div>
                <div class="sas tlpimgw_{$vo['id']}" style="display: none;"><img src="__STATIC__/{$vo['cover_address']}"/></div>

            </li>
            {/volist}
        </ul>
    </div>
</div>
