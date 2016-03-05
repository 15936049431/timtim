<?php
class SafecenterController extends WController{

	/*
	 * 检测用户是否登陆，未登录就跳转到登陆页
	 */
	public function beforeAction($action) {
            if (parent::beforeAction($action)) {
                if (Yii::app()->user->getIsGuest()) {
                    $this->redirect(array('site/login'));
                }
                return true;
            }
	}
	
	public function actionhome(){
		$userid = Yii::app()->user->id;
		$user_model = User::model();
		$user_info = $user_model -> findByPk($userid);
		$user_bank = AssetsBank::model()->findByAttributes(array("b_user_id"=>$userid));	
		$this -> render('home',array(
            'user_info' => $user_info,
			'user_bank' => $user_bank,
		));
	}
    

	public function actionpassword(){
		$userid = Yii::app()->user->id;
		$user1_model = User::model();
		$user_info = $user1_model->findByPk($userid);
		$user_model = new Userprofile('setnewpass');
                $user_model -> user_id = $userid;
                $result = array('status'=>0);
		if(isset($_POST['Userprofile'])){
			$user_model->attributes = $_POST['Userprofile'];
			if(!$user_model->validate()){
				$result['msg']=LYCommon::GetError($user_model->getErrors());
			}elseif(LYCommon::get_pass($userid,$user_model->login_pass)!=$user_info->login_pass){
				$result['msg'] = "原登陆密码不正确" ;
			}else{
				$user_info->login_pass = LYCommon::get_pass($userid,$user_model->new_pass);
				if($user_info->update()){
                                    $result['status'] = 1;
                                    $result['msg'] = "更改成功";
                                    $result['jump_url'] = Yii::app()->controller->createUrl("safecenter/home");
				}
			}
		}
		$this->render("password",array(
			"user_model"=>$user_model,	
			"result"=>$result,
		));
	}
        
        public function actionChangepaypass(){
            $result = array('status'=>0);
            $userid = Yii::app()->user->id;
            $user_model = new Userprofile;
            $user_info = $user_model->findByPk($userid);
            $user_model -> user_id = $user_info->user_id;
            if($user_info -> login_pass == $user_info -> pay_pass){
                $user_model -> scenario = 'setnew_pay_pass';
            }else{
                $user_model -> scenario = 'change_pay_pass';
            }
            
            if(isset($_POST['Userprofile'])){
                $user_model -> attributes = $_POST['Userprofile'];
                if($user_model ->validate()){
                    $user_info -> pay_pass = LYCommon::get_pass($user_info->user_id,$user_model->new_pass);
                    if($user_info -> update()){
                        $result['status'] = 1;
                        $result['msg'] = '操作成功';
                        $result['jump_url'] = Yii::app()->controller->createUrl('safecenter/home');
                    }
                }else{
                    $result['msg'] = current(current($user_model->getErrors()));;
                }
                
            }
            
            $this -> render('changepaypass',array(
                'user_model'=>$user_model,
                'user_info'=>$user_info,
                'result'=>$result,
            ));
        }
        
