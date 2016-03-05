<style type="text/css">
    .controls{ padding-top: 5px;}
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 充值信息</h3>
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
                        <?php echo $form->labelEx($model,'r_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->r_money; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'r_BillNo',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->r_BillNo; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'r_type',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->itemAlias('r_type',$model->r_type); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'r_recharge_type',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::GetItem($model->r_recharge_type,($model->r_type==1)?'assets_recharge_type':'assets_oevrrecharge_type'); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'r_addtime',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::subtime($model->r_addtime,2); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<?php $this->endWidget(); ?>
            
                    </div>
                </div>
				<div class="box">
						<div class="box-title">
							<h3><i class="icon-reorder"></i> 充值审核</h3>
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
							<?php if($model->r_status==0 && $model->r_type==2){ ?>
							<div class="control-group">
								<?php echo $form->labelEx($model,'r_status',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->dropDownList($model,'r_status',array("0"=>"未审","1"=>"通过","2"=>"失败"),array('class'=>'input-xlarge')); ?>
									<span class="help-inline"></span>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model,'r_verify_remark',array('class'=>'control-label')); ?>
								<div class="controls">
									<?php echo $form->textarea($model,'r_verify_remark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('r_verify_remark'))); ?>
									<span class="help-inline"></span>
								</div>
							</div>
							
								<div class="form-actions">
									<input type="submit" class="btn btn-primary" value="提交">
									<button type="reset" class="btn">重置</button>
								</div>
							<?php }else{ ?>
								<div class="control-group">
									<?php echo $form->labelEx($model,'r_status',array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $form->dropDownList($model,'r_status',array("0"=>"未审","1"=>"通过","2"=>"失败"),array('class'=>'input-xlarge')); ?>
										<span class="help-inline"></span>
									</div>
								</div>
								
								<?php if($model->r_status!=0){ ?>
									<div class="control-group">
										<?php echo $form->labelEx($model,'r_verify_user',array('class'=>'control-label')); ?>
										<div class="controls">
											<?php echo ($model->r_verify_user!=0)?$model->verify_user->manager_name:"线上充值自动审核"; ?>
											<span class="help-inline"></span>
										</div>
									</div>
									<div class="control-group">
										<?php echo $form->labelEx($model,'r_verify_remark',array('class'=>'control-label')); ?>
										<div class="controls">
											<?php echo $model->r_verify_remark; ?>
											<span class="help-inline"></span>
										</div>
									</div>
									<div class="control-group">
										<?php echo $form->labelEx($model,'r_verify_time',array('class'=>'control-label')); ?>
										<div class="controls">
											<?php echo LYCommon::subtime($model->r_verify_time,2);  ?>
											<span class="help-inline"></span>
										</div>
									</div>
								<?php } ?>
								
							<?php } ?>
							<?php $this->endWidget(); ?>
						</div>
				</div>
            </div>
        </div>