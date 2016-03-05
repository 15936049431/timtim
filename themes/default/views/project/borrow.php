<?php
    $this -> css = array('uc','rl');
    $this -> js = array('dot.min');
    $this -> page_title = '';
?>
<link rel="stylesheet" href="<?php echo STATIC_URL.'uploadify/uploadify.css' ?>" />
<script src="<?php echo STATIC_URL.'uploadify/jquery.uploadify.min.js' ?>"></script>
<?php if(!empty($message)){ ?>
<script type="text/javascript">
layer_alert_p('<?php echo $message[0]; ?>','<?php echo $message[1]; ?>','<?php echo $message[2]; ?>','<?php echo $message[3]; ?>');
</script>
<?php } ?>
<style>#project_type li{cursor:pointer;}</style>
<div class="main-box">

    <!--    主体头部-->
    <div class="main-head">
        <div class="left">
            <ul id="project_type">
            	<?php foreach($project_type_arr as $k=>$v){ ?>
            		<li attr="<?php echo $k; ?>" class="<?php if(Yii::app()->request->getParam("id")==$k || (Yii::app()->request->getParam("id")=="") && $k==1){echo "on";} ?>" >
            			<a href="<?php echo Yii::app()->controller->createUrl("project/borrow",array("id"=>$k)); ?>" >发布<?php echo $v; ?></a>
            		</li>
            	<?php } ?>
            </ul>
        </div>
        <div class="right">
            当前位置：首页 > <font class="font-org">我要借款</font>
        </div>
    </div>

    <div class="main-body">
        <?php $form = $this->beginWidget('CActiveForm',array(
            'htmlOptions'=>array(
                'enctype'=>'multipart/form-data',
            ),
        )); ?>
        <div class="top">
            <div class="div-ico">1</div>
            <div class="div-title">
                <font class="bot-b-org">基本信息</font>
            </div>
        </div>

                <div class="switch-list">
                    <ul>
                    <?php if(Yii::app()->request->getParam("id")!=4){ ?>
                        <li><div><img src="<?php echo IMG_URL; ?>switch_off.jpg" alt="这是开关" id="show_day" attr="off" /></div>是否天标</li>
                    <?php } ?>
                        <li><div><img src="<?php echo IMG_URL; ?>switch_off.jpg" alt="这是开关" id="show_award" attr="off" /></div>是否奖励</li>
                        <li><div><img src="<?php echo IMG_URL; ?>switch_off.jpg" alt="这是开关" id="show_dxb" attr="off" /></div>是否定向标</li>
                    </ul>
                </div>

        <div class="main-con" style="padding-top:20px;">
            <ul>
                <li>
                    <div class="one-lable">借款金额：</div>
                    <div class="one-input"><?php echo $form->textField($project_model, 'p_account',array('class'=>'sinput','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?></div>
                    <?php if($project_model -> getError('p_account')){ ?>
                    	<div class="one-remark" style="color:red">* <?php echo $project_model -> getError('p_account'); ?></div>
                    <?php }else{ ?>
                    	<div class="one-remark">* 说明需要借款的金额</div>
                    <?php } ?>
                </li>
                <?php if(Yii::app()->request->getParam("id")==4){ ?>
                <li>
                    <div class="one-lable">借款期限：</div>
                    <div class="one-input">额满即还<?php echo $form->textField($project_model, 'p_time_limit', array('class'=>'sinput','value'=>'1','style'=>'display:none')); ?></div>
                    <div class="one-remark">* 选择该借款项目的借款期限</div>
                </li>
                <li>
                    <div class="one-lable">还款方式：</div>
                    <div class="one-input">额满即还<?php echo $form->textField($project_model, 'p_style', array('class'=>'sinput','value'=>'3','style'=>'display:none')); ?></div>
                    <div class="one-remark">* 选择该借款项目的还款方式</div>
                </li>
                <?php }else{ ?>
                <li>
                    <div class="one-lable">借款期限：</div>
                    <div class="one-input"><?php echo $form->dropDownList($project_model, 'p_time_limit', $project_month_type_arr , array('class'=>'select')); ?></div>
                    <div class="one-remark">* 选择该借款项目的借款期限</div>
                </li>
                <li>
                    <div class="one-lable">还款方式：</div>
                    <div class="one-input"><?php echo $form->dropDownList($project_model, 'p_style', $repayment_type_arr,array('class'=>'select')); ?></div>
                    <div class="one-remark">* 选择该借款项目的还款方式</div>
                </li>
                <?php } ?>
                <li>
                    <div class="one-lable">年化利率：</div>
                    <div class="one-input"><?php echo $form->textField($project_model, 'p_apr',array('class'=>'sinput','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?></div>
                    <?php if($project_model -> getError('p_apr')){ ?>
                    	<div class="one-remark" style="color:red">* <?php echo $project_model -> getError('p_apr'); ?></div>
                    <?php }else{ ?>
                    	<div class="one-remark">* 填写您提供给投资者的年利率。年利率不能超过24% 范围：12%至24%。</div>
                    <?php } ?>
                </li>
                <li>
                    <div class="one-lable">最低投标金额：</div>
                    <div class="one-input"><?php echo $form->dropDownList($project_model, 'p_lowaccount', $project_minorder_type_arr,array('class'=>'select')); ?></div>
                   	<div class="one-remark">* 允许投资者对对一个借款项目的投标总的最低投标金额的限制</div>
                </li>
                <li>
                    <div class="one-lable">最高投标金额：</div>
                    <div class="one-input"><?php echo $form->dropDownList($project_model, 'p_mostaccount', $project_maxorder_type_arr,array('class'=>'select')); ?></div>
                   	<div class="one-remark">* 允许投资者对对一个借款项目的投标总的投总额的限制</div>
                </li>
                <li>
                    <div class="one-lable">项目有效时间：</div>
                    <div class="one-input"><?php echo $form->dropDownList($project_model, 'p_valid_time', $project_validtime_arr,array('class'=>'select')); ?></div>
                    <div class="one-remark">* 以天为单位设置此次借款融资的天数，融资进度达到100%后直接进行网站的复审</div>
                </li>
                <?php if(Yii::app()->request->getParam("id")==4){ ?>
                	<?php echo $form->textField($project_model, 'p_autorate',array('class'=>'sinput',"value"=>0,"style"=>"display:none;")); ?>
                <?php }else{ ?>
                <li>
                    <div class="one-lable">自动投标比例：</div>
                    <div class="one-input"><?php echo $form->textField($project_model, 'p_autorate',array('class'=>'sinput','onkeyup'=>"value = value.replace(/[^0-9]/g, '')","value"=>0)); ?></div>
                    <?php if($project_model -> getError('p_autorate')){ ?>
                    	<div class="one-remark" style="color:red">* <?php echo $project_model -> getError('p_autorate'); ?></div>
                    <?php }else{ ?>
                    	<div class="one-remark">* 以百分比为单位（%）</div>
                    <?php } ?>
                </li>
                <?php } ?>
                <li style="display:none;" id="dxb">
                    <div class="one-lable">定向标密码：</div>
                    <div class="one-input"><?php echo $form->textField($project_model, 'p_dxb',array('class'=>'sinput')); ?></div>
                    <div class="one-remark">* 定向标表示该标属于密码标,密码可自行设置。</div>
                </li>
            </ul>
        </div>
        <!-- 借款奖励开始 -->
	    <div class="top">
	        <div class="div-ico">2</div>
	            <div class="div-title">
	                <font class="bot-b-org">奖励信息</font>
	            </div>
	        </div>
	        <div class="main-con" style="padding-top:20px;">
	            <ul id="award_on" style="display:none;">
	                <li>
	                    <div class="one-lable">按照金额奖励：</div>
	                    <div class="one-input"><div><img src="<?php echo IMG_URL; ?>switch_off.jpg" alt="这是开关" id="show_award_type" attr="off" />(固定金额或比例)</div>
	                    	<input type="hidden" name="Project[p_award_type]" id="Project_p_award_type" value="0" />
	                    </div>
 	                    <div class="one-remark">* 选择您的奖励方式，请先选择开启奖励</div>
	                </li>
	                <li>
	                    <div class="one-lable"><font id="award_name">奖励百分比</font>：</div>
	                    <div class="one-input"><?php echo $form->textField($project_model, 'p_award',array('class'=>'sinput','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?></div>
	                    <div class="one-remark">* 如果要设置奖励，请确保您的账户有足够的账户余额。</div>
	                </li>
	         </ul>
	         <ul id="award_off">
	                <li>
	                    <div class="one-lable">按照金额奖励：</div>
	                    <div class="one-input">无</div>
 	                    <div class="one-remark">* 选择您的奖励方式，请先选择开启奖励</div>
	                </li>
	         </ul>
	    </div>
	    <!-- 详细信息描述 -->
	    <div class="top">
	        <div class="div-ico">3</div>
	        <div class="div-title">
	             <font class="bot-b-org">详细信息描述</font>
	        </div>
	    </div>
	    <div class="main-con" style="padding-top:20px;">
	    	<ul id="award_off">
	                <li>
	                    <div class="one-lable">标题：</div>
	                    <div class="one-input"><?php echo $form->textField($project_model, 'p_name',array('class'=>'sinput','style'=>'width:500px;')); ?></div>
	                </li>
	                <li>
	                    <div class="one-lable">项目图片：</div>
                            <style type="text/css">
                                #file_upload_1-queue{
                                    display: block;
                                    margin-left: 20%;
                                }
                            </style>
                            <div id="file_upload_1"></div>
<!--                            <div class="one-input"><button id="add_pro_pic_btn" type="button">添加</button></div>-->
	                </li>
                        <li>
                            <div class="one-lable"></div>
                            <div id="project_pic_show"></div>
                        </li>
	                <li style="height:420px;width:1000px;">
	                    <div class="one-lable" style="height:400px;line-height:400px;float:left;">内容：</div>
	                    <div class="one-input" style="width:750px;float:left;">
	                    		<?php echo $form->textArea($project_model,'p_content',array('class'=>'sinput','rows'=>'5')); ?>
                                        <?php $this->widget('application.widget.kindeditor.KindEditor', array('target' => array(
                                                '#Project_p_content' => array('uploadJson' => $this->createUrl('upload'),'width'=>'100%'))));
                                        ?>
	                    </div>
	                </li>
	                <li>
	                    <div class="one-lable">验证码：</div>
	                    <div class="one-input"><?php echo $form->textField($project_model,'authcode',array('class'=>'input','placeholder'=>'验证码','style'=>'width:100px')); ?>
	                    	 <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'cursor:pointer;'))); ?>
	                    </div>
	                </li>
	                <li>
	                    <div class="one-lable"></div>
	                    <input type="hidden" name="is_dxb" id="is_dxb" value="0" />
	                    <input type="hidden" name="type" id="type" value="<?php echo (Yii::app()->request->getParam("id")=="")?1:(Yii::app()->request->getParam("id")); ?>" />
	                    <input type="hidden" name="Project[p_time_limittype]" id="Project_p_time_limittype" value="0" />
	                    <div class="one-input"><input type="submit" value="提交" class="btn-bbc1 submit" /></div>
	                </li>
	         </ul>
                <script type="text/lcp2p" id="add_pic_file_tmp">
                    <input name="Projectpic[pro_pic][pic{{=it}}]" type="file">
                </script>
	    </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/lcp2p" id="by_day_tmp">
	<?php foreach (LYCommon::GetItemList('project_day_type') as $k => $v) { ?>
         <option value="<?php echo $v->i_value ?>"><?php echo $v->i_name; ?></option>
	<?php } ?>
</script>
<script type="text/lcp2p" id="by_month_tmp">
    <?php foreach (LYCommon::GetItemList('project_month_type') as $k => $v) { ?>
         <option value="<?php echo $v->i_value ?>"><?php echo $v->i_name; ?></option>
    <?php } ?>
</script>
    <script type="text/lcp2p" id="style_by_month">
    <?php foreach ($repayment_type_arr as $k => $v) { ?>
         <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
    <?php } ?>
</script>
<script type="text/lcp2p" id="style_by_day">
    <?php foreach ($repayment_type_day as $k => $v) { ?>
         <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
    <?php } ?>
</script>
<script type="text/lcp2p" id="project_pic_show_tmp">
    <font onclick="this.remove();">
        <img src="<?php echo SITE_UPLOAD.'projectpic/s_'; ?>{{=it.pic_name}}" />
        <input type="hidden" name="Project[propic][pic{{=window.pro_pic_num}}]" value="{{=it.pic_name}}" />
    </font>
</script>
<script>
$(".switch-list ul li div img").click(function(){
	var type=$(this).attr("id");
	var imgUrl="<?php echo IMG_URL;?>";
	var img="switch_";
	var next=($(this).attr("attr")=="off")?"on":"off";
	$(this).attr("attr",next);
	$(this).attr("src",imgUrl+img+next+".jpg");
	if(type=="show_day"){
		if(next=="on"){
			$("#Project_p_time_limit").html($("#by_day_tmp").html());
			$("#Project_p_time_limittype").val(1);
			$("#Project_p_style").html($("#style_by_day").html());
		}else{
			$("#Project_p_time_limit").html($("#by_month_tmp").html());
			$("#Project_p_time_limittype").val(0);
			$("#Project_p_style").html($("#style_by_month").html());
		}
	}else if(type=="show_award"){
		if(next=="on"){
			$("#award_off").hide();
			$("#award_on").show();
			$("#Project_p_award_type").val(1);
		}else{
			$("#award_off").show();
			$("#award_on").hide();
			$("#Project_p_award_type").val(0);
		}
	}else if(type=="show_dxb"){
		if(next=="on"){
			$("#dxb").show();
			$("#is_dxb").val(1);
		}else{
			$("#dxb").hide();
			$("#is_dxb").val(0);
		}
	}
});
$("#show_award_type").click(function(){
	var imgUrl="<?php echo IMG_URL;?>";
	var img="switch_";
	var next=($(this).attr("attr")=="off")?"on":"off";
	$(this).attr("attr",next);
	$(this).attr("src",imgUrl+img+next+".jpg");
	if(next=="on"){
		$("#Project_p_award_type").val(2);
		$("#award_name").html("奖励固定金额");
	}else{
		$("#Project_p_award_type").val(1);
		$("#award_name").html("奖励百分比");
	}
});
window.pro_pic_num = 1;
$("#add_pro_pic_btn").click(function(){
    $(this).before(doT.template($("#add_pic_file_tmp").html())(window.pro_pic_num++));
});

$(function() {
	$("#file_upload_1").uploadify({
		height        : 30,
		swf           : '<?php echo STATIC_URL.'uploadify/uploadify.swf' ?>',
		uploader      : '<?php echo Yii::app()->controller->createUrl('project/upload_project_pic') ?>',
		width         : 120,
                'onUploadSuccess' : function(file, data, response) {
                    var obj = eval("("+data+")");
                    $("#project_pic_show").append(doT.template($("#project_pic_show_tmp").html())(obj));
                    window.pro_pic_num ++;
                    //alert(data);
                }
	});
});
</script>