<?php

class SafecenterController extends Controller {

    public $layout = '//layouts/usercenter_main';
    public $user_info;
    public $safevalue;
    public $real_money;

    /*
     * 检测用户是否登陆，未登录就跳转到登陆页
     */
    
    public function actions() {
    	return array(
    			// captcha action renders the CAPTCHA image displayed on the contact page
    			'captcha' => array(
    					'class' => 'CCaptchaAction',
    					'backColor' => 0xFFFFFF,
    					'minLength' => 4,
    					'maxLength' => 4,
    					'width' => 80,
    					'height' => 32,
    					'testLimit' => 1,
    					'offset'=>0
    			),
    			// page action renders "static" pages stored under 'protected/views/site/pages'
    			// They can be accessed via: index.php?r=site/page&view=FileName
    			'page' => array(
    					'class' => 'CViewAction',
    			),
    	);
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            if (Yii::app()->user->getIsGuest()) {
                $this->redirect(array('site/login'));
            }
            return true;
        }
    }

    public function actionIndex() {
        $userid = Yii::app()->user->id;
        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        $user_safenum = 0;
        if ($user_info->login_pass != "") {
            $user_safenum+=20;
        }
        if ($user_info->login_pass != $user_info->pay_pass) {
            $user_safenum+=20;
        }
        if ($user_info->is_realname_check == 1) {
            $user_safenum+=20;
        }
        if ($user_info->is_phone_check == 1) {
            $user_safenum+=20;
        }
        if ($user_info->is_safequestion_check) {
            $user_safenum+=20;
        }
        $this->render('index', array(
            'user_info' => $user_info,
            'user_safe' => $user_safenum,
        ));
    }

    public function actionrealname() {
        $model = new Identity('human');
        $userid = Yii::app()->user->id;
        $user_identity = $model->findByAttributes(array('user_id' => $userid));
        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        $message = $success = 0;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'realname1-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Identity']) && empty($user_identity)) {
            if ($_FILES['Identity']['size']['identity_positive'] > 2048000 || $_FILES['Identity']['size']['identity_negative'] > 2048000) {
                $message = "图片尺寸太大";
            } else {
                $model->attributes = $_POST['Identity'];
                $model->identity_id = LYCommon::getInsertID();
                $model->user_id = $userid;
                $model->status = 0;
                $model->add_time = time();
                $model->add_ip = Yii::app()->request->userHostAddress;
                if ($model->validate()) {
                    $model->identity_positive = LYCommon::uploadimage($model, 'identity_positive', 'identity');
                    $model->identity_negative = LYCommon::uploadimage($model, 'identity_negative', 'identity');
                    $model->save();
                    $user_info->real_name = $model->real_name;
                    $user_info->card_num = $model->identity_num;
                    $user_info->update();
                    $success = array("实名认证提交成功!", Yii::app()->controller->createUrl("safecenter/index"), 1, 1);
                } else {
                    $message = current(current($model->getErrors()));
                }
            }
        }
        $this->renderPartial('realname', array(
            "model" => $model,
            "user_identity" => $user_identity,
            'message' => $message,
            'success' => $success,
        ));
    }

    /*
     * 更改绑定手机第一步
     */

    public function actionChange_phone_1() {
        $user_model = new Userprofile('change_phone_1');
        $message = $success = 0;
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'changephone1-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                if (LYCommon::validate_code($user_info->user_phone, 'safecenter_change_phone_1', $user_model->code)) {
                    Yii::app()->session['validata_phone_yes'] = 1;
                    $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/change_phone_2'), 1, 1);
                    $this->redirect(Yii::app()->controller->createUrl('change_phone_2'));
                } else {
                    $message = '验证码不正确';
                }
            } else {
                $message = current(current($user_model->getErrors()));
            }
        }

        $this->renderPartial('change_phone_1', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actionChange_phone_2() {
        $now_user = User::model()->findByPk(Yii::app()->user->id);
        if (!(isset(Yii::app()->session['validata_phone_yes']) && Yii::app()->session['validata_phone_yes'] == 1)) {
            if ($now_user->is_phone_check == 1) {
                $this->redirect(Yii::app()->controller->createUrl('change_phone_1'));
            }
        }
        $user_model = new Userprofile('bind_phone');
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bindphone-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        $message = $success = 0;
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                if (LYCommon::validate_code($user_model->user_phone, 'safecenter_change_phone_2', $user_model->code)) {
                    if($user_info->user_phone == $user_info->user_name){
                        $user_info->user_name = $user_model->user_phone;
                    }
                    $user_info->user_phone = $user_model->user_phone;
                    $user_info->is_phone_check = 1;
                    if ($user_info->update()) {
                        unset(Yii::app()->session['validata_phone_yes']);
                        $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
                    } else {
                        $message = "操作有误";
                    }
                } else {
                    $message = '验证码不正确';
                }
            } else {
                $message = current(current($user_model->getErrors()));
            }
        }
        $this->renderPartial('change_phone_2', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
            'success' => $success,
        ));
    }

    
    /*
     * 更改绑定邮箱第一步
     */
    public function actionChange_email_1() {
        $user_model = new Userprofile('change_email_1');
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'changeemail1-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        $message = $success = 0 ;
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                $code_model = Code::model();
                $code_info = $code_model->findByAttributes(array('target' => $user_info->user_email, 'codecat_id' => '5'));
                if (!empty($code_info)) {
                    if ($code_info->exc_time > time() && $code_info->status == 0 && $code_info->error_num < 3) {
                        if ($code_info->code == $user_model->code) {
                            $code_info->status = 1;
                            $code_info->update();
                            Yii::app()->session['validata_email_yes'] = 1;
                            $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/change_email_2'), 1, 1);
                            $this->redirect(Yii::app()->controller->createUrl('change_email_2'));
                        } else {
                            $message = '验证码不正确';
                            $code_info->error_num ++;
                            $code_info->update();
                        }
                    } else {
                       $message = '验证码不正确';
                    }
                } else {
                    $message = '验证码不正确';
                }
            } else {
                $message = '验证码不正确';
            }
        }

        $this->renderPartial('change_email_1', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
        	"message"=>$message,
        	"success"=>$success,
        ));
    }

    /*
     * 设置新邮箱
     */
    public function actionChange_email_2() {
    	$now_user = User::model()->findByPk(Yii::app()->user->id);
        if (!(isset(Yii::app()->session['validata_email_yes']) && Yii::app()->session['validata_email_yes'] == 1)) {
        	if($now_user->is_email_check==1){
	            $this->redirect(Yii::app()->controller->createUrl('change_email_1'));
        	}
        }
        $user_model = new Userprofile('bind_email');
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bindemail-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        $message = $success =0;
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                $code_model = Code::model();
                $code_info = $code_model->findByAttributes(array('target' => $user_model->user_email, 'codecat_id' => '6'));
                if (!empty($code_info)) {
                    if ($code_info->exc_time > time() && $code_info->status == 0 && $code_info->error_num < 3) {
                        if ($code_info->code == $code_info->code) {
                            $user_info->user_email = $user_model->user_email;
                            $user_info->is_email_check = 1;
                            if ($user_info->update()) {
                                $code_info->status = 1;
                                $code_info->update();
                                $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
                                unset(Yii::app()->session['validata_email_yes']);
                            }
                        } else {
                            $message = '验证码不正确';
                            $code_info->error_num ++;
                            $code_info->update();
                        }
                    } else {
                        $message = '验证码不正确';
                    }
                } else {
                    $message = '验证码不正确';
                }
            }
        }
        $this->renderPartial('change_email_2', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
        	"success" => $success,
        ));
    }

    public function actionChange_login_pass() {
        $user_model = new Userprofile('change_login_pass');
        $message = $success = 0;
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'changeloginpass-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                $user_info->login_pass = LYCommon::get_pass($user_info->user_id, $user_model->new_pass);
                if ($user_info->update()) {
                    $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
                }
            } else {
                $message = current(current($user_model->getErrors()));
            }
        }
        $this->renderPartial('change_login_pass', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actionChange_pay_pass() {
        $user_model = new Userprofile('change_pay_pass');
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $this->user_info = $user_info;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'changepaypass-form') {
            echo CActiveForm::validate($user_model);
            Yii::app()->end();
        }
        $message = $success = 0;
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                $user_info->pay_pass = LYCommon::get_pass($user_info->user_id, $user_model->new_pass);
                if ($user_info->update()) {
                    $success = array("更改成功", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
                }
            } else {
                $message = current(current($user_model->getErrors()));
            }
        }
        $this->renderPartial('change_pay_pass', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
            'success' => $success,
        ));
    }
    
    

    public function actionSafequestion() {
        $message = $success = 0;
        $userid = Yii::app()->user->id;
        $user_info = User::model()->findByPk($userid);
        if (!empty($user_info->is_safequestion_check) && empty(Yii::app()->session['vali_safequestion_yes'])) {
            $this->redirect(Yii::app()->controller->createUrl('vali_safequestion'));
            return false;
        }
        $safequestion_model = new Safequestion('set_safe');
        $safequestion_info = $safequestion_model->findByAttributes(array('user_id' => $userid));

        $item_list = LYCommon::GetItemList('safequestion');
        $item_arr = array('0' => '请选择密保问题');
        foreach ($item_list as $k => $v) {
            $item_arr[$v->i_id] = $v->i_name;
        }

        if (isset($_POST['Safequestion'])) {
            if (!empty($safequestion_info)) {
                $safequestion_info->attributes = $_POST['Safequestion'];
                $safequestion_info->update_time = time();
                $safequestion_info->update_ip = Yii::app()->request->userHostAddress;
                $safequestion_info->scenario = 'set_safe';
                if ($safequestion_info->save()) {
                    unset(Yii::app()->session['vali_safequestion_yes']);
                    $success = array("修改成功", Yii::app()->controller->createUrl("safecenter/index"), 1, 1);
                } else {
                    $message = current(current($safequestion_info->getErrors()));
                }
            } else {
                $safequestion_model->attributes = $_POST['Safequestion'];
                $safequestion_model->sq_id = LYCommon::getInsertID();
                $safequestion_model->user_id = $userid;
                $safequestion_model->add_time = time();
                $safequestion_model->add_ip = Yii::app()->request->userHostAddress;
                if ($safequestion_model->save()) {
                    User::model()->updateByPk($userid, array('is_safequestion_check' => 1));
                    $success = array("修改成功", Yii::app()->controller->createUrl("safecenter/index"), 1, 1);
                } else {
                    $message = current(current($safequestion_model->getErrors()));
                }
            }
        }


        $this->renderPartial('safequestion', array(
            'safequestion_model' => $safequestion_model,
            'item_arr' => $item_arr,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actionVali_safequestion($url = null) {
        $message = $success = 0;
        $userid = Yii::app()->user->id;
        $safequestion_model = Safequestion::model();
        $safequestion_model->scenario = 'vali_safe';
        $safequestion_info = $safequestion_model->findByAttributes(array('user_id' => $userid));
        if (empty($safequestion_info)) {
            $this->redirect(Yii::app()->controller->createUrl('safequestion'));
            return false;
        }

        if (isset($_POST['Safequestion'])) {
            $safequestion_model->attributes = $_POST['Safequestion'];
            if ($safequestion_model->validate()) {
                if ($safequestion_model->answer_one == $safequestion_info->answer_one && $safequestion_model->answer_two == $safequestion_info->answer_two && $safequestion_model->answer_three == $safequestion_info->answer_three) {
                    Yii::app()->session['vali_safequestion_yes'] = 1;
                    $success = array("验证成功", Yii::app()->controller->createUrl(base64_decode($url)), 1, 1);
                    $this->redirect(Yii::app()->controller->createUrl(base64_decode($url)));
                } else {
                    $message = '密保问题不正确';
                }
            } else {
                $message = current(current($safequestion_model->getErrors()));
            }
        }

        $this->renderPartial('vali_safequestion', array(
            'safequestion_info' => $safequestion_info,
            'safequestion_model' => $safequestion_model,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actionVali_phone($url = null) {
        $message = $success = 0;
        $user_model = new Userprofile('valie_phone');
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        if (isset($_POST['Userprofile'])) {
            $user_model->attributes = $_POST['Userprofile'];
            if ($user_model->validate()) {
                if (LYCommon::validate_code($user_info->user_phone, 'vali_phone', $user_model->code)) {
                    Yii::app()->session['validata_phone_yes'] = 1;
                    $success = array("验证成功", Yii::app()->controller->createUrl(base64_decode($url)), 1, 1);
                    $this->redirect(Yii::app()->controller->createUrl(base64_decode($url)));
                } else {
                    $message = '验证码不正确';
                }
            } else {
                $message = current(current($user_model->getErrors()));
            }
        }

        $this->renderPartial('vali_phone', array(
            'user_model' => $user_model,
            'user_info' => $user_info,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actionSet_new_paypass() {
        $message = $success = 0;
        $model = new Userprofile('setnew_pay_pass');
        $userid = Yii::app()->user->id;
        $model->user_id = $userid;
        $user_info = User::model()->findByPk($userid);
        if (!empty(Yii::app()->session['vali_safequestion_yes']) || !empty(Yii::app()->session['validata_phone_yes']) || $user_info->pay_pass == $user_info->login_pass) {
            if (isset($_POST['Userprofile'])) {
                $model->attributes = $_POST['Userprofile'];
                if ($model->validate()) {
                    $user_info->pay_pass = LYCommon::get_pass($user_info->user_id, $model->new_pass);
                    if ($user_info->update()) {
                        unset(Yii::app()->session['vali_safequestion_yes']);
                        unset(Yii::app()->session['validata_phone_yes']);
                        $success = array('支付密码设置成功，请妥善保管', Yii::app()->controller->createUrl("safecenter/index"), 1, 1);
                    } else {
                        $message = '未知原因，重置失败';
                    }
                } else {
                    $message = current(current($model->getErrors()));
                }
            }

            $this->renderPartial('set_new_paypass', array(
                'model' => $model,
                'message' => $message,
                'success' => $success,
            ));
        } else {
            $this->redirect(Yii::app()->controller->createUrl('vali_safequestion'));
            return false;
        }
    }

    /*
     * 发送短信/邮件
     */

    public function actionSendsms($phone = null, $type = null) {
        $result = array('status' => 0);
        if (!empty($phone)) {
            if (preg_match('/^1\d{10}$/', $phone)) {
                //只要手机号码格式正确就显示发送成功
//        			$result['status'] = 1;
//        			$result['msg'] = '发送成功';
                $user_model = User::model();
                $user_info = $user_model->findByAttributes(array('user_phone' => $phone, 'is_phone_check' => 1));
                if (!empty($user_info)) {
                    if (($send_result = LYCommon::sendcode(0, $phone, $type)) === true) {
                        $result['status'] = 1; //发送成功
                        $result['msg'] = "发送成功";
                    } else {
                        $result = $send_result;
                    }
                } else {
                	if (($send_result = LYCommon::sendcode(0, $phone, $type)) === true) {
                        $result['status'] = 1; //发送成功
                        $result['msg'] = "发送成功";
                    } else {
                        $result = $send_result;
                    }
                }
            } else {
                $result['msg'] = '手机号码格式不正确';
            }
        } else {
            $result['msg'] = '手机号码不可为空';
        }


        echo json_encode($result);
    }
    
    public function actionSendemail($email = null, $type = null) {
    	$result = array('status' => 0);
    	if (!empty($email)) {
    		if (preg_match('/(\w*)@(\w*).com/', $email)) {
    			//只要手机号码格式正确就显示发送成功
    			//        			$result['status'] = 1;
    			//        			$result['msg'] = '发送成功';
    			$user_model = User::model();
    			$user_info = $user_model->findByAttributes(array('user_email' => $email, 'is_email_check' => 1));
    			if (!empty($user_info)) {
    				if (($send_result = LYCommon::sendcode(0, $email, $type)) === true) {
    					$result['status'] = 1; //发送成功
    					$result['msg'] = "发送成功";
    				} else {
    					$result = $send_result;
    				}
    			} else {
    				if (($send_result = LYCommon::sendcode(0, $email, $type)) === true) {
    					$result['status'] = 1; //发送成功
    					$result['msg'] = "发送成功";
    				} else {
    					$result = $send_result;
    				}
    			}
    		} else {
    			$result['msg'] = '邮箱格式不正确';
    		}
    	} else {
    		$result['msg'] = '邮箱不可为空';
    	}
    	echo json_encode($result);
    }

}
