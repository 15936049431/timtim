<?php

class UsercenterController extends WController {
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

    public function actionHome() {
        $userid = Yii::app()->user->id;
        $user_model = User::model();
        $assets_model = Assets::model();
        $user_info = $user_model->findByPk($userid);
        $assets_info = $assets_model->findByPk($userid);
        $everyuser_model = Everyuser::model();
        $every_user = $everyuser_model->findByPk($userid);
        //获取签到信息
        $day_model = Day::model();
        $day_info = $day_model->findByAttributes(array('user_id' => $userid));
        $this->render('home', array(
            'user_info' => $user_info,
            'assets_info' => $assets_info,
            'every_user' => $every_user,
            'day_info' => $day_info,
        ));
    }
    
    public function actionbill(){
    	$userid = Yii::app()->user->id;
    	$bill_model = Bill::model();
    	$bill_list = $bill_model->findAll(array("limit"=>"20","order"=>"b_time DESC","condition"=>"user_id='{$userid}'"));
    	$this->render("bill",array(
    		"bill_list"=>$bill_list,
    	));
    }
    
    public function actionBank(){
    	$userid = Yii::app()->user->id;
    	$user_info = User::model()->findByPk($userid);
    	$bank_model = new AssetsBank;
    	$user_bank = $bank_model->findByAttributes(array("b_user_id"=>$userid));
    	$bank_num = $bank_model->CountByAttributes(array("b_user_id"=>$userid));
    	$bank_type = LYCommon::GetItemList('bank_type');
    	$area_model = Area::model();
    	$area_result = $area_model->findAllByAttributes(array('pid' => '0'));
    	foreach ($area_result as $key => $value) {
    		$area[$value->id] = $value->name;
    	}
    	$message = 0 ;
    	if (isset($_POST['AssetsBank'])) {
    		$bank_model->attributes = $_POST['AssetsBank'];
    		if (!empty($_GET['id'])) {
    			$bank_model->b_addtime = time();
    			$bank_model->b_addip = $_SERVER['REMOTE_ADDR'];
    		} else {
    			$bank_model->b_id = LYCommon::getInsertId();
    			$bank_model->b_addtime = time();
    			$bank_model->b_addip = $_SERVER['REMOTE_ADDR'];
    			$bank_model->b_user_id = $userid;
    		}
    		$bank_model->b_status = 1;
    		if ($bank_num >= 1) {
    			$message = array("银行卡最多添加1张",Yii::app()->controller->createUrl("usercenter/home"));
    		} elseif ($user_info->is_realname_check != 1) {
    			$message = array("清先实名认证",Yii::app()->controller->createUrl("safecenter/home"));
    		} else {
    			if ($bank_model->save()) {
    					$this->redirect(Yii::app()->controller->createUrl("usercenter/bank"));
    			} else {
    				$message = current(current($bank_model->getErrors()));
    			}
    		}
    	}
    	$this->render("bank",array(
    		"user_info"=>$user_info,
    		"user_bank"=>$user_bank,
    		"bank_model"=>$bank_model,
    		"bank_type"=>$bank_type,
    		"area"=>$area,
    		"message"=>$message,
    	));
    }
    
    public function actionGetCity() {
    	$area_model = Area::model();
    	$area = $area_model->findAllByAttributes(array('pid' => $_POST['city']));
    	if (!empty($area)) {
    		$str = "";
    		foreach ($area as $key => $value) {
    			$str.="<option value='{$value->id}'>{$value->name}</option>";
    		}
    		echo $str;
    		exit;
    	}
    	echo "error";
    	exit;
    }
    
    public function actionrecharge_return() {
    	$message = $success = 0;
    	if (isset($_REQUEST)) {
    		$result = PayCommon::GetBack($_REQUEST);
    		if ($result) {
    			$success = array("充值成功", Yii::app()->controller->createUrl('usercenter/home'));
    		} else {
    			$success = array("充值失败", Yii::app()->controller->createUrl('usercenter/home'));
    		}
    	} else {
    		$success = array("请不要非法访问", Yii::app()->controller->createUrl('usercenter/home'));
    	}
    	$this->render("recharge_return", array(
    			"message" => $message,
    			"success" => $success,
    	));
    }
    
