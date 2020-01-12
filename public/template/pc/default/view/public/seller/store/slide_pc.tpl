<div class="div_texts">
    <div class="div_texts div_tishi">
        <ul class="divtishi-ul">
            <li>电脑幻灯片说明：</li>
            <li>1.最多只能上传5张图片。</li>
        </ul>
    </div>
    <div class="layui-carousel floatfalse margin-auto" id="advert_pc" lay-filter="advert_pc">
        <div carousel-item="">
            {volist name="advertPcList" id="vo"}
            <div>
                <a href="{$vo['adv_link']}" target="_blank"><img src="__STATIC__/{$vo['dire']}" /></a>
            </div>
            {/volist}
        </div>
    </div> 
    <form action="" method="post" name="advert_pc_from" enctype="multipart/form-data">
        <ul class="imglist-ul" id="imglist-ul">
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advert1', 160)" id="advert1" name="advert1" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg">X</div>
                    <img src="__STATIC__/{$advertPcInfo1['dire']}" class="fileimg_advert1" width="160"/>

                </div>
                &nbsp;url：<input type="text" value="{$advertPcInfo1['adv_link']}" name="adv_link1" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advert1">选择文件</label>
                <input type="hidden" name="advert1" value="{$advertPcInfo1['dire']}" />
                <input type="hidden" name="adv1_id" value="{$advertPcInfo1['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advert2', 160)" id="advert2" name="advert2" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg">X</div>
                    <img src="__STATIC__/{$advertPcInfo2['dire']}" class="fileimg_advert2" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertPcInfo2['adv_link']}" name="adv_link2" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advert2">选择文件</label>
                <input type="hidden" name="advert2" value="{$advertPcInfo2['dire']}" />
                <input type="hidden" name="adv2_id" value="{$advertPcInfo2['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advert3', 160)" id="advert3" name="advert3" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg">X</div>
                    <img src="__STATIC__/{$advertPcInfo3['dire']}" class="fileimg_advert3" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertPcInfo3['adv_link']}" name="adv_link3" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advert3">选择文件</label>
                <input type="hidden" name="advert3" value="{$advertPcInfo3['dire']}" />
                <input type="hidden" name="adv3_id" value="{$advertPcInfo3['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advert4', 160)" id="advert4" name="advert4" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg">X</div>
                    <img src="__STATIC__/{$advertPcInfo4['dire']}" class="fileimg_advert4" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertPcInfo4['adv_link']}" name="adv_link4" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advert4">选择文件</label>
                <input type="hidden" name="advert4" value="{$advertPcInfo4['dire']}" />
                <input type="hidden" name="adv4_id" value="{$advertPcInfo4['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advert5', 160)" id="advert5" name="advert5" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg">X</div>
                    <img src="__STATIC__/{$advertPcInfo5['dire']}" class="fileimg_advert5" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertPcInfo5['adv_link']}" name="adv_link5" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advert5">选择文件</label>
                <input type="hidden" name="advert5" value="{$advertPcInfo5['dire']}" />
                <input type="hidden" name="adv5_id" value="{$advertPcInfo5['adv_id']}" />
            </li>
        </ul>
    </form>
</div>
<div class="goodsbtn_div formdiv_btn">
    <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
    <botton class="goods_btn goodsbtn_act" onclick="advertPcModify(this)">确定</botton>
</div>