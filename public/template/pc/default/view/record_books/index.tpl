<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的出入账</title>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__PC__/css/member/index.css" />
        <link rel="stylesheet" type="text/css" href="__PC__/css/record_books/index.css" />
    </head>
    <body>
        <div class="pcdiv-all">
            {include file="public/top" /}
            <div class="member-all">
                <!--头部栏目-->
                {include file="public/member_top" /}

                <div class="pcdiv-auto">
                    <div class="membertext-all">
                        <!--左部栏目-->
                        {include file="public/member_left" /}

                        <div class="member-right floatleft">
                            <div class="member-text">
                                <form class="layui-form" action="">
                                    <div class="member-yue"><span>我的余额：<i>{$memberInfo['forehead']}</i></span><span>我的积分：<i>{$memberInfo['integral']}</i></span></div>
                                    <div class="layui-inline zhanglx">
                                        <label class="layui-form-label">账单类型</label>
                                        <div class="layui-input-inline">
                                            <select name="quiz" lay-filter="bookstype" >
                                                <option value="" >选择类型</option>
                                                <option value="into" {eq name="books_type" value="into"}selected{/eq} >入账类型</option>
                                                <option value="out" {eq name="books_type" value="out"}selected{/eq}>出账类型</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="churuzhang">
                                        <table border="1" class="churuzhang-tb">
                                            <thead class="churuzhang-te">
                                                <tr>
                                                    <th>内容</th>
                                                    <th>类型</th>
                                                    <th>数量</th>
                                                    <th>时间</th>
                                                </tr>
                                            </thead>
                                            <tbody class="churuzhang-ty">
                                                {volist name="recordBooksList" id="vo"}
                                                <tr class="tbcenter">
                                                    <td>{$vo['books_text']}</td>
                                                    <td>
                                                        {eq name="vo['books_type']" value="into"}入账{/eq}
                                                        {eq name="vo['books_type']" value="out"}出账{/eq}
                                                    </td>
                                                    <td>
                                                        {if $vo['books_type']=='into'}
                                                            <span class="color-green">
                                                                +{$vo['amount']}
                                                                {eq name="vo['rdbook_type']" value="1"}余额{/eq}
                                                                {eq name="vo['rdbook_type']" value="2"}积分{/eq}
                                                            </span>
                                                        {else/}
                                                            <span class="color-red">
                                                                -{$vo['amount']}
                                                                {eq name="vo['rdbook_type']" value="1"}余额{/eq}
                                                                {eq name="vo['rdbook_type']" value="2"}积分{/eq}
                                                            </span>
                                                        {/if}
                                                    </td>
                                                    <td>{$vo.create_time}</td>
                                                </tr>
                                                {/volist}

                                        </table>
                                        <div class="page-div">{$page}</div>

                                    </div>
                                </form>
                            </div>
                            <!--猜你喜欢-->
                            {include file="public/guess_you_like" /}
                        </div>
                    </div>
                </div>
            </div>
            {include file="public/bottom" /}
        </div>
        <script type="text/javascript" src="__PC__/js/record_books/index.js"></script>
    </body>
</html>
