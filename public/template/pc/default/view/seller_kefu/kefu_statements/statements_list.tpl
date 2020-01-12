
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>常用语句管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>状态</label>
                <span>
                    <select name="is_show" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>显示</option>
                        <option value="2" {eq name=":input('is_show')" value="2"} selected {/eq}>隐藏</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="常用语句内容"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="del(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除常用语句
                </a>
            </div>
            <div class="floatright">
                <a href="javascript:;" onclick="add(this)" url="{:url('seller_kefu.kefu_statements/statements_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加常用语句
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>常用语句内容</th>
                    <th>状态</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="list['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['content']}</td>
                    <td>
                        {eq name="vo['is_show']" value="1"} <span class="color-green">显示</span> {/eq}
                        {eq name="vo['is_show']" value="2"} <span class="color-red">隐藏</span> {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="details(this)" url="{:url('seller_kefu.kefu_statements/statements_details',['kstem_id'=>$vo['id']])}">编辑</a>
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

<script type="text/javascript" src="__PC__/js/seller_kefu/kefu_statements/statements_list.js"></script>
