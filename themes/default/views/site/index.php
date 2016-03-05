<?php 
	$this->css = array("index");
?>		
		<!-- 主体 开始 -->
        <div class="index_banner wrap">
            <div class="full_screen_slider wrap">
                <ul class="slides wrap">
                	<?php foreach($banner_list as $k=>$v){ ?>
	                    <li style="background: url(<?php echo SITE_UPLOAD.'link/'.$v->link_pic; ?>) no-repeat center center;"><a target="_blank" href="<?php echo $v->link_url;?>"></a></li>
	                <?php } ?>
                </ul>
                <ul class="pagination wrap">
                	<?php foreach($banner_list as $k=>$v){ ?>
                		<li></li>
	                <?php } ?>
                </ul>
            </div>
            <div class="index_banner_box main">
                <div class="index_banner_login">
                    <dl class="bb">
                        <dt></dt>
                        <dd><i></i>皖平财富</dd>
                    </dl>
                    <dl>
                        <dt></dt>
                        <dd>您身边的理财专家</dd>
                    </dl>
                    <?php if(Yii::app()->user->getIsGuest()){ ?>
	                    <a href="<?php echo Yii::app()->controller->createUrl("site/register"); ?>" class="btn">快速注册</a>
	                    <p>已有账号？<a href="<?php echo Yii::app()->controller->createUrl("site/login"); ?>" style="font-size:24px;font-weight:bold;">立即登录</a></p>
                    <?php }else{ ?>
                    	<a href="<?php echo Yii::app()->controller->createUrl("usercenter/home"); ?>" class="btn">欢迎您,<?php echo Yii::app()->user->name; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="index_coulmn wrap">
            <div class="main clear">
                <div class="index_acount fl clear_fixed">
                    <dl class="c1">
                        <dt></dt>
                        <dd>
                            <h2>注册人数</h2>
                            <p><?php echo $index_use_money['total_user']; ?>人</p>
                        </dd>
                    </dl>
                    <dl class="c2">
                        <dt></dt>
                        <dd>
                            <h2>累计成交总额</h2>
                            <p>￥<?php echo $index_use_money['total_order_money']; ?>元</p>
                        </dd>
                    </dl>
                    <dl class="c3">
                        <dt></dt> 
                        <dd>
                            <h2>已为投资人赚取收益</h2>
                            <p>￥<?php echo $index_use_money['have_interest']; ?>元</p>
                        </dd>
                    </dl>
                </div>
               <div class="index_desc fr"> 
                    <h1>什么是添添利？</h1> 
                    <p>添添利是用先进的理念和创新的技术建立的一个安全、高效、诚信、透明的互联网金融中介平台，规范了个人借贷行为,让借出者增加投资渠道。</p> 
                    <a href="<?php echo Yii::app()->controller->createUrl("article/list",array("p"=>"about","cat"=>"aboutus")); ?>">了解更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
                 </div>
            </div>
        </div>
        <div class="main">
            <h1 class="index_tit">
                <span>投资项目</span>
                <a href="<?php echo Yii::app()->controller->createUrl("project/list"); ?>">更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
            </h1>
            <div class="index_tenders">
                <ul class="clear">
                	<?php foreach($project_list as $k=>$v){ ?>
	                    <li class="<?php echo ($k>3) ? "t2" : "t1" ;?>">
	                        <a href="<?php echo Yii::app()->controller->createUrl('project/tender',array('id'=>$v->p_id)); ?>" class="tit"><?php echo LYCommon::truncate_longstr($v->p_name,12); ?></a>
	                        <em class="lv"><?php echo $v->p_apr; ?><i>%</i></em>
	                        <dl class="clear">
	                            <dt>总额：<?php echo $v->p_account; ?></dt>
	                            <dd>期限：<?php echo $v->p_time_limit.(($v->p_time_limittype==1)?"天":"个月");?></dd>
	                        </dl>
	                        <p>项目奖励:<?php if($v->p_award_type==1){echo $v->p_award."%";}elseif($v->p_award_type==2){echo $v->p_award."元";}else{echo "无";} ?></p>
	                        <div class="progress"><div class="progress_bar"></div><span><?php echo $v->p_account_yes/$v->p_account*100<100 ? LYCommon::sprintf_diy_9($v->p_account_yes/$v->p_account*100) : 100; ?>%</span></div>
	                        <?php if($v->p_status==1){ ?>
				            	<?php if($v->p_account>$v->p_account_yes){ ?>
				            	<a href="<?php echo Yii::app()->controller->createUrl('project/tender',array('id'=>$v->p_id)); ?>" class="btn" target="_blank">立即投标</a>
				            	<?php }else{ ?>
				            	<span class="btn">满标待审</span>
				            	<?php } ?>
				            <?php }elseif($v->p_status==2 || $v->p_status==0){ ?>
				            	<span class="btn"><?php echo ($project_now->p_status==2)?"初审失败":"发标待初审"; ?></span>
				            <?php }elseif($v->p_status==3){ ?>
				            	<span class="btn">正在还款</span>
				            <?php }elseif($v->p_status==4){ ?>
				            	<span class="btn">满标审核失败</span>
				            <?php }elseif($v->p_status==5){ ?>
				            	<span class="btn">流标</span>
				            <?php }elseif($v->p_status==6){ ?>
				            	<span class="btn">用户已撤销</span>
				            <?php }else{ ?>
				            	<span class="btn">还款完成</span>
				            <?php } ?>
	                    </li>
                    <?php } ?>
                </ul>
            </div>
             <h1 class="index_tit">
                 <span>公司动态</span>
             </h1>
            <div class="index_news ba clear">
                <div class="index_box fl">
                    <dl>
                        <dt>
                            <span>发标预告</span>
                            <a href="<?php echo Yii::app()->controller->createUrl("article/list", array("p" => "company", "cat" => "trailer")); ?>">更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
                        </dt>
                        <dd>
                            <ul>
                            	<?php foreach($trailer_list as $k=>$v){ ?>
                                	<li><a href="<?php echo Yii::app()->controller->createUrl('article/view', array('id' => $v->article_id)); ?>"><?php echo LYCommon::truncate_longstr($v->article_title,20); ?></a><span><?php echo LYCommon::subtime($v->add_time,3); ?></span></li>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                </div>
                <div class="index_box fr">
                    <dl class="bl">
                        <dt>
                            <span>平台公告</span>
                            <a href="<?php echo Yii::app()->controller->createUrl("article/list", array("p" => "company", "cat" => "site")); ?>">更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
                        </dt>
                        <dd>
                            <ul>
                                <?php foreach($company_list as $k=>$v){ ?>
                                	<li><a href="<?php echo Yii::app()->controller->createUrl('article/view', array('id' => $v->article_id)); ?>"><?php echo LYCommon::truncate_longstr($v->article_title,20); ?></a><span><?php echo LYCommon::subtime($v->add_time,3); ?></span></li>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="index_news ba clear">
                <div class="index_box fl">
                    <dl>
                        <dt>
                            <span>公司动态</span>
                            <a href="<?php echo Yii::app()->controller->createUrl("article/list", array("p" => "company", "cat" => "dynamic")); ?>">更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
                        </dt>
                        <dd>
                            <ul>
                            	<?php foreach($dyanmic_list as $k=>$v){ ?>
                                	<li><a href="<?php echo Yii::app()->controller->createUrl('article/view', array('id' => $v->article_id)); ?>"><?php echo LYCommon::truncate_longstr($v->article_title,20); ?></a><span><?php echo LYCommon::subtime($v->add_time,3); ?></span></li>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                </div>
                <div class="index_box fr">
                    <dl class="bl">
                        <dt>
                            <span>行业新闻</span>
                            <a href="<?php echo Yii::app()->controller->createUrl("article/list", array("p" => "company", "cat" => "industry")); ?>">更多<i class="fontello">&#xe83f;&#xe83f;</i></a>
                        </dt>
                        <dd>
                            <ul>
                                <?php foreach($industry_list as $k=>$v){ ?>
                                	<li><a href="<?php echo Yii::app()->controller->createUrl('article/view', array('id' => $v->article_id)); ?>"><?php echo LYCommon::truncate_longstr($v->article_title,20); ?></a><span><?php echo LYCommon::subtime($v->add_time,3); ?></span></li>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
            <h1 class="index_tit">
                <span>合作伙伴</span>
            </h1>
            <div class="index_partner bt bl br">
                <ul class="clear">
                	<?php foreach($link_list as $k=>$v){ ?>
	                    <li><a target="_blank" href="<?php echo empty($v->link_url) ? "" : $v->link_url; ?>"><img src="<?php echo SITE_UPLOAD.'link/'.$v->link_pic; ?>" style="width:125px;" alt="<?php echo $v->link_name; ?>" /></a></li>
	                <?php } ?>
                </ul>
            </div>
        </div>
        <!-- 主体 结束 -->