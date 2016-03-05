<?php
    $this->page_title = '发布项目';
    $this->page_desc = '发布项目';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min','js/dot.min','js/layer/layer','js/laydate/laydate');
?>
<link rel="stylesheet" href="<?php echo STATIC_URL.'uploadify/uploadify.css' ?>" />
<script src="<?php echo STATIC_URL.'uploadify/jquery.uploadify.min.js' ?>"></script>
<style>
.controls{padding-top:5px;};
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 项目信息</h3>
                        <div class="box-tool">
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                        <ul  class="nav nav-tabs">
                            <li class="active"><a href="#project_info" data-toggle="tab">项目详情</a></li>
                            <li><a href="#project_pic" data-toggle="tab">项目图片</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        
                        <div class="tab-pane active" id="project_info">
                            <div class="box-content form-horizontal">
                        <?php $form = $this->beginWidget('CActiveForm',array(
                            'htmlOptions'=>array(
                                'enctype'=>'multipart/form-data',
                                'class'=>'form-horizontal',
                            ),
                        )); ?>
        <!--                输出错误信息  开始-->
                        <?php if($form->errorSummary($model)){ ?>
                        <div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <p><?php echo $form->errorSummary($model); ?></p>
                        </div>
                        <?php } ?>
        <!--                输出错误信息  结束-->

                        <div class="control-group">
                	<label class='control-label'>用户名</label>
                <div class="controls">
                    <?php echo $user_info->user_name; ?>
                    <?php echo $form->hiddenField($model,'p_user_id',array('class'=>'input-xlarge','value'=>$user_info->user_id)); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_pic',array('class'=>'control-label')); ?>
                <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                           <div class="uneditable-input">
                              <i class="icon-file fileupload-exists"></i> 
                              <span class="fileupload-preview"></span>
                           </div>
                           <span class="btn btn-file">
                              <span class="fileupload-new">选择文件</span>
                              <span class="fileupload-exists">更换</span>
                              <?php echo $form->fileField($model,'p_pic',array('class'=>'default')); ?>
                           </span>
                           <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">删除</a>
                        </div>
                    </div>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_name',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_name'))); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_account',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_account',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_account'))); ?>
                    <span class="help-inline">元</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_apr',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_apr',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_apr'),'value'=>'15','readonly'=>(Yii::app()->user->issuper)?'':'readonly')); ?>
                    <span class="help-inline">%</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_dxb',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_dxb',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_dxb'))); ?>
                    <span class="help-inline">（不需定向标请不要填写！）</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_time_limit',array('class'=>'control-label')); ?>
                <div class="controls" id="time_limit">
                	<?php echo $form->dropDownList($model,'p_time_limit',$project_month_type_arr); ?>
                	<?php echo $form->dropDownList($model,'p_time_limittype',$model->itemAlias('p_time_limittype'),array('style'=>'width:60px;')); ?>
                    <span class="help-inline">项目的时间</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_valid_time',array('class'=>'control-label')); ?>
                <div class="controls">
                	<?php echo $form->dropDownList($model,'p_valid_time',$project_validtime_arr); ?>
                    <span class="help-inline">天（借款标的有效时间！）</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_type',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'p_type',LYCommon::findcat('project_type','')); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_style',array('class'=>'control-label')); ?>
                <div class="controls" id="repay_type">
                    <?php echo $form->dropDownList($model,'p_style', $repayment_type_arr); ?>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_award_type',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'p_award_type',array("0"=>"无奖励","1"=>"按百分比奖励","2"=>"固定金额奖励")); ?>
                    <span class="help-inline">（选择借款标奖励的类型！）</span>
                </div>
            </div>
            <div class="control-group" style="display:none;" id="show_award">
                <?php echo $form->labelEx($model,'p_award',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_award',array('class'=>'input-xlarge','value'=>'0','placeholder'=>'请填写'.$model->getAttributeLabel('p_award'))); ?>
                    <span class="help-inline">（根据奖励类型填写相对应的百分比或者固定金额！）</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_lowaccount',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_lowaccount',array('value'=>50,'class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_lowaccount'))); ?>
                    <span class="help-inline">元（0为不限制最小投标金额）</span>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_mostaccount',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_mostaccount',array('value'=>0,'class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_mostaccount'))); ?>
                    <span class="help-inline">元（0为不限制最大投标金额）</span>
                </div>
            </div>
            <div class="control-group" id="auto_project">
                <?php echo $form->labelEx($model,'p_autorate',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'p_autorate',array('value'=>0,'class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_autorate'),'value'=>'30')); ?>
                    <span class="help-inline">%（0-100自动投标占本借款的比例）</span>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'p_content',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model,'p_content',array('class'=>'span4','rows'=>'5')); ?>
                 </div>
                 <?php $this->widget('application.widget.kindeditor.KindEditor',array('target'=>array(
                        '#Project_p_content'=>array('uploadJson'=> $this->createUrl('upload')))));?>
            </div>
                        <div class="form-actions">
                            <input type="submit" class="btn btn-primary" value="提交">
                            <button type="reset" class="btn">重置</button>
                        </div>
                        <?php $this->endWidget(); ?>
                            </div>
                                
                        </div>
                        
                        
                        <div class="tab-pane" id="project_pic">
                            <div class="box-content form-horizontal">
                                <!-- BEGIN Main Content -->
				                <div class="row-fluid">
				                    <div class="span12">
				                        <div class="box">
				                            
				                            <div class="box-content">
                                                                <ul class="gallery" id="pic_con">
				                                    <?php foreach($project_pic_list as $k => $v){ ?>
                                                                    <li onclick="open_pic('<?php echo SITE_UPLOAD.'projectpic/'.$v->p_src; ?>');">
				                                            <a href="javascript:;" rel="prettyPhoto">
				                                                <div>
				                                                    <img src="<?php echo SITE_UPLOAD.'projectpic/s_'.$v->p_src; ?>" alt="" />
				                                                    <i></i>
				                                                </div>
				                                            </a>
				                                        </li>
				                                    <?php } ?>
				                                    
				                                </ul>
                                                                <li id="add_pic" style="cursor:pointer;">
				                                        <font rel="prettyPhoto" title="添加图片">
				                                            <div>
				                                                <img src="<?php echo BACK_IMG_URL; ?>add.jpg" alt="" />
				                                                <i></i>
				                                            </div>
				                                        </font>
				                                    </li>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <!-- END Main Content -->
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
         </div>

