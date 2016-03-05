<style type="text/css">
    .controls{ padding-top: 5px;}
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 提现信息</h3>
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
                        <?php echo $form->labelEx($model,'user_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->user->user_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model->user,'real_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->user->real_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					
					<div class="control-group">
                        <?php echo $form->labelEx($model,'c_province',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo empty($model->c_city)?"未知":$model->area_c->name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'c_city',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo empty($model->c_province)?"未知":$model->area_p->name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'c_bank',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->item->i_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'c_branch',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->c_branch; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'c_cardNum',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->c_cardNum; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'c_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->c_money; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'c_addtime',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::subtime($model->c_addtime,2); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<?php $this->endWidget(); ?>
					</div>
                </div>
				<div class="box">
						<div class="box-title">
							<h3><i class="icon-reorder"></i> 提现信息</h3>
							<div class="box-tool">
								<a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="icon-remove"></i></a>
							</div>
						</div>
						 <?php $form = $this->beginWidget('CActiveForm',array(
                            'htmlOptions'=>array(
                                'enctype'=>'multipart/form-data',
                                'class'=>'form-horizontal',
                            ),
                        )); ?>
						<div class="box-content">
							<?php if($model->c_status==0){ ?>
							<div class="control-group">
								<?php echo $form->labelEx($model,'c_status',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->dropDownList($model,'c_status',array("0"=>"未审","1"=>"通过","2"=>"失败"),array('class'=>'input-xlarge')); ?>
									<span class="help-inline"></span>
								</div>
							</div>                
							<div class="control-group">
								<?php echo $form->labelEx($model,'c_realmoney',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->textField($model,'c_realmoney',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('c_realmoney'))); ?>
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model,'c_fee',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->textField($model,'c_fee',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('c_fee'))); ?>
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model,'c_verify_remark',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->textarea($model,'c_verify_remark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('c_verify_remark'))); ?>
									<span class="help-inline"></span>
								</div>
							</div>
								<div class="form-actions">
									<input type="submit" class="btn btn-primary" value="提交">
									<button type="reset" class="btn">重置</button>
								</div>
							<?php }else{ ?>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_status',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $form->dropDownList($model,'c_status',array("0"=>"未审","1"=>"通过","2"=>"失败"),array('class'=>'input-xlarge')); ?>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_realmoney',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $model->c_realmoney; ?>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_fee',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $model->c_fee; ?>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_verify_remark',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $model->c_verify_remark; ?>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_verify_user',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $model->verify_user->manager_name; ?>
										<span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($model,'c_verify_time',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo LYCommon::subtime($model->c_verify_time,2); ?>
										<span class="help-inline"></span>
									</div>
								</div>
							<?php } ?>
							<?php $this->endWidget(); ?>
						</div>
				</div>
            </div>
        </div>