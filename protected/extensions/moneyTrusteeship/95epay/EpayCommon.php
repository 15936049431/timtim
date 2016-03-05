<?php

class EpayCommon{
    public $web_mark = '';
    public $acc_url = null;
    public $ReturnURL = null;
    public $NotifyURL = null;
    
    public function onsubmit($data){
        $this->renderPartial('//');
    }
}