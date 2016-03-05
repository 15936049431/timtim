<?php
    $this->page_title = '编辑项目';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<style>
.controls{padding-top:5px;}
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 项目信息</h3>
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
                        <?php echo $form->labelEx($model,'p_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->p_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'p_money',array('class'=>'control-label')); ?>
                        <div class="controls">
                            ￥<?php echo $model->p_money; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'p_time_limit',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->p_time_limit; ?>个月
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'p_phone',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->p_phone; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div> 
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'p_realname',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->p_realname; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div> 
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_city',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->city->name.'-'.$model->province->name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div> 
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'p_status',array('1'=>'通过','2'=>'拒绝'),array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<?php if($model->p_status==0){ ?>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_verifyremark',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($model,'p_verifyremark',array('class'=>'input-xlarge')); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="form-actions">
                                <input type="submit" class="btn btn-primary" value="提交">
                                <button type="reset" class="btn">重置</button>
                            </div>
					<?php }else{ ?>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_verifyuser',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->verify_user->manager_name; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_verifyremark',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $model->p_verifyremark; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_verifytime',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::subtime($model->p_verifytime,2); ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<?php } ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                
                
            </div>
         </div>