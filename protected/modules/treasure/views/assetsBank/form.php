<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 银行卡信息</h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
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
                        <?php echo $form->labelEx($model->user,'user_name',array('class'=>'control-label')); ?>
                        <div class="controls" style="padding-top:5px;">
                            <?php echo $model->user->user_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model->user,'real_name',array('class'=>'control-label')); ?>
                        <div class="controls" style="padding-top:5px;">
                            <?php echo $model->user->real_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'b_addtime',array('class'=>'control-label')); ?>
                        <div class="controls" style="padding-top:5px;">
                            <?php echo LYCommon::subtime($model->b_addtime,2); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'b_branch',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'b_branch',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('b_branch'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'b_cardNum',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'b_cardNum',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('b_cardNum'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div><div class="control-group">
                        <?php echo $form->labelEx($model,'b_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'b_status',array("0"=>"关闭","1"=>"激活"),array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>  
					<div class="control-group">
							<?php echo $form->labelEx($model,'b_bank',array('class'=>'control-label')); ?>
							<div class="controls">
								<?php echo $form->dropDownList($model,'b_bank',$banktype_list,array('class'=>'input-xlarge')); ?>
								<span class="help-inline"></span>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($model,'b_city',array('class'=>'control-label')); ?>
							<div class="controls">
								<?php echo $form->dropDownList($model,'b_city',$city,array('class'=>'input-xlarge','style'=>'width:140px;')); ?>
								<?php echo $form->dropDownList($model,'b_province',array("0"=>"请选择"),array('class'=>'input-xlarge','style'=>'width:140px;')); ?>
								<span class="help-inline"></span>
							</div>
						</div>
							<div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="提交">
                                <button type="reset" class="btn">重置</button>
                            </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
                        </div>
						
<script>
	$(function(){
      	$("#AssetsBank_b_city").change(function(){
	 		getProvince();
		});
		getProvince();
		function getProvince(){
			var city=$("#AssetsBank_b_city").val();
			$.post("<?php echo Yii::app()->controller->createUrl('assetsBank/GetCity') ?>",{'city':city},
				function(result){
					if(result!="error"){
						$("#AssetsBank_b_province").html(result);
					}
				}
			);
		}
    });
</script>