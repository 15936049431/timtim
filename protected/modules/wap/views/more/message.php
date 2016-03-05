<?php 
	$this->page_title = "个人消息"; 
?>
<div class="container-fluid">
	<?php foreach($message_list as $k=>$v){ ?>
		<div class="col-xs-12 message-list">
			<a href=""><h4><?php echo $v->remark; ?></h4></a>
			<p><?php echo LYCommon::subtime($v->add_time,3);?></p>
			<p class="content"><?php echo $v->m_con; ?></p>
		</div>
	<?php } ?>
</div>