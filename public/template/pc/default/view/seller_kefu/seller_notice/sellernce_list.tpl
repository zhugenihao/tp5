
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>系统信息管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="消息内容"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSellernce(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除系统信息
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>消息内容</th>
                    <th>通知者</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="sellernce['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td><div class="tablediv-name">{$vo['content']}</div></td>
                    <td>总平台</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="tablediv-btn">
                            <a href="javascript:;" class="btn-blue" onclick="sellernceDetails(this)" url="{:url('seller_kefu.seller_notice/sellernce_details',['id'=>$vo['id']])}">详情</a>

                            <a href="javascript:;" class="btn-red" onclick="delSellernce(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $sellernce['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_kefu/seller_notice/sellernce_list.js"></script>
