<div class="container-fluid pd-0">
		<div class="swiper-container">
	        <div class="swiper-wrapper">
	            <?php foreach($banner_list as $k=>$v){ ?>
	            	<div class="swiper-slide" style="background:url('<?php echo SITE_UPLOAD."link/s_".$v->link_pic; ?>') center center no-repeat;"></div>
	            <?php } ?>
	        </div>
	        <!-- Add Pagination -->
	        <div class="swiper-pagination"></div>
	        <!-- Add Arrows -->
	        <div class="swiper-button-next"></div>
	        <div class="swiper-button-prev"></div>
	    </div>
	</div>
	
	<!--div class="container-fluid pd-0 bg-gray1">
		<div class="row mg-0" style="padding-top:5px;">
		  <div class="col-xs-6" style="padding:0">
			<div class="thumbnail img-none">
			<a href="/">
			  <img style="width:50px;height:50px;" src="<?php echo WAP_IMG_URL; ?>touzi04.png" alt="...">
			  <div class="img-font">	
				<h6 style="color:black;">累计成功投资金额</h6>
				<p style="color:#d9534f;font-weight:bold"><?php echo $count['project']; ?></p>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-6" style="padding:0">
			<div class="thumbnail img-none">
			<a href="/">
			  <img style="width:50px;height:50px;" src="<?php echo WAP_IMG_URL; ?>touzi05.png" alt="...">
			  <div class="img-font">
				<h6 style="color:black;">投资人已赚取收益</h6>
				<p style="color:#d9534f;font-weight:bold"><?php echo $count['collection']; ?></p>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-3" style="padding:0">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl(Yii::app()->user->getIsGuest() ? "site/login" : "usercenter/home" ); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>index3.png" alt="...">
			  <div class="img-font">
				<h6>账户余额</h6>
			  </div>
			</a>
			</div>
		  </div>
		  <div class="col-xs-3" style="padding:0">
			<div class="thumbnail img-none">
			<a href="<?php echo Yii::app()->controller->createUrl(Yii::app()->user->getIsGuest() ? "site/login" : "usercenter/home" ); ?>">
			  <img src="<?php echo WAP_IMG_URL; ?>index4.png" alt="...">
			  <div class="img-font">
				<h6>每日签到</h6>
			  </div>
			</a>
			</div>
		  </div>
		</div>
	</div>-->
	
	<div class="container-fluid pd-0">
		<?php foreach($project_list as $k=>$v){ ?>
			<div class="row mg-0 project">
				<div class="col-xs-3 project_left">
					<p><?php echo $v->p_name; ?></p>
				</div>
				<div class="col-xs-6 project_center">
					<p>借款金额(元):<?php echo $v->p_account;?></p>
					<p>
						<span class="exp_span"><font class="exp"><?php echo $v->p_apr;?></font>%</span>
						<span class="month_span pdl-5"><font class="month"><?php echo $v->p_time_limit; ?></font><?php echo ($v->p_time_limittype==1) ? "天" : "个月" ;?></span>
						<span class="repay pdl-5"></span>
					</p>
					<p><span class="exp_span">预期年化</span><span class="month_span pdl-5">理财期限</span></p>
				</div>
				<div class="col-xs-3 project_right">
					<?php if($v->p_status==1){ ?>
		            	<?php if($v->p_account>$v->p_account_yes){ ?>
		            		<button type="button" class="btn btn-sm btn-warning project_btn" onclick="window.location.href='<?php echo Yii::app()->controller->createUrl('project/view',array('id'=>$v->p_id)); ?>'">立即投资</button>
		            	<?php }else{ ?>
		            		<button type="button" class="btn btn-sm btn-default project_btn" ">已满标</button>
		            	<?php } ?>
		            <?php }elseif($v->p_status==2 || $v->p_status==0){ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">初审失败</button>
		            <?php }elseif($v->p_status==3){ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">募集完成</button>
		            <?php }elseif($v->p_status==4){ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">满标失败</button>
		            <?php }elseif($v->p_status==5){ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">已流标</button>
		            <?php }elseif($v->p_status==6){ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">已撤销</button>
		            <?php }else{ ?>
		            	<button type="button" class="btn btn-sm btn-default project_btn" ">还款完成</button>
		            <?php } ?>
					<p><?php echo $v->p_account_yes/$v->p_account*100<100? LYCommon::sprintf_diy_9($v->p_account_yes/$v->p_account*100):100; ?>%</p>
				</div>
			</div>
		<?php } ?>
	</div>
