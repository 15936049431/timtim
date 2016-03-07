<?php

class UserController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = User::model();
			$model->unsetAttributes();
			$criteria = new CDbCriteria;
			if(isset($_GET['User'])){
				$model->attributes=$_GET['User'];
				$model -> p_user_id = $_GET['User']['p_user_id'];
			}
			if(!empty($model->user_name)){
				$criteria->compare('user_name',$model->user_name,true);
			}
			if(!empty($model->real_name)){
				$criteria->compare('real_name',$model->real_name,true);
			}
			if(!empty($model->user_email)){
				$criteria->compare('user_email',$model->user_email,true);
			}
			if(!empty($model->p_user_id)){
				$criteria->compare('p_user_id',$model->p_user_id);
			}
			if(!empty($_GET['order'])){
				if($_GET['order'] == 'register'){
					$criteria -> order = 'register_time DESC';
				}elseif($_GET['order'] == 'invite'){
					$criteria -> order = 'invite_num DESC';
				}
			}else{
				$criteria -> order = 'register_time DESC';
			}
			
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$list = $model->findAll($criteria);
				$data = array(
						array(
								"序号","ID", "用户名", "真实姓名","用户邮箱", "手机号码", "身份证号码", "性别", "年龄",  "邀请人数","注册时间", "最后登录时间",
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->user_id,
							$v->user_name,
							$v->real_name,
							$v->user_email,
							$v->user_phone,
							$v->card_num,
							$model->itemAlias('user_sex',$v->user_sex),
							$v->user_age,
							$v->invite_num,
							LYCommon::subtime($v->register_time,2),
							LYCommon::subtime($v->login_time,2),
					);
				}
					
				$xls = new JPhpExcel('UTF-8', false,'用户报表');
				$xls->addArray($data);
				$xls->generateXML('user');
				die;
			}
			
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
			$list = $model->findAll($criteria);
            $this->render('list',array(
                'model'=>$model,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new User;
            
            if(isset($_POST['User'])){
                $model->attributes = $_POST['User'];
                $model -> user_type = 1;
                $model -> user_id = LYCommon::getInsertID();
                $model -> register_time = time();
                $image=CUploadedFile::getInstance($model,'user_pic');
                if($image) {
                    if($image->extensionName!='jpg' && $image->extensionName!='jpeg' && $image->extensionName!='png' && $image->extensionName!='gif')
                        die('上传文件非法');
                    if(!empty($image)){
                            $dir=dirname(Yii::app()->basePath).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR;
                            if(!is_dir($dir)) {
                                die('文件夹不存在');
                            }
                            $name=time().strtolower(rand(1000,9999)).strrchr($image->name,'.');
                            $image->saveAs($dir.$name);
                            $model->user_pic=$name;
                            LYCommon::saveThumb($dir.$name, $dir.'s_'.$name);    //保存图像的时候，生成缩略图。
                    }
                }
                if($model->save()){
                    Yii::app()->user->setFlash('success','用户添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('create',array(
                'model'=>$model,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            if(isset($_POST['User'])){
                $model->attributes = $_POST['User'];
				
                $image=CUploadedFile::getInstance($model,'user_pic');
                if($image) {
                    if($image->extensionName!='jpg' && $image->extensionName!='jpeg' && $image->extensionName!='png' && $image->extensionName!='gif')
                        die('上传文件非法');
                    if(!empty($image)){
                            $dir=dirname(Yii::app()->basePath).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'userpic'.DIRECTORY_SEPARATOR;
                            if(!is_dir($dir)) {
                                die('文件夹不存在');
                            }
                            $name=time().strtolower(rand(1000,9999)).strrchr($image->name,'.');
                            $image->saveAs($dir.$name);
                            $model->user_pic=$name;
                            LYCommon::saveThumb($dir.$name, $dir.'s_'.$name);    //保存图像的时候，生成缩略图。
                    }
                }
                if($model->save()){
                    Yii::app()->user->setFlash('success','用户更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
            ));                    
        }
		
		public function actionAddborrowuser(){
            $user_model = new Register;
            
            if(isset($_POST['Register'])){
                $user_model -> attributes = $_POST['Register'];
                if(!empty($user_model->user_name)){
                    if(!empty($user_model->login_pass)){
                        $user_model -> user_id = LYCommon::getInsertID();
						$user_model -> login_pass = LYCommon::get_pass($user_model->user_id,$user_model->login_pass);
						$user_model -> pay_pass = $user_model -> login_pass;
						$user_model -> register_time = time();
						$user_model -> user_type = 2;
                        $transaction = Yii::app()->db->beginTransaction();
                        try{
                            if($user_model ->insert()){
                                $assets_model = new Assets;
                                $assets_model -> user_id = $user_model->user_id;
                                $assets_model -> insert();
                                
                                //插入用户统计表
                                $every_user = new Everyuser;
                                $every_user -> user_id = $user_model->user_id;
                                $every_user -> insert();
                                //插入积分表
                                $integral_model=new Integral;
                                $integral_model->user_id=$user_model->user_id;
                                $integral_model->i_addtime=time();
                                $integral_model->i_addip=$_SERVER['REMOTE_ADDR'];
                                $integral_model->insert();
                                //插入授信额度
                                $usercredit = new Usercredit;
                                $usercredit -> user_id=$user_model->user_id;
                                $usercredit -> insert();
                            }
                            
                            $transaction ->commit();
                            Yii::app()->user->setFlash('success','添加成功！');
                            $this->redirect(Yii::app()->controller->createUrl('project/searchuser'));
                        }  catch (Exception $e){
                            $transaction ->rollback();
                        }
                    }else{
                        $user_model ->addError('login_pass', '密码不可为空');
                    }
                }else{
                    $user_model ->addError('user_name', '用户名不可为空');
                }
            }
            
            $this -> render('addborrowuser',array(
                'user_model'=>$user_model
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
                $model = User::model();
                if($model->deleteAllByAttributes(array('user_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return User::model()->findByPk($id);
        }
}