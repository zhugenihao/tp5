{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />

<form action="" method="post" name="submitfrom" enctype="multipart/form-data">
    <div class="fromtext_auto">
        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                商品名称：
            </label>
            <div class="form_text">
                {$info['goods_name']}
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                用户名称：
            </label>
            <div class="form_text">
                {$info['member_name']}
            </div>
        </div>

        <div class="div_texts">
            <label class="form_title2">
                <i class="Hui-iconfont color-red">&#xe630;</i>
                内容：
            </label>
            <div class="form_text">
                <textarea cols="39" rows="5" name="texts" disabled="">{$info['texts']}</textarea>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                评论图片：
            </label>
            <div class="form_text">
                <ul class="imglist-ul" id="imglist-ul2">
                    {volist name="info['commentsImgList']" id="vo"}
                    <li class="imglist-li2">
                        <div onclick="imgBigShow(this)" url="__STATIC__/{$vo['img_url']}">
                            <img src="__STATIC__/{$vo['img_url']}" width="100" height="80">
                        </div>
                    </li>
                    {/volist}

                </ul>
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                评论时间：
            </label>
            <div class="form_text">
                {$info['create_time']}
            </div>
        </div>
        <div class="div_texts">
            <label class="form_title2">
                显示：
            </label>
            <div class="form_text">
                <input type="radio" name="is_show" id="is_show1" value="1" title="是" {eq name="info['is_show']" value="1"} checked{/eq}>
                <label for="is_show1">是</label>
                <input type="radio" name="is_show" id="is_show2" value="2" title="否" {eq name="info['is_show']" value="2"} checked{/eq}>
                <label for="is_show2">否</label>
            </div>
        </div>
    </div>


    <div class="goodsbtn_div formdiv_btn">
        <botton class="goods_btn" onclick="shutDown(this)">取消</botton>
        <botton class="goods_btn goodsbtn_act" onclick="detailsComments(this)">编辑</botton>
    </div>
</div>
<input type="hidden" value="{$info['id']}" name="id" />
</form>


<script type="text/javascript" src="__PC__/js/seller_after_sales/comments/comments_details.js"></script>