    public function actionrecharge(){
    	$userid = Yii::app()->user->id;
        $message = 0;

        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        if ($user_info->is_realname_check != 1) {
            $message = array("请先进行实名认证", Yii::app()->controller->createUrl('usercenter/realname'));
        }
        //获取用户资金信息
        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($userid);

    	$phone_recharge = array("shanxin_pay","tonglianphone_pay");
        $online_recharge = LYCommon::GetItemList("assets_recharge_type",'i_order ASC');
        foreach($online_recharge as $k=>$v){
        	if(!in_array($v->i_nid,$phone_recharge)){
        		unset($online_recharge[$k]);
        	}
        }
        $overline_recharge = LYCommon::GetItemList("assets_oevrrecharge_type");
        $recharge_model = new AssetsRecharge();

		$bank_model = AssetsBank::model();
        $bank_list = $bank_model->findAllByAttributes(array('b_user_id' => $userid, 'b_status' => 1));
		
        if (isset($_POST['AssetsRecharge'])) {
			if(($_POST['AssetsRecharge']['r_recharge_type']=="shanxin_pay") && empty($_POST['bankCard'])){
				$message = array("请先绑定银行卡", Yii::app()->controller->createUrl('usercenter/bank'));
			}elseif ($_POST['AssetsRecharge']['r_money'] >= 0) {
                if ($_POST['type'] == "online" || ($_POST['type'] == "overline" && !empty($_POST['AssetsRecharge']['r_BillNo']))) {
                    $recharge_model->attributes = $_POST['AssetsRecharge'];
                    $recharge_model->r_BillNo = ($_POST['type'] == "online") ? substr(time() . $userid . rand(1, 9), 0, 18) : $_POST['AssetsRecharge']['r_BillNo'];
                    $recharge_model->r_id = LYCommon::getInsertID();
                    $recharge_model->r_user_id = $userid;
                    $recharge_model->r_realmoney = $_POST['AssetsRecharge']['r_money'];
                    $recharge_model->r_type = ($_POST['type'] == "online") ? 1 : 2;
                    $recharge_model->r_addtime = time();
                    $recharge_model->r_addip = $_SERVER['REMOTE_ADDR'];
					$recharge_model->sign =	empty($_POST['bankCard']) ? "" : $_POST['bankCard'];
                    if ($recharge_model->save()) {
                        if ($recharge_model->r_type == 2) {
                            $message = array("提交成功", Yii::app()->controller->createUrl('usercenter/rechargelist'));
                        } else {
                            $result = PayCommon::GetRechargeType($recharge_model);
                            if (isset($result['form'])) {
								header("Content-type: text/html; charset=utf-8"); 
                                echo $result['form'];
                                exit;
                            } elseif(isset($result['treasure'])){
                            	$recharge_model->r_verify_remark = json_encode($result);
                            	$recharge_model->update();
                            	if($result['returnCode'] == "IPS0000"){
                            		$message = array("申请成功", Yii::app()->controller->createUrl('usercenter/home'));
                            	}else{
                            		$message = array(empty($result['message']) ? "未知错误" : $result['message']) ;
                            	}
                            }else {
								header("Content-type: text/html; charset=utf-8"); 
                                header("Location: {$result['url']}");
                                exit;
                            }
                        }
                    } else {
                        $message = current(current($recharge_model->getErrors()));
                    }
                } else {
                    $message = array("充值方式不正确,线下充值应填写流水号！");
                }
            } else {
                $message = array("充值金额最小10元！");
            }
        }

        $this->render('recharge', array(
            'assets_info' => $assets_info,
            'online_recharge' => $online_recharge,
            'overline_recharge' => $overline_recharge,
            'model' => $recharge_model,
            'message' => $message,
			'bank_list'=>$bank_list,
        ));
    }
    
