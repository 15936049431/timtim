<?php
    $this->page_title = '还款信息';
    $this->page_desc = '还款信息明细';
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<style>.controls{padding-top:5px;}</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 还款信息</h3>
                <ul class="nav nav-tabs">
                   <li class="active"><a href="#tab-1-1" data-toggle="tab">项目信息</a></li>
                   <li class=""><a href="#tab-1-2" data-toggle="tab">收款明细</a></li>
<!--                    <li class=""><a href="#tab-1-3" data-toggle="tab">投标记录</a></li> -->
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
	            <div class="control-group">
	                	<?php echo $form->labelEx($model,'用户名',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->project->user->user_name; ?>
	                    <span class="help-inline"></span>
	                </div>
	            </div>
	            <div class="control-group">
	                	<?php echo $form->labelEx($model,'项目名称',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->project->p_name; ?>
	                    <span class="help-inline"></span>
	                </div>
	            </div>
	            <div class="control-group">
	                <?php echo $form->labelEx($model,'p_order',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->p_order+1; ?>/<?php echo $repay_view->project->p_time_limit; ?>
	                    <span class="help-inline"></span>
	                </div>
	            </div>
	            <div class="control-group">
	                <?php echo $form->labelEx($model,'p_repaytime',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo LYCommon::subtime($repay_view->p_repaytime,2); ?>
	                    <span class="help-inline"></span>
	                </div>
	            </div>
	            <div class="control-group">
	                <?php echo $form->labelEx($model,'p_repayaccount',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->p_repayaccount; ?>
	                    <span class="help-inline">元</span>
	                </div>
	            </div>
	            <div class="control-group">
	                <?php echo $form->labelEx($model,'p_money',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->p_money; ?>
	                    <span class="help-inline">元</span>
	                </div>
	            </div>
	            <div class="control-group">
	                <?php echo $form->labelEx($model,'p_interest',array('class'=>'control-label')); ?>
	                <div class="controls">
	                    <?php echo $repay_view->p_interest; ?>
	                    <span class="help-inline">元</span>
	                </div>
	            </div>
	            
	            
	            <?php if($repay_view->p_status==0){ ?>
	            <div class="form-actions">
	                <button type="submit" name="repay" value="1" class="btn btn-success">代用户还款</button>
	            </div>
	            <?php } ?>
	                <?php $this->endWidget(); ?>
	            </div>
	            <div class="tab-pane" id="tab-1-2">
	                 <div class="box-content">
                            <table class="table table-striped">
                              <thead>
                               <tr>
                                  <th>ID</th>
                                  <th>用户名</th>
                                  <th>期数</th>
                                  <th>状态</th>
                                  <th>应收金额</th>
                                  <th>应收时间</th>
                                  <th>应收本金</th>
                                  <th>应收利息</th>
                                </tr>
                              </thead>
                           <tbody>
                          <?php foreach($project_collect_list as $k => $v){ ?>
                            <tr>
                               <td><?php echo $v->p_id; ?></td>
                               <td><?php echo $v->project_order->user->user_name; ?></td>
                               <td><?php echo $v->p_order+1; ?>/<?php echo $v->project->p_time_limit; ?></td>
                               <td><?php if($v->p_status==0){echo "未收";}else{echo "已收";} ?></td>
                               <td><?php echo $v->p_repayaccount; ?></td>
                               <td><?php echo LYCommon::subtime($v->p_repaytime,2); ?></td>
                               <td><?php echo $v->p_realmoney; ?></td>
                               <td><?php echo $v->p_interest; ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                    </table>
                  </div>
	            </div>
<!-- 	             <div class="tab-pane" id="tab-1-3"> -->
<!-- 	                            这是投标记录 -->
<!-- 	             </div> -->
	            </div>
	         </div>
        </div>
    </div>
</div>
