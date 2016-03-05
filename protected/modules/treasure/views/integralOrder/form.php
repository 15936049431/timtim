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
                        <?php echo $form->labelEx($model,'user_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->user->user_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'order_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->order_id; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <?php if($model->integral_shop->i_ntype==1){ ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'address_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo empty($model->address_id)?"无":$model->integral_address->address_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'address_allwith',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->address_allwith; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'收件人',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo empty($model->address_id)?"无":$model->integral_address->address_people; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'收件人手机',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo empty($model->address_id)?"无":$model->integral_address->address_phone; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'number',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->number; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'need_integral',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $model->need_integral; ?>
                          <span class="help-inline"></span>
                      </div>
                   </div>
                   <div class="control-group">
                      <?php echo $form->labelEx($model,'user_remark',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $model->user_remark; ?>
                          <span class="help-inline"></span>
                      </div>
                   </div>
                   <?php $this->endWidget(); ?>
                    </div>
                </div>
                
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
                     <?php if($model->status!=0){?>
	                     <div class="control-group">
	                      <?php echo $form->labelEx($model,'verify_user',array('class'=>'control-label')); ?>
	                      <div class="controls">
	                          <?php echo $model->manager->manager_name; ?>
	                          <span class="help-inline"></span>
	                      </div>
	                   	</div>
	                   	<div class="control-group">
	                      <?php echo $form->labelEx($model,'verify_time',array('class'=>'control-label')); ?>
	                      <div class="controls">
	                          <?php echo LYCommon::subtime($model->verify_time,2); ?>
	                          <span class="help-inline"></span>
	                      </div>
	                   	</div>
	                   	 <div class="control-group">
	                      <?php echo $form->labelEx($model,'verify_remark',array('class'=>'control-label')); ?>
	                      <div class="controls">
	                          <?php echo $model->verify_remark; ?>
	                          <span class="help-inline"></span>
	                      </div>
	                   	</div>
	                   	<div class="control-group">
		                      <?php echo $form->labelEx($model,'send_time',array('class'=>'control-label')); ?>
		                      <div class="controls">
		                          <?php echo LYCommon::subtime($model->send_time,2); ?>
		                          <span class="help-inline"></span>
		                      </div>
		                   	</div>
		                <div class="control-group">
		                      <?php echo $form->labelEx($model,'send_order',array('class'=>'control-label')); ?>
		                      <div class="controls">
		                          <?php echo $model->send_order; ?>
		                          <span class="help-inline"></span>
		                      </div>
		                   	</div>
	                   	<?php if($model->status==4){ ?>
	                   		<div class="control-group">
		                      <?php echo $form->labelEx($model,'send_yestime',array('class'=>'control-label')); ?>
		                      <div class="controls">
		                          <?php echo LYCommon::subtime($model->send_yestime,2); ?>
		                          <span class="help-inline"></span>
		                      </div>
		                   	</div>
		                   	<div class="control-group">
		                      <?php echo $form->labelEx($model,'user_remark',array('class'=>'control-label')); ?>
		                      <div class="controls">
		                          <?php echo $model->user_remark; ?>
		                          <span class="help-inline"></span>
		                      </div>
		                   	</div>
	                   	<?php } ?>
                     <?php } ?>
                     <?php if($model->status==0){ ?>
	                    <div class="control-group">
			                <?php echo $form->labelEx($model,'status',array('class'=>'control-label')); ?>
			                <div class="controls">
			                    <?php echo $form->dropDownList($model,'status',array("0"=>"未审","1"=>"通过","5"=>"返还用户积分"),array('class'=>'input-xlarge')); ?>
			                    <span class="help-inline"></span>
			                </div>
			            </div>
			            <div class="control-group">
	                      <?php echo $form->labelEx($model,'send_order',array('class'=>'control-label')); ?>
	                      <div class="controls">
	                          <?php echo $form->textField($model,'send_order',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('send_order'))); ?>
	                          <span class="help-inline"></span>
	                      </div>
	                    </div>
	                    <div class="control-group">
	                      <?php echo $form->labelEx($model,'verify_remark',array('class'=>'control-label')); ?>
	                      <div class="controls">
	                          <?php echo $form->textArea($model,'verify_remark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('verify_remark'))); ?>
	                          <span class="help-inline"></span>
	                      </div>
	                    </div>
	                    <div class="form-actions">
	                                <input type="submit" class="btn btn-primary" value="提交">
	                                <button type="reset" class="btn">重置</button>
	                     </div>
	                     <?php }elseif($model->status==2){ ?>
	                     <div class="form-actions">
	                     			<input type="hidden" name="IntegralOrder[status]" id="IntegralOrder_status" value="5" />
	                                <input type="submit" class="btn btn-primary" value="返还用户积分">
	                     </div>
	                     <?php }elseif($model->status==3){ ?>
	                     <div class="form-actions">
	                     			<input type="hidden" name="IntegralOrder[status]" id="IntegralOrder_status" value="0" />
	                                <input type="submit" class="btn btn-primary" value="重新发货">
	                                <button type="button" class="btn">返还积分</button>
	                     </div>
	                     <?php }else{ ?>
		                     <div class="control-group">
		                        <?php echo $form->labelEx($model,'status',array('class'=>'control-label')); ?>
		                        <div class="controls">
		                            <?php echo $form->dropDownList($model,'status',array('0' =>'申请','1' =>'发货','2'=>'审核拒绝','3'=>'未到货','4'=>'已收件','5'=>'已返还积分'),array('class'=>'input-xlarge')); ?>
		                            <span class="help-inline"></span>
		                        </div>
		                    </div>
                     <?php } ?>
                     <?php $this->endWidget(); ?>
                   </div>
                 </div>
            </div>
</div>