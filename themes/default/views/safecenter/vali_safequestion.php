<!doctype html>
<html>
<meta charset="utf-8">
    <body>
        <link href="<?php echo CSS_URL; ?>layout.css" rel="stylesheet" />
<link href="<?php echo CSS_URL; ?>user.css" rel="stylesheet" />
<script src="<?php echo JS_URL; ?>jquery.min.js"></script> 
<script src="<?php echo JS_URL; ?>layer/layer.js"></script> 
<script src="<?php echo JS_URL; ?>7pointer.js"></script> 
<?php 
   	if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")) {
		$script="<script src='".JS_URL."layer-old/layer.min.js'></script><script src='".JS_URL."7pointer.js'></script>";
	  }elseif(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
		$script="<script src='".JS_URL."layer-old/layer.min.js'></script><script src='".JS_URL."7pointer.js'></script>";
	  }else{
	  	$script="<script src='".JS_URL."layer/layer.js'></script><script src='".JS_URL."7pointer_back.js'></script>";
	  }
	  echo $script;
?>
<div class="tc_container2">
<?php $form = $this -> beginWidget('CActiveForm',array(

)); ?>
<div class="tc_con">
    <table>
        <tr>
            <td>安全保护问题一</td>
            <td>
                <?php echo LYCommon::GetItem_of_id($safequestion_info->name_one, 'safequestion'); ?>
            </td>
        </tr>
        <tr>
            <td>问题答案一</td>
            <td>
                <?php echo $form->textField($safequestion_model,'answer_one',array('class'=>'tc_text1','placeholder'=>'请输入密保答案')); ?>
            </td>
        </tr>   
        <tr>
            <td>安全保护问题二</td>
            <td>
                <?php echo LYCommon::GetItem_of_id($safequestion_info->name_two, 'safequestion'); ?>
            </td>
        </tr>
        <tr>
            <td>问题答案二</td>
            <td>
                <?php echo $form->textField($safequestion_model,'answer_two',array('class'=>'tc_text1','placeholder'=>'请输入密保答案')); ?>
            </td>
        </tr>   
        <tr>
            <td>安全保护问题三</td>
            <td>
                <?php echo LYCommon::GetItem_of_id($safequestion_info->name_three, 'safequestion'); ?>
            </td>
        </tr>
        <tr>
            <td>问题答案三</td>
            <td>
                <?php echo $form->textField($safequestion_model,'answer_three',array('class'=>'tc_text1','placeholder'=>'请输入密保答案')); ?>
            </td>
        </tr>   
        <tr>
	    <td></td>
            <td>
                <ul>
                    <li><button type='button' onclick="parent.layer.closeAll();" id="tc_out3" value="取消">取消</button></li>
                    <li><button id="tc_in2" type='submit' value="验证">验证</button></li>
                </ul>
            </td>
        </tr>
    </table>
</div>
<?php $this -> endWidget(); ?>
</div>
<script type="text/javascript">
    var arr = new Array();
        arr.push('<?php echo $safequestion_model->name_one; ?>');
        arr.push('<?php echo $safequestion_model->name_two; ?>');
        arr.push('<?php echo $safequestion_model->name_three; ?>');
        
        $(".tc_select").each(function(xb){
            var the_val = $(this).val();
            $(this).children().show();
            $(this).children().each(function(){
                for(var i = 0; i<arr.length;i++){
                    if(arr[i]==$(this).val() && arr[i] != 0 && arr[i] != the_val){
                        $(this).hide();
                    }
                }
           });
        });
        
    $(".tc_select").each(function(se_num){
        $(this).change(function(){
            arr = [];
            $(".tc_select").each(function(xb){
                arr.push($(this).val());
            });
            $(".tc_select").each(function(xb){
                var the_val = $(this).val();
                if(se_num != xb){
                    $(this).children().show();
                    $(this).children().each(function(){
                        for(var i = 0; i<arr.length;i++){
                            if(arr[i]==$(this).val() && arr[i] != 0 && arr[i] != the_val){
                                $(this).hide();
                            }
                        }
                   });
                }
            });
        });
    });
</script>
<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>', 6);
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsgpar('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>
</body>
</html>