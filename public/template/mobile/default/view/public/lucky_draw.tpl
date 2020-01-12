
<style type="text/css">

    #lottery table tr td{
        width:70px;height:70px;text-align:center;vertical-align:middle;font-size:24px;
        color:#333; z-index:-999;
        overflow: hidden;
        border: 1px solid #ccc;
    }
    #lottery table{
      width:84%;
      margin:0px auto;
    }
    #lottery table tr td img{
        width:70px;
    }
    #lottery table td a{
        width:135px;height:135px;line-height:100px;display:block;text-decoration:none;
    }
    #lottery table td.active{
        background-color: #ff6600;
    }
    .lottery-a{
        width:284px;height:284px;line-height:150px;display:block;text-decoration:none;
    }
    .active{
        background-color:#ea0000;
    }
    #lottery{
        width:340px;height:334px;margin:20px auto 0;background:url('__STATIC__/plugin/jquery-cj/images/bg.jpg') no-repeat;
        background-size: 100% auto;
        padding-top: 24px;
    }
    .zjxinxi{
      color:red;
      font-size:17px;
      font-weight:800;
    }
</style>
<div id="lottery">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="lottery-unit lottery-unit-0"><img src="__STATIC__/plugin/jquery-cj/images/1.png"></td>
            <td class="lottery-unit lottery-unit-1"><img src="__STATIC__/plugin/jquery-cj/images/2.png"></td>
            <td class="lottery-unit lottery-unit-2"><img src="__STATIC__/plugin/jquery-cj/images/4.png"></td>
            <td class="lottery-unit lottery-unit-3"><img src="__STATIC__/plugin/jquery-cj/images/3.png"></td>
        </tr>
        <tr>
            <td class="lottery-unit lottery-unit-11"><img src="__STATIC__/plugin/jquery-cj/images/7.png"></td>
            <td colspan="2" rowspan="2"><a href="#" class="lottery-a"></a></td>
            <td class="lottery-unit lottery-unit-4"><img src="__STATIC__/plugin/jquery-cj/images/5.png"></td>
        </tr>
        <tr>
            <td class="lottery-unit lottery-unit-10"><img src="__STATIC__/plugin/jquery-cj/images/1.png"></td>
            <td class="lottery-unit lottery-unit-5"><img src="__STATIC__/plugin/jquery-cj/images/6.png"></td>
        </tr>
        <tr>
            <td class="lottery-unit lottery-unit-9"><img src="__STATIC__/plugin/jquery-cj/images/3.png"></td>
            <td class="lottery-unit lottery-unit-8"><img src="__STATIC__/plugin/jquery-cj/images/6.png"></td>
            <td class="lottery-unit lottery-unit-7"><img src="__STATIC__/plugin/jquery-cj/images/8.png"></td>
            <td class="lottery-unit lottery-unit-6"><img src="__STATIC__/plugin/jquery-cj/images/7.png"></td>
        </tr>
    </table>
</div>
<div>中奖信息&nbsp;<span class="zjxinxi"></span></div>
<script type="text/javascript">

    var lottery = {
        index: -1, //当前转动到哪个位置，起点位置
        count: 0, //总共有多少个位置
        timer: 0, //setTimeout的ID，用clearTimeout清除
        speed: 20, //初始转动速度
        times: 0, //转动次数
        cycle: 50, //转动基本次数：即至少需要转动多少次再进入抽奖环节
        prize: -1, //中奖位置
        init: function (id) {
            if ($("#" + id).find(".lottery-unit").length > 0) {
                $lottery = $("#" + id);
                $units = $lottery.find(".lottery-unit");
                this.obj = $lottery;
                this.count = $units.length;
                $lottery.find(".lottery-unit-" + this.index).addClass("active");
            };
        },
        roll: function () {
            var index = this.index;
            var count = this.count;
            var lottery = this.obj;
            $(lottery).find(".lottery-unit-" + index).removeClass("active");
            index += 1;
            if (index > count - 1) {
                index = 0;
            }
            ;
            $(lottery).find(".lottery-unit-" + index).addClass("active");
            this.index = index;
            return false;
        },
        stop: function (index) {
            this.prize = index;
            return false;
        }
    };
    function roll() {
        lottery.times += 1;
        lottery.roll();
        if (lottery.times > lottery.cycle + 10 && lottery.prize == lottery.index) {
            clearTimeout(lottery.timer);
            lottery.prize = -1;
            lottery.times = 0;
            click = false;
            console.log(lottery.index);
            setTimeout(function(){
            $(".zjxinxi").text('您抽中了'+lottery.index+'!');
            },1000);
        } else {
            if (lottery.times < lottery.cycle) {
                lottery.speed -= 10;
            } else if (lottery.times == lottery.cycle) {
                var index = Math.random() * (lottery.count) | 0;
                lottery.prize = index;
            } else {
                if (lottery.times > lottery.cycle + 10 && ((lottery.prize == 0 && lottery.index == 7) || lottery.prize == lottery.index + 1)) {
                    lottery.speed += 110;
                } else {
                    lottery.speed += 20;
                }
            }
            if (lottery.speed < 40) {
                lottery.speed = 40;
            }
            ;
            //console.log(lottery.times+'^^^^^^'+lottery.speed+'^^^^^^^'+lottery.prize);
            lottery.timer = setTimeout(roll, lottery.speed);
        }
        return false;
    }
    var click = false;
    window.onload = function () {
        lottery.init('lottery');
        $("#lottery a").click(function () {
            if (click) {
                return false;
            } else {
                lottery.speed = 100;
                roll();
                click = true;
                return false;
            }
        });
    };

</script>