    public function actioncash(){
    	$userid = Yii::app()->user->id;
    	$cash_model = new AssetsCash;
    	$message =  0; $bank_list = array();
    	$bank_model = AssetsBank::model();
    	$user_bank = $bank_model->findAllByAttributes(array("b_user_id"=>$userid));
    	$user_info = User::model()->findByPk($userid);
    	if($user_info->is_realname_check!=1){
    		$message = array("清先进行实名认证",Yii::app()->controller->createUrl("usercenter/home"));
    	}elseif(empty($user_bank)){
    		$message = array("请先绑定银行卡",Yii::app()->controller->createUrl("usercenter/bank"));
    	}
    	$assets_info = Assets::model()->findByPk($userid);
    	foreach($user_bank as $k=>$v){
    		$bank_list[$v->b_id] = $v->item->i_name.$v->b_cardNum;
    	}
    	if (isset($_POST['AssetsCash'])) {
    		$cash_model->attributes = $_POST['AssetsCash'];
    		$bank_one = $bank_model->findByPk($cash_model->c_bank);
            $cash_one = $cash_model->findByAttributes(array("c_user_id" => $userid), array("order" => "c_addtime DESC"));
            if (empty($user_info->is_realname_check)) {
                $message = array('请先实名认证',Yii::app()->controller->createUrl("safecenter/home"));
            } elseif (LYCommon::get_pass($user_info->user_id, $_POST['paypassword']) != $user_info->pay_pass) {
                $message = array('交易密码输入有误',Yii::app()->controller->createUrl("usercenter/cash"));
            } elseif (empty($bank_one)) {
               $message = array('清先绑定银行卡',Yii::app()->controller->createUrl("usercenter/cash"));
            } elseif ($cash_model->c_money > $assets_info->real_money) {
                $message = array('提现金额大于可用余额',Yii::app()->controller->createUrl("usercenter/cash"));
            } elseif ($cash_model->c_money < 10 || $cash_model->c_money > 50000) {
				$message = array('提现金额区间为(10 - 50000)元',Yii::app()->controller->createUrl("usercenter/cash"));
            } elseif (!empty($cash_one) && time() - $cash_one->c_addtime < 10) {
				$message = array('提现过于频繁, 请1分钟后在做操作',Yii::app()->controller->createUrl("usercenter/cash"));
            } else {
                $cash_model->c_id = LYCommon::getInsertID();
                $cash_model->c_user_id = $userid;
                $cash_model->c_status = 0;
                $cash_model->c_cardNum = $bank_one->b_cardNum;
                $cash_model->c_bank = $bank_one->b_bank;
                $cash_model->c_branch = $bank_one->b_branch;
                $cash_model->c_fee = LYCommon::getCashFee($userid, $cash_model->c_money);
				$cash_model -> c_city = $bank_one->b_city;
				$cash_model-> c_province = $bank_one->b_province;
				$cash_model -> c_branch = $bank_one->b_branch;
                $cash_model->c_realmoney = $cash_model->c_money ;//- $cash_model->c_fee
                $cash_model->c_addtime = time();
                $cash_model->c_addip = $_SERVER['REMOTE_ADDR'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($cash_model->save()) {
                        $bill['user_id'] = $userid;
                        $bill['b_money'] = $cash_model->c_money;
                        $bill['b_type'] = 1;
                        $bill['b_itemtype'] = "assets_cash_forzen";
                        $bill['u_total_money'] = $assets_info->total_money;
                        $bill['u_real_money'] = $assets_info->real_money - $bill['b_money'];
                        $bill['u_frost_money'] = $assets_info->frost_money + $bill['b_money'];
                        $bill['u_wait_interest'] = $assets_info->wait_interest;
                        $bill['u_have_interest'] = $assets_info->have_interest;
                        $bill['u_wait_total_money'] = $assets_info->wait_total_money;
                        $bill['b_mark'] = $bank_one->b_id;
                        $bill['b_time'] = time();
                        $bill['remark'] = "提现冻结{$cash_model->c_money}元！";
                        LYCommon::AddBill($bill);
                        //发送站内信
                        LYCommon::send_message(0, $cash_model->c_user_id, 'apply_cash', array('cash_money' => $cash_model->c_money));
                    }
                    $assets_user = Assets::model()->findByPk($userid);
                    $assets_user->continue_money = ($assets_user->continue_money - $cash_model->c_money > 0) ? $assets_user->continue_money - $cash_model->c_money : 0 ;
                    $assets_user->update();
                    $transaction->commit();
                    $message = array("提现申请成功", Yii::app()->controller->createUrl('usercenter/home'));
                } catch (Exception $e) {
                    $transaction->rollback();
                }
    			$message = array("未知错误", Yii::app()->controller->createUrl('usercenter/home'));
    		}
    	}
    	$this->render("cash",array(
    		"model"=>$cash_model,
    		"message"=>$message,
    		"bank_list"=>$bank_list,
    	));
    }

