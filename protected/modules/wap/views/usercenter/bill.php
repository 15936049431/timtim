<div class="container-fluid">
	<?php foreach($bill_list as $k=>$v){ ?>
		<div class="col-xs-12 more-list" >
			<div class="pull-left lh-25"><?php echo LYCommon::GetItem_of_alias($v->b_itemtype,"assets_type"); ?><br><?php echo LYCommon::subtime($v->b_time,3); ?></div>
			<div class="pull-right"><?php echo $v->b_money; ?></div>
		</div>
	<?php } ?>
	</div>