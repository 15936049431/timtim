<?php 
	$this->page_title = "绑定银行卡" ;
?>
					<div class="user_money_main">
                        <h1 class="user_tit"><span>我的银行卡</span></h1>
                        <dl class="user_cark_list clear">
                        <?php foreach($bank_list as $k=>$v){ ?>
                            <dd attr="<?php echo $v->b_id ?>">
                                <div class="bank_logo"><em><img src="<?php echo UIMG_URL; ?>bank/<?php echo $v->item->i_nid; ?>.jpg" alt="" /></em></div>
                                <div class="unionpay"></div>
                                <div class="card_info clear">
                                    <h3 style="font-size:14px;"><?php echo empty($v->province) || empty($v->city) ? "" : $v->province->name.$v->city->name; ?>储蓄卡</h3>
                                    <p><?php echo LYCommon::half_replace($v->b_cardNum); ?></p>
                                </div>
                            </dd>
                        <?php } ?>
                        <?php if($user_bank<3){ ?>
	                        <dt onclick="openWindow('添加银行卡','500','450','<?php echo Yii::app()->controller->createUrl('usercenter/bankedit');?>');"><em>添加银行卡</em></dt>
	                    <?php } ?>
                        </dl>
                        <input type="hidden" name="open_bank" value="" />
                        <div class="user_mone_desc mt20">
                            <p>* 温馨提示：网上银行充值过程中请耐心等待,充值成功后，请不要关闭浏览器,充值成功后返回皖平财富,充值金额才能打入您的帐号。<i>如有问题，请与我们联系；线下充值如遇到问题，请马上与客服联系联系；</i></p>
                            <p><i>（1）线下充值奖励充值金额的千分之二，建议留有小数以便皖平财富查询，如10000.08。</i></p>
                            <p><i>（2）有效充值登记时间为:周一至周五的9:00到16:00，充值成功请跟我们的客服联系。</i></p>
                        </div>
                    </div>
<script>
	$(".user_cark_list dd").click(function(){
		var _id = $(this).attr("attr");
		$(this).addClass("sel").siblings("dd").removeClass("sel");
		$("input[name='open_bank']").val(_id);
	});
	$(".user_cark_list dd:first").click();
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>');
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsgpar('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>