    public function actionNewday() {
        $result = array('status' => 0);
        $day_model = new Day;
        $userid = Yii::app()->user->id;
        $day_info = $day_model->findByAttributes(array('user_id' => $userid));
        if (!empty($day_info)) {
            if ($day_info->day_time < strtotime(date('Y-m-d'))) {
                $day_info->day_time = time();
                if ($day_info->update()) {
                    $integral_model = Integral::model();
                    $integral_info = $integral_model->findByPk($userid);
                    $integral_info->i_total_value += Yii::app()->params['invest_newday'] * 2;
                    $integral_info->i_real_value += Yii::app()->params['invest_newday'] * 2;
                    $data = array(
                        'i_cat_alias' => 'newday',
                        'remark' => '签到加积分',
                    );
                    LYCommon::Add_integral($integral_info, $data);
                    $result['status'] = 1; //签到成功
                } else {
                    $result['status'] = 3; //签到失败，数据更新失败。请稍后再试
                    $result['message'] = '签到失败';
                }
            } else {
                $result['status'] = 2; //您今天已经签过到了。请明天再来
                $result['message'] = '您今天已经签过到了。请明天再来';
            }
        } else {
            $day_model->day_id = LYCommon::getInsertID();
            $day_model->user_id = $userid;
            $day_model->day_time = time();
            if ($day_model->insert()) {
                $data = array(
                    'user_id' => $userid,
                    'integral' => Yii::app()->params['invest_newday'] * 2,
                    'type' => 1,
                    'i_cat_alias' => 'newday',
                    'remark' => '签到加积分',
                );
                LYCommon::Addintegral($data);
                $result['status'] = 1; //签到成功
            } else {
                $result['status'] = 3; //签到失败，数据插入失败。请稍后再试
                $result['message'] = '签到失败';
            }
        }
        echo json_encode($result);
    }

    public function actionorder() {
    	$userid = Yii::app()->user->id;
    	$project_order_model = ProjectOrder::model();
    	$project_order_list = $project_order_model->findAll(array("limit" => "10", "order" => "p_addtime DESC", "condition" => "p_user_id='{$userid}'"));
    	$this->render("order", array(
    			"project_order" => $project_order_list,
    	));
    }

