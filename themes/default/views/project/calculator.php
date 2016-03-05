
<?php
    $this -> page_title = '计算器';
    $this -> css = array("jisuanqi","layout");
    $this -> js = array("jquery.min","jquery.SuperSlide","jquery.prettyphoto","lrtk",'dot.min');
    
?>
<style>
	.main_box{ width:1000px; margin:0 auto;}
</style>
<div class="main_box" style="margin-top:40px; margin-bottom:20px;>
    <div >
        <div class="container_10 row-fluid" style="width:1000px;">
            <div class="span4 mt20 bg-white pt30 jisuanqi">
                <h1 class="ml30 f20">收益计算器</h1>
                <form method="POST" name="project">
                    <ul class="jsq1">
                        <li class="jsq2">金额：
                            <input type="text" name="Project[p_account]" id="Project_p_account" class="jsqinput">
                            &nbsp;元<span id="tishi0" class="f14 h30"></span></li>
                        <li class="jsq2">时间：
                            <input type="text" name="Project[p_time_limit]" id="Project_p_time_limit" class="jsqinput">
                            &nbsp;
                            <select name="Project[p_time_limittype]" id="Project_p_time_limittype">
                                <option value="0">月</option>
                                <option value="1">天</option>
                            </select><span id="tishi" class="f14 h30"></span></li>

                        <li class="jsq2">利率：
                            <input type="text" name="Project[p_apr]" id="Project_p_apr" class="jsqinput">
                            &nbsp;%<span id="tishi2" class="f14 h30"></span></li>
                          <!--<li class="jsq2">奖励：<input type="text" name="jiangli" id='jiangli' class="jsqinput"/>&nbsp;%</li>-->
                        <li class="jsq2">类型：
                            <select name="sProject[p_style]" id="Project_p_style" class="jsqinput2">
                                <?php foreach ($repay_style as $k => $v) { ?>
                                    <option value="<?php echo $k; ?>"  <?php if($k==2) echo ' selected'; ?>><?php echo $v; ?></option>
                                <?php } ?>
                            </select>
                        </li>
                        <li class="jsq3">
                            <input type="button" value="计算" onclick="jisuan();" class="btn">
                            <input type="reset" value="重置" class="btn">
                        </li>
                    </ul>
                </form>
            </div>

            <div class="span8 bg-white jsq4" id="jg">
                <div class="jsq5"> 计算结果 </div>
                <div class="jsq6"> 总回款：<span id="hk"></span>利息收益：<span id="lx"></span><!--奖励收益：<span id='jl'></span> --></div>
                <div class="jsq7 fn-clear">
                    <h1 class="bold">本息收款时间表</h1>
					<div id="html_title">
						<ul class="jsq8 bg-F99 white h40"><li>期数</li><li>金额（元）</li><li>本金（元）</li><li>利息（元）</li></ul>
						<font id="calculator_result">
							
						</font>
						<div style="clear:both;"></div>
					</div>
                    <ul class="jsq8 black">
						
                    </ul>
                </div>
            </div>
			<div style="clear:both;"></div>
        </div>
    </div>
</div>
<script type="text/lcp2p" id="type_mouth_tmp">
	<?php foreach ($repay_style as $k => $v) { ?>
		<option value="<?php echo $k; ?>"  <?php if($k==2) echo ' selected'; ?>><?php echo $v; ?></option>
	<?php } ?>
</script>
<script type="text/lcp2p" id="type_day_tmp">
	<option value="4">天标按天回款</option>
</script>
<script type="text/lcp2p" id="calculator_tmp_one">
	{{ for(var i=0;i<it.length;i++){ }}
		<ul class="jsq8">
			<li>{{=i+1}}</li>
			<li>{{=it[i].repay_account}}</li>
			<li>{{=it[i].repay_account-it[i].repay_interest}}</li>
			<li>{{=it[i].repay_interest}}</li>
		</ul>
	{{ } }}
</script>
<script language="javascript" type="text/javascript">
    function jisuan() {

        var account = parseInt($('#Project_p_account').val());
        var time_limit = parseInt($('#Project_p_time_limit').val());
        var apr = parseInt($('#Project_p_apr').val());
        var style = $('#Project_p_style').val();
        var type = $('#Project_p_time_limittype').val();
        if (isNaN(account) || account > 10000000 || account < 100) {
            pointererror('金额过高或过低',6);
            return false;
        }
        if (isNaN(time_limit) || time_limit > 30 || time_limit < 1) {
            pointererror('请输入30以内的数字',6);
            return false;
        }
        if (isNaN(apr) || apr > 24 || apr < 12) {
            pointererror('利率设置过高或过低',6);
            return false;
        }
        $('#tishi0').html('');
        $('#tishi').html('');
        $('#tishi2').html('');
        paramsdata = 'account=' + account + '&time_limit=' + time_limit + '&apr=' + apr + '&style=' + style + '&type=' + type;
        jQuery.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->controller->createUrl("project/calculator"); ?>',
            data: paramsdata,
            dataType: 'json',
            success: function (data) {
                $('#hk').html(data.all.repay_account + '元');
                $('#lx').html(data.all.repay_interest + '元');
			
			
				var obj_list = [];
				var test_str = data.data["0"];
				if('undefined' == typeof(test_str)){
					var i = 1;
				}else{
					var i = 0;
					data.total_count = data.total_count - 1;
				}
				
				for(i;i<=data.total_count;i++){
					if($("#Project_p_style").val() == '5'){
						obj_list.push(data.data[i*3]);
					}else{
						obj_list.push(data.data[i]);
					}
					
				}
				console.log(obj_list);
				$("#calculator_result").html(doT.template($("#calculator_tmp_one").html())(obj_list));
            }
        });

    }
	
	$("#Project_p_time_limittype").change(function(){
		if($(this).val() == 0){
			$("#Project_p_style").html($("#type_mouth_tmp").html());
		}else if($(this).val() == 1){
			$("#Project_p_style").html($("#type_day_tmp").html());
		}
	});
</script> 

