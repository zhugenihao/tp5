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
        <link rel="stylesheet" type="text/css" href="__PC__/css/seller/seller_qualification.css" />
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
                                <li class="progress-li bacactive-red">
                                    <div class="progress-heng"></div>
                                    <div class="progress-num progressnum-auto">3</div>
                                    <div class="progress-title title-auto">填写店铺信息</div>
                                </li>
                                <li class="progress-li bacactive-red">
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
                            <ul class="login-ul floatfalse">
                                <li class="login-li">
                                    <div class="bacg-lihui">
                                        <div class="bacgli-auto">
                                            <div>资质上传信息</div>
                                            <div class="bacgli-title2">注意：图片要清晰，支持JPG,JPEG,GIF,PNG</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="login-li">
                                    <span>企业营业执照副本复印件（需加盖红章）</span>
                                    <div class="righttitle"><a href="" target="_blank">查看示例</a></div>
                                    <input type="file" name="file[]" class="loginli-input" id="business_attachment"/>
                                </li>
                                <li class="login-li">
                                    <span>税务登记证复印件（国税、地税）（需加盖红章）</span>
                                    <div class="righttitle"><a href="" target="_blank">查看示例</a></div>
                                    <input type="file" name="file[]" class="loginli-input" id="trc_copy"/>
                                </li>
                                <li class="login-li">
                                    <span>织机构代码证复印件（需加盖红章）</span>
                                    <div class="righttitle"><a href="" target="_blank">查看示例</a></div>
                                    <input type="file" name="file[]" class="loginli-input" id="koc_copy"/>
                                </li>
                                <li class="login-li">
                                    <span>法人身份证正反面复印件或护照（需加盖红章）</span>
                                    <div class="righttitle"><a href="" target="_blank">查看示例</a></div>
                                    <input type="file" name="file[]" class="loginli-input" id="panlpicop_copy"/>
                                </li>
                                <li class="login-li">
                                    <span>店铺负责人身份证正反面复印件（需加盖红章）</span>
                                    <div class="righttitle"><a href="" target="_blank">查看示例</a></div>
                                    <input type="file" name="file[]" class="loginli-input" id="shoticcot_front"/>
                                </li>
                                <li class="login-li">
                                    <span>法人身份证/护照号码</span>
                                    <input type="text" value="{$info['card_or_passport']}" name="card_or_passport" class="loginli-input" placeholder="请输入法人身份证/护照号码" id="card_or_passport"/>
                                </li>
                                <li class="login-li">
                                    <span>店铺负责人身份证号码</span>
                                    <input type="text" value="{$info['store_card']}" name="store_card" class="loginli-input" placeholder="请输入店铺负责人身份证号码" id="store_card"/>
                                </li>
                                <li class="login-li li-submit">
                                    <input type="hidden" value="{$info['business_attachment']}" name="business_attachment" />
                                    <input type="hidden" value="{$info['trc_copy']}" name="trc_copy" />
                                    <input type="hidden" value="{$info['koc_copy']}" name="koc_copy" />
                                    <input type="hidden" value="{$info['panlpicop_copy']}" name="panlpicop_copy" />
                                    <input type="hidden" value="{$info['shoticcot_front']}" name="shoticcot_front" />
                                    
                                    <input type="button" value="提交资料" class="login-btn" onclick="qualificationSubmit(this);"/>
                                    <a href="{:url('seller/seller_store')}" class="shangyb-btn3">上一步</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/seller/seller_qualification.js"></script>

    </body>
</html>
