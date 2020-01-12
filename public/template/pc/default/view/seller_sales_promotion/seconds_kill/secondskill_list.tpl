
{include file="public/js_css" /}
<link rel="stylesheet" type="text/css" href="__PC__/css/seller/index.css" />
<div class="seller-allas">
    <div class="member-yue"><span>秒杀管理</span></div>

    <div class="churuzhang">

        <form class="" action="" method="post" id="secondskill_from" class="floatleft">
            <div class="zhanglx zhanglxpad">
                <label>状态</label>
                <div class="layui-input-inline">
                    <select name="is_show" class="selectpad">
                        <option value="">请选择</option>
                        <option value="1" {eq name=":input('is_show')" value="1"} selected {/eq}>上架</option>
                        <option value="2" {eq name=":input('is_show')" value="2"} selected {/eq}>下架</option>
                    </select>
                </div>
                <input type="text" value="{:input('search')}" name="search" class="member_text" placeholder="秒杀名称"/>
                <input type="submit" value="搜索" class="update_btn2"/>
                <input type="hidden" value="4" name="top"/>
                <input type="hidden" value="1" name="type"/>
            </div>
        </form>
        <div class="divtitle_btn">
            <div class="floatleft">
                <a href="javascript:;" class="mall_btn goodsbtn_red" onclick="delSecondskill(this)">
                    <i class="Hui-iconfont">&#xe609;</i>
                    删除秒杀
                </a>
            </div>
            <div class="floatright">
                <a href="{:url('seller_sales_promotion.seconds_kill/secondskill_add',['top'=>4,'type'=>1])}" class="mall_btn goodsbtn_act">
                    <i class="Hui-iconfont">&#xe600;</i>
                    添加秒杀
                </a>
            </div>
        </div>
        <table border="1" class="churuzhang-tb floatfalse">
            <thead class="churuzhang-te">
                <tr>
                    <th width="30"><input type="checkbox" name="all" id="checkedAll"/></th>
                    <th>编号</th>
                    <th>封面</th>
                    <th>商品名称</th>
                    <th>秒杀价</th>
                    <th>秒杀数量</th>
                    <th width="170">更新时间</th>
                    <th width="80">状态</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody class="churuzhang-ty">
                {volist name="secondsKill['data']" id="vo"}
                <tr class="tbcenter">
                    <td><input type="checkbox" name="id[]" value="{$vo['id']}" /></td>
                    <td>{$vo['id']}</td>
                    <td>
                        <div class="goods-img">
                            <img src="__STATIC__/{$vo['thecover']}" width="50" height="50">
                        </div>
                    </td>
                    <td><div class="goods-names">{$vo['goods_name']}</div></td>
                    <td>{$vo['sk_price']}</td>
                    <td>{$vo['sk_num']}</td>
                    <td>{$vo['create_time']}</td>
                    <td>
                        {eq name="vo['is_show']" value="1"}
                        <span class="color-green">已上架</span> 
                        {/eq}
                        {eq name="vo['is_show']" value="2"}
                        <span class="color-red">已下架</span> 
                        {/eq}
                    </td>
                    <td>
                        <div class="order-btn">
                            <a href="{:url('seller_sales_promotion.seconds_kill/secondskill_details',['top'=>4,'type'=>1,'secondskill_id'=>$vo['id']])}">编辑</a>
                            <a href="javascript:;" onclick="delSecondskill(this)" data-secondskillid="{$vo['id']}">删除</a>
                        </div>
                    </td>
                </tr>
                {/volist}
                {if $secondsKill['total'] < 1}
                    <tr class="tbcenter"><td colspan="9">暂时没有数据</td></tr>
                {/if}
            </tbody>
        </table>
        <div class="page-div">{$page}</div>
    </div>
</div>

<script type="text/javascript" src="__PC__/js/seller_sales_promotion/seconds_kill/secondskill_list.js"></script>
