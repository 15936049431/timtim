<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
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
                'offset' => 1
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


	public function actiontest(){
		//LYCommon::sendPhone("15936049431","您的验证码为197822，请于30分钟内输入，如非本人操作，请忽略本短信。");
	}
	
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $link_model = Link::model();
        $banner_list = $link_model->findAll(array('limit' => '5', 'condition' => 'link_type=14491969465234842 ', "order" => "link_order ASC"));
    	$link_list = $link_model->findAll(array("limit"=>"7","condition"=>"link_type=14491969761511063 and link_pic<>'' ","order"=>"link_order ASC"));
    	$index_shop = $link_model->findByAttributes(array("link_type"=>"14491970190512455"));
    	$article_model = Article::model();
    	$company_list = $article_model->findAll(array('limit' => '4', 'condition' => 'article_cat_id=14478538593203093', "order" => "add_time DESC"));
    	$trailer_list = $article_model->findAll(array("limit"=>"4","condition"=>"article_cat_id = 14478539001145229","order"=>"add_time DESC"));
    	$dyanmic_list = $article_model->findAll(array("limit"=>"4","condition"=>"article_cat_id = 14496491486456585","order"=>"add_time DESC"));
    	$industry_list = $article_model->findAll(array("limit"=>"4","condition"=>"article_cat_id = 14496491669837615","order"=>"add_time DESC"));
    	$project_model = Project::model();
        $project_list = $project_model->findAll(array("limit"=>"8","condition"=>"p_status in (1,3)",'order' => 'p_status ASC,((p_account - p_account_yes)/p_account) DESC,p_verifytime DESC',));
        $project_order_model = ProjectOrder::model();
        $assets_model = Assets::model();
        $index_use_money = array();
        $connection = Yii::app()->db;
        $today = strtotime(date("Y-m-d")); 
        $today_order_money = $connection->createCommand("select sum(p_money) from {{project_order}} where p_addtime>{$today}")->queryScalar();
        $assets_sum_money = $connection->createCommand("select sum(have_interest) as interest from {{assets}}")->queryRow();
        $total_order_money = $connection->createCommand("select sum(p_money) from {{project_order}}")->queryScalar();
        $all_user = $connection->createCommand("select count(*) as num from {{user}}")->queryScalar();
        $index_use_money['total_user'] = empty($all_user) ? 0 : $all_user;
        $index_use_money['total_order_money'] = empty($total_order_money) ? 0 : $total_order_money;
        $index_use_money['have_interest'] = empty($assets_sum_money['interest']) ? 0 : $assets_sum_money['interest'];
    	$this->render("index",array(
       		"banner_list"=>$banner_list,
    		"link_list"=>$link_list,
    		"company_list"=>$company_list,
    		"trailer_list"=>$trailer_list,
    		"project_list"=>$project_list,
    		"index_use_money"=>$index_use_money,
    		"index_shop"=>$index_shop,
    		"dyanmic_list"=>$dyanmic_list,
    		"industry_list"=>$industry_list,
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;
        $message = $success = 0;
        /* if( isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') 
          {
          echo CActiveForm::validate($model);
          Yii::app() -> end();
          } */
        // collect user input data
        if (!Yii::app()->user->getIsGuest()) {
            $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if (!$model->validate()) {
                $message = current(current($model->getErrors()));
            } else {
                if ($model->login()) {
                    $userid = Yii::app()->user->id;
                    $user_model = User::model();
                    $user_info = $user_model->findByPk($userid);
                    $user_info->login_time = time();
                    $user_info->update();
                    if (empty($user_info->is_phone_check)) {
                        $success = array("请绑定手机号码", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
                    } else {
                        $success = array("登陆成功", Yii::app()->controller->createUrl('usercenter/home'), 1, 1);
                    }
                    $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
                }
            }
        }
        $this->render('login', array('model' => $model, 'message' => $message, "success" => $success,));
    }

    public function actionRegister() {
        if (!Yii::app()->user->getIsGuest()) {
            $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
        }
        $model = new Register;
        $message = $success = 0;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['Register'])) {
            $model->attributes = $_POST['Register'];
            $model->user_id = LYCommon::getInsertID();
            if (!empty($_GET['ly'])) {
                $model->p_user_id = base64_decode($_GET['ly']);
            }
			$login_pass = $model->login_pass;
            if (LYCommon::validate_code($model->user_phone, 'register_phone', $model->authcode)) {
                if ($model->validate()) {
                    $model->login_pass = LYCommon::get_pass($model->user_id, $model->login_pass);
                    $model->pay_pass = $model->login_pass;
                    $model->register_time = time();
                    $model->login_time = $model->register_time;
                    $model->is_phone_check = 1;
                    $model->register_ip = Yii::app()->request->userHostAddress;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($model->insert()) {
                            //插入资金表
                            $assets_model = new Assets;
                            $assets_model->user_id = $model->user_id;
                            //插入用户统计表
                            $every_user = new Everyuser;
                            $every_user->user_id = $model->user_id;
                            $every_user->addtime = time();
                            $every_user->insert();
                            //插入积分表
                            $integral_model = new Integral;
                            $integral_model->user_id = $model->user_id;
                            $integral_model->i_addtime = time();
                            $integral_model->i_addip = $_SERVER['REMOTE_ADDR'];
                            $integral_model->insert();

                            if (!empty($model->p_user_id)) {
                                $invite_num = $model->findByPk($model->p_user_id)->invite_num;
                                if ($invite_num < 100) {//如果邀请人数小于100
                                    $pintegral_model = Integral::model();
                                    $integral_info = $pintegral_model->findByPk($model->p_user_id);
                                    $integral_info->i_total_value += Yii::app()->params['invite_give_user'];
                                    $integral_info->i_real_value += Yii::app()->params['invite_give_user'];
                                    $data = array(
                                        'i_cat_alias' => 'invite_user',
                                        'remark' => '邀请用户积分增加',
                                    );
                                    LYCommon::Add_integral($integral_info, $data);
                                }
                            }

                            //插入授信额度
                            $usercredit = new Usercredit;
                            $usercredit->user_id = $model->user_id;
                            $usercredit->insert();

                            if ($assets_model->insert()) {
                                LYCommon::encryptSign($assets_model); //资金加签

                                $pintegral_model = Integral::model();
                                $integral_info = $pintegral_model->findByPk($model->user_id);
                                $integral_info->i_total_value += Yii::app()->params['reg_integral'];
                                $integral_info->i_real_value += Yii::app()->params['reg_integral'];
                                $data = array(
                                    'i_cat_alias' => 'reg_user',
                                    'remark' => '用户注册积分增加',
                                );
                                LYCommon::Add_integral($integral_info, $data);

                                if (!empty($model->p_user_id)) {
                                    $pintegral_model = Integral::model();
                                    $integral_info = $pintegral_model->findByPk($model->user_id);
                                    $integral_info->i_total_value += Yii::app()->params['invite_user_reg'];
                                    $integral_info->i_real_value += Yii::app()->params['invite_user_reg'];
                                    $data = array(
                                        'i_cat_alias' => 'inviteurl_reg',
                                        'remark' => '通过邀请链接注册奖励积分',
                                    );
                                    LYCommon::Add_integral($integral_info, $data);
                                    $p_user = User::model()->findByPk($model->p_user_id);
                                    $p_user->invite_num = $p_user->invite_num + 1;
                                    $p_user->update();
                                }
                                UtilCommon::giveRegisterMoney($model->user_id);
                                $transaction->commit();
                                $autologin = new UserIdentity($model->user_name, $_POST['Register']['login_pass']);
                                if ($autologin->authenticate()) {
                                    Yii::app()->user->login($autologin);
                                    $success = array("注册成功", Yii::app()->controller->createUrl('usercenter/home'), "1", "1");
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                    }
                } else {
                    $error_message = current($model->getErrors());
                    $message = $error_message[0];
                }
            } else {
                $message = "验证码不正确";
            }
        } else {
            if (isset($_GET['ly'])) {
                $recommend_info = User::model()->findByPk(base64_decode(Yii::app()->request->getParam('ly')));
                $model->recommend = $recommend_info->user_phone;
            }
        }
        $this->render('register', array('model' => $model, 'message' => $message, "success" => $success));
    }

    public function actionForgetpass() {
        if (!Yii::app()->user->getIsGuest()) {
            $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
            Yii::app()->end();
        }
        $message = $success = 0;
        $model = new Userprofile('forgot_pass');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot_pass_form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Userprofile'])) {
            $model->attributes = $_POST['Userprofile'];
            if ($model->validate()) {
                if (LYCommon::validate_code($model->user_phone, 'forgotpass', $model->code)) {
                    $user_info = $model->findByAttributes(array('user_phone' => $model->user_phone, 'is_phone_check' => 1));
                    $user_info->login_pass = LYCommon::get_pass($user_info->user_id, $model->new_pass);
                    if ($user_info->update()) {
                        $success = array("密码重置成功", Yii::app()->controller->createUrl('site/login'), "1", "1");
                    }
                } else {
                    $message = '验证码不正确';
                }
            } else {
                $message = current(current($model->getErrors()));
            }
        }
        $this->render('forgetpass', array(
            'model' => $model,
            'message' =>$message,
        	'success' =>$success,
        ));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionSendphone($phone = null, $type = null, $authcode = null) {
        $result = array('status' => 0);
        $phone = isset($_POST['phone']) ? $_POST['phone'] : $phone;
        $type = isset($_POST['type']) ? $_POST['type'] : $type;
        $authcode = isset($_POST['authcode']) ? $_POST['authcode'] : $authcode;
        if (!empty($phone)) {
            if (preg_match('/^1\d{10}$/', $phone)) {
                $user_model = User::model();
                $user_info = $user_model->findByAttributes(array('user_phone' => $phone, 'is_phone_check' => 1));
                $filter = array('register_phone', 'safecenter_change_phone_2');
                if (in_array($type, $filter)) {//如果是注册则user_info必须为空
                    if (empty($user_info)) {
                         if (!empty($authcode)) {
                             if ($this->createAction('captcha')->getVerifyCode() == $authcode) {
                                 if (($send_result = LYCommon::sendcode(0, $phone, $type)) === true) {
                                     $result['status'] = 1; //发送成功
                                     $result['msg'] = '发送成功';
                                 } else {
                                     $result = $send_result;
                                 }
                             } else {
                                 $result['msg'] = '验证码不正确';
                             }
                         } else {
                             $result['msg'] = '验证码不为空';
                         }                     
                    } else {
                        $result['msg'] = '手机号已被注册';
                    }
                } else {//除了注册user_info必须不能为空
                    if (!empty($user_info)) {
                    	if (!empty($authcode)) {
                    		if ($this->createAction('captcha')->getVerifyCode() == $authcode) {
		                        if (($send_result = LYCommon::sendcode(0, $phone, $type)) === true) {
		                            $result['status'] = 1; //发送成功
		                            $result['msg'] = '发送成功';
		                        } else {
		                            $result = $send_result;
		                        }
		                    } else {
		                        $result['msg'] = '验证码不正确';
		                    }
		                } else {
		                    $result['msg'] = '验证码不为空';
		                }
                    }else{
                    	$result['msg'] = "没有此用户" ;
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

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                if ($error['code'] == '404') {
                    $this->render('//error/error404', $error);
                } elseif ($error['code'] == '500') {
                    $this->render('//error/error500', $error);
                }
            }
        }
    }

}
