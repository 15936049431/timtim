<?php 
	$this -> js = array('js/laydate/laydate');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 奖品信息</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal',
                    ),
                ));
                                ?>
                <!--                输出错误信息  开始-->
					<?php if ($form->errorSummary($model)) { ?>
                    <div class="alert alert-error">
                        <button class="close" data-dismiss="alert">×</button>
                        <p><?php echo $form->errorSummary($model); ?></p>
                    </div>
                    <?php } ?>
                <!--                输出错误信息  结束-->
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'award_name', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textField($model, 'award_name', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('award_name'))); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>

                <div class="control-group">
                        <?php echo $form->labelEx($model, 'award_alias', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textField($model, 'award_alias', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('award_alias'))); ?>                          
                        <span class="help-inline"></span>
                    </div>
                </div>
                
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'award_desc', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textArea($model, 'award_desc', array('class' => 'span4', 'rows' => '5', 'placeholder' => '请填写' . $model->getAttributeLabel('award_desc'))); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->dropDownList($model,'status',array("1"=>"开启","0"=>"关闭"),array('class'=>'input-xlarge')); ?>                          
                        <span class="help-inline"></span>
                    </div>
                </div>
                
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'start_time', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textField($model, 'start_time', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('start_time'),"onfocus"=>"laydate()")); ?>                          
                        <span class="help-inline"></span>
                    </div>
                </div>
                
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'end_time', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textField($model, 'end_time', array('class' => 'input-xlarge', 'placeholder' => '请填写' . $model->getAttributeLabel('end_time'),"onfocus"=>"laydate()")); ?>                          
                        <span class="help-inline"></span>
                    </div>
                </div>
                
                <div class="control-group">
                        <?php echo $form->labelEx($model, 'award_all', array('class' => 'control-label')); ?>
                    <div class="controls">
						<?php echo $form->textField($model, 'award_all', array('class' => 'input-xlarge', 'placeholder' => '0元',"disabled"=>"disabled")); ?>                          
                        <span class="help-inline"></span>
                    </div>
                </div>

				<div class="control-group">
                        <label class="control-label">赠送红包</label>
                        <div class="controls">
                                <?php foreach($type_model as $k => $v){ ?>
                                <label class="checkbox inline">
                                    <input type="checkbox" value="<?php echo $v->id; ?>" <?php if(in_array($v->id,$model->award_check)){echo "checked='checked'";} ?> name="award_check[]" money="<?php echo $v->money; ?>"> <?php echo $v->name; ?>
                               </label>
                                <?php } ?>
                        </div>
                     </div>
				<input type="hidden" name="Award[award_money]" value="" />
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
	$("[name='award_check[]']").click(function(){
		var _count = 0 ; 
		$("[name='award_check[]']:checked").each(function(){ _count+= parseInt($(this).attr("money"))});
		$("#Award_award_all").val(_count+"元");
		$("input[name='Award[award_money]']").val(_count);
	});
</script>