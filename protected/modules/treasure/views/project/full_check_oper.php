<?php
    $this->page_title = '项目复审';
    $this->page_desc = '项目满标，进入复审';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<style>
.controls{padding-top:5px;};
</style>
<div class="row-fluid">
    <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="icon-folder-close"></i>项目复审</h3>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-1-1" data-toggle="tab">项目信息</a></li>
                        <li class=""><a href="#tab-1-2" data-toggle="tab">借款资料</a></li>
                        <li class=""><a href="#tab-1-3" data-toggle="tab">投标记录</a></li>
                    </ul>
                </div>

                <div class="box-content">
                    <?php $form = $this->beginWidget('CActiveForm',array(
                'htmlOptions'=>array(
                    'enctype'=>'multipart/form-data',
                    'class'=>'form-horizontal',
                ),
            )); ?>
                    <div class="tab-content" style="overflow:inherit;">
                        <div class="tab-pane active" id="tab-1-1">
            
<!--                输出错误信息  开始-->
            <?php if($form->errorSummary($model)){ ?>
            <div class="alert alert-error">
                <button class="close" data-dismiss="alert">×</button>
                <p><?php echo $form->errorSummary($model); ?></p>
            </div>
            <?php } ?>
<!--                输出错误信息  结束-->
                    <div class="control-group">
            <?php echo $form->labelEx($model,'p_type',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo LYCommon::findcat('project_type',$model->p_type); ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_name',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_name; ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model->user,'user_name',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->user->user_name; ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_account',array('class'=>'control-label')); ?>
            <div class="controls">
                ￥<?php echo $model->p_account; ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_time_limit',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_time_limit.(($model->p_time_limittype==1)?"天":"个月"); ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_apr',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_apr; ?>%
                <span class="help-inline"></span>
            </div>
        </div> 
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_valid_time',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_valid_time."天"; ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_style',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo LYCommon::GetItem_of_value($model->p_style,'project_repay_type'); ?>
                <span class="help-inline"></span>
            </div>
        </div>
        <?php if($model->p_dxb!=""){ ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_dxb',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_dxb; ?>
                <span class="help-inline">（定向标）</span>
            </div>
        </div>
        <?php } ?>    
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_award_type',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php if($model->p_award_type==1){echo "百分比";}elseif($model->p_award_type==2){echo "固定金额";}else{echo "无";}; ?>
                <span class="help-inline">（奖励类型）</span>
            </div>
        </div>
        <?php if($model->p_award_type!=0){ ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_award',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_award; ?><?php if($model->p_award_type==1){echo "%";}else{echo "元";}; ?>
                <span class="help-inline">（奖励类型）</span>
            </div>
        </div>    
        <?php } ?> 
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_lowaccount',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo ($model->p_lowaccount==0)?"无限制":$model->p_lowaccount."元";; ?>
                <span class="help-inline">（借款标最小投资金额）</span>
            </div>
        </div>    
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_mostaccount',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo ($model->p_mostaccount==0)?"无限制":$model->p_mostaccount."元"; ?>
                <span class="help-inline">（借款标最多投资金额）</span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_verifytime',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo LYCommon::subtime($model->p_verifytime,2); ?>
                <span class="help-inline">（初审）</span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_verifyremark',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->p_verifyremark; ?>
                <span class="help-inline">（初审备注）</span>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'p_verifyuser',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $model->manager->manager_name; ?>
                <span class="help-inline">（初审管理员）</span>
            </div>
        </div>
		<div class="control-group">
            <?php echo $form->labelEx($model,'p_fulltime',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo empty($model->p_fulltime) ? "" : LYCommon::subtime($model->p_fulltime,3); ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo $form->labelEx($model,'p_fullverifyremark',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model,'p_fullverifyremark',array('class'=>'input-xlarge','placeholder'=>'请填写'.$model->getAttributeLabel('p_fullverifyremark'),'rows'=>'5')); ?>
                    <span class="help-inline"></span>
                </div>
             </div>
            <div class="form-actions">
                <button type="submit" name="Project[sh_status]" value="1" class="btn btn-success">审核通过</button>
                <button type="submit" name="Project[sh_status]" value="2" class="btn btn-danger">审核拒绝</button>
            </div>
                        </div>
                        <div class="tab-pane" id="tab-1-2">
                           	<?php echo $model->p_content; ?>
                        </div>
                        <div class="tab-pane" id="tab-1-3">
                            <div class="box-content">
                                        <table class="table table-striped">
                                          <thead>
                                           <tr>
                                              <th>ID</th>
                                              <th>用户名</th>
                                              <th>状态</th>
                                              <th>年化收益</th>
                                              <th>投资金额</th>
                                              <th>有效金额</th>
                                              <th>投标时间</th>
                                            </tr>
                                          </thead>
                                       <tbody>
                                      <?php foreach($project_order_list as $k => $v){ ?>
                                        <tr>
                                           <td><?php echo $v->p_id; ?></td>
                                           <td><?php echo $v->user->user_name; ?></td>
                                           <td><?php echo ($v->p_status==1)?"全部通过":"部分通过"; ?></td>
                                           <td><?php echo $v->project->p_apr; ?></td>
                                           <td><?php echo $v->p_money; ?></td>
                                           <td><?php echo $v->p_realmoney; ?></td>
                                           <td><?php echo LYCommon::subtime($v->p_addtime,1); ?></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
</div>