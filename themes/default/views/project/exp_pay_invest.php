<!--主体-->  
<div id="chetouzhi">
    <div id="touzhi"><h2><?php echo $project_info->p_name; ?><storng>标的编号：<?php echo $project_info->p_id; ?></storng></h2>
	    <div class="info">
	       <dl>
      <dd>标的总额(元)</dd>
      <dt>¥<?php echo $project_info->p_account; ?></dt>
      <dd>保障方式 本息保障</dd>
      <dd>还款方式   体验金收回，收益可提现</dd>
      <dd>最低投标额 ：<?php echo $project_info->p_lowaccount; ?></dd>
      </dl>
      
      <dl>
      <dd>年化收益率</dd>
      <dt><?php echo $project_info->p_apr; ?>%</dt>
      <dd>剩余时间 ：<span id="timer">一直有效</span></dd>
      <dd>发布时间：  <?php echo LYCommon::subtime($project_info->p_addtime,2); ?></dd>
      <dd>最高投标额 ：<?php echo $project_info->p_mostaccount==0?'不限':$project_info->p_mostaccount; ?></dd>
      </dl>
      

      <dl>
      <dd>期限(<?php echo ($project_info->p_time_limittype==1)?"天":"月"; ?>)</dd>
      <dt><?php echo $project_info->p_time_limit; ?></dt>
      </dl>

	
	      <div class="info-right" >
	       <dl >
	         <dt>剩余可投<span> ¥ <?php echo LYCommon::sprintf_diy_9($project_info->p_account-$project_info->p_account_yes); ?></span></dt>
	         <?php if(isset(Yii::app()->user->id)){ ?>
		         <dd>体验金余额：<?php echo !empty($user_assets)?$user_assets->exp_money-$user_assets->exp_use_money:0; ?>元</dd>
		         <?php $form=$this->beginWidget('CActiveForm',array(
					'htmlOptions'=>array(
						'name'=>'ProjectExporder'
					),
				));?>
		         <dd>认购金额: <?php echo $form->textField($project_order_model,'p_money',array('placeholder'=>'支付金额', 'maxlength'=>8 ,'onkeyup' => "amount(this)", 'onblur'=>"overFormat(this)",'onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?><span>元</span></dd>
                         <dd>支付密码 :<input id="pay_pass" placeholder="支付密码" name="pay_pass" type="password" /> <span>[<a href="<?php echo Yii::app()->controller->createUrl("safecenter/index"); ?>">前往设置</a>]</span></dd>
				<?php if($project_info->p_dxb!=""){ ?>
		        	 <dd>定向标密码: <?php echo $form->passwordField($project_order_model,'p_dxb',array('placeholder'=>'定向标密码')); ?></dd>
		         <?php } ?>		        
				<dd>验证码: 
		         	<?php echo $form->textField($project_order_model,'authcode',array('placeholder'=>'验证码')); ?>
	                <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'看不清楚?请点击刷新验证码','style'=>'vertical-align:middle;cursor:pointer;'))); ?>
		         </dd>
		         <dd><input type="submit" class="btn" id="SUB" value=""></dd>
		         <?php $this->endWidget();?>
	         <?php }else{ ?>
	         <dd>请不要非法操作</dd>
	         <?php } ?>
	       </dl>
	      </div>
	    </div> 
    </div>
</div>
<?php if(!empty($message)){ ?>
<script>
	layer.msg('<?php echo $message; ?>', {shift: 6});
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsg('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>
<script>
$("#ProjectExporder_p_money").keyup(function(){
		var _money = <?php echo $project_info->p_account-$project_info->p_account_yes; ?>;
		var _umoney = $(this).val();
		if(parseInt(_money) < parseInt(_umoney)){
			pointererror("您的投标金额大于可用金额",6);
			$(this).val(_money);
			//$("#SUB").attr("type","button");
		}else{
			//$("#SUB").attr("type","submit");
		}
	});
/**
 * 实时动态强制更改用户录入
 * arg1 inputObject
 **/
function amount(th) {
    var regStrs = [
        ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
        ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
        ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
        ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上
    ];
    for (i = 0; i < regStrs.length; i++) {
        var reg = new RegExp(regStrs[i][0]);
        th.value = th.value.replace(reg, regStrs[i][1]);
    }
}

/**
 * 录入完成后，输入模式失去焦点后对录入进行判断并强制更改，并对小数点进行0补全
 * arg1 inputObject
 * 这个函数写得很傻，是我很早以前写的了，没有进行优化，但功能十分齐全，你尝试着使用
 * 其实有一种可以更快速的JavaScript内置函数可以提取杂乱数据中的数字：
 * parseFloat('10');
 **/
function overFormat(th) {
    var v = th.value;
    if (v === '') {
        v = '0.00';
    } else if (v === '0') {
        v = '0.00';
    } else if (v === '0.') {
        v = '0.00';
    } else if (/^0+\d+\.?\d*.*$/.test(v)) {
        v = v.replace(/^0+(\d+\.?\d*).*$/, '$1');
        v = inp.getRightPriceFormat(v).val;
    } else if (/^0\.\d$/.test(v)) {
        v = v + '0';
    } else if (!/^\d+\.\d{2}$/.test(v)) {
        if (/^\d+\.\d{2}.+/.test(v)) {
            v = v.replace(/^(\d+\.\d{2}).*$/, '$1');
        } else if (/^\d+$/.test(v)) {
            v = v + '.00';
        } else if (/^\d+\.$/.test(v)) {
            v = v + '00';
        } else if (/^\d+\.\d$/.test(v)) {
            v = v + '0';
        } else if (/^[^\d]+\d+\.?\d*$/.test(v)) {
            v = v.replace(/^[^\d]+(\d+\.?\d*)$/, '$1');
        } else if (/\d+/.test(v)) {
            v = v.replace(/^[^\d]*(\d+\.?\d*).*$/, '$1');
            ty = false;
        } else if (/^0+\d+\.?\d*$/.test(v)) {
            v = v.replace(/^0+(\d+\.?\d*)$/, '$1');
            ty = false;
        } else {
            v = '0.00';
        }
    }
    th.value = v;
    if(v=='0.00'){
        return false;
    }
}
</script>