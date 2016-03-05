<?php
/*
 * @author: 三氧化二砷 waitfox@qq.com
 * @Created:2015-8-28 10:58:02
 * @version:0.01
 * @desc:抽奖页
 * 我只为你回眸一笑，即使不够倾国倾城，我只为你付出此生，换来生再次相守
 */
?>
<?php
$this->url = Yii::app()->controller->createUrl("menu/ilove");
?>
<section class="box">
</section>
<style type="text/css">
    #lottery{width:574px;height:584px;margin:20px auto 0;background:url(<?php echo WAP_IMG_URL; ?>draw/bg.jpg) no-repeat;padding:50px 55px;}
    #lottery table td{width:142px;height:142px;text-align:center;vertical-align:middle;font-size:24px;color:#333;font-index:-999}
    #lottery table td a{width:284px;height:284px;line-height:150px;display:block;text-decoration:none;}
    #lottery table td.active{background-color:#ea0000;}
</style>
<section class="box">
    <div id="lottery">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td class="lottery-unit lottery-unit-0"><img src="<?php echo WAP_IMG_URL; ?>draw/1.png"></td>
                <td class="lottery-unit lottery-unit-1"><img src="<?php echo WAP_IMG_URL; ?>draw/2.png"></td>
                <td class="lottery-unit lottery-unit-2"><img src="<?php echo WAP_IMG_URL; ?>draw/4.png"></td>
                <td class="lottery-unit lottery-unit-3"><img src="<?php echo WAP_IMG_URL; ?>draw/3.png"></td>
            </tr>
            <tr>
                <td class="lottery-unit lottery-unit-11"><img src="<?php echo WAP_IMG_URL; ?>draw/7.png"></td>
                <td colspan="2" rowspan="2"><a href="#"></a></td>
                <td class="lottery-unit lottery-unit-4"><img src="<?php echo WAP_IMG_URL; ?>draw/5.png"></td>
            </tr>
            <tr>
                <td class="lottery-unit lottery-unit-10"><img src="<?php echo WAP_IMG_URL; ?>draw/1.png"></td>
                <td class="lottery-unit lottery-unit-5"><img src="<?php echo WAP_IMG_URL; ?>draw/6.png"></td>
            </tr>
            <tr>
                <td class="lottery-unit lottery-unit-9"><img src="<?php echo WAP_IMG_URL; ?>draw/3.png"></td>
                <td class="lottery-unit lottery-unit-8"><img src="<?php echo WAP_IMG_URL; ?>draw/6.png"></td>
                <td class="lottery-unit lottery-unit-7"><img src="<?php echo WAP_IMG_URL; ?>draw/8.png"></td>
                <td class="lottery-unit lottery-unit-6"><img src="<?php echo WAP_IMG_URL; ?>draw/7.png"></td>
            </tr>
        </table>
    </div>
</section>
<script type="text/javascript">
    var lottery = {
        index: -1, //当前转动到哪个位置，起点位置
        count: 0, //总共有多少个位置
        timer: 0, //setTimeout的ID，用clearTimeout清除
        speed: 20, //初始转动速度
        times: 0, //转动次数
        cycle: 50, //转动基本次数：即至少需要转动多少次再进入抽奖环节
        prize: -1, //中奖位置
        pos: -1,
        init: function (id) {
            if ($("#" + id).find(".lottery-unit").length > 0) {
                $lottery = $("#" + id);
                $units = $lottery.find(".lottery-unit");
                this.obj = $lottery;
                this.count = $units.length;
                $lottery.find(".lottery-unit-" + this.index).addClass("active");
            }
            ;
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
        },
        getpos: function () {
            var pos;
            $.get("/wap/more/dodraw.html", function (data) {
                pos = data;
            });
            return pos;
        }

    };
    //下面是 奖品编号:位置 对应关系的一个数组
    var awardArr={"1":"0","2":"1"};

    function roll(pos) {
        //console.log("位置0：" + pos);
        lottery.times += 1;
        lottery.roll();
        if (lottery.times > lottery.cycle + 10 && lottery.prize == lottery.index) {
            clearTimeout(lottery.timer);
            lottery.prize = -1;
            lottery.times = 0;
            click = false;
        } else {
            if (lottery.times < lottery.cycle) {
                lottery.speed -= 10;
            } else if (lottery.times == lottery.cycle) {
                var index = Math.random() * (lottery.count) | 0;
                index=pos;
                //console.log("奖品编号：" + pos+"，对应位置:"+awardArr[index]);
                lottery.prize = awardArr[index];
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
            lottery.timer = setTimeout(_roll(pos), lottery.speed);
        }
        return false;
    }
    
    function _roll(pos){
        return function(){
            roll(pos);
        }
    }

    var click = false;

    window.onload = function () {
        lottery.init('lottery');
        $("#lottery a").click(function () {
            $.get("/wap/more/dodraw.html", function (data) {
                pos = data;
                if (pos > 0) {
                    if (click) {
                        return false;
                    } else {
                        lottery.speed = 100;
                        roll(pos);
                        click = true;
                        return false;
                    }
                } else {
                    alert("未登录或权限不够");
                }
            });


        });
    };
</script>
