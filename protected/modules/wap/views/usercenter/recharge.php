<div class="container-fluid pd-20">
		<?php $form = $this->beginWidget('CActiveForm',array("id"=>"chongzhi",
		  "htmlOptions"=>array(
				)
			)
		  ); ?>
		  <div class="form-group">
			<label for="money">充值金额</label>
			<?php echo $form->NumberField($model,'r_money',array('class'=>'form-control','placeholder'=>'请填写充值金额',"required"=>"required")); ?>
		  </div>
		  <div class="form-group">
			<label for="type">支付平台</label>
			 <div class="input-group">
			 <div class="input-group-addon">●</div>
			  <input type="text" class="form-control" id="type" value="钱多多在线支付" disabled="disabled">
			 </div>
		  </div>
		  <input type="hidden" name="AssetsRecharge[r_recharge_type]" id="recharge" value="1" />
		  <input type="hidden" name="type" value="nav1" />
		  <button type="submit" class="btn btn-default" style="width:100%;margin-top:20px;">充值</button>
		<?php $this->endWidget(); ?>
</div>
<?php if (!empty($message)) { ?>
    <script>msg('<?php echo $message[0]; ?>','<?php echo empty($message[1]) ? "" : $message[1]; ?>');</script>
<?php } ?>