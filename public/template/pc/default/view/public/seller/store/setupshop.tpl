<form action="" method="post" name="store_from" enctype="multipart/form-data">
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺等级：
        </label>
        <div class="form_text">
            一星
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺名称：
        </label>
        <div class="form_text">
            <input type="text" name="store_name" value="{$store['store_name']}" class="mall_input" id="store_name" size="40">
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            主营商品：
        </label>
        <div class="form_text">
            <textarea cols="40" rows="5" name="main_products" id="main_products" class="mall_texta">{$store['main_products']}</textarea>
            <p class="text_tishi">关键字最多可输入50字，请用","进行分隔，例如”手机,电脑“</p>
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺logo：
        </label>
        <div class="form_text">
            <label class="fileimg-btn" for="logo">选择文件</label>
            <input class="" onchange="getPhoto(this, 'logo', 200)" id="logo" style="display: none;" name="logo" type="file">
            <div class="widthheight_1">
                <img src="__STATIC__/{$store['logo']}" class="fileimg_logo" width="200"/>
            </div>
            <input type="hidden" name="logo" value="{$store['logo']}" />
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺条幅：
        </label>
        <div class="form_text">
            <label class="fileimg-btn" for="banner">选择文件</label>
            <input class="" onchange="getPhoto(this, 'banner', 600)" id="banner" style="display: none;" name="banner" type="file">
            <div class="widthheight_2">
                <img src="__STATIC__/{$store['banner']}" class="fileimg_banner" width="600"/>
            </div>
            <input type="hidden" name="banner" value="{$store['banner']}" />
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺头像：
        </label>
        <div class="form_text">
            <label class="fileimg-btn" for="image">选择文件</label>
            <input class="" onchange="getPhoto(this, 'image', 200)" id="image" style="display: none;" name="image" type="file">
            <div class="widthheight_1">
                <img src="__STATIC__/{$store['image']}" class="fileimg_image" width="200"/>
            </div>
            <input type="hidden" name="image" value="{$store['image']}" />
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            负责人QQ号码：
        </label>
        <div class="form_text">
            <input type="text" name="head_qq" value="{$store['head_qq']}" class="mall_input" id="head_qq" size="40">
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            负责人手机号码：
        </label>
        <div class="form_text">
            <input type="text" name="head_mobile" value="{$store['head_mobile']}" class="mall_input" id="head_mobile" size="40">
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            电子邮箱：
        </label>
        <div class="form_text">
            <input type="text" name="email" value="{$store['email']}" class="mall_input" id="email" size="40">
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            店铺详细地址：
        </label>
        <div class="form_text">
            <input type="text" name="store_address" value="{$store['store_address']}" class="mall_input" id="store_address" size="40">
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            库存预警：
        </label>
        <div class="form_text">
            <input type="text" name="inventory_warning" value="{$store['inventory_warning']}" class="mall_input" id="inventory_warning" size="40">
            <p class="text_tishi">库存少于预警数则报警提示</p>
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            包邮额度：
        </label>
        <div class="form_text">
            <input type="text" name="pm_quota" value="{$store['pm_quota']}" class="mall_input" id="pm_quota" size="40">
            <p class="text_tishi">满多少免运费</p>
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            SEO关键字：
        </label>
        <div class="form_text">
            <input type="text" name="seo_keyword" value="{$store['seo_keyword']}" class="mall_input" id="seo_keyword" size="40">
            <p class="text_tishi">用于店铺搜索引擎的优化，关键字之间请用英文逗号分隔</p>
        </div>
    </div>
    <div class="div_texts">
        <label class="form_title">
            <i class="Hui-iconfont color-red">&#xe630;</i>
            SEO店铺描述：
        </label>
        <div class="form_text">
            <textarea cols="40" rows="5" name="seo_description" id="seo_description" class="mall_texta">{$store['seo_description']}</textarea>
            <p class="text_tishi">用于店铺搜索引擎的优化，建议120字以内</p>
        </div>
    </div>
    <div class="goodsbtn_div formdiv_btn">
        <botton class="goods_btn" onclick="returnOnPage(this)">取消</botton>
        <botton class="goods_btn goodsbtn_act" onclick="storeModify(this)">确定</botton>
    </div>
    <input type="hidden" name="store_id" value="{$store['id']}" />
</form>