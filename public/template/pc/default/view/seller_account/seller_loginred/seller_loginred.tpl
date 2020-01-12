
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>商家登陆日志</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="商家名称/登录ip"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delLoginred(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除日志
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>商家名称</th>
                    <th>登陆ip</th>
                    <th>内容</th>
                    <th width="160">登陆时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="sellerLoginred['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['seller_name']}</td>
                    <td>{$vo['login_ip']}</td>
                    <td>{$vo['texts']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="delLoginred(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $sellerLoginred['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_account/seller_loginred/seller_loginred.js"></script>
