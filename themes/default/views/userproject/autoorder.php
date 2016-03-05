<?php 
	$this->page_title = "理财助手" ;
?>
				<div class="user_money_main">
                        <dl class="user_money_tab clear">
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/invite"); ?>">邀请好友</a></dd>
                            <dd class="sel"><a href="#">理财助手</a></dd>
                            <dd><a href="<?php echo Yii::app()->controller->createUrl("usercenter/message"); ?>">系统消息</a></dd>
                        </dl>
                        <?php $form = $this->beginWidget('CActiveForm',array(
    						'htmlOptions'=>array('name'=>'auto_order'),
    					)); ?>
                            <table>
                                <tr>
                                    <td>账户可用余额:</td>
                                    <td>&nbsp;&nbsp;<?php echo $user_assets->real_money; ?>元</td>
                                </tr>
                                <tr>
                                    <td>待收金额:</td>
                                    <td>&nbsp;&nbsp;<?php echo $user_assets->wait_total_money; ?>元</td>
                                </tr>
                                <tr>
                                    <td><i>*</i>自动状态:</td>
                                    <td>&nbsp;&nbsp;
                                    	<?php echo $form->radioButtonList($model,'p_order_status',array('0'=>'关闭','1'=>'开启'),array('template'=>'{input}{label}&nbsp;&nbsp;','separator'=>'')); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i>*</i>当前自动排名:</td>
                                    <td>&nbsp;&nbsp;第<?php echo $cnt; ?>位</td>
                                </tr>
                                <tr>
                                    <td><i>*</i>排位等待资金:</td>
                                    <td>&nbsp;&nbsp;约<?php echo $sum; ?>元</td>
                                </tr>
                                <tr>
                                    <td>最多投标金额:</td>
                                    <td><?php echo $form->textField($model,'p_order_maxmoney',array('class'=>'my_text','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>元</td>
                                </tr>
                                <tr>
                                    <td>最小投标金额:</td>
                                    <td><?php echo $form->textField($model,'p_order_minmoney',array('class'=>'my_text','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>元</td>
                                </tr>
                                <tr>
                                    <td>年化利率范围:</td>
                                    <td><?php echo $form->textField($model,'p_order_minapr',array('style'=>'width:80px;','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?> -
                            			<?php echo $form->textField($model,'p_order_maxapr',array('style'=>'width:80px;','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>%</td>
                                </tr>
                                <tr>
                                    <td>投标期限范围:</td>
                                    <td><?php echo $form->textField($model,'p_order_minmonth',array('style'=>'width:80px;','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?> -
                            			<?php echo $form->textField($model,'p_order_maxmonth',array('style'=>'width:80px;','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>月</td>
                                </tr>
                                <tr>
                                    <td>保留金额:</td>
                                    <td><?php echo $form->textField($model,'p_retain',array('class'=>'my_text','onkeyup'=>"value = value.replace(/[^0-9]/g, '')")); ?>元</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="clear">
                                        <input type="button" id="SUB" class="btn" value="立即设置" />
                                    </td>
                                </tr>
                            </table>
                        <?php $this->endWidget(); ?>
                        <div class="user_mone_desc mt20">
                        	<p><i>1、自动投标成功后，排名移到队尾 </i></p>
                            <p><i>2、当贷款进入招标中后，自动投标程序即开始运行(自动方式优先于手动方式)。</i></p>
                            <p><i>3、修改自动投标设置，不影响排名。关闭自动投标功能后再次开启，排名移到队尾。</i></p>
                            <p><i>排在您前面的自动投标总资金，仅供参考（实时变化），比实际的略偏大。</i></p>
                        </div>
                    </div>
<script>
$("#SUB").click(function(){
    var use_money=<?php echo $user_assets->real_money; ?>;
    var project_minmoney=$("input[name='ProjectAutoorder[p_order_maxmoney]']");
    var project_maxmoney=$("input[name='ProjectAutoorder[p_order_maxmoney]']");
    var project_minapr=$("input[name='ProjectAutoorder[p_order_minapr]']");
    var project_maxapr=$("input[name='ProjectAutoorder[p_order_maxapr]']");
    var project_minmonth=$("input[name='ProjectAutoorder[p_order_minmonth]']");
    var project_maxmonth=$("input[name='ProjectAutoorder[p_order_maxmonth]']");
    var project_retain=$("input[name='ProjectAutoorder[p_retain]']");
    var project_status=$("input[name='ProjectAutoorder[p_order_status]']");
    var error=0;
    if(parseInt(use_money)<parseInt(project_retain.val()) || parseInt(project_retain.val())<0){
    		pointererror('保留余额必须是整数且不能大于可用余额', 6);
            error++;
    }
    if(parseInt(project_minmoney.val())<50 || parseInt(project_minmoney.val())>=100000){
    		pointererror('最小投标金额最少50元，最大100000元', 6);
            error++;
    }
    if(parseInt(project_minmoney.val())>parseInt(project_maxmoney.val()) || parseInt(project_maxmoney.val())>=100000){
            pointererror('最小投标金额最少50元，最大100000元', 6);
            error++;
    }
    if(parseInt(project_minapr.val())>parseInt(project_maxapr.val()) || parseInt(project_minapr.val())<10 || parseInt(project_maxapr.val())>30){
            pointererror('最大利率不能小于最小利率，并且不能为负数,最低为10%', 6);
            error++;
    }
    if(parseInt(project_minmonth.val())>parseInt(project_maxmonth.val()) || parseInt(project_minmonth.val())<1 || parseInt(project_maxmonth.val())>24){
            pointererror('投标期限设置有误,请检查', 6);
            error++;
    }
    if(project_minmoney.val()=="" || project_maxmoney.val()=="" || project_minapr.val()=="" || project_maxapr.val()=="" || project_minmonth.val()=="" || project_maxmonth.val()=="" || project_retain.val()==""){
            pointererror('参数不能为空！', 6);
            error++;
    }
    if(error==0){
            document.auto_order.submit();
    }
});
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>', 6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsg('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>