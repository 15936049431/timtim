<?php

class SiteController extends WController {

    public function actionIndex() {
    	$link_model = Link::model();
    	$banner_list = $link_model->findAll(array('limit' => '2', 'condition' => 'link_type=14491969962099984', 'order' => 'link_order ASC'));
        $project_modle = Project::model();
        $criteria = new CDbCriteria;
        $criteria ->compare('p_status', array(1,3));
        $criteria -> select = '*, (p_account_yes/p_account) as jindu';
        $criteria -> order = 'jindu ASC, p_verifytime DESC';
        $criteria -> limit = 9 ;
        $project_info = $project_modle -> findAll($criteria); 
		$count['collection'] = $count['project'] = 0;
        $connection = Yii::app()->db;
        $collection_sql = "select sum(p_interest) from ly_project_collect";
        $count['collection'] = $connection->createCommand($collection_sql)->queryScalar();
        $project_sql = "select sum(p_money) from ly_project_order";
        $count['project'] = $connection->createCommand($project_sql)->queryScalar();
        $this->render('index', array(
        	'project_list'=>$project_info,
        	'banner_list' => $banner_list,
			'count'=>$count,
        ));
    }

    public function actionLoad_index_more() {
        $result = array('status' => 0);
        $project_modle = Project::model();
        $criteria = new CDbCriteria;
        $criteria->compare('p_status', array(1, 3));
        $total_count = $project_modle->count($criteria);
        $page = new Pagination($total_count, 10);
        $criteria->select = '*, (p_account_yes/p_account) as jindu';
        $criteria->order = 'jindu ASC, p_verifytime DESC';
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $project_list = $project_modle->findAll($criteria);
        if (!empty($project_list)) {
            foreach ($project_list as $k => $v) {
                foreach ($v as $a => $b) {
                    $project_son[$a] = $b;
                }
                $result['project_list'][] = $project_son;
            }
            $result['status'] = 1;
        }
        echo json_encode($result);
    }

