<?php
$this->css = array("about", "user");
$this->js = array("layer.m");
?> 
		<?php if(!empty($success)){ ?>
	        <script>
		        msg("<?php echo $success[0]?>","<?php echo $success[1]?>");
	        </script>
	    <?php } ?>
