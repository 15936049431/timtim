<style>.controls{padding-top:5px;}</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 资信审核</h3>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-1-1" data-toggle="tab">用户信息</a></li>
                    <li class=""><a href="#tab-1-2" data-toggle="tab">资信信息</a></li>
 <!--                    <li class=""><a href="#tab-1-3" data-toggle="tab">投标记录</a></li> -->
                 </ul>
            </div>
            <div class="box-content">
                <font class="form-horizontal">
                    <div class="tab-content" style="overflow:inherit;">
                        <div class="tab-pane active" id="tab-1-1">
                            <div class="control-group">
                                <label class="control-label"><?php echo $model->getAttributeLabel('user_name'); ?></label>
                                <div class="controls">
                                    <?php echo $model->user->user_name; ?>                    
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $model->getAttributeLabel('real_name'); ?></label>
                                <div class="controls">
                                    <?php echo $model->user->real_name; ?>                    
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $model->getAttributeLabel('card_num'); ?></label>
                                <div class="controls">
                                    <?php echo $model->user->card_num; ?>                    
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $model->getAttributeLabel('user_email'); ?></label>
                                <div class="controls">
                                    <?php echo $model->user->user_email; ?>                    
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $model->getAttributeLabel('user_phone'); ?></label>
                                <div class="controls">
                                    <?php echo $model->user->user_phone; ?>                    
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-1-2">
                            <ul class="gallery">
                                <?php foreach($credit_pic_list as $k => $v){ ?>
                                <li>
                                    <a href="javascript:;" rel="prettyPhoto" onclick="showphoto('<?php echo base64_encode(SITE_UPLOAD.'usercredit/'.$v->credit_pic); ?>');" title="">
                                        <div>
                                            <img src="<?php echo SITE_UPLOAD.'usercredit/s_'.$v->credit_pic ?>" alt="">
                                            <i></i>
                                        </div>
                                    </a>
                                    <div class="gallery-tools">
                                        <a href="#"><i class="icon-link"></i></a>
                                        <a href="#"><i class="icon-paper-clip"></i></a>
                                        <a href="#"><i class="icon-pencil"></i></a>
                                        <a href="#"><i class="icon-trash"></i></a>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div>
                </font>
            </div>
        </div>
        
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 资信审核</h3>
            </div>
            <div class="box-content">
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal'
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
        		<?php if($model->status==0){ ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'amount',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'amount',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('amount'))); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'real_amount',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'real_amount',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('real_amount'))); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'check_remark',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'check_remark',array('class'=>'input-xlarge', 'rows'=>'5','placeholder'=>'请填写'.$model->getAttributeLabel('check_remark'))); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="Credit[status]" value="1" class="btn btn-success">审核通过</button>
                    <button type="submit" name="Credit[status]" value="2" class="btn btn-danger">审核拒绝</button>
                </div>
                <?php }else{ ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'check_remark',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $model->check_remark; ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'check_manager',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $model->manager->manager_name; ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'check_time',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo LYCommon::subtime($model->add_time,2); ?>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <?php } ?>
                <?php $this -> endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showphoto(photourl){
        $.layer({
            type: 2,
            title:['查看资信','font-size:14px;color:#666;border-bottom:1px #005178 solid;background:none; font-weight:bold;'],
            border:[0],
            area: ['1000px', '550px'],
            iframe: {
                src: '<?php echo Yii::app()->controller->createUrl('extend/photoshow'); ?>?photourl='+photourl,
                scrolling:'yes'
            }

        });
    }
</script>