    public function actionLogin() {
        if (!Yii::app()->user->getIsGuest()) {
            $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
        }

        /*if ((empty(Yii::app()->SESSION['oauth']) || (!empty(Yii::app()->SESSION['oauth']) && Yii::app()->SESSION['oauth'] == 2)) && (!(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false))) {
            Yii::app()->SESSION['oauth'] = 1;
            $this->redirect('https://open.weixin.qq.com/connect/oauth2/authorize?' . http_build_query(array('appid' => 'wx220ef5a844e5701d', 'redirect_uri' => 'http://www.chenengdai.com/wap/site/wxoauth.html', 'response_type' => 'code', 'scope' => 'snsapi_base', '#wechat_redirect' => '')));
        }*/

        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $userid = Yii::app()->user->id;
                $user_model = User::model();
                $user_info = $user_model->findByPk($userid);
                $user_info->login_time = time();
                $user_info->update();
                $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
            }
        }
        $this->render('login', array(
            'model' => $model
        ), false, true);
    }

    public function actionRegister() {
        if (!Yii::app()->user->getIsGuest()) {
            $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
        }
        $model = new Register;
        $message = '';
        if (isset($_POST['Register'])) {
            $model->attributes = $_POST['Register'];
        	$model->user_id = LYCommon::getInsertID();
            if (!empty($_GET['ly'])) {
                $model->p_user_id = base64_decode($_GET['ly']);
            }
			$login_pass = $model->login_pass;
			$is_have = User::model()->findByAttributes(array("user_name"=>$model->user_name));
			if(empty($is_have)){
	            if (LYCommon::validate_code($model->user_phone, 'register_phone', $model->code)) {
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
								UtilCommon::registerInsert($model);
	                            UtilCommon::giveRegisterMoney($model->user_id,"register_award");
	                            $transaction->commit();
	                            $autologin = new UserIdentity($model->user_name, $_POST['Register']['login_pass']);
	                            if ($autologin->authenticate()) {
	                                 Yii::app()->user->login($autologin);
	                                 $this->redirect(Yii::app()->controller->createUrl('usercenter/home'));
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
			}else{
				$message = "用户名已存在" ;
			}
        }
        $this->render('register', array(
            'model' => $model,
            'first_error' => $message,
        ));
    }

    public function actionForgotpass() {
        $first_error = '';
        if (isset($_POST['Forgotpass'])) {
            if (empty($_POST['Forgotpass']['user_phone'])) {
                $first_error = '手机号码不可为空';
            } elseif (empty($_POST['Forgotpass']['code'])) {
                $first_error = '手机验证码不可为空';
            } else {
                $user_model = User::model();
                $user_info = $user_model->findByAttributes(array('user_phone' => $_POST['Forgotpass']['user_phone']));
                if (!empty($user_info)) {
                    $code_model = Code::model();
                    $code_info = $code_model->findByAttributes(array('target' => $user_info->user_phone, 'codecat_id' => '8'));
                    if (!empty($code_info)) {
                        if ($code_info->exc_time > time() && $code_info->status == 0 && $code_info->error_num < 3) {
                            if ($_POST['Forgotpass']['code'] == $code_info->code) {
                                Yii::app()->session['forgot_user_id'] = $user_info->user_id;
                                $this->redirect(Yii::app()->controller->createUrl('site/setNewpass'));
                            } else {
                                $code_info->error_num ++;
                                $code_info->update();
                                $first_error = '手机验证码不正确';
                            }
                        } else {
                            $first_error = '手机验证码不正确';
                        }
                    } else {
                        $first_error = '手机验证码不正确';
                    }
                } else {
                    $first_error = '手机验证码不正确';
                }
            }
        }
        $this->render('forgotpass', array(
            'first_error' => $first_error
        ));
    }
    
    
    
    public function actionSetNewpass() {
        $model = new Userprofile('setnewpass');
        $first_error = '';
        if (isset($_POST['Userprofile'])) {
            $model->attributes = $_POST['Userprofile'];
            $userid = Yii::app()->session['forgot_user_id'];
            $user_info = $model->findByPk($userid);
            if (!empty($user_info)) {
                $user_info->login_pass = LYCommon::get_pass($user_info->user_id, $model->new_pass);
                if ($user_info->update()) {
                    $this->redirect(Yii::app()->controller->createUrl('site/login'));
                }
            } else {
                $first_error = '用户不存在';
            }
            $error = $model->getErrors();
            if (!empty($error)) {
                $first_error = current(current($model->getErrors()));
            }
        }

        $this->render('setnewpass', array(
            'model' => $model,
            'first_error' => $first_error,
        ));
    }
    
    
    public function actionSendsms($phone = null, $type = null) {
        $result = array('status' => 0);
        if (!empty($phone)) {
            if (preg_match('/^1\d{10}$/', $phone)) {
                //只要手机号码格式正确就显示发送成功
                $result['status'] = 1;
                $result['msg'] = '发送成功';
                $user_model = User::model();
                $user_info = $user_model->findByAttributes(array('user_phone' => $phone));
                if ($_REQUEST['type'] == 'register_phone' && !empty($user_info)) {
                    $result['status'] = -1;
                    $result['msg'] = '手机号码已被注册';
                    echo json_encode($result);
                    die;
                }
                if ($type == 'register_phone' && empty($user_info)) {
                    if (($send_result = LYCommon::sendcode(0, $phone, $type)) === true) {
                        $result['status'] = 1; //发送成功
                    } else {
                        $result = $send_result;
                    }
                } elseif (!empty($user_info)) {
                    if (($send_result = LYCommon::sendcode($user_info->user_id, $user_info->user_phone, $type)) === true) {
                        $result['status'] = 1; //发送成功
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

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->controller->createUrl('site/index'));
    }

    public function actionWxoauth() {
        if (!empty($_GET['code'])) {
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
            $params = array(
                'appid' => 'wx220ef5a844e5701d',
                'secret' => '53a49506076bce1ea76bd29187ae33ef',
                'code' => $_GET['code'],
                'grant_type' => 'authorization_code',
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在  
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $data = curl_exec($ch);
            curl_close($ch);
            if ($data) {
                Yii::app()->SESSION['oauth'] = 2;
                $data_info = json_decode($data);
                $oauth_model = new Oauth;
                $oauth_info = $oauth_model->findByAttributes(array('oauth_id' => $data_info->openid));
                if (!empty($oauth_info)) {
                    $user_model = User::model();
                    $user_info = $user_model->findByPk($oauth_info->user_id);
                    $autoLogin = new UserIdentity($user_info->user_name, '');    //自动登录
                    if ($autoLogin->authenticate_oahth($user_info->user_id)) {
                        Yii::app()->user->login($autoLogin);

                        $this->redirect(Yii::app()->controller->createUrl('menu/ihave'));
                    }
                } else {
                    if (!Yii::app()->user->getIsGuest()) {
                        //登陆了，还没有绑定，可以执行绑定操作
                        $oauth_model->user_id = Yii::app()->user->id;
                        $oauth_model->o_type = 1;
                        $oauth_model->oauth_id = $data_info->openid;
                        $oauth_model->add_time = time();
                        $oauth_model->add_ip = Yii::app()->request->userHostAddress;
                        if ($oauth_model->save()) {
                            $this->redirect(Yii::app()->controller->createUrl('menu/ihave'));
                        }
                    } else {
                        Yii::app()->SESSION['oauth'] = 1;
                        //没有登陆，也没有绑定
                        $this->redirect(Yii::app()->controller->createUrl('site/login'));
                    }
                }
            } else {
                var_dump(curl_errno($ch));
                die;
            }
        }
    }

    public function actionCancel_wxoauth() {
        $userid = Yii::app()->user->id;
        $oauth_model = Oauth::model();
        if ($oauth_model->deleteByPk($userid)) {
            $this->redirect(Yii::app()->controller->createUrl('menu/ihave'));
        }
    }

}
