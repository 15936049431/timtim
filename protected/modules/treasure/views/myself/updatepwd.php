<?php
    $this->page_title = '修改密码';
    $this->page_desc = '后台登录密码修改';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 修改密码</h3>
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
<!--                输出错误信息  结束-->

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'oldpassword',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'oldpassword',array('class'=>'input-xlarge','placeholder'=>'请填管理员密码')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'newpassword',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'newpassword',array('class'=>'input-xlarge','placeholder'=>'请填管理员密码')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'repassword',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'repassword',array('class'=>'input-xlarge','placeholder'=>'请填再次管理员密码')); ?>
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
<script type="text/javascript">
    window.onload = function(){
        $("#recreate").click(function(){
            $.post("<?php echo Yii::app()->controller->createUrl('manager/ajaxrecreate') ?>",{
                
            },function(result){
                var obj = eval("("+result+")");
                $("#Myself_google_secret").val(obj.key);
                $("#input_google_img").attr("src",obj.googleImg);
            });
        });
    }
</script>