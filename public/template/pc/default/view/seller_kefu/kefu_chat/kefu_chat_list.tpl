
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/socket/css/index/pc_index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>聊天内容管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>类型</label>
                <span>
                    <select name="type" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('type')" value="1"} selected {/eq}>用户的信息</option>
                        <option value="2" {eq name=":input('type')" value="2"} selected {/eq}>客服的信息</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="聊天内容"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="del(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除聊天内容
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>聊天内容</th>
                    <th>用户名称</th>
                    <th>客服名称</th>
                    <th>类型</th>
                    <th width="170">创建时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty" id="content-tb">
                {volist name="list['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td class="text-left"><div class="content_div" go_type="{$vo['go_type']}">{$vo['content']}</div></td>
                    <td>{$vo['member_name']}</td>
                    <td>{$vo['kefu_name']}</td>
                    <td>
                        {eq name="vo['type']" value="1"} <span class="color-green">用户的信息</span> {/eq}
                        {eq name="vo['type']" value="2"} <span class="color-blue">客服的信息</span> {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="details(this)" url="{:url('seller_kefu.kefu_chat/kefu_chat_details',['id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="del(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $list['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>
<script type="text/javascript" src="__STATIC__/socket/js/public/functions.js"></script>
<script type="text/javascript" src="__PC__/js/seller_kefu/kefu_chat/kefu_chat_list.js"></script>
