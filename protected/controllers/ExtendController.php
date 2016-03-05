<?php

class ExtendController extends Controller{
    public function actionBackUploadPic(){
        $verifyToken = md5('treasure' . $_POST['timestamp']);
        if($_POST['token'] != $verifyToken){
            return false;
        }
        $pic_name = $_FILES['Filedata']['name'];
        $image=CUploadedFile::getInstanceByName("Filedata");
        $project_pic_model = new ProjectPic;
        $project_pic_model -> p_id = LYCommon::getInsertID();
        $project_pic_model -> p_project_id = $_POST['project_id'];
        $project_pic_model -> p_user_id = $_POST['pub_user_id'];
        if($image) {
            if($image->extensionName!='jpg' && $image->extensionName!='jpeg' && $image->extensionName!='png' && $image->extensionName!='gif')
                die('上传文件非法');
                if(!empty($image)){
                    $dir=dirname(Yii::app()->basePath).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'projectpic'.DIRECTORY_SEPARATOR;
                    if(!is_dir($dir)) {
                        mkdir($dir);
                        if(!is_dir($dir)){
                            die('文件夹不存在');
                        }
                    }
                    $name=time().strtolower(rand(1000,9999)).strrchr($image->name,'.');
                    $project_pic_model -> p_pic = $project_pic_model -> p_project_id;
                    $project_pic_model -> p_src = $name;
                    $image->saveAs($dir.$name);
                    LYCommon::saveThumb($dir.$name, $dir.'s_'.$name);    //保存图像的时候，生成缩略图。
            }
        }
        $project_pic_model->p_addtime = time();
        $project_pic_model->p_addip = Yii::app()->request->userHostAddress;
        $project_pic_model -> save();
        
        echo json_encode(array('pic_name'=>$name));
    }
}