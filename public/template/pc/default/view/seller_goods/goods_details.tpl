
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/goods_details.css" />
<div class="seller-allas">
    <form class="" action="" id="fabu_from" name="fabu_from">
        <div class="member-yue"><span>商品发布</div>
        <div class="goods_fabu">
            <ul class="goodsfabu_ul">
                <li id="goods_title1" class="fabu_active"><span>选择商品分类</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title2"><span>填写商品详情</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title3"><span>上传商品图片</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title4"><span>商品编辑成功</span></li>
            </ul>
            <div class="goods-cateall floatfalse">
                <div class="goods-cate" id="goods-cate">
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory1">
                            {volist name="businessCategory" id="vo"}
                            <li data-dir1id="{$vo['directory1_id']}" 
                                class="{eq name="businessCategoryInfo['directory1_id']" value="$vo['directory1_id']"}goodscat_active{/eq}">
                                {$vo['directory1_name']}
                            </li>
                            {/volist}
                        </ul>
                    </div>
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory2">
                            {volist name="businessCategory2" id="vo"}
                            <li data-dir1id="{$vo['directory2_id']}" 
                                class="{eq name="businessCategoryInfo['directory2_id']" value="$vo['directory2_id']"}goodscat_active{/eq}">
                                {$vo['directory2_name']}
                            </li>
                            {/volist}
                        </ul>
                    </div>
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory3">
                            {volist name="businessCategory3" id="vo"}
                            <li data-dir1id="{$vo['directory3_id']}" 
                                class="{eq name="businessCategoryInfo['directory3_id']" value="$vo['directory3_id']"}goodscat_active{/eq}">
                                {$vo['directory3_name']}
                            </li>
                            {/volist}
                        </ul>
                    </div>
                </div>
                <div class="goods-cate1 goodsdetails-act" id="goods-details">
                    <div class="details-title" id="detailstitle">
                        <div class="detls-act">基本信息</div>
                        <div>商品详情</div>
                        <div>商品图片</div>
                        <div>规格信息</div>
                    </div>
                    <div class="detls-text">
                        <div class="detlstext-auto1">
                            <div class="detlstext-auto">
                                <div class="detlstext-one" style="display: block;">

                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品品牌</label>
                                        <div class="layui-input-inline">
                                            <select name="brand_id" id="brand_id">
                                                <option value="0">请选择</option>
                                                {volist name="brandList" id="vo"}
                                                <option value="{$vo['id']}" {eq name="goods['brand_id']" value="$vo['id']"}selected{/eq}>{$vo['brand_name']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            商品名称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_name" value="{$goods['goods_name']}" class="layui-input" id="goods_name">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>成本价（￥）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="cost_price" value="{$goods['cost_price']}" class="layui-input" id="cost_price">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>商品价格（￥）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_price" value="{$goods['goods_price']}" class="layui-input" id="goods_price">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>商品库存（件）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_stock" value="{$goods['goods_stock']}" class="layui-input" id="goods_stock">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品小名</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods2_name" value="{$goods['goods2_name']}" class="layui-input" id="goods2_name">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品货号</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_sku" value="{$goods['goods_sku']}" class="layui-input" id="goods_sku">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>所在地</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="region" value="{$goods['region']}" class="layui-input" id="region">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>封面</label>
                                        <div class="layui-input-block">
                                            <label class="fileimg-btn" for="images">选择文件</label>
                                            <input class="" onchange="getPhoto(this, 'thecover')" id="images" style="display: none;" name="thecover" type="file">

                                            <img src="__STATIC__/{$goods['thecover']}" class="fileimg_thecover" />
                                            <input type="hidden" value="{$goods['thecover']}" name="thecover" />
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">虚拟销量</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sales" value="{$goods['sales']}" class="layui-input" id="sales">
                                        </div>
                                    </div>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>设置规格</label>
                                        <div class="layui-input-block divline">
                                            <input type="checkbox" {if $goods['setup_norm']=='on'}checked=""{/if} name="setup_norm" id="setup_norm" title="开关">
                                            <label for="setup_norm">开关</label>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">类型内容</label>
                                        <div class="layui-input-block">
                                            <select name="billing_way" class="billing_way">
                                                <option value="1" {eq name="goods['billing_way']" value="1"}selected{/eq}>件数</option>
                                                <option value="2" {eq name="goods['billing_way']" value="2"}selected{/eq}>重量(kg)</option>
                                                <option value="3" {eq name="goods['billing_way']" value="3"}selected{/eq}>体积(立方米)</option>
                                            </select>
                                            <div>不设置规格时必填（除件数）</div>
                                            <input type="text" name="billing_num" value="{$goods['billing_num']}" class="layui-input" id="billing_num">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">推荐类型</label>
                                        <div class="layui-input-inline">
                                            <select name="recommended" id="recommended">
                                                <option value="0" {eq name="goods['recommended']" value="0"}selected{/eq}>不推荐</option>
                                                <option value="1" {eq name="goods['recommended']" value="1"}selected{/eq}>热门推荐</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">运费模板</label>
                                        <div class="layui-input-inline">
                                            <select name="freight_id" id="freight_id">
                                                <option value="">请选择</option>
                                                {volist name="freightList" id="vo"}
                                                <option value="{$vo['id']}" {eq name="goods['freight_id']" value="$vo['id']"}selected{/eq}>{$vo['freight_name']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">排序</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sort" value="{$goods['sort']}" value="100" class="layui-input" id="sort">
                                        </div>
                                    </div>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label">状态</label>
                                        <div class="layui-input-block divline">
                                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" {if $goods['is_show']=='1'}checked=""{/if}>
                                            <label for="is_show1">上架</label>
                                            <input type="radio" name="is_show" id="is_show2" value="0" title="下架" {if $goods['is_show']=='0'}checked=""{/if}>
                                            <label for="is_show2">下架</label>
                                        </div>
                                    </div>


                                </div>
                                <div class="detlstext-one">

                                    <div class="gdetails">
                                        <div><i class="Hui-iconfont color-red">&#xe630;</i>产品描述</div>
                                        <div class="gdetails_text">
                                            <textarea id="description" name="goods_desc">{$goods['goods_desc']|htmlspecialchars_decode}</textarea>
                                        </div>
                                    </div>
                                    <div class="gdetails">
                                        <div>规格参数</div>
                                        <div class="gdetails_text">
                                            <textarea id="parameter" name="goods_desc2">{$goods['goods_desc2']|htmlspecialchars_decode}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="detlstext-one detonedis">
                                    <div class="addgimgdiv">
                                        <input type="button" class="fileimg-btn floatright" value="添加图片" id="add_goodsimg"/>
                                    </div>

                                    <form></form>
                                    <ul class="goodsimg-ul" id="goodsimg_list">
                                        {volist name="galleryList" id="vo"}
                                        <li class="goodsimg-li">

                                            <form class="gallery_from" action="" name="gallery_from{$vo['gallery_id']}">

                                                <div class="goodsimg-auto">

                                                    <img src="__STATIC__/{$vo['img_big']}" class="fileimg_g1y{$i} img_big" />
                                                    <label class="fileimg-btn goodsimgbtn" for="g1y{$i}">选择文件</label>
                                                    <input class="" onchange="editGallery(this, '{$vo['gallery_id']}')" id="g1y{$i}" style="display: none;" name="gallery" type="file"/>
                                                    <input type="hidden" value="{$vo['img_big']}" name="img_big" />
                                                    <input type="hidden" value="{$vo['gallery_id']}" name="gallery_id" />

                                                </div>
                                                <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)" data-galleryid="{$vo['gallery_id']}">
                                                    <i class="Hui-iconfont" title="删除">&#xe609;</i>
                                                </a>
                                            </form>

                                        </li>
                                        {/volist}

                                    </ul>
                                </div>
                                <div class="detlstext-one detonedis">
                                    <input type="button" class="fileimg-btn floatright" value="添加规格项" id="add_norm"/>
                                    <table border="1" class="churuzhang-tb">
                                        <thead class="churuzhang-te">
                                            <tr>
                                                <th>序号</th>
                                                <th>颜色</th>
                                                <th>版本</th>
                                                <th>价格</th>
                                                <th>原价</th>
                                                <th>库存</th>
                                                <th colspan="2">类型内容</th>
                                                <th>排序</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody class="churuzhang-ty" id="norm_lists">
                                            {volist name="inventoryList" id="vo" key="index"}
                                            <tr class="tbcenter">
                                                <td>{$index}</td>
                                                <td>
                                                    <select name="goodscolor[]" class="goodscolor_list" onchange="editInventory(this,{$vo['id']}, 'goodscolor_id')">
                                                        <option value="0">请选颜色</option>
                                                        {volist name="GoodsColorList" id="gcvo"}
                                                        <option value="{$gcvo['id']}" {eq name="vo['goodscolor_id']" value="$gcvo['id']"}selected{/eq}>
                                                            {$gcvo['color_name']}
                                                        </option>
                                                        {/volist}
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="cates[]" class="cates_list" onchange="editInventory(this,{$vo['id']}, 'cate_id')">
                                                        <option value="0">请选版本</option>
                                                        {volist name="catesList" id="ctvo"}
                                                        <option value="{$ctvo['cate_id']}" {eq name="vo['cate_id']" value="$ctvo['cate_id']"}selected{/eq}>
                                                            {$ctvo['cate_name']}
                                                        </option>
                                                        {/volist}
                                                    </select>
                                                </td>
                                                <td><input type="text" class="inty_price" value="{$vo['inty_price']}" name="inty_price[]" size="10" oninput="editInventory(this,{$vo['id']},'inty_price')"/></td>
                                                <td><input type="text" class="orgprice" value="{$vo['orgprice']}" name="orgprice[]" size="10" oninput="editInventory(this,{$vo['id']},'orgprice')"/></td>
                                                <td><input type="text" class="inventory" value="{$vo['inventory']}" name="inventory[]" size="10" oninput="editInventory(this,{$vo['id']},'inventory')"/></td>
                                                <td>
                                                    <select name="type[]" onchange="editInventory(this,{$vo['id']}, 'type')">
                                                        <option value="1" {eq name="vo['type']" value="1"} selected {/eq}>件数</option>
                                                        <option value="2" {eq name="vo['type']" value="2"} selected {/eq}>重量(kg)</option>
                                                        <option value="3" {eq name="vo['type']" value="3"} selected {/eq}>体积(立方米)</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="type_num" value="{$vo['type_num']}" name="type_num[]" size="10" oninput="editInventory(this,{$vo['id']},'type_num')"/></td>

                                                <td><input type="text" class="sort" value="{$vo['sort']}" size="10" oninput="editInventory(this,{$vo['id']},'sort')"/></td>
                                                <td>
                                                    <input type="hidden" value="{$vo['id']}" name="inventory_id[]" />
                                                    <a href="javascript:;" data-inventoryid="{$vo['id']}" class="nduotu">多图</a>
                                                    <a href="javascript:;" data-inventoryid="{$vo['id']}" onclick="delInventory(this)">删除</a>
                                                </td>
                                            </tr>
                                            {/volist}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="cate_name">当前选择的类别：
                    <span id="directory1_name">{$businessCategoryInfo['directory1_name']}</span>》
                    <span id="directory2_name">{$businessCategoryInfo['directory2_name']}</span>》
                    <span id="directory3_name">{$businessCategoryInfo['directory3_name']}</span>
                </div>
                <div class="goodsbtn_div">
                    <input type="hidden" name="goods_id" value="{$goods['goods_id']}" id="goods_id"/>
                    <input type="hidden" name="directory_id" value="{$goods['dir_id']}" id="directory_id"/>
                    <botton class="goods_btn" id="goodsbtn_on1">上一步</botton>
                    <botton class="goods_btn goodsbtn_act" id="goodsbtn_under1">下一步，商品详情</botton>
                </div>
            </div>
        </div>

        <input type="hidden" name="is_showdiv" value="1" id="is_showdiv"/>
    </form>
</div>
{include file="public/seller/norm_img" /}

{include file="public/plugin/kindeditor" /}
<script type="text/javascript" src="__PC__/js/seller_goods/goods_details.js"></script>
