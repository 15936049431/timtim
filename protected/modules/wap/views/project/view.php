<div class="container-fluid project-info">
		<h3><?php echo $project_info->p_apr; ?>%</h3>
		<h4>预期年化收益率</h4>
	</div>
  
	<div class="container-fluid pd-0 center-p">
		<div class="row mg-0" style="padding-top:5px;">
		  <div class="col-xs-4 bd-1">
			<p style="color:red;">理财期限:<?php echo $project_info->p_time_limit; ?><?php echo $project_info->p_time_limittype==1 ? "天" : "个月" ;?></p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p style="color:red;"><?php echo LYCommon::GetItem_of_value($project_info->p_style,'project_repay_type'); ?></p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p>最低<?php echo $project_info->p_lowaccount; ?>元起投</p>
		  </div>
		</div>
	</div>
	
	<div class="container-fluid pd-20 bg-gray"></div>
	
	<div class="container-fluid pd-0">
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">标的总额</div>
			<div class="pull-right"><?php echo $project_info->p_account; ?></div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">剩余投资金额</div>
			<div class="pull-right"><?php echo LYCommon::sprintf_diy($project_info->p_account-$project_info->p_account_yes); ?></div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">产品类型</div>
			<div class="pull-right">金银票</div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">项目推荐方</div>
			<div class="pull-right"><?php echo LYCommon::half_replace($project_info->user->user_name); ?></div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">资金用途</div>
			<div class="pull-right">资金周转</div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">项目详情</div>
			<div class="pull-right">></div>
		</div>
		<div class="col-xs-12 project-info-bottom">
			<div class="pull-left">投标记录</div>
			<div class="pull-right">已有<?php echo $num; ?>人></div>
		</div>
	</div>
	
	<?php if($project_info->p_status==1){ ?>
         <?php if($project_info->p_account>$project_info->p_account_yes){ ?>   
              <button type="button" class="btn btn-sm btn-danger project_btn" onclick="window.location.href='<?php echo Yii::app()->controller->createUrl('project/pay',array('id'=>$project_info->p_id)); ?>'">立即投资</button>
		 <?php }else{ ?>
		  	  <button type="button" class="btn btn-sm btn-default project_btn" ">已满标</button>
		 <?php } ?>
	<?php }elseif($project_info->p_status==2 || $project_info->p_status==0){ ?>
		 <button type="button" class="btn btn-sm btn-default project_btn" ">初审失败</button>
	<?php }elseif($project_info->p_status==3){ ?>
		  <button type="button" class="btn btn-sm btn-default project_btn" ">还款中</button>
	<?php }elseif($project_info->p_status==4){ ?>
		  <button type="button" class="btn btn-sm btn-default project_btn" ">满标失败</button>
	<?php }elseif($project_info->p_status==5){ ?>
		  <button type="button" class="btn btn-sm btn-default project_btn" ">已流标</button>
	<?php }elseif($project_info->p_status==6){ ?>
		  <button type="button" class="btn btn-sm btn-default project_btn" ">已撤销</button>
	<?php }else{ ?>
		  <button type="button" class="btn btn-sm btn-default project_btn" ">还款完成</button>
	<?php } ?>