    public function actionhaverepay() {
        $userid = Yii::app()->user->id;
        $model = ProjectCollect::model();
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{project_order}} as t1 on t.p_project_order = t1.p_id';
        $criteria->compare("t1.p_user_id", $userid);
        $criteria->compare("t.p_status", array(1, 2));
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time() + 86400 * 365 * 5;
        $criteria->addCondition("t.p_repaytime>'{$start_time}' and t.p_repaytime<'{$end_time}'");
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC,p_order asc';
        $list = $model->findAll($criteria);
        $this->render("haverepay", array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionwaitrepay() {
        $userid = Yii::app()->user->id;
        $model = ProjectCollect::model();
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{project_order}} as t1 on t.p_project_order = t1.p_id left join {{project}} as t2 on t.p_project_id = t2.p_id';
        $criteria->compare("t1.p_user_id", $userid);
        $criteria->compare("t.p_status", "0");
        $criteria->compare("t2.p_status", "3");
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time() + 86400 * 365 * 5;
        $criteria->addCondition("t.p_repaytime>'{$start_time}' and t.p_repaytime<'{$end_time}'");
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC,p_order asc';
        $list = $model->findAll($criteria);
        $this->render("waitrepay", array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionorderon() {
        $order_model = ProjectOrder::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{project}} as t1 on t.p_project_id = t1.p_id';
        $criteria->compare('t.p_user_id', $userid);
        $criteria->compare('t1.p_status', "1");
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time();
        $criteria->addCondition("t.p_addtime>'{$start_time}' and t.p_addtime<'{$end_time}'");
        $total_count = $order_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $order_model->findAll($criteria);
        $this->render("orderon", array(
            'list' => $list,
            'page_list' => $page_list,
            'model' => $order_model,
        ));
    }

    public function actioninvite() {
		$userid = Yii::app()->user->id;
		$invite_url = Yii::app()->request->hostInfo.'/site/register.html?ly='.base64_encode($userid);
		$erm_url = UtilCommon::WxCode($userid, $invite_url, "invite");
		$this->render("invite",array(
			"url"=>$erm_url,
			"invite_url"=>$invite_url,
		));
    }
   
    public function actionintegrallog() {
        $userid = Yii::app()->user->id;
        $exchange_model = new IntegralOrder;
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $userid);
        $criteria->compare('foods_type', "14287729544582441");
        $total_count = $exchange_model->count($criteria);
        $page = new Pagination($total_count, 20);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'addtime DESC';
        $list = $exchange_model->findAll($criteria);
        $this->render("integrallog", array(
            "list" => $list,
            "page_list" => $page_list,
        ));
    }
    
    public function actionrealname(){
    	$userid = Yii::app()->user->id;
    	$identity_model = new Identity;
    	$identity_info = $identity_model->findByAttributes(array('user_id' => $userid));
    	$user_info = User::model()->findByPk($userid);
    	$message = 0;
    	if(isset($_POST['Identity'])){
    		if (!empty($_POST['Identity']['identity_num'])) {
    			$_POST['Identity']['identity_num'] = strtoupper($_POST['Identity']['identity_num']);
    		}
    		if (empty($identity_info)) {
                $identity_model->attributes = $_POST['Identity'];
                $identity_model->identity_id = LYCommon::getInsertID();
                $identity_model->user_id = $userid;
                $identity_model->status = 0;
                $identity_model->add_time = time();
                $identity_model->add_ip = Yii::app()->request->userHostAddress;
                if ($identity_model->save()) {
                	$result = DoubleCommon::Name(array("realname"=>$identity_model->real_name,"identificationNo"=>$identity_model->identity_num));
                	$notify = DoubleCommon::AddName($identity_model,json_decode($result));
                	if($notify == true){
                		$message = array("实名认证成功!", Yii::app()->controller->createUrl("usercenter/home"), 1, 1);
                	}else{
                		$message = array("实名认证失败!", Yii::app()->controller->createUrl("usercenter/home"), 2, 2);
                	}
                } else {
                    $message = array(current(current($identity_model->getErrors())));
                }
            } else {
                $identity_info->attributes = $_POST['Identity'];
                $identity_info->status = 0;
                $identity_info->add_time = time();
                $identity_info->add_ip = Yii::app()->request->userHostAddress;
                if ($identity_info->save()) {
                	$result = DoubleCommon::Name(array("realname"=>$identity_info->real_name,"identificationNo"=>$identity_info->identity_num));
                	$notify = DoubleCommon::AddName($identity_model,json_decode($result));
                	if($notify == true){
                		$message = array("实名认证成功!", Yii::app()->controller->createUrl("usercenter/home"), 1, 1);
                	}else{
                		$message = array("实名认证失败!", Yii::app()->controller->createUrl("usercenter/home"), 2, 2);
                	}
                } else {
                    $message = array(current(current($identity_info->getErrors())));
                }
            }
    	}
    	$this->render("realname",array(
    		"message"=>$message,
    		"model"=>$identity_model,
    		"user_info"=>$user_info,
    	));
    }
    