<script type="text/lcp2p" id="pic_tmp">
<li onclick="open_pic('<?php echo SITE_UPLOAD.'projectpic/'; ?>{{=it.pic_name}}')">
    <a href="javascript:;" rel="prettyPhoto">
        <div>
            <img src="<?php echo SITE_UPLOAD.'projectpic/'; ?>s_{{=it.pic_name}}" alt="" />
            <i></i>
        </div>
    </a>
</li>
</script>

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
<script type="text/lcp2p" id="time_limit_month"></script><script type="text/lcp2p" id="repay_type_month"></script>
<script type="text/lcp2p" id="time_limit_mb">
额满即还<input type="hidden" name="Project[p_time_limit]" value="1" style="display;none" /><input type="hidden" name="Project[p_time_limittype]" value="0" style="display;none" /><span class="help-inline">秒标额满即还</span>
</script>
<script type="text/lcp2p" id="repay_type_mb">
额满即还<input type="hidden" name="Project[p_style]" value="3" style="display;none" /><span class="help-inline">秒标额满即还</span>
</script>

<script type="text/javascript">    
    
    
    function open_pic(src){
        layer.open({
            title: '图片预览',
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: 'auto',
            maxWidth :'700',
            offset  :'auto',
            shadeClose:true,
            content: '<div  style=" padding:10px;"><img id="pic" src="'+src+'" /></div>'
        });
    }
    $(function() {
	$("#add_pic").uploadify({
		height        : 30,
		swf           : '<?php echo STATIC_URL.'uploadify/uploadify.swf' ?>',
		uploader      : '<?php echo Yii::app()->controller->createUrl('/extend/BackUploadPic') ?>',
		width         : 120,
                formData     : {
                    'timestamp' : '<?php echo $timestamp=time();?>',
                    'token'     : '<?php echo md5('treasure' . $timestamp);?>',
                    'project_id'  : '<?php echo Yii::app()->session['new_project_id']; ?>',
                    'pub_user_id'  : '<?php echo Yii::app()->request->getParam('uid'); ?>'
                },
                'onUploadSuccess' : function(file, data, response) {
                    var obj = eval("("+data+")");
                    $("#pic_con").append(doT.template($("#pic_tmp").html())(obj));
                }
	});

	$("#Project_p_type").change(function(){
		var _type = parseInt($(this).val());
		if(_type==4){
			$("#time_limit_month").html($("#time_limit").html());
			$("#time_limit").html($("#time_limit_mb").html());
			$("#repay_type_month").html($("#repay_type").html());
			$("#repay_type").html($("#repay_type_mb").html());
			$("#auto_project").hide();
		}else{
			if($("#time_limit_month").html()!=""){
				$("#time_limit").html($("#time_limit_month").html());
				$("#repay_type").html($("#repay_type_month").html());
				$("#auto_project").show();
			}
		}
	});

	$("#Project_p_award_type").change(function(){
		var _type = parseInt($(this).val());
		if(_type==0){
			$("#show_award").hide();
		}else{
			$("#show_award").show();
		}
	});

	$("#time_limit").on("change","#Project_p_time_limittype",function(){
		var _type = parseInt($(this).val());
		if(_type==1){
			$("#Project_p_time_limit").html($("#by_day_tmp").html());
			$("#Project_p_style").html($("#style_by_day").html());
		}else{
			$("#Project_p_time_limit").html($("#by_month_tmp").html());
			$("#Project_p_style").html($("#style_by_month").html());
		}
	});
        
        $("#Project_p_province").change(function () {
            getProvince();
        });
        getProvince();
        function getProvince() {
            var city = $("#Project_p_province").val();
            $.post("<?php echo Yii::app()->controller->createUrl('assetsBank/GetCity') ?>", {'city': city},
            function (result) {
                if (result != "error") {
                    $("#Project_p_city").html(result);
                }
            }
            );
        }
	
});
</script>
