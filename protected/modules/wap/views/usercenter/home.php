<div class="container-fluid pd-20 center-top">
		<img src="<?php echo WAP_IMG_URL; ?>logo.png" style="width:140px;height:140px;" class="center-block" />
		<h5>待收总额</h5>
		<h4><?php echo $assets_info->wait_total_money; ?>元</h4>
	</div>
  
	<div class="container-fluid pd-0 center-p">
		<div class="row mg-0" style="padding-top:5px;">
		  <div class="col-xs-4 bd-1">
			<p>账户资产</p>
			<p><?php echo $assets_info->total_money; ?>元</p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p>账户余额</p>
			<p><?php echo $assets_info->real_money; ?>元</p>
		  </div>
		  <div class="col-xs-4 bd-1">
			<p>冻结金额</p>
			<p><?php echo $assets_info->frost_money; ?>元</p>
		  </div>
		</div>
	</div>
	
	<div class="container-fluid pd-20 bg-gray"></div>
	
	<div class="container-fluid pd-0">
		<div class="row mg-0" style="padding-top:0px;">
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/recharge"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>chongzhi.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>充值</h6>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/cash"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>tixian.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>提现</h6>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/order"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>wdtz.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>我的投资</h6>
			  </div>
			</a>
			</div>
		  </div>
		</div>
	</div>
	<div class="container-fluid pd-0">
		<div class="row mg-0" style="padding-top:0px;">
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/realname"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>shiming.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>实名认证</h6>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/bill"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>jyjl.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>交易记录</h6>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl("usercenter/bank"); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>jfzh.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>银行卡管理</h6>
			  </div>
			</a>
			</div>
		  </div>
		</div>
	</div>
	<!--div class="container-fluid pd-0">
		<div class="row mg-0" style="padding-top:0px;">
		  
		  <div class="col-xs-4 bd-1">
			<div class="thumbnail img-none">
			<a href="#">
			  <img src="<?php echo WAP_IMG_URL; ?>yqhy.png" alt="..." style="width:50px;height:50px;">
			  <div class="img-font">
				<h6>我的邀请</h6>
			  </div>
			</a>
			</div>
		  </div>
		</div>
	</div-->