<div class="div_texts">
    <div class="div_texts div_tishi">
        <ul class="divtishi-ul">
            <li>手机幻灯片说明：</li>
            <li>1.最多只能上传5张图片。</li>
        </ul>
    </div>
    <div class="layui-carousel floatfalse margin-auto" id="advert_mobile" lay-filter="advert_mobile">
        <div carousel-item="">
            {volist name="advertMobileList" id="vo"}
            <div>
                <a href="{$vo['adv_link']}" target="_blank"><img src="__STATIC__/{$vo['dire']}" /></a>
            </div>
            {/volist}
        </div>
    </div> 
    <form action="" method="post" name="advert_mobile_from" enctype="multipart/form-data">
        <ul class="imglist-ul" id="imglist-ul2">
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advertmobile1', 160)" id="advertmobile1" name="advert1" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg" data-type="mobile">X</div>
                    <img src="__STATIC__/{$advertMobileInfo1['dire']}" class="fileimg_advertmobile1" width="160"/>

                </div>
                &nbsp;url：<input type="text" value="{$advertMobileInfo1['adv_link']}" name="adv_link1" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advertmobile1">选择文件</label>
                <input type="hidden" name="advert1" value="{$advertMobileInfo1['dire']}" />
                <input type="hidden" name="adv1_id" value="{$advertMobileInfo1['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advertmobile2', 160)" id="advertmobile2" name="advert2" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg" data-type="mobile">X</div>
                    <img src="__STATIC__/{$advertMobileInfo2['dire']}" class="fileimg_advertmobile2" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertMobileInfo2['adv_link']}" name="adv_link2" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advertmobile2">选择文件</label>
                <input type="hidden" name="advert2" value="{$advertMobileInfo2['dire']}" />
                <input type="hidden" name="adv2_id" value="{$advertMobileInfo2['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advertmobile3', 160)" id="advertmobile3" name="advert3" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg" data-type="mobile">X</div>
                    <img src="__STATIC__/{$advertMobileInfo3['dire']}" class="fileimg_advertmobile3" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertMobileInfo3['adv_link']}" name="adv_link3" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advertmobile3">选择文件</label>
                <input type="hidden" name="advert3" value="{$advertMobileInfo3['dire']}" />
                <input type="hidden" name="adv3_id" value="{$advertMobileInfo3['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advertmobile4', 160)" id="advertmobile4" name="advert4" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg" data-type="mobile">X</div>
                    <img src="__STATIC__/{$advertMobileInfo4['dire']}" class="fileimg_advertmobile4" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertMobileInfo4['adv_link']}" name="adv_link4" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advertmobile4">选择文件</label>
                <input type="hidden" name="advert4" value="{$advertMobileInfo4['dire']}" />
                <input type="hidden" name="adv4_id" value="{$advertMobileInfo4['adv_id']}" />
            </li>
            <li class="imglist-li">
                <input class="hide" onchange="getPhoto(this, 'advertmobile5', 160)" id="advertmobile5" name="advert5" type="file">
                <div class="widthheight_3">
                    <div class="divguanbi shanchuimg" data-type="mobile">X</div>
                    <img src="__STATIC__/{$advertMobileInfo5['dire']}" class="fileimg_advertmobile5" width="160"/>
                </div>
                &nbsp;url：<input type="text" value="{$advertMobileInfo5['adv_link']}" name="adv_link5" size="17"/>
                <label class="fileimg-btn goodsimgbtn" for="advertmobile5">选择文件</label>
                <input type="hidden" name="advert5" value="{$advertMobileInfo5['dire']}" />
                <input type="hidden" name="adv5_id" value="{$advertMobileInfo5['adv_id']}" />
            </li>
        </ul>
    </form>
</div>
<div class="goodsbtn_div formdiv_btn">
    <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
    <botton class="goods_btn goodsbtn_act" onclick="advertMobileModify(this)">确定</botton>
</div>