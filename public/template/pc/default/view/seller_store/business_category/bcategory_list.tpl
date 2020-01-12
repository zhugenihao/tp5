
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>类目管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>审核状态</label>
                <div class="layui-input-inline">
                    <select name="audit" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('audit')" value="1"} selected {/eq}>审核中</option>
                        <option value="2" {eq name=":input('audit')" value="2"} selected {/eq}>审核通过</option>
                        <option value="3" {eq name=":input('audit')" value="3"} selected {/eq}>审核不通过</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="类目名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="6" name="top"/>
                <input type="hidden" value="2" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delBcategory(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除类目
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_store.business_category/bcategory_add',['top'=>6,'type'=>3])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加类目
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th colspan="3">经营类目</th>
                    <th width="80">分佣比例</th>
                    <th width="170">添加时间</th>
                    <th width="100">审核状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="bcategory['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>{$vo['directory1_name']}</td>
                    <td>-->{$vo['directory2_name']}</td>
                    <td>-->{$vo['directory2_name']}</td>
                    <td>{$vo['commission_rate']}%</td>
                    <td>{$vo['add_time']|date="Y-m-d H:i:s",###}</td>
                    <td>
                        {eq name="vo['audit']" value="1"}
                        <span class="color-blue">审核中</span> 
                        {/eq}
                        {eq name="vo['audit']" value="2"}
                        <span class="color-green">审核通过</span> 
                        {/eq}
                        {eq name="vo['audit']" value="3"}
                        <span class="color-red">审核不通过</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <!--<a href="javascript:;" onclick="delBcategory(this)" data-id="{$vo['id']}">删除</a>-->
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $bcategory['total'] < 1}
                    <tr class="tbcenter"><td colspan="8">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_store/business_category/bcategory_list.js"></script>
