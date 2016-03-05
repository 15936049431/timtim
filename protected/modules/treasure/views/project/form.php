<?php 
	$this->js = array('js/layer/layer'); 
?>
<style>
.controls{padding-top:5px;};
</style>
<div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="icon-reorder"></i> 项目信息</h3>
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-1-1" data-toggle="tab">项目信息</a></li>
							<li class=""><a href="#tab-1-2" data-toggle="tab">借款资料</a></li>
							<li class=""><a href="#tab-1-3" data-toggle="tab">项目图片</a></li>
							<li class=""><a href="#tab-1-4" data-toggle="tab">投标记录</a></li>
						</ul>
                    </div>
					<div class="box-content">
                    <div class="tab-content">
					
					<div class="tab-pane active" id="tab-1-1">
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
        			<?php if(!empty($model->p_pic)){ ?>
       				<div class="control-group">
                        <?php echo $form->labelEx($model,'p_pic',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <a href="javascript:;" onclick="open_pic('<?php echo SITE_UPLOAD.'project/'.$model->p_pic; ?>');">点击查看</a>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <?php } ?>
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
                        <?php echo $form->labelEx($model,'p_status',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo LYCommon::findcat('project_status',$model->p_status); ?>
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
                            ¥<?php echo $model->p_account; ?>
                            <span class="help-inline"></span>
                        </div>
                    </div>
					<div class="control-group">
                        <?php echo $form->labelEx($model,'p_repayment',array('class'=>'control-label')); ?>
                        <div class="controls">
                            ¥<?php echo empty($model->p_repayment)?"无":$model->p_repayment; ?>
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
        
                        <?php $this->endWidget(); ?>
						
						</div>
						
						<div class="tab-pane" id="tab-1-2">
							<div class="box-content">
								<?php echo $model->p_content; ?>
							</div>
						</div>
						
						<div class="tab-pane" id="tab-1-3">
							<div class="box-content">
								<?php foreach($project_pic as $k=>$v){ ?>
									<img src="<?php echo SITE_UPLOAD.'projectpic/'.$v->p_src; ?>" />
								<?php } ?>
							</div>
						</div>
						
						<div class="tab-pane" id="tab-1-4">
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
                                              <th>投资奖励</th>
                                              <th>投标时间</th>
											  <th>投标类型</th>
											  <th>投标说明</th>
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
                                           <td>
                                               <?php if($model->p_award_type==1){ ?>
                                               	  <?php echo LYCommon::sprintf_diy($model->p_award/100*$v->p_realmoney);?>
                                               <?php }elseif($model->p_award_type==2){ ?>
                                               	  <?php echo LYCommon::sprintf_diy($v->p_realmoney/$model->p_account*$model->p_award);?>
                                               <?php }else{ ?>
                                               	  无
                                               <?php }?>
                                           </td>
                                           <td><?php echo LYCommon::subtime($v->p_addtime,1); ?></td>
										   <td><?php if($v->p_type==1){echo "自动投标";}elseif($v->p_type==2){echo "手机投标";}else{echo "电脑投标";} ?></td>
										   <td><?php echo LYCommon::GetOrderImg($v->p_mold,'back'); ?></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                              </div>
						</div>
                    </div>
					</div>
                </div>
                
                
               	
            </div>
         </div>
 <script>
	function open_pic(src){
		layer.open({
            title: '图片预览',
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: 'auto',
            maxWidth :'700',
            offset  :'auto',
            shadeClose:true,
            content: '<div  style=" padding:10px;"><img id="pic" src="'+src+'" /></div>'
        });
	}
 </script>