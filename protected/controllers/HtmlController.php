<?php
 
class HtmlController extends Controller{
	
    public function actionSafe(){
        $this->render('safe');
    }
    
    public function actionsafety(){
    	$this->render("safety");
    }
	
}

?>