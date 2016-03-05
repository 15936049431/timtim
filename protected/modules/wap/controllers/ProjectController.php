<?php

class ProjectController extends WController{
    
    public function actionView($id){
        if(!preg_match('/^\d{0,}$/', $id)){
            throw new CHttpException('404');
        }
        
        $project_model = Project::model();
        $project_info = $project_model -> findByPK($id);
        $project_pic_model = ProjectPic::model();
        
        if(!empty($project_info)){
            $project_pic_list = $project_pic_model->findAllByAttributes(array("p_project_id"=>$project_info->p_id));
        }else{
            throw new CHttpException('404');
        }
        $project_order_model=ProjectOrder::model();
        $project_order_list = $project_order_model->findAll(array("condition"=>"p_project_id={$id}","order"=>"p_addtime DESC"));
    	$connection = Yii::app()->db;
    	$count = "select count(*) as num from {{project_order}} where p_project_id='{$id}'";
    	$num=intval($connection->createCommand($count)->queryScalar());
        
        $this -> render('view',array(
            'project_info'=>$project_info,
        	'project_pic_list'=>$project_pic_list,'project_order'=>$project_order_list,'num'=>$num
        ),false,true);
    }
    
    public function actionList(){
            $project_modle = Project::model();
            $criteria = new CDbCriteria;
            $criteria ->compare('p_status', array(1,3));
            $criteria -> select = '*, (p_account_yes/p_account) as jindu';
            $criteria -> order = 'jindu ASC, p_verifytime DESC';
            $criteria -> limit = 10 ;
            $project_info = $project_modle -> findAll($criteria); 
            $this->render('list',array(
                'project_info'=>$project_info,
            ));
    }
    
    
    public function actionpay($id){
        if(Yii::app()->user->getIsGuest()){
            $this ->redirect(Yii::app()->controller->createUrl('site/login'));
        }
        if(!preg_match('/^\d{0,}$/', $id)){
            throw new CHttpException('404');
        }
        $message = 0 ;
        $userid = Yii::app()->user->id;

        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        $project_model = Project::model();
        $project_info = $project_model->findByPk($id);
        $assets_info = Assets::model()->findByPk($userid);
        if ($project_info->p_user_id == $userid) {
        	$message = array("不能投自己的标", Yii::app()->controller->createUrl('usercenter/home'), 2, 2);
        } elseif ($user_info->is_realname_check != 1) {
        	$message = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 1, 1);
        }
        $project_order_model = new ProjectOrder("order_one");
        if (isset($_POST['ProjectOrder'])) {
            $project_order_model->attributes = $_POST['ProjectOrder'];
            $project_order_model->p_realmoney = $project_order_model->p_money;
            $status = 1;
            if (($project_order_model->p_money + $project_info->p_account_yes) > $project_info->p_account) {
                $project_order_model->p_money = round($project_info->p_account - $project_info->p_account_yes,4);
                $status = 2;
            }
            $project_order_model->p_id = LYCommon::getInsertID();
            $project_order_model->p_user_id = $userid;
            $project_order_model->p_status = $status;
            
            $connection = Yii::app()->db;
            $sql = "select sum(p_money) from ly_project_order where p_user_id='{$userid}' and p_project_id='{$project_info->p_id}'";
            $result = $connection->createCommand($sql)->queryScalar();
            $timer = $connection->createCommand("select p_addtime from {{project_order}} where p_user_id='{$userid}' order by p_addtime DESC")->queryScalar();
            if ($user_info->pay_pass != LYCommon::get_pass($user_info->user_id, $project_order_model->pay_pass)) {
                $message = array("交易密码输入有误");
            } elseif ($project_order_model->p_money > $assets_info->real_money) {
                $message = array("投标金额大于可用金额");
            } elseif ($project_info->p_dxb != "" && $project_info->p_dxb != $_POST['ProjectOrder']['p_dxb']) {
                $message = array("定向标密码输入有误!");
            } elseif ($project_info->p_user_id == $userid) {
                $message = array("不能投自己的标!");
            } elseif ($project_order_model->validate() != true) {
            	$message = array("验证码错误" );
            }elseif ($project_info->p_status != 1) {
            	$message = array('状态有误');
            }elseif (!is_numeric($project_order_model->p_money) || $project_order_model->p_money <= 0) {
	            $message = array('投标金额非法');
	        }elseif ($project_info->p_account < ($project_info->p_account_yes + $project_order_model->p_money)) {
	            $message = array('投标金额大于可投金额');
	        }elseif ($project_order_model->p_realmoney < $project_info->p_lowaccount && Yii::app()->params['project_quota'] == 1) {
	            $message = array('投标金额小于最小投标限额');
	        }elseif ($project_order_model->p_money > $project_info->p_mostaccount && Yii::app()->params['project_quota'] == 1 && $project_info->p_mostaccount != 0) {
	            $message = array('投标金额大于最大投标限额');
	        }elseif (!empty($result) && $result + $project_order_model->p_money > $project_info->p_mostaccount && $project_info->p_mostaccount != 0 && Yii::app()->params['project_quota']){
	        	$message = array("您的投标总额已经大于最高投资金额{$project_info->p_mostaccount}");
	        }elseif (!empty($timer) && time() - $timer < 60*5) {
				$message = array('投资过于频繁, 请5分钟后在做操作');
            }else {
            	$result = LYCommon::AddOrder($project_info, $project_order_model);
        		$project_now = $project_model -> findByPk($project_info->p_id);
        		if ($result === true) {
        			if ($project_now->p_account_yes >= $project_now->p_account) {
        				$project_now -> p_fulltime = time();
        				if($project_now->p_type == 4){
        					$project_now->p_fullverifyuser = 0;
        					$project_now->p_fullverifytime = time();
        					$project_now->p_status = 3;
        					$project_now->p_fullverifyremark = "秒标自动审核通过";
        					$project_now->update();
        					$project_order_list = $project_order_model->findAllByAttributes(array("p_project_id" => $project_now->p_id));
        					LYCommon::AddRepay($project_now, $project_order_list);
        					$repayment_model = ProjectRepay::model();
        					$repayment_list = $repayment_model->findAllByAttributes(array("p_project_id" => $project_now->p_id, "p_status" => "0"));
        					foreach ($repayment_list as $k => $v) {
        						LYCommon::Repay($v);
        					}
        				}else{
        					$project_now->update();
        				}
        			}
        			$message = array('投资成功',Yii::app()->controller->createUrl("usercenter/home"));
        		} else {
        			$message = $result;
        		}
	        }
        }
        
        $this -> render('pay',array(
            "message"=>$message,
        	'project_info' => $project_info,
            'project_order_model' => $project_order_model,
        	'assets_info' => $assets_info,
			'user_info'=>$user_info,
        ));
    }
	
	
}