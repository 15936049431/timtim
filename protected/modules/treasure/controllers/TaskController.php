<?php

class TaskController extends BController{
    public function actionList(){
        $model = Authitem::model();
        $task_list = $model->findAll(array(
            'condition'=>'type = 1'
        ));
        $this->render('list',array(
            'task_list'=>$task_list,
        ));
    }
    
    public function actionCreate(){
        $auth = Yii::app()->authManager;
        $model = new Authitem;
        
        if(isset($_POST['Authitem'])){
            $model->attributes = $_POST['Authitem'];
            $model -> realname = $model->name;
            $model->type = 1;
            if($model->save()){
                Manager::model()->updateAll(array('work_menu'=>''));//清空所有管理员work_menu字段
                Yii::app()->user->setFlash('success','任务添加成功！');
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
            $model -> realname = $model->name;
            if($model->save()){
                Manager::model()->updateAll(array('work_menu'=>''));//清空所有管理员work_menu字段
                Yii::app()->user->setFlash('success','任务更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('task/list'));
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
    
    public function actionGiveauth($name){
        $authitem = self::loadmodel($name);
        $connection = Yii::app()->db;
        $parentrole_list = $connection->createCommand("SELECT parent FROM {{authitemchild}} INNER JOIN {{authitem}} ON parent = `name` WHERE child = '{$name}' AND type = 2")->queryAll();
        $parenttask_list = $connection->createCommand("SELECT {{authitemchild}}.*,{{authitem}}.* FROM {{authitemchild}} INNER JOIN {{authitem}} ON parent = `name` WHERE child = '{$name}' AND type = 1")->queryAll();
        $childtask_list = $connection->createCommand("SELECT {{authitemchild}}.*,{{authitem}}.* FROM {{authitemchild}} INNER JOIN {{authitem}} ON child = name WHERE parent = '{$name}' and type = 1")->queryAll();
        $childoperetion_list = $connection->createCommand("SELECT {{authitemchild}}.*,{{authitem}}.* FROM {{authitemchild}} INNER JOIN {{authitem}} ON child = name WHERE parent = '{$name}' and type = 0")->queryAll();
        
        $apr_list = $connection->createCommand("SELECT * FROM {{authitem}} WHERE type = 2 AND name <> '{$name}' AND name NOT IN ('".str_replace(",","','",implode(',',Yii::app()->authManager->defaultRoles))."') AND name NOT IN (SELECT parent FROM {{authitemchild}} WHERE child = '{$name}')")->queryAll();//可以添加的父角色
        $apt_list = $connection->createCommand("SELECT * FROM {{authitem}} WHERE type = 1 AND name <> '{$name}' AND name NOT IN (SELECT child FROM {{authitemchild}} WHERE parent = '{$name}' UNION SELECT parent FROM {{authitemchild}} WHERE child = '{$name}')")->queryAll();//可以添加的父任务
        $aco_list = $connection->createCommand("SELECT * FROM {{authitem}} WHERE type = 0 AND name NOT IN (SELECT child FROM {{authitemchild}} WHERE parent = '{$name}')")->queryAll();//可以添加的子操作
        $this->render('giveauth',array(
            'authitem'=>$authitem,
            'parentrole_list'=>$parentrole_list,
            'parenttask_list'=>$parenttask_list,
            'childtask_list'=>$childtask_list,
            'childoperetion_list'=>$childoperetion_list,
            'apr_list'=>$apr_list,
            'apt_list'=>$apt_list,
            'aco_list'=>$aco_list,
        ));
    }
    
    public function actionAjaxgiveauth(){
        if(isset($_POST['Giveauth'])){
            $giveauth_post = $_POST['Giveauth'];
            $giveauth_result = array('status'=>0);
            $authchild = new Authitemchild;
            if($giveauth_post['type']==2 || $giveauth_post['type'] == 1){
                $authchild->parent = $giveauth_post['cone'];
                $authchild->child = $giveauth_post['ctwo'];
                
            }else{
                $authchild->parent = $giveauth_post['ctwo'];
                $authchild->child = $giveauth_post['cone'];
            }
            if($authchild->save()){
                Manager::model()->updateAll(array('work_menu'=>''));//清空所有管理员work_menu字段
                $giveauth_result['status'] = 1;
            }else{
                $giveauth_result['message'] = '添加失败';
            }
            echo json_encode($giveauth_result);
        }
    }
    
    public function actionAjaxremoveauth(){
        if(isset($_POST['Removeauth'])){
            $removeauth_post = $_POST['Removeauth'];
            $removeauth_result = array('status'=>0);
            $authitemchild_model = Authitemchild::model();
            if($removeauth_post['type'] == 2 || $removeauth_post['type'] == 1){
                $authitemchild_info = $authitemchild_model ->findByAttributes(array('parent'=>$removeauth_post['cone'],'child'=>$removeauth_post['ctwo']));
            }else{
                $authitemchild_info = $authitemchild_model ->findByAttributes(array('parent'=>$removeauth_post['ctwo'],'child'=>$removeauth_post['cone']));
            }
            if(!empty($authitemchild_info)){
                if($authitemchild_info->delete()){
                    Manager::model()->updateAll(array('work_menu'=>''));//清空所有管理员work_menu字段
                    $removeauth_result['status'] = 1;
                    $removeauth_result['message'] = '删除成功';
                    
                }
            }else{
                $removeauth_result['message'] = '没有此项';
            }
            echo json_encode($removeauth_result);
        }
    }
    
    public function loadmodel($name){
        return Authitem::model()->findByPk($name);
    }
}