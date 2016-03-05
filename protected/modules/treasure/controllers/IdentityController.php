<?php

class IdentityController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Identity::model();
            $criteria = new CDbcriteria;
            $criteria -> with = 'user';
            if(isset($_GET['Identity'])){
            	$model->attributes=$_GET['Identity'];
                $criteria ->compare('user.user_name', $_GET['Identity']['user_name'],true);
                $criteria ->compare('t.real_name', $model->real_name,true);
                $criteria ->compare('t.identity_num', $model->identity_num,true);
            }
            $criteria->compare("status",1);
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$list = $model->findAll($criteria);
				$data = array(
						array(
								"序号","ID", "用户名", "真实姓名","身份证号码", "申请时间"
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->user_id,
							$v->user->user_name,
							$v->user->real_name,
							$v->user->card_num,
							LYCommon::subtime($v->add_time,2),
					);
				}
					
				$xls = new JPhpExcel('UTF-8', false,'实名认证已审核');
				$xls->addArray($data);
				$xls->generateXML('identity');
				die;
			}
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6,3,7,0,2));
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
         * 列表
         */
        public function actionWait_list(){
            $model = Identity::model();
            $user_model = User::model();
            $criteria = new CDbcriteria;
            if(isset($_GET['Identity'])){
            	$model->attributes = $_GET['Identity'];
            	$criteria->compare("real_name",$model->real_name,true);
            	$criteria->compare("identity_num",$model->identity_num,true);
            }
            if(isset($_GET['User'])){
            	$user_model->attributes = $_GET['User'] ;
            	$criteria->with="user";
            	$criteria->compare("user.user_name",$user_model->user_name,true);
            }
            $criteria ->addCondition('status = 0');
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$list = $model->findAll($criteria);
				$data = array(
						array(
								"序号","ID", "用户名", "真实姓名","身份证号码", "申请时间"
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->user_id,
							$v->user->user_name,
							$v->user->real_name,
							$v->user->card_num,
							LYCommon::subtime($v->add_time,2),
					);
				}
					
				$xls = new JPhpExcel('UTF-8', false,'实名认证未审核');
				$xls->addArray($data);
				$xls->generateXML('identity');
				die;
			}
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $criteria -> order = ' add_time DESC';
            $list = $model->findAll($criteria);
            $this->render('wait_list',array(
                'model'=>$model,
                'list'=>$list,
            	"user_model"=>$user_model,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new Identity;
            
            if(isset($_POST['Identity'])){
                $model->attributes = $_POST['Identity'];
                $mr_arr = '[{"field_name":"identity_id","fortablename":"lc_identity","iskey":"PRI","input_type":"0","title":"\u8ba4\u8bc1id"},{"field_name":"user_id","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u7528\u6237id"},{"field_name":"real_name","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u771f\u5b9e\u59d3\u540d"},{"field_name":"identity_num","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u8bc1\u4ef6\u53f7\u7801"},{"field_name":"identity_positive","fortablename":"lc_identity","iskey":"","input_type":"6","title":"\u8eab\u4efd\u8bc1\u6b63\u9762"},{"field_name":"identity_negative","fortablename":"lc_identity","iskey":"","input_type":"6","title":"\u8eab\u4efd\u8bc1\u80cc\u9762"},{"field_name":"status","fortablename":"lc_identity","iskey":"","input_type":"3","title":"\u5ba1\u6838\u72b6\u6001","data":"0,\u5f85\u5ba1\u6838$1,\u5ba1\u6838\u901a\u8fc7$2,\u5ba1\u6838\u5931\u8d25"},{"field_name":"check_manager","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u5ba1\u6838\u4eba"},{"field_name":"check_time","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u5ba1\u6838\u65f6\u95f4","istime":"2"},{"field_name":"check_remark","fortablename":"lc_identity","iskey":"","input_type":"2","title":"\u5ba1\u6838\u5907\u6ce8"},{"field_name":"add_time","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u7533\u8bf7\u65f6\u95f4","istime":"2"},{"field_name":"add_ip","fortablename":"lc_identity","iskey":"","input_type":"1","title":"\u7533\u8bf7ip"},{"field_name":"manager_id","fortablename":"lc_manager","iskey":"PRI"},{"field_name":"manager_name","fortablename":"lc_manager","iskey":""},{"field_name":"manager_pass","fortablename":"lc_manager","iskey":""},{"field_name":"manager_realname","fortablename":"lc_manager","iskey":""},{"field_name":"manager_tel","fortablename":"lc_manager","iskey":""},{"field_name":"google_status","fortablename":"lc_manager","iskey":""},{"field_name":"google_secret","fortablename":"lc_manager","iskey":""},{"field_name":"issuper","fortablename":"lc_manager","iskey":""},{"field_name":"add_time","fortablename":"lc_manager","iskey":""},{"field_name":"login_time","fortablename":"lc_manager","iskey":""},{"field_name":"user_id","fortablename":"lc_user","iskey":"PRI"},{"field_name":"user_name","fortablename":"lc_user","iskey":""},{"field_name":"login_pass","fortablename":"lc_user","iskey":""},{"field_name":"pay_pass","fortablename":"lc_user","iskey":""},{"field_name":"user_email","fortablename":"lc_user","iskey":""},{"field_name":"user_phone","fortablename":"lc_user","iskey":""},{"field_name":"home_tel","fortablename":"lc_user","iskey":""},{"field_name":"user_qq","fortablename":"lc_user","iskey":""},{"field_name":"user_pic","fortablename":"lc_user","iskey":""},{"field_name":"real_name","fortablename":"lc_user","iskey":""},{"field_name":"card_num","fortablename":"lc_user","iskey":""},{"field_name":"user_sex","fortablename":"lc_user","iskey":""},{"field_name":"user_age","fortablename":"lc_user","iskey":""},{"field_name":"user_edu","fortablename":"lc_user","iskey":""},{"field_name":"birth_place","fortablename":"lc_user","iskey":""},{"field_name":"live_place","fortablename":"lc_user","iskey":""},{"field_name":"user_address","fortablename":"lc_user","iskey":""},{"field_name":"p_user_id","fortablename":"lc_user","iskey":""},{"field_name":"user_type","fortablename":"lc_user","iskey":""},{"field_name":"is_email_check","fortablename":"lc_user","iskey":""},{"field_name":"is_phone_check","fortablename":"lc_user","iskey":""},{"field_name":"is_realname_check","fortablename":"lc_user","iskey":""},{"field_name":"vip_stop_time","fortablename":"lc_user","iskey":""},{"field_name":"is_hook","fortablename":"lc_user","iskey":""},{"field_name":"resiter_time","fortablename":"lc_user","iskey":""},{"field_name":"login_time","fortablename":"lc_user","iskey":""}]';
                foreach(json_decode($mr_arr) as $k => $v){
                    if(!array_key_exists($v->field_name,$_POST['Identity']) || empty($_POST['Identity'][$v->field_name])){
                        $model->{$v->field_name} = $v->mr;
                    }
                }
                $model->identity_positive = JYCommon::uploadimage($model,'identity_positive',trim(trim($model->tableName(),'}}'),'{{'));$model->identity_negative = JYCommon::uploadimage($model,'identity_negative',trim(trim($model->tableName(),'}}'),'{{'));
                if($model->save()){
                    Yii::app()->user->setFlash('success','实名认证添加成功！');
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
            if(isset($_POST['Identity'])){
                $model->attributes = $_POST['Identity'];
                if($model->save()){
                    Yii::app()->user->setFlash('success','实名认证更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
            ));                    
        }
        
        /*
         * 实名认证审核操作
         */
        public function actionWait_oper($id){
            $model = self::loadmodel($id);
            $model -> scenario = 'wait_oper';
            if(isset($_POST['Identity'])){
                $model -> attributes = $_POST['Identity'];
                if($model -> sh_status == 1){
                    $model -> status = 1;
                }elseif($model -> sh_status == 2){
                    $model -> status = 2;
                }
                $model -> check_manager = Yii::app()->user->id;
                $model -> check_time = time();
                $transaction = Yii::app()->db->beginTransaction();
                if($model->status==1){
	                try{
	                    if($model -> update()){
	                        $user_model = User::model();
	                        $user_info = $user_model ->findByPk($model->user_id);
	                        $user_info -> real_name = $model -> real_name;
	                        $user_info -> card_num = $model -> identity_num;
	                        $user_info -> is_realname_check = 1;
                                $last_num = '';
                                if(strlen($user_info -> card_num) == 15){
                                    $last_num = substr($user_info -> card_num, -1,1);
                                }elseif (strlen($user_info -> card_num) == 18) {
                                    $last_num = substr($user_info -> card_num, -2,1);
                                }
                                if($last_num%2==0){
                                    $user_info -> user_sex =  '2';
                                }else{
                                    $user_info -> user_sex =  '1';
                                }
	                        if($user_info -> update()){
	                            $transaction ->commit();
	                            Yii::app()->user->setFlash('success','实名认证审核成功！');
	                            $this->redirect(Yii::app()->controller->createUrl('wait_list'));
	                        }else{
	                            $transaction ->rollback();
	                        }
	                    }
	                }  catch (Exception $e){
	                    $transaction ->rollback();
	                }
                }else{
					try{
						$model->delete();
						$transaction ->commit();
					}catch(Exception $e){
						$transaction ->rollback();
					}
                	Yii::app()->user->setFlash('success','实名认证审核成功！');
                	$this->redirect(Yii::app()->controller->createUrl('wait_list'));
                }
            }
            $this->render('wait_oper',array(
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
                $model = Identity::model();
                if($model->deleteAllByAttributes(array('identity_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Identity::model()->findByPk($id);
        }
}