    public function actionemail(){
    	$userid = Yii::app()->user->id;
    	$user_model = new Userprofile('bind_email');
    	$user_info = $user_model->findByPk($userid);
    	$message = 0;
    	if (isset($_POST['Userprofile'])) {
    		$user_model->attributes = $_POST['Userprofile'];
    		if ($user_model->validate()) {
    			$code_model = Code::model();
    			$code_info = $code_model->findByAttributes(array('target' => $user_model->user_email, 'codecat_id' => '4'));
    			if (!empty($code_info)) {
    				if ($code_info->exc_time > time() && $code_info->status == 0 && $code_info->error_num < 3) {
    					if ($code_info->code == $user_model->code) {
    						$user_info->is_email_check = 1;
    						$user_info->user_email = $user_model->user_email;
    						if ($user_info->update()) {
    							$code_info->status = 1;
    							$code_info->update();
    							$message = array("绑定成功", Yii::app()->controller->createUrl('safecenter/index'));
    						}
    					} else {
    						$user_model->addError('code', '验证码不正确');
    						$code_info->error_num ++;
    						$code_info->update();
    						$message = array("验证码输入有误");
    					}
    				} else {
    					$user_model->addError('code', '验证码不正确');
    					$message = array("验证码已过期");
    				}
    			} else {
    				$model->addError('code', '验证码不正确');
    				$message = array("验证码不能为空");
    			}
    		}
    	}
    	$this->render("email",array(
    		"user_info"=>$user_info,
    		"user_model"=>$user_model,
    		"message"=>$message,
    	));
    }
    
    public function actionSendEmail($email = null, $type = null) {
    	$result = array('status' => 0);
    	$userid = Yii::app()->user->id;
    	$email = empty($email) ? $_POST['email'] : $email;
    	if (!empty($email)) {
    		$user_model = User::model();
    		$user_info = $user_model->findByAttributes(array('user_email' => $email, 'is_email_check' => 1));
    		if (empty($user_info)) {
    			if (($send_result = LYCommon::sendcode($userid, $email, $type)) === true) {
    				$result['status'] = 1; //发送成功
    				$result['msg'] = "发送成功";
    			} else {
    				$result = $send_result;
    			}
    		} else {
    			$result['msg'] = "邮箱已存在";
    		}
    	} else {
    		$result['msg'] = '邮箱不可为空';
    	}
    	echo json_encode($result);
    }
	
	public function actionpaypass(){
		$userid = Yii::app()->user->id;
		$user_info = User::model()->findByPk($userid);
		$model = new Userprofile('setnew_pay_pass');
		$message = 0 ; 
		if(isset($_POST['Userprofile'])){
			$model->attributes = $_POST['Userprofile'];
			if(LYCommon::get_pass($userid,$_POST['Userprofile']['pay_pass']) != $user_info->pay_pass){
				$message = array("原交易密码输入有误");
			}elseif($model->new_pass != $model->re_new_pass){
				$message = array("两次输入密码不一致");
			}elseif(LYCommon::get_pass($userid,$model->new_pass) == $user_info->login_pass){
                $message = array("交易密码与登陆密码不能设置同一密码");
            }else{
				$user_info->pay_pass = LYCommon::get_pass($userid,$model->new_pass);
				if($user_info->update()){
					$message = array("修改成功",Yii::app()->controller->createUrl("usercenter/home"));
				}else{
					$message = array(current(current($user_info->getErrors())));
				}
			}
		}
		$this->render("paypass",array(
			"user_info"=>$user_info,
			"model"=>$model,
			"message"=>$message,
		));
	}
	
	

}
