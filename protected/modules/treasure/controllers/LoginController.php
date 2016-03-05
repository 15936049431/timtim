<?php
class LoginController extends BController{
    
    function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'minLength' => 4,
                'maxLength' => 4,
                'width' => 104,
                'height' => 26,
                'testLimit' => 1,
            	'offset'=>0,
            ),
        );
    }
    
    public function actionLogin(){
        if(!Yii::app()->user->getIsGuest()){
            $this->redirect(Yii::app()->controller->createUrl('default/index'));
        }
        $login_model = new LoginForm;
        if(isset($_POST['LoginForm'])){
            $login_model->attributes = $_POST['LoginForm'];
            if ($login_model->validate() && $login_model->login()){
                $manager_info = Manager::model()->findByPk(Yii::app()->user->id);
                $manager_info->login_time = time();
                $manager_info->update();
                Yii::app()->user->setState('login_time',$manager_info->login_time);
                Yii::app()->user->setState('issuper',$manager_info->issuper);
                if(Yii::app()->params['site_seclogin'] == 0){
                    self::loginsucceed($manager_info);
                }else{
                    $this->redirect(Yii::app()->controller->createUrl('seclogin'));
                }
            }
        }
        $this->renderPartial('login',array(
            'login_model'=>$login_model,
        ),$return=false,$processOutput=true);
    }
    
    public function actionSeclogin(){
        if(!Yii::app()->user->getIsGuest()){
            if(Yii::app()->session['issecloginval'] == 1){
                $this->redirect(Yii::app()->controller->createUrl('default/index'));
            }
            $manager_info = Manager::model()->findByPk(Yii::app()->user->id);
            Yii::app()->session['manager_tel'] = $manager_info->manager_tel;
            $error = null;
            if(isset($_POST['SecLoginForm'])){
                if(intval($_POST['SecLoginForm']['validate_type']) == 1){
                    if(intval($_POST['SecLoginForm']['seccode']) == Yii::app()->session['seccode'] && !empty($_POST['SecLoginForm']['seccode'])){
                        self::loginsucceed($manager_info);
                    }else{
                        $error = '手机验证码输入不正确';
                    }
                }elseif(intval($_POST['SecLoginForm']['validate_type']) == 2){
                    $ga = new GoogleAuthenticator($manager_info);
                    $veryfy = $ga->verifyCode(LYCommon::zjy_decode($manager_info->google_secret,$manager_info->manager_name), intval($_POST['SecLoginForm']['seccode']), 2);
                    if($veryfy){
                        self::loginsucceed($manager_info);
                    }else{
                        $error = '谷歌验证码输入不正确';
                    }
                }
            }
            $this->renderPartial('seclogin',array(
                'manager_info'=>$manager_info,
                'error'=>$error,
                ),
                $return=false,
                $processOutput=true
            );
            
        }else{
            $this->redirect('login');
        }
    }
    
    public function actionGetseccode(){
        if(!(Yii::app()->user->getIsGuest()) && Yii::app()->session['issecloginval']==0){
            //$result = array('status'=>0);
            $seccode = rand(100000, 999999);
            Yii::app()->session['seccode'] = $seccode;
            echo $seccode;
        }
    }
    
    
    private function loginsucceed($manager_info){
        Yii::app()->session['issecloginval'] = 1;
        if($manager_info->issuper == 0){
            $userid = Yii::app()->user->id;
            $connection = Yii::app()->db;
            $rbac_list = $connection->createCommand("SELECT * FROM {{authassignment}} as t1
            INNER JOIN {{authitem}} as t2
            on t1.itemname = name
            WHERE t2.type = 2 AND t1.userid = {$userid}
            LIMIT 1")->queryAll();
            Yii::app()->user->setState('rolename',$rbac_list[0]['name']);
        }else{
            Yii::app()->user->setState('rolename','超级管理员');
        }
        $this->redirect(Yii::app()->controller->createUrl('default/index'));
    }


    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }
}