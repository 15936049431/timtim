<?php

class ExtendController extends BController{
    public function actionPhotoshow($photourl){
        $this->renderPartial('photoshow',array(
            'photourl'=>$photourl,
        ));
    }
}