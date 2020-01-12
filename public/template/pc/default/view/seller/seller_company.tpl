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
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/seller_company.css" />
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
                                    <div class="progress-title title-auto">填写公司信息</div>
                                </li>
                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">3</div>
                                    <div class="progress-title title-auto">填写店铺信息</div>
                                </li>
                                <li class="progress-li bacactive-hui">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">4</div>
                                    <div class="progress-title title-auto">资质上传</div>
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
                                                <div>填写公司信息</div>
                                                <div class="bacgli-title2"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>公司名称</span>
                                        <input type="text" value="{$info['company_name']}" name="company_name" class="loginli-input" placeholder="请输入公司名称" id="company_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>公司性质</span>
                                        <div class="selectwidth floatleft">
                                            <select name="company_nature" lay-filter="company_nature">
                                                <option value="1" {eq name="info['company_nature']" value="1"}selected{/eq}>个人独立企业</option>
                                                <option value="2" {eq name="info['company_nature']" value="2"}selected{/eq}>国企</option>
                                                <option value="3" {eq name="info['company_nature']" value="3"}selected{/eq}>外企</option>
                                            </select>
                                        </div>

                                    </li>
                                    <li class="login-li">
                                        <span>公司官网地址</span>
                                        <input type="text" value="{$info['company_url']}" name="company_url" class="loginli-input" placeholder="请输入公司官网地址" id="company_url"/>
                                    </li>

                                    <li class="login-li">
                                        <span>公司所在地</span>
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
                                                <option value="0" >市级</option>
                                                {if $info['id']}
                                                    {volist name="cityList" id="vo"}
                                                    <option value="{$vo['id']}" {eq name="info['city_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                    {/volist}
                                                {/if}
                                            </select>
                                        </div>
                                        <div class="selectwidth floatleft">
                                            <select name="county_id" lay-filter="county_id" id="county_id">
                                                <option value="0" >县级</option>
                                                {if $info['id']}
                                                    {volist name="countyList" id="vo"}
                                                    <option value="{$vo['id']}" {eq name="info['county_id']" value="$vo['id']"}selected{/eq}>{$vo['name']}</option>
                                                    {/volist}
                                                {/if}
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>公司详细地址</span>
                                        <input type="text" value="{$info['detaddress']}" name="detaddress" class="loginli-input" placeholder="请输入公司详细地址" id="detaddress"/>
                                    </li>
                                    <li class="login-li">
                                        <span>固定电话</span>
                                        <input type="text" value="{$info['fixed_telephone']}" name="fixed_telephone" class="loginli-input" placeholder="请输入固定电话" id="fixed_telephone"/>
                                    </li>
                                    <li class="login-li">
                                        <span>电子邮箱</span>
                                        <input type="text" value="{$info['email']}" name="email" class="loginli-input" placeholder="请输入电子邮箱" id="email"/>
                                    </li>
                                    <li class="login-li">
                                        <span>传真</span>
                                        <input type="text" value="{$info['fax']}" name="fax" class="loginli-input" placeholder="请输入传真" id="fax"/>
                                    </li>
                                    <li class="login-li">
                                        <span>邮政编码</span>
                                        <input type="text" value="{$info['thezipcode']}" name="thezipcode" class="loginli-input" placeholder="请输入邮政编码" id="thezipcode"/>
                                    </li>

                                </ul>
                                <ul class="login-ul floatfalse">
                                    <li class="login-li">
                                        <div class="bacg-lihui">
                                            <div class="bacgli-auto">
                                                <div>营业执照信息</div>
                                                <div class="bacgli-title2"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>一证一码商家</span>
                                        <div class="appltype">
                                            <input type="radio" name="a_yard_merchants" {if !$info['id']||$info['a_yard_merchants']==1}checked{/if} value="1" title="是">
                                            <input type="radio" name="a_yard_merchants" {eq name="info['a_yard_merchants']" value="2"}checked{/eq} value="2" title="否">
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>注册资金</span>
                                        <input type="text" value="{$info['registered_capital']}" name="registered_capital" class="loginli-input" placeholder="请输入注册资金" id="registered_capital"/>
                                        <div class="righttitle">万元人民币</div>
                                    </li>
                                    <li class="login-li">
                                        <span>统一社会信用代码</span>
                                        <input type="text" value="{$info['credit_code']}" name="credit_code" class="loginli-input" placeholder="请输入统一社会信用代码" id="credit_code"/>
                                    </li>
                                    <li class="login-li">
                                        <span>法定代表人姓名</span>
                                        <input type="text" value="{$info['legal_rep_name']}" name="legal_rep_name" class="loginli-input" placeholder="请输入法定代表人姓名" id="legal_rep_name"/>
                                    </li>
                                    <li class="login-li">
                                        <span>营业执照有效期</span>
                                        <input type="text" value="{$info['effective_start_time']}" name="effective_start_time" class="loginli-input2" id="effective_start_time"/>
                                        <div class="righttitle">-</div>
                                        <div id="div_end_time">
                                            <input type="text" value="{if $info['effective_end_time']}{$info['effective_end_time']}{else/}长期{/if}" name="effective_end_time" class="loginli-input2"/> 
                                        </div>
                                        <div class="righttitle">
                                            <input type="checkbox" name="long_time" lay-filter="long_time" lay-skin="primary" title="长期" checked=""/>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>营业执照经营范围</span>
                                        <input type="text" value="{$info['scope_business']}" name="scope_business" class="loginli-input" placeholder="请输入营业执照经营范围" id="scope_business"/>
                                    </li>
                                    <li class="login-li">
                                        <span>纳税人类型</span>
                                        <div class="selectwidth floatleft">
                                            <select name="taxpayers_type" lay-filter="taxpayers_type" id="taxpayers_type">
                                                <option value="1" {eq name="info['taxpayers_type']" value="1"}selected{/eq}>一般纳税人</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li">
                                        <span>纳税类型税码</span>
                                        <div class="selectwidth floatleft">
                                            <select name="taxtypetaxcode" lay-filter="taxtypetaxcode" id="taxtypetaxcode">
                                                <option value="1" {eq name="info['taxtypetaxcode']" value="1"}selected{/eq}>0%</option>
                                                <option value="2" {eq name="info['taxtypetaxcode']" value="2"}selected{/eq}>5%</option>
                                                <option value="3" {eq name="info['taxtypetaxcode']" value="3"}selected{/eq}>10%</option>
                                                <option value="4" {eq name="info['taxtypetaxcode']" value="4"}selected{/eq}>20%</option>
                                                <option value="5" {eq name="info['taxtypetaxcode']" value="5"}selected{/eq}>30%</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="login-li li-submit">
                                        <input type="button" value="下一步,填写店铺信息" class="login-btn" onclick="companySubmit(this);"/>
                                        <a href="{:url('seller/seller_contact')}" class="shangyb-btn3">上一步</a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/seller_company.js"></script>

    </body>
</html>
