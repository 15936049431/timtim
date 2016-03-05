<?php
    $this -> js = array('laydate/laydate');
    $this -> page_title = '债权转让';
?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>layout.css" />
<div id="usermain"class="fr">
      <div id="zj_gaikuang1">
       <div class="slideTxtBox">
			<div class="hd" id="zj_nav">
				<ul>
				<li class="on" onclick="window.location.href='<?php echo Yii::app()->controller->createUrl("userproject/debt"); ?>'">可以转让的债权</li>
				<li onclick="window.location.href='<?php echo Yii::app()->controller->createUrl("userproject/debting"); ?>'">正在转让的债权</li>
				<li onclick="window.location.href='<?php echo Yii::app()->controller->createUrl("userproject/assignsuccess"); ?>'">成功转让的债权</li>
				<li onclick="window.location.href='<?php echo Yii::app()->controller->createUrl("userproject/debtsuccess"); ?>'">成功购买的债权</li>
				</ul>
			</div>
			<div class="bd">
				<ul class="infoList">
					<?php $form = $this->beginWidget('CActiveForm',array(
						'method'=>'GET',
						'action'=>Yii::app()->controller->createUrl('userproject/order_list'),
						'htmlOptions'=>array(
							'name'=>'form_search'
						),
					)); ?>
    				
					<?php $this->endWidget(); ?>
                    <div class="cz_info">
                         <table>
						    <tr class="cz_tit">
							    <th>借款者</th>
								<th>借款标</th>
								<th>投标总额</th>
								<th>债权金额</th>
								<th>预期收益</th>
								<th>投标时间</th>
								<th>操作</th>
							</tr>
							<?php foreach($list as $k=>$v){ ?>
							<tr>
								<td><?php echo $v->project->user->user_name; ?></td>
								<td><a target="_blank" href="<?php echo Yii::app()->controller->createUrl('project/tender',array('id'=>$v->p_project_id)); ?>"><?php echo LYCommon::truncate_longstr($v->project->p_name,7); ?></a></td>
								<td>￥<?php echo $v->p_realmoney; ?></td>
								<td>￥<?php echo LYCommon::sprintf_diy($v->p_repayaccount-$v->p_repayyesaccount); ?></td>
								<td>￥<?php echo $v->p_waitinterest; ?></td>
								<td><?php echo LYCommon::subtime($v->p_addtime,3); ?></td>
								<td><a href="javascript:;" attr="<?php echo $v->p_id; ?>" class="debting">转让</a></td>
							</tr>
							<?php } ?>
						 </table>
					</div>
					<div class="list">
				      <?php echo $page_list; ?>
				    </div>
				</ul>
		    </div>
      </div>
     </div>
   </div>

<script type="text/javascript">
    $(".debting").click(function(){
        var id = $(this).attr("attr");
        openWindow('债权转让','576','500','<?php echo Yii::app()->controller->createUrl('userproject/assignment'); ?>?id='+id);
    });
</script>

