
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__PC__/css/seller_goods/index.css" />
<div class="seller-allas">
    <form class="" action="" id="fabu_from" name="fabu_from">
        <div class="member-yue"><span>商品发布</div>
        <div class="goods_fabu">
            <ul class="goodsfabu_ul">
                <li id="goods_title1" class="fabu_active"><span>选择商品分类</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title2"><span>填写商品详情</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title3"><span>上传商品图片</span><i class="Hui-iconfont">&#xe6d7;</i></li>
                <li id="goods_title4"><span>商品发布成功</span></li>
            </ul>
            <div class="goods-cateall floatfalse">
                <div class="goods-cate" id="goods-cate">
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory1">
                            {volist name="businessCategory" id="vo"}
                            <li data-dir1id="{$vo['directory1_id']}">{$vo['directory1_name']}</li>
                                {/volist}
                        </ul>
                    </div>
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory2"></ul>
                    </div>
                    <div class="goodscate_div">
                        <ul class="goodscate_ul" id="directory3"></ul>
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
                                        <span class="layui-input-inline">
                                            <select name="brand_id" id="brand_id">
                                                <option value="0">请选择</option>
                                                {volist name="brandList" id="vo"}
                                                <option value="{$vo['id']}">{$vo['brand_name']}</option>
                                                {/volist}
                                            </select>
                                        </span>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">
                                            <i class="Hui-iconfont color-red">&#xe630;</i>
                                            商品名称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_name" placeholder="请输入商品名称" class="layui-input" id="goods_name">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>成本价（￥）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="cost_price" placeholder="请输入成本价" class="layui-input" id="cost_price">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>商品价格（￥）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_price" placeholder="请输入商品价格" class="layui-input" id="goods_price">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>商品库存（件）</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_stock" placeholder="请输入商品库存" class="layui-input" id="goods_stock">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品小名</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods2_name" placeholder="请输入商品小名" class="layui-input" id="goods2_name">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品货号</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="goods_sku" placeholder="请输入商品货号" class="layui-input" id="goods_sku">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>所在地</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="region" placeholder="请输入所在地" class="layui-input" id="region">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>封面</label>
                                        <div class="layui-input-block">
                                            <label class="fileimg-btn" for="images">选择文件</label>
                                            <input class="" onchange="getPhoto(this, 'thecover')" id="images" style="display: none;" name="thecover" type="file">

                                            <img src="" class="fileimg_thecover" />
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">虚拟销量</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sales" placeholder="请输入虚拟销量" class="layui-input" id="sales">
                                        </div>
                                    </div>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label"><i class="Hui-iconfont color-red">&#xe630;</i>设置规格</label>
                                        <div class="layui-input-block divline">
                                            <input type="checkbox" checked="" name="setup_norm" id="setup_norm" title="开关">
                                            <label for="setup_norm">开关</label>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">类型内容</label>
                                        <div class="layui-input-block">
                                            <select name="billing_way" class="billing_way">
                                                <option value="1">件数</option>
                                                <option value="2">重量(kg)</option>
                                                <option value="3">体积(立方米)</option>
                                            </select>
                                            <div>不设置规格时必填（除件数）</div>
                                            <input type="text" name="billing_num" value="10.00" class="layui-input" id="billing_num">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">推荐类型</label>
                                        <div class="layui-input-inline">
                                            <select name="recommended" id="recommended">
                                                <option value="">不推荐</option>
                                                <option value="">热门推荐</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">运费模板</label>
                                        <div class="layui-input-inline">
                                            <select name="freight_id" id="freight_id">
                                                <option value="">请选择</option>
                                                {volist name="freightList" id="vo"}
                                                <option value="{$vo['id']}">{$vo['freight_name']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">排序</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sort" placeholder="请输入排序" value="100" class="layui-input" id="sort">
                                        </div>
                                    </div>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label">状态</label>
                                        <div class="layui-input-block divline">
                                            <input type="radio" name="is_show" id="is_show1" value="1" title="上架" checked="">
                                            <label for="is_show1">上架</label>
                                            <input type="radio" name="is_show" id="is_show2" value="0" title="下架">
                                            <label for="is_show2">下架</label>
                                        </div>
                                    </div>


                                </div>
                                <div class="detlstext-one">

                                    <div class="gdetails">
                                        <div><i class="Hui-iconfont color-red">&#xe630;</i>产品描述</div>
                                        <div class="gdetails_text">
                                            <textarea id="description" name="goods_desc"></textarea>
                                        </div>
                                    </div>
                                    <div class="gdetails">
                                        <div>规格参数</div>
                                        <div class="gdetails_text">
                                            <textarea id="parameter" name="goods_desc2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="detlstext-one detonedis">
                                    <div class="addgimgdiv">
                                        <input type="button" class="fileimg-btn floatright" value="添加图片" id="add_goodsimg"/>
                                    </div>

                                    <ul class="goodsimg-ul" id="goodsimg_list">
                                        <li class="goodsimg-li">
                                            <div class="goodsimg-auto">
                                                <img src="" class="fileimg_g1y1"/>
                                                <label class="fileimg-btn goodsimgbtn" for="g1y1">选择文件</label>
                                                <input class="" onchange="getPhoto(this, 'g1y1', 140, 140)" id="g1y1" style="display: none;" name="gallery[]" type="file">
                                            </div>
                                            <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)">
                                                <i class="Hui-iconfont" title="删除">&#xe609;</i>
                                            </a>
                                        </li>
                                        <li class="goodsimg-li">
                                            <div class="goodsimg-auto">
                                                <img src="" class="fileimg_g1y2"/>
                                                <label class="fileimg-btn goodsimgbtn" for="g1y2">选择文件</label>
                                                <input class="" onchange="getPhoto(this, 'g1y2', 140, 140)" id="g1y2" style="display: none;" name="gallery[]" type="file">
                                            </div>
                                            <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)">
                                                <i class="Hui-iconfont" title="删除">&#xe609;</i>
                                            </a>
                                        </li>
                                        <li class="goodsimg-li">
                                            <div class="goodsimg-auto">
                                                <img src="" class="fileimg_g1y3"/>
                                                <label class="fileimg-btn goodsimgbtn" for="g1y3">选择文件</label>
                                                <input class="" onchange="getPhoto(this, 'g1y3', 140, 140)" id="g1y3" style="display: none;" name="gallery[]" type="file">
                                            </div>
                                            <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)">
                                                <i class="Hui-iconfont" title="删除">&#xe609;</i>
                                            </a>
                                        </li>
                                        <li class="goodsimg-li">
                                            <div class="goodsimg-auto">
                                                <img src="" class="fileimg_g1y4"/>
                                                <label class="fileimg-btn goodsimgbtn" for="g1y4">选择文件</label>
                                                <input class="" onchange="getPhoto(this, 'g1y4', 140, 140)" id="g1y4" style="display: none;" name="gallery[]" type="file">
                                            </div>
                                            <a href="javascript:;" class="gimg-dela" onclick="gimgDela(this)">
                                                <i class="Hui-iconfont" title="删除">&#xe609;</i>
                                            </a>
                                        </li>

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
                                            <tr class="tbcenter">
                                                <td>1</td>
                                                <td>
                                                    <select name="goodscolor[]" class="goodscolor_list">
                                                        <option value="0">请选颜色</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="cates[]" class="cates_list">
                                                        <option value="0">请选版本</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" value="10.00" class="inty_price" name="inty_price[]" size="10"/></td>
                                                <td><input type="text" value="10.00" class="orgprice" name="orgprice[]" size="10"/></td>
                                                <td><input type="text" value="10" class="inventory" name="inventory[]" size="10"/></td>
                                                <td>
                                                    <select name="type[]">
                                                        <option value="1">件数</option>
                                                        <option value="2">重量(kg)</option>
                                                        <option value="3">体积(立方米)</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="type_num" value="10.00" name="type_num[]" size="10"/></td>
                                                <td><input type="text" class="sort" value="10" name="sort[]" size="10"/></td>
                                                <td>
                                                    <!--<a href="javascript:;" data-nid="0">多图</a>-->
                                                    <a href="javascript:;" data-inventoryid="0">删除</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="cate_name">当前选择的类别：
                    <span id="directory1_name"></span>》
                    <span id="directory2_name"></span>》
                    <span id="directory3_name"></span>
                </div>
                <div class="goodsbtn_div">
                    <botton class="goods_btn" id="goodsbtn_on1">上一步</botton>
                    <botton class="goods_btn" id="goodsbtn_under1">下一步，商品详情</botton>
                </div>
            </div>
        </div>
        <input type="hidden" name="directory_id" value="0" id="directory_id"/>
        <input type="hidden" name="is_showdiv" value="1" id="is_showdiv"/>
    </form>
</div>
{include file="public/plugin/kindeditor" /}
<script type="text/javascript" src="__PC__/js/seller_goods/index.js"></script>