        public function actionrealname(){
            $identity_model = new Identity;
		$userid = Yii::app()->user->id;
		$identity_info = $identity_model -> findByAttributes(array('user_id'=>$userid));
		$message=$success=0;
		if(isset($_POST['Identity'])){
			if(!empty($_POST['Identity']['identity_num'])){
				$_POST['Identity']['identity_num'] = strtoupper($_POST['Identity']['identity_num']);
			}	
			if(empty($identity_info)){
				$identity_model -> attributes = $_POST['Identity'];
				$identity_model -> identity_id = LYCommon::getInsertID();
				$identity_model -> user_id = $userid;
				$identity_model -> status = 0;
				$identity_model -> add_time = time();
				$identity_model -> add_ip = Yii::app()->request->userHostAddress;
				if($identity_model ->save()){
					$data = array(
						'params' => array(
						'transNo' => substr(LYCommon::getInsertID(), 1, 15),
						'inputDate' => date('Ymd', time()),
						'inputTime' => date('Him', time()),
						'realName' => str_replace('"','',json_encode($identity_model -> real_name)),
						'certNo' => strtoupper($identity_model->identity_num),
						'bgRetUrl' => Yii::app()->request->hostInfo.'/wap/async/id5notify.html',
						'pageRetUrl' =>Yii::app()->request->hostInfo.'/wap/safecenter/id5return.html',
						'private1' => $identity_model -> identity_id,
						'chkValue'=>''
					   )
					);
					//需要插入数据库
					$umbank = new Umbank($data);
					$str = $umbank->getSign();
						
					if (!empty($str)) {
						$sign = explode('|', $str);
						$umbank->params['certNo'] = $sign[0];
						$umbank->params['chkValue'] = $sign[1];
					}

					$datax = new stdClass();
					$datax->params = $umbank->params;
					$datax->acc_url = Umbank::PHPNEurl;
					$this->renderPartial('/paycommon/form', array(
						'data' => $datax,
						'open'=>1
					));
					die;
				}else{
//					var_dump($identity_model->getErrors());die;
					$message = current(current($identity_model->getErrors()));
				}
			}else{
				$identity_info -> attributes = $_POST['Identity'];
				$identity_info -> status = 0;
				$identity_info -> add_time = time();
				$identity_info -> add_ip = Yii::app()->request->userHostAddress;
				if($identity_info ->save()){
					$data = array(
						'params' => array(
						'transNo' => substr(LYCommon::getInsertID(), 1, 15),
						'inputDate' => date('Ymd', time()),
						'inputTime' => date('Him', time()),
						'realName' => str_replace('"','',json_encode($identity_info -> real_name)),
						'certNo' => strtoupper($identity_info->identity_num),
						'bgRetUrl' => Yii::app()->request->hostInfo.'/wap/async/id5notify.html',
						'pageRetUrl' =>Yii::app()->request->hostInfo.'/wap/safecenter/id5return.html',
						'private1' => $identity_info -> identity_id,
						'chkValue'=>''
					   )
					);
					//需要插入数据库
					$umbank = new Umbank($data);
					$str = $umbank->getSign();
						
					if (!empty($str)) {
						$sign = explode('|', $str);
						$umbank->params['certNo'] = $sign[0];
						$umbank->params['chkValue'] = $sign[1];
					}

					$datax = new stdClass();
					$datax->params = $umbank->params;
					$datax->acc_url = Umbank::PHPNEurl;
					$this->renderPartial('/paycommon/form', array(
						'data' => $datax,
						'open'=>1
					));
					die;
				}else{
					$message = current(current($identity_info->getErrors()));
				}
			}
        }
        $this -> render('realname',array(
            'identity_model'=>$identity_model,
            'message'=>$message,
            'success'=>$success,
        ));
        }
        
