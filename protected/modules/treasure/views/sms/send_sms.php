<?php
    $this->page_title = '发送短信';
    $this->page_desc = '';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>


<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 用户信息</h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    
                    <div class="box-content">
                        <?php $form = $this->beginWidget('CActiveForm',array(
                            'htmlOptions'=>array(
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
                        
        
                        <div class="control-group">
                            <label class="control-label required" for="Sms_get_user_contact">选择发送内容 <span class="required">*</span></label>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'remark',$smstmp_arr); ?>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'get_user_contact',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model,'get_user_contact',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('get_user_contact'))); ?>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'sms_con',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model,'sms_con',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('sms_con'),'rows'=>'5','style'=>'width:400px;')); ?>
                                <span class="help-inline"></span>
                            </div>
                        </div>
        
        
                        <div class="form-actions">
                            <input type="submit" class="btn btn-primary" value="提交">
                            <button type="reset" class="btn">重置</button>
                        </div>
        
                        <?php $this -> endWidget(); ?>
                        
                    </div>
                    
                </div>
            </div>
    
</div>

<script type="text/javascript">
    $("#Sms_remark").change(function(){
        $.post("<?php echo Yii::app()->controller->createUrl('sms/ajax_get_tmp') ?>?tmp_alias="+$(this).val(),{
            
        },function(data){
            $("#Sms_sms_con").text(data);
        });
    });
</script>