<?php

class ManagerController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Manager::model();
            $total_count = $model->count();
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $manager_list = $model->findAll(array(
                'limit'=>$page->limitnum,
                'offset'=>$page->offset,
            ));
            $this->render('list',array(
                'model'=>$model,
                'manager_list'=>$manager_list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建文章
         */
        public function actionCreate(){
            $model = new Manager('create');
            $authassign_model = new Authassignment;
            if(isset($_POST['Manager'])){
                $model->attributes = $_POST['Manager'];
                $model->manager_id = LYCommon::getInsertId();
                if(!empty($model->google_status)){
                    $model->google_secret=  LYCommon::zjy_encode(LYCommon::setGoogleCode(),$model->manager_name);
                }
                $model->add_time = time();
                if($model->validate()){
                    if(isset($_POST['Authassignment'])){
                        if(!empty($_POST['Authassignment']['itemname'])){
                            $model->manager_pass = LYCommon::get_pass($model ->manager_id, $model -> manager_pass);
                            if($model->insert()){
                                if($_POST['Authassignment']['itemname'] == 'issuper'){
                                    $model->issuper = 1;
                                    $model -> update();
                                }else{
                                    $authassign_model -> itemname = $_POST['Authassignment']['itemname'];
                                    $authassign_model -> userid = $model->manager_id;
                                    if($authassign_model->save()){

                                    }
                                }
                                Yii::app()->user->setFlash('success','管理员添加成功！');
                                $this->redirect(Yii::app()->controller->createUrl('manager/list'));
                            }
                        }else{
                            $authassign_model->addError('itemname', '角色不能为空');
                        }
                    }else{
                        $authassign_model->addError('itemname', '角色不能为空');
                    }
                }
            }
            $this->render('create',array(
                'model'=>$model,
                'authassign_model'=>$authassign_model,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            $authassign_model = new Authassignment;
            $authassign_info = Authassignment::model()->findByAttributes(array('userid'=>$id));
            if(!empty($authassign_info)){
                if(!empty($model->issuper)){
                    $authassign_model -> itemname = 'issuper';
                }else{
                    $authassign_model = $authassign_info;
                }
            }else{
                if(!empty($model->issuper)){
                    $authassign_model -> itemname = 'issuper';
                }
            }
            $model -> scenario = 'update';
            if(isset($_POST['Manager'])){
                if(empty($_POST['Manager']['manager_pass'])){
                   unset($_POST['Manager']['manager_pass']); 
                   unset($_POST['Manager']['repassowrd']); 
                   $model->repassowrd = $model ->manager_pass;
                }
                $model->attributes = $_POST['Manager'];
                $model->google_secret = LYCommon::zjy_encode($model->google_secret,$model->manager_name);
                if(!empty($model->google_status) && empty($model->google_secret)){
                    $model->google_secret=  LYCommon::zjy_encode(LYCommon::setGoogleCode(),$model->manager_name);
                }
                if($model->validate()){
                    if(isset($_POST['Authassignment'])){
                        if(!empty($_POST['Authassignment']['itemname'])){
                            if($_POST['Authassignment']['itemname'] != 'issuper'){
                                $authassign_model -> itemname = $_POST['Authassignment']['itemname'];
                                $authassign_model -> userid = $model->manager_id;
                                $authassign_model -> save();
                            }else{
                                $model -> issuper = 1;
                            }
                        }
                    }
                    if(!empty($_POST['Manager']['manager_pass'])){
                        $model -> manager_pass = LYCommon::get_pass($model ->manager_id, $model -> manager_pass);
                    }
                    if($model->update()){
                        Manager::model()->updateAll(array('work_menu'=>''));//清空所有管理员work_menu字段
                        Yii::app()->user->setFlash('success','管理员更新成功！');
                        $this->redirect(Yii::app()->controller->createUrl('manager/list'));
                    }
                }
            }
            $model->google_secret = LYCommon::zjy_decode($model->google_secret,$model->manager_name);
            $google_img = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
            if(!empty($model->google_secret)){
                $google_img = GoogleAuthenticator::getQRCodeGoogleUrl($model->manager_name,$model->google_secret);
            }
            $this->render('update',array(
                'model'=>$model,
                'authassign_model'=>$authassign_model,
                'google_img'=>$google_img,
            ));                    
        }
        
        /*
         * 删除
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
                $model = Manager::model();
                if($model->deleteAllByAttributes(array('manager_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        
        public function Getrole(){
            $authitem = Authitem::model();
            $criteria = new CDbCriteria;
            $criteria->addCondition('type = 2');
            $criteria->addNotInCondition('name', Yii::app()->authManager->defaultRoles);
            $authitem_role_list = $authitem->findAll($criteria);
            $authitem_role_arr = array('0'=>'-- 请选择角色 --','issuper'=>'超级管理员');
            foreach($authitem_role_list as $k => $v){
                $authitem_role_arr[$v->name] = $v->realname;
            }
            return $authitem_role_arr;
        }
        
        /*
         * 重新生成二维码
         */
        
        public function actionAjaxrecreate(){
            $ga = new GoogleAuthenticator();
            $recreate_result = array('status'=>0);
            if($secret = $ga->createSecret()){//生成密钥，随机值
                $recreate_result['status'] = 1;
                $recreate_result['key'] = $secret;
                $recreate_result['googleImg'] = $ga->getQRCodeGoogleUrl(Yii::app()->user->name, $recreate_result['key']);
            }      
            
            echo json_encode($recreate_result);
            
        }
        
        public function loadmodel($id){
            return Manager::model()->findByPk($id);
        }
}