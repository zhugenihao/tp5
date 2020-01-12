
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>导航管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="brand_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>设备</label>
                <select name="equipment" class="selectpad">
                    <option value="">请选择</option>
                    <option value="1" {eq name=":input('equipment')" value="1"} selected {/eq}>手机</option>
                    <option value="2" {eq name=":input('equipment')" value="2"} selected {/eq}>电脑</option>
                </select>
                <label>状态</label>
                <select name="is_show" class="selectpad">
                    <option value="">请选择</option>
                    <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>显示</option>
                    <option value="0" {eq name=":input('is_show')" value="0"} selected {/eq}>隐藏</option>
                </select>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="导航名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="6" name="top"/>
                <input type="hidden" value="2" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delCategory(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除导航
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_store.category/category_add',['top'=>6,'type'=>2])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加导航
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>导航名称</th>
                    <th>排序</th>
                    <th>设备</th>
                    <th width="170">更新时间</th>
                    <th width="80">新窗口打开</th>
                    <th width="80">显示</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="category['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['cat_id']}" /></td>
                    <td>{$vo['cat_id']}</td>
                    <td>
                        <div class="goods-names">
                            {$vo['cat_name']}
                        </div>
                    </td>
                    <td>{$vo['sort']}</td>
                    <td>
                        {eq name="vo['equipment']" value="1"}
                        <span class="color-green">手机</span> 
                        {/eq}
                        {eq name="vo['equipment']" value="2"}
                        <span class="color-blue">电脑</span> 
                        {/eq}
                    </td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['is_newwindow']" value="1"}
                        <span class="color-green">是</span> 
                        {/eq}
                        {eq name="vo['is_newwindow']" value="2"}
                        <span class="color-red">否</span> 
                        {/eq}
                    </td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">是</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="0"}
                        <span class="color-red">否</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_store.category/category_details',['top'=>6,'type'=>2,'category_id'=>$vo['cat_id']])}">编辑</a>
                            <a href="javascript:;" onclick="delCategory(this)" data-categoryid="{$vo['cat_id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $category['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/brand/brand_list.js"></script>
