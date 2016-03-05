<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 管理员信息</h3>
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
<!--                输出错误信息  开始-->
                <?php if($form->errorSummary($authassign_model)){ ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <p><?php echo $form->errorSummary($authassign_model); ?></p>
                </div>
                <?php } ?>
<!--                输出错误信息  结束-->
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'manager_name',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'manager_name',array('class'=>'input-xlarge','placeholder'=>'请填管理员登录名')); ?>
                        </div>
                    </div>
                    <?php if($model->isNewRecord){ ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'manager_pass',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'manager_pass',array('class'=>'input-xlarge','placeholder'=>'请填管理员密码')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'repassowrd',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'repassowrd',array('class'=>'input-xlarge','placeholder'=>'请填再次管理员密码')); ?>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'manager_pass',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'manager_pass',array('class'=>'input-xlarge','placeholder'=>'请填管理员密码','value'=>'')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'repassowrd',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->passwordField($model,'repassowrd',array('class'=>'input-xlarge','placeholder'=>'请填再次管理员密码','value'=>'')); ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="control-group">
                      <?php echo $form->labelEx($model,'manager_realname',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textField($model,'manager_realname',array('class'=>'span4','rows'=>'5','placeholder'=>'请填管理员真实姓名')); ?>
                      </div>
                    </div>

                    <div class="control-group">
                      <?php echo $form->labelEx($model,'manager_tel',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->textField($model,'manager_tel',array('class'=>'span4','rows'=>'5','placeholder'=>'请填管理员真实姓名')); ?>
                      </div>
                   </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model,'google_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php if($this->getAction()->getId()=='create'){$model->google_status=0;}  echo $form->radioButtonList($model,'google_status',$model->itemAlias('google_status'),array('template'=>'<label class="radio inline">{input}{label}</label>','separator'=>'&nbsp;')); ?>
                        </div>
                    </div>

                    <?php if($this->getAction()->getId()=='update'){ ?>
                    <div class="control-group">
                        <label class="control-label required" for="sitename_sadfasdf">谷歌验证码</label>
                        <div class="controls">
                            <div class="fileupload-new thumbnail" id="recreate" style="width: 200px; height: 200px; cursor: pointer;" title="点击更换二维码">
                                <img id="input_google_img" src="<?php echo $google_img; ?>" alt="">
                            </div>
                        </div>
                        
                        <div class="controls" style="margin-top:10px;">
                          <?php echo $form->textField($model,'google_secret',array('class'=>'span4','rows'=>'5','placeholder'=>'请填管理员真实姓名')); ?>
                        </div>
                    </div>
                    <?php } ?>
                   <div class="control-group">
                        <label class="control-label">角色</label>
                        <div class="controls">
                            <?php echo $form->dropDownList($authassign_model,'itemname',  ManagerController::Getrole(),array('class'=>'input-xlarge')); ?>
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
<?php if($this->getAction()->getId()=='update'){ ?>
<script type="text/javascript">
    window.onload = function(){
        $("#recreate").click(function(){
            $.post("<?php echo Yii::app()->controller->createUrl('ajaxrecreate') ?>",{
                
            },function(result){
                var obj = eval("("+result+")");
                $("#Manager_google_secret").val(obj.key);
                $("#input_google_img").attr("src",obj.googleImg);
            });
        });
    }
</script>
<?php } ?>