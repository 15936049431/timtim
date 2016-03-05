<?php
class SystemController extends BController{
    
    public function actionList(){
        $model = System::model();
        $criteria = new CDbCriteria;
        if(isset($_GET['System'])){
                $model->attributes=$_GET['System'];
                if(!empty($model->systemcat_id)){
                    $criteria ->compare('systemcat_id', $model->systemcat_id);
                }
        }
        
        $total_count = $model ->count($criteria);
        $page = new Pagination($total_count,10);
        $page_list = $page->fpage(array(4,5,6, 3, 7 ,0,2));
        $page_list = $total_count<=$page->limitnum?"":$page_list;
        $criteria -> limit = $page->limitnum;
        $criteria -> offset = $page->offset;
        $system_list = $model->findAll($criteria);
        
        $system_cat_model = Systemcat::model();
        $system_cat_list = $system_cat_model ->findAll();
        $system_arr = array('0'=>'全部');
        foreach($system_cat_list as $k => $v){
            $system_arr[$v->systemcat_id] = $v->systemcat_name;
        }
        $this->render('list',array(
            'model'=>$model,
            'system_list'=>$system_list,
            'page_list'=>$page_list,
            'system_arr'=>$system_arr,
        ));
    }
    
    public function actionCreate(){
        $model = new System;
        if(isset($_POST['System'])){
            $model -> attributes = $_POST['System'];
            $model -> add_time = time();
            $model -> isdefault = 1;
            if(!empty($model -> data)){
                $model -> data = explode(';', trim($model -> data,';'));
                $data = array();
                foreach($model -> data as $k => $v){
                    $data_son = explode(',', $v);
                    $data[$data_son[0]] = $data_son[1];
                }
                $model -> data = json_encode($data);
            }
            if($model -> save()){
                Yii::app()->user->setFlash('success','字段添加成功！');
                $this->redirect(Yii::app()->controller->createUrl('system/list'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate($id){
        $model = self::loadmodel($id);
        if(isset($_POST['System'])){
            $model -> attributes = $_POST['System'];
            $model -> update_time = time();
            if(!empty($model -> data)){
                $model -> data = explode(';', trim($model -> data,';'));

                $data = array();
                foreach($model -> data as $k => $v){
                    $data_son = explode(',', $v);
                    $data[$data_son[0]] = $data_son[1];
                }
                $model -> data = json_encode($data);
            }
            if($model->save()){
                Yii::app()->user->setFlash('success','字段编辑成功！');
                $this->redirect(Yii::app()->controller->createUrl('system/list'));
            }
        }
        $model -> data = json_decode($model -> data);
        $data = null;
        if(!empty($model -> data)){
            foreach($model -> data as $k => $v){
                $data .= $k.','.$v.';';
                $model -> data = $data;
            }
        }
        $this->render('update',array(
            'model'=>$model,
        ));
    }
    
    /*
    * 删除单条记录
    */
    public function actionAjaxdelete($id){
        $model = self::loadmodel($id);
        if($model->delete()){
            echo json_encode(1);
            die;
        }else{
            echo json_encode(0);
            die;
        }
    }
    
    /*
    * 批量删除
    */
    public function actionAjaxdelmore(){
        if(isset($_POST['delarr'])){
            $del_result = array('status'=>0);
            $model = System::model();
            if($model->deleteAllByAttributes(array('system_id'=>$_POST['delarr']))){
                $del_result['status'] = 1;
            }else{
                $del_result['message'] = '删除失败';
            }
            echo json_encode($del_result);
        }
    }
    
    public function getcats(){
        $systemcat_model = Systemcat::model();
        $systemcat_list = $systemcat_model->findAll();
        $systemcat_arr = array('0'=>'-- 请选择 --');
        foreach($systemcat_list as $k => $v){
            $systemcat_arr[$v->systemcat_id] = $v->systemcat_name;
        }
        return $systemcat_arr;
    }
    
    public function actionSeting($systemcatid=null){
        if(empty($systemcatid)){
           die('输入有误'); 
        }
        require_once(WWWPATH . DS .'protected'.DS.'config'.DS.'inputtype.php');
        $system_model = System::model();
        $systemcat_model = Systemcat::model();
        
        $systemcat_info = $systemcat_model->findByPk($systemcatid);
        if(isset($_POST[$systemcat_info->systemcat_alias])){
            foreach($_POST[$systemcat_info->systemcat_alias] as $k => $v){
                $system_info = $system_model->findByAttributes(array('system_alias'=>$k));
                if($system_info->input_type == 5){
                    $v = json_encode($v);
                }
                if($system_info->input_type == 6){
                    $v = $v['hidden'];
                    $image=CUploadedFile::getInstanceByName($systemcat_info->systemcat_alias.'['.$system_info->system_alias.']');
                    if($image) {
                        if($image->extensionName!='jpg' && $image->extensionName!='jpeg' && $image->extensionName!='png')
                            die('上传文件非法');
                        if(!empty($image)){
                                $dir=dirname(Yii::app()->basePath).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'servers'.DIRECTORY_SEPARATOR;
                                if(!is_dir($dir)) {
                                        die('文件夹不存在');
                                }
                                $name=time().strtolower(rand(1000,9999)).strrchr($image->name,'.');
                                $image->saveAs($dir.$name);
                                $v=$name;
                                LYCommon::saveThumb($dir.$name, $dir.'s_'.$name);    //保存图像的时候，生成缩略图。
                        }
                    }
                }
                $system_info -> system_value = $v;
                $system_info->save();
            }
            Yii::app()->user->setFlash('success','保存成功！');
        }
        
        $seting_list = $system_model->findAllByAttributes(array('systemcat_id'=>$systemcatid));
        
        
        $this->render('seting',array(
            'systemcat_info'=>$systemcat_info,
            'seting_list'=>$seting_list,
        ));
    }
    
    public function loadmodel($id){
        return System::model()->findByPk($id);
    }
}