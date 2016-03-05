<?php

class OperetionController extends BController{
    public function actionList(){
        $model = Authitem::model();
        $operetion_list = $model->findAll(array(
            'condition'=>'type = 0'
        ));
        $this->render('list',array(
            'operetion_list'=>$operetion_list,
        ));
    }
    public function actionCreate($taskname=null){
        $auth = Yii::app()->authManager;
        $model = new Authitem;
        if(empty($taskname)){
            die('请选择任务');
        }
        $taskinfo = $model->findByAttributes(array('name'=>$taskname,'type'=>'1'));
        if(empty($taskinfo)){
            die('没有此任务');
        }
        
        if(isset($_POST['Authitem'])){
            $model->attributes = $_POST['Authitem'];
            $model->type = 0;
            if($model->save()){
                $authchild = new Authitemchild;
                $authchild -> parent = $taskinfo->name;
                $authchild -> child = $model->name;
                $authchild -> save();
                Yii::app()->user->setFlash('success','操作添加成功！');
                $this->redirect(Yii::app()->controller->createUrl('task/list'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate($name){
        $model = self::loadmodel($name);
        if(isset($_POST['Authitem'])){
            $model->attributes = $_POST['Authitem'];
            if($model->save()){
                Yii::app()->user->setFlash('success','操作更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('operetion/list'));
            }
        }
        $this->render('update',array(
            'model'=>$model,
        ));
    }
    
    public function actionAjaxdeldata($name){
        $model = self::loadmodel($name);
        $transaction = Yii::app()->db->beginTransaction();
        try{
            if($model->delete()){
                $authchild_model = Authitemchild::model();
                $authchild_model->deleteAllByAttributes(array('parent'=>$model->name));
                $authchild_model->deleteAllByAttributes(array('child'=>$model->name));
            }
            $transaction ->commit();
            echo json_encode(1);
        }  catch (Exception $e){
            $transaction ->rollback();
            die('删除错误');
        }
    }
    
    public function loadmodel($name){
        return Authitem::model()->findByPk($name);
    }
}