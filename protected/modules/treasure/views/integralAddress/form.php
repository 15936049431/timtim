<style>
.controls{padding-top:5px;}
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 商品信息</h3>
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
                        <?php echo $form->labelEx($model,'address_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'address_name',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('address_name'))); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'address_people',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'address_people',array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'address_phone',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'address_phone',array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'address_city',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'address_city',$city_list,array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group" id="show_province" style="display:none;">
                        <?php echo $form->labelEx($model,'address_province',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <select name="IntegralAddress[address_province]" id="IntegralAddress_address_province"></select>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'address_place',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($model,'address_place',array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'addtime',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::subtime($model->addtime,2); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'is_default',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'is_default',array('0' =>'否','1' =>'是'),array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'status',array('0' =>'关闭','1' =>'开启'),array('class'=>'input-xlarge')); ?>
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
                        	$("#IntegralAddress_address_city").change(function(){
								getProvince();
							});
							getProvince();
							function getProvince(){
								var city=$("#IntegralAddress_address_city").val();
								$.post("<?php echo Yii::app()->controller->createUrl('GetCity') ?>",{'city':city},
									function(result){
										if(result!="error"){
											$("#IntegralAddress_address_province").html(result);
											$("#show_province").show();
										}else{
											$("#show_province").hide();
										}
									}
								);
							}
                        });
							
						
                        </script>