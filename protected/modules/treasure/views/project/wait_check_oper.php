<?php
    $this->page_title = '项目待审';
    $this->page_desc = '前台发起项目，待审核';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min','js/layer/layer','js/dot.min');
?>
<style>.controls{padding-top:5px;}</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 项目信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
                <ul  class="nav nav-tabs">
                    <li class="active"><a href="#content1" data-toggle="tab">项目详情</a></li>
                    <li><a href="#pic" data-toggle="tab">项目图片</a></li>
                </ul>
            </div>
            <div class="tab-content">
            	<div class="tab-pane active" id="content1">
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
			                <?php echo $form->labelEx($model,'p_pic',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <a href="javascript:;" onclick="open_pic('<?php echo SITE_UPLOAD.'project/'.$model->p_pic; ?>');">点击查看</a>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model->user,'user_name',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $model->user->user_name; ?>
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
			                    <?php echo $form->textField($model,'p_apr',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_apr'))); ?>
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
			                <?php echo $form->labelEx($model,'p_award_type',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->dropDownList($model,'p_award_type',array("0"=>"无奖励","1"=>"按百分比奖励","2"=>"固定金额奖励")); ?>
			                    <span class="help-inline">（选择借款标奖励的类型！）</span>
			                </div>
			            </div>
			            <div class="control-group" style="display:none;" id="show_award">
			                <?php echo $form->labelEx($model,'p_award',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->textField($model,'p_award',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_award'))); ?>
			                    <span class="help-inline">（根据奖励类型填写相对应的百分比或者固定金额！）</span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_lowaccount',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->textField($model,'p_lowaccount',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_lowaccount'))); ?>
			                    <span class="help-inline">元（0为不限制最小投标金额）</span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_mostaccount',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->textField($model,'p_mostaccount',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_mostaccount'))); ?>
			                    <span class="help-inline">元（0为不限制最大投标金额）</span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_autorate',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->textField($model,'p_autorate',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_autorate'))); ?>
			                    <span class="help-inline">%（0-100自动投标占本借款的比例）</span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_valid_time',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $model->p_valid_time; ?>
			                    <span class="help-inline">天（借款标的有效时间！）</span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_time_limit',array('class'=>'control-label')); ?>
			                <div class="controls">
			                   	<?php if($model->p_type!=4){ echo $model->p_time_limit.(($model->p_time_limittype==1)?"天":"个月"); }else{echo "额满即还";} ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
						<div class="control-group">
							<?php echo $form->labelEx($model,'p_time_limit',array('class'=>'control-label')); ?>
							<div class="controls" id="time_limit">
								<?php echo $form->dropDownList($model,'p_time_limit',($model->p_time_limittype==1 ? $project_day_type_arr : $project_month_type_arr)); ?>
								<?php echo $form->dropDownList($model,'p_time_limittype',$model->itemAlias('p_time_limittype'),array('style'=>'width:60px;')); ?>
								<span class="help-inline">项目的时间</span>
							</div>
						</div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_style',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php if($model->p_type!=4){ echo LYCommon::GetItem_of_value($model->p_style,'project_repay_type'); }else{echo "额满即还";} ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_type',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo LYCommon::findcat('project_type',$model->p_type); ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_addtime',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo LYCommon::subtime($model->p_addtime,1); ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
                                    <div class="controls">
                                        <?php echo $form->textArea($model,'p_content',array('class'=>'span4','rows'=>'5')); ?>
                                     </div>
                                     <?php $this->widget('application.widget.kindeditor.KindEditor',array('target'=>array(
                                            '#Project_p_content'=>array('uploadJson'=> $this->createUrl('upload')))));?>
			            <div class="control-group">
			                <?php echo $form->labelEx($model,'p_verifyremark',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->textArea($model,'p_verifyremark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_verifyremark'),'rows'=>'5')); ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
			            <div class="form-actions">
			                <button type="submit" name="Project[sh_status]" value="1" class="btn btn-success">审核通过</button>
			                <button type="submit" name="Project[sh_status]" value="2" class="btn btn-danger">审核拒绝</button>
			            </div>
		                <?php $this->endWidget(); ?>
		            </div>
                </div>
                
                <div class="tab-pane" id="pic">
		            <div class="box-content form-horizontal">
		            	<?php foreach($projectpic as $k=>$v){ ?>
		            		<img src="<?php echo SITE_UPLOAD.'projectpic/'.$v->p_src; ?>" />
		            	<?php } ?>
		            </div>
		        </div>
                
            </div>            
        </div>        
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
<script>
$(function(){
	$("#Project_p_award_type").change(function(){
		ShowAward();
	});
	function ShowAward(){
		var award_type=$("#Project_p_award_type").val();
		if(award_type==0){
			$("#show_award").hide();
		}else{
			$("#show_award").show();
		}
	}
	ShowAward();
});
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
</script>