        public function actionid5return(){
        $identity_id=Yii::app()->request->getParam("private1");
        $respCode=Yii::app()->request->getParam("respCode");
		$identity_model = Identity::model();
		$identity_info = $identity_model -> findByPk($identity_id);
        if($respCode=='00'){
            $identity_info -> status = 1;
			if($identity_info -> update()){
				$user_model = User::model();
				$user_info = $user_model -> findByPk($identity_info -> user_id);
				$user_info -> card_num = $identity_info -> identity_num;
				$user_info -> real_name = $identity_info -> real_name;
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
					$userid = Yii::app()->user->id;
					Hook::realname_push_hook($userid);
				}
			}
			
			
        }else{
			$identity_info -> status = 2;
			$identity_info -> update();
		}
		$url = Yii::app()->controller->createUrl('safecenter/home');
		$this->redirect($url);
    }
      	
        public function actionchangephone(){
            $result = array('status'=>0);
        	$userid = Yii::app()->user->id;
        	$user_model = new Userprofile("changephone");
        	$user_nmodel = User::model();
        	$user_info = $user_model->findByPk($userid);
        	
        	if(isset($_POST['Userprofile'])){
        		$user_model->attributes=$_POST['Userprofile'];
        		if(!$user_model->validate()){
                            $result['msg'] = current(current($user_model->getErrors()));
        		}else{
                            if(LYCommon::validate_code($user_info->user_phone, 'safecenter_change_phone_1', $user_model->code)){
                                Yii::app()->session['change_phone'] = 1;
                                $result['status'] = 1;
                                $result['msg'] = '验证成功';
                                $result['jump_url'] = Yii::app()->controller->createUrl('safecenter/setphone');
                            }else{
                                $result['msg'] = '手机验证码不正确';
                            }
        		}
        	}
        	$this->render("changephone",array(
        		"result"=> $result,
        		"user_model"=>$user_model,
        		"user_info"=>$user_info,
        	));
        }
        
        public function actionsetphone(){
            $result = array('status'=>0);
            $userid = Yii::app()->user->id;
            $user_model = new Userprofile("setphone");
            $user_nmodel = User::model();
            $user_info = $user_model->findByPk($userid);

            if(empty(Yii::app()->session['change_phone']) && $user_info->is_phone_check==1){
                $this ->redirect(Yii::app()->controller->createUrl('safecenter/changephone'));
            }else{
            	if(isset($_POST['Userprofile'])){
            		$user_model->attributes=$_POST['Userprofile'];
            		if(!$user_model->validate()){
                            $result['msg'] = current(current($user_model->getErrors()));
            		}else{
                            if(LYCommon::validate_code($user_model->user_phone, 'safecenter_change_phone_2', $user_model->code)){
                                unset(Yii::app()->session['change_phone']);
                                $user_info->user_phone=$user_model->user_phone;
                                $user_info->user_name = $user_model->user_phone;
                                if($user_info->update()){
                                    $result['status'] = 1;
                                    $result['msg'] = '操作成功';
                                    $result['jump_url'] = Yii::app()->controller->createUrl('safecenter/home');
                                }
                            }else{
                                $result['msg'] = '手机验证码不正确';
                            }
            		}
            	}
            }
        	
        	$this->render("setphone",array(
        		"result"=>$result,
        		"user_model"=>$user_model,
        		"user_info"=>$user_info,
        	));
        }
        
        public function actionSendsms($phone=null,$type=null){
        	$result = array('status'=>0);
        	if(!empty($phone)){
        		if(preg_match('/^1\d{10}$/', $phone)){
        			//只要手机号码格式正确就显示发送成功
//        			$result['status'] = 1;
//        			$result['msg'] = '发送成功';
        			$user_model = User::model();
        			$user_info = $user_model ->findByAttributes(array('user_phone'=>$phone));
        			$userid =Yii::app()->user->id;
        			if(empty($user_info)){
        				if(($send_result = LYCommon::sendcode($userid,$phone,$type)) === true){
        					$result['status'] = 1;//发送成功
        					$result['msg']='发送成功';
        				}else{
        					$result = $send_result;
        				}
                                }else{
                                    $result['msg'] = '手机号已经被绑定';
                                }
        		}else{
        			$result['msg'] = '手机号码格式不正确';
        		}
        	}else{
        		$result['msg'] = '手机号码不可为空';
        	}
        
        
        	echo json_encode($result);
        }
        
        
    public function actionForgotpaypass() {
        $first_error = '';
        $user_model = User::model();
        $userid = Yii::app()->user->id;
        $user_info = $user_model -> findByPk($userid);
        if(empty($user_info->is_phone_check)){
            die;
        }
        if (isset($_POST['Forgotpass'])) {
            if (empty($_POST['Forgotpass']['code'])) {
                $first_error = '手机验证码不可为空';
            } else {
                if(LYCommon::validate_code($user_info->user_phone, 'forgotpaypass',$_POST['Forgotpass']['code'])){
                    Yii::app()->session['setnew_paypass'] = 1;
                    $this->redirect(Yii::app()->controller->createUrl('safecenter/setNewpaypass'));
                }else{
                    $first_error = '手机验证码不正确';
                }
            }
        }
        $this->render('forgotpaypass', array(
            'user_info' => $user_info,
            'first_error' => $first_error,
        ));
    }
    
    
    public function actionSetNewpaypass() {
        $model = new Userprofile('setnew_pay_pass');
        if(empty(Yii::app()->session['setnew_paypass'])){
            $this ->redirect(Yii::app()->controller->createUrl('safecenter/forgotpaypass'));
            die;
        }
        $userid = Yii::app()->user->id;
        $user_info = $model->findByPk($userid);
        $model -> user_id = $user_info -> user_id;
        $first_error = '';
        if (isset($_POST['Userprofile'])) {
            $model->attributes = $_POST['Userprofile'];
            if($model ->validate()){
                $user_info->pay_pass = LYCommon::get_pass($user_info->user_id, $model->new_pass);
                if ($user_info->update()) {
                    unset(Yii::app()->session['setnew_paypass']);
                    $this->redirect(Yii::app()->controller->createUrl('menu/ihave'));
                }
            }else{
                $error = $model->getErrors();
            }
            if (!empty($error)) {
                $first_error = current(current($model->getErrors()));
            }
        }

        $this->render('setnewpaypass', array(
            'model' => $model,
            'first_error' => $first_error,
        ));
    }
	
	
}

?>