
	<div class="container-fluid">
		<div class="col-xs-12 project-search">
			<ul>
				<li><a href="<?php echo Yii::app()->controller->createUrl("usercenter/order"); ?>">投资明细</a></li>
				<li><a href="<?php echo Yii::app()->controller->createUrl("usercenter/orderon"); ?>">正在投标</a></li>
				<li><a href="<?php echo Yii::app()->controller->createUrl("usercenter/haverepay"); ?>">已收明细</a></li>
				<li><a href="<?php echo Yii::app()->controller->createUrl("usercenter/waitrepay"); ?>">未收明细</a></li>
			</ul>
		</div>
	</div>
	
	<div class="container-fluid pd-0 bg-gray">
		<?php if(!empty($list)){ ?>
		<?php foreach($list as $k=>$v){ ?>
			<div class="row mg-0 project">
				<div class="col-xs-3 project_left">
					<p><?php echo $v->project->p_name;?></p>
				</div>
				<div class="col-xs-6 project_center">
					<p>应收总额(元):<?php echo $v->project_order->p_repayaccount;?></p>
					<p>
						<span class="exp_span">利息:<font class="exp"><?php echo $v->p_interest; ?></font>元</span>
						<span class="month_span pdl-5"><font class="month"><?php echo $v->p_order+1; ?></font>/<?php echo ($v->project->p_time_limittype==1) ? "1" : $v->project->p_time_limit; ?></span>
						<span class="repay pdl-5"><?php echo LYCommon::GetItem_of_value($v->project->p_style,'project_repay_type'); ?></span>
					</p>
				</div>
				<div class="col-xs-3 project_right">
					<button type="button" class="btn btn-sm btn-default project_btn" ">已收<?php echo $v->p_repayaccount; ?>元</button>
					<p><?php echo $v->project->p_account_yes/$v->project->p_account*100<100? LYCommon::sprintf_diy_9($v->project->p_account_yes/$v->project->p_account*100):100; ?>%</p>
				</div>
			</div>
		<?php } ?>
		<?php }else{ ?>
		<div class="row mg-0 project" style="text-align:center;line-height:200%">
           	您还没有投资哦,赶紧去头投资吧.
        </div>
	<?php } ?>
	</div>