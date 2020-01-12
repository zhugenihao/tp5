
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>客服管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>类型</label>
                <span>
                    <select name="kefu_type" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('kefu_type')" value="1"} selected {/eq}>售前客服</option>
                        <option value="2" {eq name=":input('kefu_type')" value="2"} selected {/eq}>售后客服</option>
                    </select>
                </span>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="客服名称/客服账号"/>
                <input type="submit" value="搜索" class="update_btn2"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delKefu(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除客服
                </a>
            </div>
            <div class="floatright">
                <a href="javascript:;" onclick="kefuAdd(this)" url="{:url('seller_kefu.kefu/kefu_add')}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加客服
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>客服名称</th>
                    <th>客服账号</th>
                    <th>客服电话</th>
                    <th>客服工具</th>
                    <th>类型</th>
                    <th width="170">更新时间</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="kefu['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['kefu_name']}</td>
                    <td>{$vo['kefu_account']}</td>
                    <td>{$vo['tel']}</td>
                    <td>
                        {eq name="vo['kefu_tool']" value="1"} 站内客服 {/eq}
                        {eq name="vo['kefu_tool']" value="2"} qq客服 {/eq}
                        {eq name="vo['kefu_tool']" value="3"} 微信客服 {/eq}
                        {eq name="vo['kefu_tool']" value="4"} 旺旺客服 {/eq}
                    </td>
                    <td>
                        {eq name="vo['kefu_type']" value="1"} 售前客服 {/eq}
                        {eq name="vo['kefu_type']" value="2"} 售后客服 {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        <div class="order-btn">
                            <a href="javascript:;" onclick="kefuDetails(this)" url="{:url('seller_kefu.kefu/kefu_details',['kefu_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delKefu(this)" data-id="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $kefu['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_kefu/kefu/kefu_list.js"></script>
