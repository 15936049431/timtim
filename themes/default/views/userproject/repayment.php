<?php if(!empty($message)){ ?>
<script>
	pointererror('<?php echo $message; ?>', {shift: 6});
</script>
<?php } ?>
<?php if(!empty($success)){ ?>
<script>
	pointermsgpar('<?php echo $success['0']; ?>','<?php echo $success['1']; ?>','<?php echo $success['2']; ?>','<?php echo $success['3']; ?>');  
</script>
<?php } ?>