<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>商家入驻</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/login.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/seller_store.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="login-div">
                <div class="login-auto">
                    <div class="login-text">
                        <form method="post" enctype="multipart/form-data" name="formsubmit" class="layui-form login-text2">
                            <div class="login_title">商家入驻</div>
                            <ul class="progress-ul">
                                <li class="progress-li bacactive-red" style="width:100px;">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num">1</div>
                                    <div class="progress-title progress-mg1">联系信息</div>
                                </li>

                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">2</div>
                                    {if input('application_type')==2}
                                        <div class="progress-title title-auto">填写公司信息</div>
                                    {else/}
                                        <div class="progress-title title-auto">填写公司信息(省略)</div>
                                    {/if}
                                </li>

                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">3</div>
                                    <div class="progress-title title-auto">填写店铺信息</div>
                                </li>

                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">4</div>
                                    {if input('application_type')==2}
                                        <div class="progress-title title-auto">资质上传</div>
                                    {else/}
                                        <div class="progress-title title-auto">资质上传(省略)</div>
                                    {/if}
                                </li>

                                <li class="progress-li bacactive-hui" style="width:100px;">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num floatright"><i class="Hui-iconfont">&#xe6a7;</i></div>
                                    <div class="progress-title progress-mg2">等待审核</div>
                                </li>
                            </ul>
                            <div class="dakuangborder">
                                <ul class="login-ul floatfalse">
                                    <li class="login-li">
                                        <div class="bacg-lihui">
                                            <div class="bacgli-auto">
                                                <div>填写店铺信息</div>
                                                <div class="bacgli-title2"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>店铺名称</span>
                                        <input type="text" value="{$info['store_name']}" name="store_name" class="loginli-input" placeholder="请输入店铺名称" id="store_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>店铺主营大类</span>
                                        <div class="selectwidth floatleft">
                                            <select name="directory_big_id" lay-filter="directory_big_id" id="directory_big_id">
                                                <option value="0" >选择主营大类</option>
                                                {volist name="directoryBigList" id="vo"}
                                                <option value="{$vo['id']}" {eq name="info['directory_big_id']" value="$vo['id']"}selected{/eq}>{$vo['title']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>店铺性质</span>
                                        <div class="selectwidth floatleft">
                                            <select name="store_nature" lay-filter="store_nature">
                                                <option value="1" {eq name="info['store_nature']" value="1"}selected{/eq}>旗舰店</option>
                                                <option value="2" {eq name="info['store_nature']" value="2"}selected{/eq}>专卖店</option>
                                                <option value="3" {eq name="info['store_nature']" value="3"}selected{/eq}>专营店</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>店铺负责人姓名</span>
                                        <input type="text" value="{$info['head_name']}" name="head_name" class="loginli-input" placeholder="请输入店铺负责人姓名" id="head_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>负责人手机号码</span>
                                        <input type="text" value="{$info['head_mobile']}" name="head_mobile" class="loginli-input" placeholder="请输入负责人手机号码" id="head_mobile"/>
                                    </li>
                                    <li class="login-li">
                                        <span>负责人QQ号码</span>
                                        <input type="text" value="{$info['head_qq']}" name="head_qq" class="loginli-input" placeholder="请输入负责人QQ号码" id="head_qq"/>
                                    </li>
                                    <li class="login-li">
                                        <span>电子邮箱</span>
                                        <input type="text" value="{$info['email']}" name="email" class="loginli-input" placeholder="请输入电子邮箱" id="email"/>
                                    </li>
                                    <li class="login-li">
                                        <span>店铺详细地址</span>
                                        <input type="text" value="{$info['store_address']}" name="store_address" class="loginli-input" placeholder="请输入店铺详细地址" id="store_address"/>
                                    </li>
                                    <li class="login-li">
                                        <span>经营类目</span>

                                        <div class="selectwidth floatleft">
                                            <select name="directory1_id" lay-filter="directory1_id" id="directory1_id">
                                                <option value="0" >选择一级类目</option>
                                                {volist name="directoryBigList" id="vo"}
                                                <option value="{$vo['id']}">{$vo['title']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                        <div class="selectwidth floatleft">
                                            <select name="directory2_id" lay-filter="directory2_id" id="directory2_id">
                                                <option value="0" >选择二级类目</option>
                                            </select>
                                        </div>
                                        <div class="selectwidth floatleft">
                                            <select name="directory3_id" lay-filter="directory3_id" id="directory3_id">
                                                <option value="0" >选择三级类目</option>
                                            </select>
                                        </div>
                                        <div class="righttitle">
                                            <input type="button" value="确定" class="login-btn2" onclick="addBusCategory(this)"/>
                                        </div>
                                        <div class="divtables floatfalse">
                                            <table border="1" class="tableswgmp" id="directory_table">
                                                <tr>
                                                    <th>一级类目名称</th>
                                                    <th>二级类目名称</th>
                                                    <th>三级类目名称</th>
                                                    <th>操作</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="login-ul floatfalse">
                                    <li class="login-li">
                                        <div class="bacg-lihui">
                                            <div class="bacgli-auto">
                                                <div>结算银行账号</div>
                                                <div class="bacgli-title2"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>银行开户名</span>
                                        <input type="text" value="{$info['bank_name']}" name="bank_name" class="loginli-input" placeholder="请输入银行开户名" id="bank_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>银行账号</span>
                                        <input type="text" value="{$info['bank_account']}" name="bank_account" class="loginli-input" placeholder="请输入银行账号" id="bank_account"/>
                                    </li>
                                    <li class="login-li">
                                        <span>开户银行支行名称</span>
                                        <input type="text" value="{$info['bank_branch_name']}" name="bank_branch_name" class="loginli-input" placeholder="请输入开户银行支行名称" id="bank_branch_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>开户银行支行所在地</span>
                                        <div class="selectwidth floatleft">
                                            <select name="province_id" lay-filter="province_id" id="province_id">
                                                <option value="0" >省级</option>
                                                {volist name="provinceList" id="vo"}
                                                <option value="{$vo['id']}" {eq name="info['province_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                {/volist}
                                            </select>
                                        </div>
                                        <div class="selectwidth floatleft">
                                            <select name="city_id" lay-filter="city_id" id="city_id">
                                                <option value="0">市级</option>
                                                {if $info['id']}
                                                    {volist name="cityList" id="vo"}
                                                    <option value="{$vo['id']}" {eq name="info['city_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                    {/volist}
                                                {/if}
                                            </select>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="login-ul floatfalse">
                                    <li class="login-li">
                                        <div class="bacg-lihui">
                                            <div class="bacgli-auto">
                                                <div>运营信息</div>
                                                <div class="bacgli-title2"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>近一年主营渠道</span>
                                        <div class="selectwidth floatleft">
                                            <select name="main_channel" lay-filter="main_channel" id="main_channel">
                                                <option value="0">请选择</option>
                                                <option value="1" {eq name="info['main_channel']" value="1"}selected{/eq}>商场/卖场</option>
                                                <option value="2" {eq name="info['main_channel']" value="2"}selected{/eq}>批发市场</option>
                                                <option value="3" {eq name="info['main_channel']" value="3"}selected{/eq}>超市/连锁店/商业中心</option>
                                                <option value="4" {eq name="info['main_channel']" value="4"}selected{/eq}>电商网站</option>
                                                <option value="5" {eq name="info['main_channel']" value="5"}selected{/eq}>其他</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>近一年销售额</span>
                                        <input type="text" value="{$info['sales']}" name="sales" class="loginli-input" placeholder="请输近一年销售额" id="sales"/>
                                        <div class="righttitle">万元</div>
                                    </li>
                                    <li class="login-li">
                                        <span>同类电子商务网站经验</span>
                                        <div class="appltype">
                                            <input type="radio" name="experience" {if !$info['id']||$info['experience']==1}checked{/if} value="1" title="有">
                                            <input type="radio" name="experience" {eq name="info['experience']" value="2"}checked{/eq} value="2" title="没有">
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>可网售商品数量</span>
                                        <input type="text" value="{if !$info['id']}1{else/}{$info['sales_quantity']}{/if}" name="sales_quantity" class="loginli-input" id="sales_quantity"/>
                                    </li>
                                    <li class="login-li">
                                        <span>预计平均客单价</span>
                                        <input type="text" value="{if !$info['id']}0.00{else/}{$info['average_price']}{/if}" name="average_price" class="loginli-input" id="average_price"/>
                                    </li>
                                    <li class="login-li">
                                        <span>仓库情况</span>
                                        <div class="selectwidth floatleft">
                                            <select name="warehouse" lay-filter="warehouse" id="warehouse">
                                                <option value="0" >请选择</option>
                                                <option value="1" {eq name="info['warehouse']" value="1"}selected{/eq}>自有仓库</option>
                                                <option value="2" {eq name="info['warehouse']" value="2"}selected{/eq}>第三方仓库</option>
                                                <option value="3" {eq name="info['warehouse']" value="3"}selected{/eq}>无仓库</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>是否有实体店</span>
                                        <div class="appltype">
                                            <input type="radio" name="there_is_store" {if !$info['id']||$info['there_is_store']==1}checked{/if} value="1" title="有">
                                            <input type="radio" name="there_is_store" {eq name="info['there_is_store']" value="2"}checked{/eq} value="2" title="无">
                                        </div>
                                    </li>


                                    <li class="login-li li-submit">
                                        <input type="hidden" value="{:input('application_type')}" id="application_type" />
                                        <input type="button" value="下一步" class="login-btn" onclick="storeSubmit(this);"/>
                                        {if input('application_type')==2}
                                            <a href="{:url('seller/seller_company')}" class="shangyb-btn3">上一步</a>
                                        {else/}
                                            <a href="{:url('seller/seller_contact')}" class="shangyb-btn3">上一步</a>
                                        {/if}

                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/seller_store.js"></script>

    </body>
</html>
