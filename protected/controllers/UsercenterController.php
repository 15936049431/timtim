<?php

class UsercenterController extends Controller {

    public $layout = '//layouts/usercenter_main';
    public $safevalue;
    public $real_money;

    /*
     * 检测用户是否登陆，未登录就跳转到登陆页
     */

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $yes_acc = array('recharge_return');
            if(!in_array($action->id, $yes_acc)){
                if (Yii::app()->user->getIsGuest()) {
                    $this->redirect(array('site/login'));
                }
            }
            return true;
        }
    }

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

    public function actionHome() {
        $userid = Yii::app()->user->id;
        //获取用户信息
        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
		if(empty($user_info->register_ip)){
			$user_info->register_ip = Yii::app()->request->userHostAddress;
			$user_info->update();
		}
        //获取用户资金信息
        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($userid);
        //如果没有资金记录则生成资金记录
        if (empty($assets_info)) {
            $assets_model = new Assets;
            $assets_model->user_id = $user_info->user_id;
            $assets_model->insert();
            $assets_info = $assets_model;
        }
        //获取签到信息
        $day_model = Day::model();
        $day_info = $day_model->findByAttributes(array('user_id' => $userid));
        //获取用户资金信息
        $integral = Integral::model();
        $integral_info = $integral->findByPk($userid);
        //如果没有积分记录则生成资金记录
        if (empty($integral_info)) {
            $integral = new Integral;
            $integral->user_id = $user_info->user_id;
            $integral->i_addtime = time();
            $integral->i_addip = Yii::app()->request->userHostAddress;
            $integral->insert();
            $integral_info = $integral;
        }
        
        $hello = self::getHello($user_info->real_name,$user_info->user_sex);
        $money['invite_url'] = Yii::app()->request->hostInfo . '/site/register.html?ly=' . base64_encode($userid);
        $money['num'] = $money['cash_money'] = $money['tender_money'] = 0;
        $connection = Yii::app()->db;
        $num_sql = "select b.id from (select @a:=@a+1 as id,a.* from {{assets}} as a order by total_money DESC) as b where b.user_id='{$userid}' ";
        $connection->createCommand("set @a=0;")->execute();
        $num = $connection->createCommand($num_sql)->queryScalar();
        $money['num'] = ($num<100) ? "{$num}，继续保持哦！" : (ceil($num/100)*100)."之外，赶紧去投资吧！" ; 
        $collect_list = ProjectCollect::model()->findAll(array("limit"=>"10","condition"=>"p_user_id = '{$userid}' and p_status=0","order"=>"p_repaytime ASC"));
		$collect_time = self::getCollectTime($userid);
        
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
        $user_safechar = ($user_safenum > 0 && $user_safenum < 50) ? '低' : (($user_safenum > 50 && $user_safenum < 90) ? '中' : '高' );
        $auto_order = ProjectAutoorder::model()->findByAttributes(array("p_user_id"=>$userid));
        $this->render('home', array(
            'user_info' => $user_info,
            'assets_info' => $assets_info,
            'integral_info' => $integral_info,
            'day_info' => $day_info,
            'money' => $money,
            'hello' => $hello,
            'user_safenum' => $user_safenum,
            'user_safechar' => $user_safechar,
        	'collect_list'=> $collect_list,
        	'collect_time'=>$collect_time,
        	"auto_order"=>$auto_order,
        ));
    }
    
    public function getCollectTime(){
    	$userid = Yii::app()->user->id;
    	$time_week = $time[0]['timestamp'] = strtotime(date("Y-m-d",strtotime("-1 week")));
    	$time[0]['date'] = date("m-d",$time_week);
    	for($i=1 ; $i<7 ; $i++){
    		$time[$i]['timestamp'] = $time_week+3600*24*$i ;
    		$time[$i]['date'] = date("m-d",$time[$i]['timestamp']);
    	}
    	$bill_model = Bill::model();
    	$interest_array = join(",",array("'assets_order_award'"));
    	$return_list = array();
    	$money = $all_money = 0 ;
    	$connection = Yii::app()->db;
    	foreach($time as $k=>$v){
    		$tomorrow = $v['timestamp'] + 3600 * 24;
    		$sql = "select sum(b_money) as money from {{bill}} where user_id='{$userid}' and b_time>={$v['timestamp']} and b_time<{$tomorrow} and b_itemtype in ($interest_array) "; 
    		$money = $connection->createCommand($sql)->queryScalar();
    		$return_list['list'][$v['date']] = empty($money) ? 0 : $money;
    		$all_money += empty($money) ? 0 : $money;
    	}
    	$return_list['money'] = $all_money ; 
    	return $return_list;
    }

    public function getHello($username,$sex) {
        $hour = date("H", time());
        $username = substr(trim($username), 0, 3);
        $str = "";
        if ($hour > 6 && $hour <= 10) {
            $str = "早上好";
        } elseif ($hour > 10 && $hour <= 16) {
            $str = "中午好";
        } elseif ($hour > 16 && $hour <= 23) {
            $str = "晚上好";
        } else {
            $str = "凌晨了";
        }
        $sex = ($sex==1) ? "先生" : ($sex==2 ? "女士" : "") ;
        return (empty($username) && empty($sex)) ? $str : $str.",".$username.$sex;
    }

    public function actionRecharge() {
        $userid = Yii::app()->user->id;
        $message = $success = 0;

        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        if ($user_info->is_realname_check != 1) {
            $success = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        }

        //获取用户资金信息
        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($userid);

        $phone_recharge = array("yinlian_pay","lianlianphone_pay","cpphonefast_pay");
        $online_recharge = LYCommon::GetItemList("assets_recharge_type",'i_order ASC');
        foreach($online_recharge as $k=>$v){
        	if(in_array($v->i_nid,$phone_recharge)){
        		unset($online_recharge[$k]);
        	}
        }
        $overline_recharge = LYCommon::GetItemList("assets_oevrrecharge_type");
        $recharge_model = new AssetsRecharge();

		$bank_model = AssetsBank::model();
        $bank_list = $bank_model->findAllByAttributes(array('b_user_id' => $userid, 'b_status' => 1));
		
        if (isset($_POST['AssetsRecharge'])) {
			if(($_POST['AssetsRecharge']['r_recharge_type']=="shanxin_pay") && empty($_POST['bankCard'])){
				$success = array("请先绑定银行卡", Yii::app()->controller->createUrl('usercenter/bank'), 2, 2);
			}elseif ($_POST['AssetsRecharge']['r_money'] >= 0) {
                if ($_POST['type'] == "online" || ($_POST['type'] == "overline" && !empty($_POST['AssetsRecharge']['r_BillNo']))) {
                    $recharge_model->attributes = $_POST['AssetsRecharge'];
                    $recharge_model->r_BillNo = ($_POST['type'] == "online") ? time() . $userid . rand(1, 9) : $_POST['AssetsRecharge']['r_BillNo'];
                    if ($recharge_model->r_recharge_type == 'chinapay_pay') {
                        //银联限定了长度必须是16位
                        if (strlen($recharge_model->r_BillNo) >= 16) {
                            $recharge_model->r_BillNo = substr($recharge_model->r_BillNo, 0, 16);
                        } else {
                            $recharge_model->r_BillNo = substr($recharge_model->r_BillNo.  mt_rand(1000000, 9999999), 0, 16);
                        }
                    }
                    $recharge_model->r_id = LYCommon::getInsertID();
                    $recharge_model->r_user_id = $userid;
                    $recharge_model->r_realmoney = $_POST['AssetsRecharge']['r_money'];
                    $recharge_model->r_type = ($_POST['type'] == "online") ? 1 : 2;
                    $recharge_model->r_addtime = time();
                    $recharge_model->r_addip = $_SERVER['REMOTE_ADDR'];
					$recharge_model->sign =	empty($_POST['bankCard']) ? "" : $_POST['bankCard'];
                    if ($recharge_model->save()) {
                        if ($recharge_model->r_type == 2) {
                            $success = array("提交成功", Yii::app()->controller->createUrl('usercenter/rechargelist'), 1, 1);
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
                            		$success = array("申请成功", Yii::app()->controller->createUrl('usercenter/rechargelist'), 1, 1);
                            	}else{
                            		$message = empty($result['message']) ? "未知错误" : $result['message'] ;
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
                    $message = "充值方式不正确,线下充值应填写流水号！";
                }
            } else {
                $message = "充值金额最小10元！";
            }
        }

        $this->render('recharge', array(
            'assets_info' => $assets_info,
            'online_recharge' => $online_recharge,
            'overline_recharge' => $overline_recharge,
            'recharge_model' => $recharge_model,
            'message' => $message,
            'success' => $success,
			'bank_list'=>$bank_list,
        ));
    }

    public function actionrechargelist($date = 0) {
        $userid = Yii::app()->user->id;
		$connection = Yii::app()->db;
		$money['recharge_num'] = $money['recharge_online_money'] = $money['recharge_overline_money'] = 0 ;
		$money['recharge_num'] = $connection->createCommand("select count(*) as money from {{assets_recharge}} where r_user_id = {$userid} and r_status = 1")->queryScalar();
		$money['recharge_online_money'] = $connection->createCommand("select sum(r_realmoney) as money from {{assets_recharge}} where r_user_id = {$userid} and r_type=1 and r_status = 1")->queryScalar();
		$money['recharge_overline_money'] = $connection->createCommand("select sum(r_realmoney) as money from {{assets_recharge}} where r_user_id = {$userid} and r_type<>1 and r_status = 1")->queryScalar();
		$money['recharge_num'] = empty($money['recharge_num']) ? 0 : $money['recharge_num'];
		$money['recharge_online_money'] = empty($money['recharge_online_money']) ? 0 : $money['recharge_online_money'];
		$money['recharge_overline_money'] = empty($money['recharge_overline_money']) ? 0 : $money['recharge_overline_money'];
        $recharge_model = AssetsRecharge::model();
        $criteria = new CDbCriteria;
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . ' 23:59:59') : time();
        $criteria->addCondition("r_addtime>'{$start_time}' and r_addtime<'{$end_time}'");
        $criteria->compare("r_user_id", $userid);
        //$criteria -> compare('r_status',array(1,2));
        $useTime = self::getYear();
        $total_count = $recharge_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'r_addtime DESC';
        $recharge_list = $recharge_model->findAll($criteria);
        $this->render("rechargelist", array(
            'page_list' => $page_list,
            'recharge_list' => $recharge_list,
            'usetime' => $useTime,
			'money'=>$money,
        ));
    }
    
    
    
    public function getYear() {
        $today = strtotime(date("Y-m-d", time()) . "+1 day");
        $return['end'] = date("Y-m-d", $today);
        $return['week'] = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-7 day"));
        $return['month'] = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-30 day"));
        $return['tmonth'] = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-90 day"));
        $return['year'] = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-1 year"));
        return $return;
    }

    public function actionrecharge_return() {
        $message = $success = 0;
        if (isset($_REQUEST)) {
            $result = PayCommon::GetBack($_REQUEST);
            if ($result) {
                $success = array("充值成功", Yii::app()->controller->createUrl('usercenter/rechargelist'), 1, 1);
            } else {
                $success = array("充值失败", Yii::app()->controller->createUrl('usercenter/rechargelist'), 2, 2);
            }
        } else {
            $success = array("请不要非法访问", Yii::app()->controller->createUrl('usercenter/rechargelist'), 2, 2);
        }
        $this->render("recharge_return", array(
            "message" => $message,
            "success" => $success,
        ));
    }

    public function actionbill() {
        $bill_model = Bill::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $userid);
        if (isset($_GET['Bill'])) {
            $bill_model->attributes = $_GET['Bill'];
        }
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . ' 23:59:59') : time();
        $criteria->compare('b_itemtype', $bill_model->b_itemtype);
        $criteria->addCondition("b_time>'{$start_time}' and b_time<'{$end_time}'");
        $useTime = self::getYear();
        $total_count = $bill_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'b_id DESC';
        $list = $bill_model->findAll($criteria);

        $item = LYCommon::GetItemList('assets_type');
        foreach ($item as $key => $value) {
            $type_list[$value->i_nid] = $value->i_name;
        }
        $this->render('bill', array(
            'model' => $bill_model,
            'type_list' => $type_list,
            'list' => $list,
            'page_list' => $page_list,
            'usetime' => $useTime,
        ));
    }

    public function actioncash() {
        $cash_model = new AssetsCash;
        $userid = Yii::app()->user->id;
        $message = $success = 0;

        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($userid);

        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);

        $bank_model = AssetsBank::model();
        $bank_list = $bank_model->findAllByAttributes(array('b_user_id' => $userid, 'b_status' => 1));

        if ($user_info->is_realname_check != 1) {
            $success = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        } elseif (empty($bank_list)) {
            $success = array("请先绑定银行卡,或者银行卡未激活", Yii::app()->controller->createUrl('usercenter/bank'), 2, 2);
        }
        if (isset($_POST['AssetsCash'])) {
            $cash_model->attributes = $_POST['AssetsCash'];
            $bank_one = $bank_model->findByPk($cash_model->c_bank);
            if ($cash_model->c_money > $assets_info->real_money) {
                $message = "提现金额大于可用余额!";
            } elseif (LYCommon::get_pass($user_info->user_id, $_POST['paypassword']) != $user_info->pay_pass) {
                $message = "交易密码输入有误!";
            } elseif (empty($bank_one)) {
                $message = "银行选择非法!";
            } elseif ($cash_model->c_money < 10) {
                $message = "提现金额不能小于10元!";
            } elseif($cash_model->c_money > 50000){
            	$message = "提现金额不能大于50000!";
            }else {
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
                    $transaction->commit();
                    $success = array("提现申请成功", Yii::app()->controller->createUrl('usercenter/cashlist'), 1, 1);
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
        }
        $this->render('cash', array(
            'model' => $cash_model,
            'user_assets' => $assets_info,
            'bank_list' => $bank_list,
        	'user_info'=>$user_info,
            'message' => $message,
            'success' => $success,
        ));
    }

    public function actioncashfee($money) {
        $userid = Yii::app()->user->id;
        if (!empty($money)) {
            $fee = LYCommon::getCashFee($userid, $money);
            echo $fee;
            exit;
        }
    }

    public function actioncashlist($date = 0) {
        $userid = Yii::app()->user->id;
		$connection = Yii::app()->db;
		$money['cash_num'] = $money['cash_money'] = $money['cash_fee'] = 0 ;
		$money['cash_num'] = $connection->createCommand("select count(*) as money from {{assets_cash}} where c_user_id = {$userid} and c_status = 1 ")->queryScalar();
		$cash_sum = $connection->createCommand("select sum(c_realmoney) as money,sum(c_fee) as fee from {{assets_cash}} where c_user_id = {$userid} and c_status = 1 ")->queryRow();
		$money['cash_num'] = empty($money['cash_num']) ? 0 : $money['cash_num'];
		$money['cash_money'] = empty($cash_sum['money']) ? 0 : $cash_sum['money'];
		$money['cash_fee'] = empty($cash_sum['fee']) ? 0 : $cash_sum['fee'];
        $cash_model = AssetsCash::model();
        $criteria = new CDbCriteria;
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . ' 23:59:59') : time();
        $criteria->addCondition("c_addtime>'{$start_time}' and c_addtime<'{$end_time}'");
        $criteria->compare("c_user_id", $userid);
        $useTime = self::getYear();
        $total_count = $cash_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'c_addtime DESC';
        $cash_list = $cash_model->findAll($criteria);
        $this->render("cashlist", array(
            'page_list' => $page_list,
            'cash_list' => $cash_list,
            'usetime' => $useTime,
			'money'=>$money,
        ));
    }

    public function actionbank() {
        $bank_model = new AssetsBank();
        $userid = Yii::app()->user->id;
        $message = $success = 0;
        $bank_list = $bank_model->findAllByAttributes(array('b_user_id' => $userid));
        $criteria = new CDbCriteria;
        $criteria->compare("b_user_id", $userid);
        $user_bank = $bank_model->count($criteria);
        $user_info =User::model()->findByPk($userid);
        if($user_info->is_realname_check!=1){
        	$success = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        }
        $this->render('bank', array(
            'model' => $bank_model,
            'bank_list' => $bank_list,
            'message' => $message,
            'user_bank' => $user_bank,
        	'success'=>$success,
        ));
    }

    public function actionbankedit() {
        $userid = Yii::app()->user->id;
        $bank_model = new AssetsBank();
        $criteria = new CDbCriteria;
        $criteria->compare("b_user_id", $userid);
        $message = $success = 0;
        $user_info = User::model()->findByPk($userid);
        $user_bank = $bank_model->count($criteria);
        if ($user_bank > 1) {
            $success = array("银行卡最多添加3张", Yii::app()->controller->createUrl('usercenter/bank'), 2, 2);
        }elseif (!empty($_GET['id'])) {
            $bank_model = $bank_model->findByPk($_GET['id']);
        }elseif ($user_info->is_realname_check != 1) {
            $success = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        }
        $bank_type = LYCommon::GetItemList('bank_type');
        $banktype_list = array();
        foreach ($bank_type as $key => $value) {
            $banktype_list[$value->i_id] = $value->i_name;
        }
        $area_model = Area::model();
        $area_result = $area_model->findAllByAttributes(array('pid' => '0'));
        foreach ($area_result as $key => $value) {
            $area[$value->id] = $value->name;
        }
        if (isset($_POST['AssetsBank'])) {
            $bank_model->attributes = $_POST['AssetsBank'];
            $bank_model->b_id = LYCommon::getInsertId();
            $bank_model->b_addtime = time();
            $bank_model->b_addip = $_SERVER['REMOTE_ADDR'];
            $bank_model->b_user_id = $userid;
            $bank_model->b_status = 1;
            $data['mobile'] = $user_info->user_phone ;
            $data['bankcard'] = $bank_model->b_cardNum ;
            $data['real_name'] = $user_info->real_name ;
            $data['idno'] = $user_info->card_num ;
            $return_result = NPayCommon::builderSign($data);
            if($return_result['returnCode'] == "IPS0000"){
            	$bank_model->sign = $return_result['agrNo'];
            	$bank_model->b_bill = $return_result['requestId'];
	            if ($bank_model->save()) {
	                $success = array("提交成功", Yii::app()->controller->createUrl('usercenter/bank'), 1, 1);
	            } else {
	                $message = current(current($bank_model->getErrors()));
	            }
            }else{
            	$message = empty($return_result['message']) ? "未知错误" : $return_result['message'] ;
            }
        }
        $this->renderPartial("bankedit", array(
            "bank_model" => $bank_model,
            "bank_type" => $banktype_list,
            "area" => $area,
            "message" => $message,
            "success" => $success,
                ), false, true);
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

    public function actionshutbank($id) {
        $status = 0;
        if (!empty($id)) {
            $bank_model = AssetsBank::model();
            $bank_one = $bank_model->findByPk($id);
            if (!empty($bank_one) && $bank_one->delete()) {
                $status = 1;
            } else {
                $status = 2;
            }
        }
        echo $status;
        exit;
    }

    public function actioninvite() {
        $userid = Yii::app()->user->id;
        $invite_url = Yii::app()->request->hostInfo . '/site/register.html?ly=' . base64_encode($userid);
        $model = User::model();
        $invite_list = $model->findAllByAttributes(array('p_user_id' => $userid));
		$result = array();
		$connection = Yii::app()->db;
		foreach($invite_list as $k=>$v){
			$result[$k]['register_time'] = $v->register_time;
			$result[$k]['user_name'] = $v->user_name;
			$sql = "select sum(p_realmoney) as money from {{project_order}} where p_user_id =".$v->user_id; 
			$tender_money = $connection->createCommand($sql)->queryScalar();
			$result[$k]['status'] = empty($tender_money) ? "已注册" : (($tender_money>=3000) ? "已投资过三千" : "已投资");
		}
        $this->render("invite", array(
            'invite_url' => $invite_url,
            'invite_list' => $result,
        ));
    }

    public function actionintegral() {
        $userid = Yii::app()->user->id;
        $user_model = User::model();
        $user_info = $user_model->findByPk($userid);
        $message = $success = 0;
        if ($user_info->is_phone_check != 1) {
            $success = array("请先进行手机认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        }elseif ($user_info->is_realname_check != 1) {
            $success = array("请先进行实名认证", Yii::app()->controller->createUrl('safecenter/index'), 2, 2);
        }
        $pintegral_model = Integral::model();
        $integral_info = $pintegral_model->findByPk($userid);

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
        $exchange_list = $exchange_model->findAll($criteria);

        $exchange_type = IntegralShop::model()->findAllByAttributes(array("i_type"=>"14287729544582441"));
        $this->render("integral", array(
            "user_info" => $user_info,
            "list" => $exchange_list,
            "page_list" => $page_list,
            "success" => $success,
            "message" => $message,
            "exchange_type" => $exchange_type,
            "integral_info" => $integral_info,
        ));
    }
   
    public function actionMessage() {
        $message_model = Message::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('get_user_id', $userid);
        $total_count = $message_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'add_time DESC';
        $my_message_list = $message_model->findAll($criteria);
        $this->render('message', array(
            'my_message_list' => $my_message_list,
            'page_list' => $page_list,
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
                    $integral_info->i_total_value += Yii::app()->params['invest_newday'];
                    $integral_info->i_real_value += Yii::app()->params['invest_newday'];
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
                    'integral' => Yii::app()->params['invest_newday'],
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

    /*
     * 用户图片上传
     */

    public function actionUploaduserpic() {
        $usermodel = new Userprofile();
        $user = $usermodel->findByPk(Yii::app()->user->id);
        $result = 0;
        $this->renderPartial('uploaduserpic', array('user' => $user, 'result' => $result));
    }

    public function actionSwfUploadPic() {
        // 保存图像，php中只能用php://input读取图像内容，其它语言不清楚
        // file_get_contents("php://input")得到的是jpg格式的180*180图片内容，存成图片文件即可
        // get中会带有activityKey=xxx，其中xxx为sina.php中的verifycode参数
        $userpicdir = dirname(Yii::app()->basePath) . '/' . 'upload/userpic';     //获取头像上传的目录路径
        $userpicname = $userpicdir . '/' . Yii::app()->user->id . '.jpg';         //获取头像的图片名称
        $user_pic = Yii::app()->user->id . '.jpg';
        $userid = Yii::app()->user->id;
        $user_model = User::model()->findByPk($userid);
        $user_model->user_pic = $user_pic;
        $user_model->update();
        //$result = Yii::app()->db->createCommand("UPDATE {{user}} SET user_pic = '{$user_pic}' where user_id = {$userid}")->queryAll();
        //file_put_contents($userpicdir.'\myhead.txt', print_r($_GET,1));
        file_put_contents($userpicname, file_get_contents("php://input"));
        // 必须以json格式返回ret=1才表示保存成功，ret为2时表示保存失败，其它可看源码
        echo json_encode(array("ret" => "1"));
    }

    
    public function actionIread($id) {
        $userid = Yii::app()->user->id;
        $message_model = Message::model();
        if ($message_model->updateByPk($id, array('is_view' => 1), array(
                    'condition' => 'get_user_id = :userid',
                    'params' => array(':userid' => $userid),
                ))) {
            echo '1';
        }
    }
	
	public function actionmyassets(){
    	$userid = Yii::app()->user->id;
    	$user_assets = Assets::model()->findByPk($userid);
    	$every_user = Everyuser::model()->findByPk($userid);
    	$connection = Yii::app()->db;
    	$near_collection = $connection->createCommand("select p2.* from {{project_order}} as p1 left join {{project_collect}} as p2 on p1.p_id=p2.p_project_order where p1.p_user_id='{$userid}' and p2.p_status=0 order by p_repaytime ASC ")->queryRow();
    	$use_money['online_money'] = $use_money['overline_money'] = $use_money['recharge_award'] = $use_money['order_award'] = $use_money['recharge_fee'] = $use_money['cash_fee'] = $use_money['award_money'] =0 ;
    	$use_money['online_money'] = $connection->createCommand("select sum(r_realmoney) as money from {{assets_recharge}} where r_user_id = {$userid} and r_type=1 and r_status = 1")->queryScalar();
    	$use_money['overline_money'] = $connection->createCommand("select sum(r_realmoney) as money from {{assets_recharge}} where r_user_id = {$userid} and r_type<>1 and r_status = 1")->queryScalar();
    	$use_money['recharge_award'] = $connection->createCommand("select sum(b_money) from {{bill}} where b_itemtype='assets_recharge_line' and user_id='{$userid}'")->queryScalar();
    	$use_money['order_award'] = $connection->createCommand("select sum(b_money) from {{bill}} where b_itemtype='assets_order_award' and user_id='{$userid}'")->queryScalar(); 
    	$use_money['recharge_fee'] = $connection->createCommand("select sum(b_money) from {{bill}} where b_itemtype='assets_recharge_fee' and user_id='{$userid}'")->queryScalar();
    	$use_money['cash_fee'] = $connection->createCommand("select sum(b_money) from {{bill}} where b_itemtype='assets_cash_fee' and user_id='{$userid}'")->queryScalar();
		$award_array = array("'assets_order_award","assets_back_recharge","assets_recharge_line","assets_invite_user'");
		$award_str = join("','",$award_array);
		$award_sql = "select sum(b_money) as money from {{bill}} where b_itemtype in ({$award_str}) and user_id = '{$userid}' " ;
		$use_money['award_money'] = $connection->createCommand($award_sql)->queryScalar();
		$use_money['ourmoney_money'] = 0 ;
    	$this->render("myassets",array(
    		"user_assets"=>$user_assets,
    		"every_user"=>$every_user,
    		"near_collection"=>$near_collection,
    		"use_money"=>$use_money,
    	));
    }
    
    public function actionawardlist(){
    	$model = AwardBill::model();
    	$userid = Yii::app()->user->id;
    	$criteria = new CDbCriteria;
    	$start_time = (isset($_GET['get_time']) && $_GET['get_time'] != "") ? strtotime($_GET['get_time']) : 0;
    	$end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . ' 23:59:59') : time();
    	$criteria->addCondition("get_time>'{$start_time}' and end_time>'{$end_time}'");
    	$criteria->compare('user_id', $userid);
    	$criteria->compare('status',empty($_GET['status']) ? "0" : $_GET['status']);
    	$total_count = $model->count($criteria);
    	$page = new Pagination($total_count, 10);
    	$page_list = $page->fpage(array(4, 5, 6, 3, 7));
    	$page_list = $total_count <= $page->limitnum ? "" : $page_list;
    	$criteria->limit = $page->limitnum;
    	$criteria->offset = $page->offset;
    	$criteria->order = 'add_time DESC';
    	$list = $model->findAll($criteria);
    	$this->render('awardlist', array(
    		'list' => $list,
    		'page_list' => $page_list,
    	));
    }

}
