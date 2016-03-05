<?php

class UserprojectController extends Controller {

    public $layout = '//layouts/usercenter_main';
    public $safevalue;
    public $real_money;

    /*
     * 检测用户是否登陆，未登录就跳转到登陆页
     */

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            if ($action->id == 'upload_usercredit_pic') {
                return true;
            }
            if (Yii::app()->user->getIsGuest()) {
                $this->redirect(array('site/login'));
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
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionautoorder() {
        $auto_model = new ProjectAutoorder;
        $userid = Yii::app()->user->id;
        $message = $success = 0;
        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($userid);
        $auto_user = $auto_model->findByAttributes(array('p_user_id' => $userid));
        
        $auto_user_to = !empty($auto_user) ? $auto_user : $auto_model;
        if (isset($_POST['ProjectAutoorder'])) {
            $auto_user_to->attributes = $_POST['ProjectAutoorder'];
            $auto_user_to->p_project_style = '["1","2","3"]';
            //$auto_user_to->p_project_style = json_encode($auto_user_to->p_project_style);
			if($assets_info->real_money < 50 && $auto_user_to->p_order_status==1){
				$message = "可用余额不足";
			}elseif ($auto_user_to->p_retain > $assets_info->real_money) {
                $message = "保留余额不能大于可用余额";
            }/* elseif ($_POST['ProjectAutoorder']['p_project_style'] == "") {
                $message = "标种类型未选择";
            }*/ elseif ($auto_user_to->p_order_minmoney > $auto_user_to->p_order_maxmoney) {
                $message = "最小投标金额不能大于最大投标金额！";
            } elseif ($auto_user_to->p_order_minmonth > $auto_user_to->p_order_maxmonth) {
                $message = "最小月份设置不能大于最大月份设置！";
            } elseif ($auto_user_to->p_order_minapr > $auto_user_to->p_order_maxapr) {
                $message = "最小利率设置不能大于最大利率设置！";
            } else {
                if (empty($auto_user)) {
                    $auto_user_to->p_id = LYCommon::getInsertID();
                    $auto_user_to->p_user_id = $userid;
                    $auto_user_to->p_addtime = time();
                    $auto_user_to->p_addip = $_SERVER['REMOTE_ADDR'];
                } else {
                    if($auto_user->p_order_status==0 && $auto_user_to->p_order_status==1){
                        //关闭自动投标功能后再次开启，排名移到队尾
                        $auto_user_to->p_order_autotime = time().substr(microtime(),2,6);
                    }
                    $auto_user_to->p_addtime = time();
                }
                
                if ($auto_user_to->save()) {
                    $success = array("操作成功", Yii::app()->controller->createUrl('userproject/autoorder'), 2, 1);
                } else {
                    $message = "操作非法！";
                }
            }
        }
        $autoorder_model = ProjectAutoorder::model();
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{user}} as t1 on t.p_user_id = t1.user_id';
        $criteria->order=' t.p_order_autotime ASC';
        $criteria->addCondition("t.p_order_status=1");
        $orderlist = $autoorder_model->findAll($criteria);
        $cnt=0;//排队位置
        $sum=0;//排位等待资金
        foreach ($orderlist as $k=>$v){
            $sum=$sum+$v['p_order_minmoney'];
            if($v->p_user_id==$userid){
              $cnt= $k+1; 
              break;
            }
            
        }
        $this->render('autoorder', array(
            'model' => $auto_user_to,
            'user_assets' => $assets_info,
            'message' => $message,
            'success' => $success,'cnt'=>$cnt,'sum'=>$sum
        ));
    }

    public function actionauto_user() {
        $userid = Yii::app()->user->id;
        $autolog_model = ProjectAutoorder::model();
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{user}} as t1 on t.p_user_id = t1.user_id';
        $criteria->order=' t.p_order_autotime ASC';
        $criteria->addCondition("t.p_order_status=1");
        $total_count = $autolog_model->count($criteria);      
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $autolog_model->findAll($criteria);
        $this->render("auto_user", array('list' => $list, 'page_list' => $page_list));
    }

    public function actionorderlist() {
        $order_model = ProjectOrder::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->join = 'left join {{project}} as t1 on t.p_project_id = t1.p_id';
        $criteria->compare('t.p_user_id', $userid);
        $have_num_count = $order_model->count($criteria);
        if(isset($_GET['type']) && $_GET['type']!=""){
        	if($_GET['type']=="repay"){
        		$criteria->compare('t1.p_status', array(3,7));
        		$criteria->addCondition("t.p_repayyesaccount <> t.p_repayaccount");
        	}elseif($_GET['type']=="success"){
        		$criteria->compare('t1.p_status', array(3,7));
        	}
        }
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
        
        $criteria->addCondition("t.p_repayyesaccount <> t.p_repayaccount");
        

        $have_num = array();
        $connection = Yii::app()->db;
        $sql = "select sum(p1.p_repayaccount) as money,sum(p1.p_money) as capital from {{project_order}} as p1 left join {{project}} as p2 on p1.p_project_id=p2.p_id where p2.p_status in(1,3,7) and p1.p_user_id = '{$userid}'";
        $result = $connection->createCommand($sql)->queryRow();
        $have_num['money'] = empty($result['money']) ? 0 : $result['money'];
        $have_num['capital'] = empty($result['money']) ? 0 : $result['capital'];
        $have_num['tender'] = empty($have_num_count) ? 0 : $have_num_count;

        $this->render('orderlist', array(
            'model' => $order_model,
            'list' => $list,
            'page_list' => $page_list,
            'have_num' => $have_num,
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

        $have_num = array();
        $connection = Yii::app()->db;
        $sql = "select sum(p1.p_repayaccount) as money,sum(p1.p_money) as capital from {{project_order}} as p1 left join {{project}} as p2 on p1.p_project_id=p2.p_id where p2.p_status=1 and p1.p_user_id = '{$userid}'";
        $result = $connection->createCommand($sql)->queryRow();
        $have_num['money'] = empty($result['money']) ? 0 : $result['money'];
        $have_num['capital'] = empty($result['money']) ? 0 : $result['capital'];
        $have_num['tender'] = empty($total_count) ? 0 : $total_count;

        $this->render("orderon", array(
            'list' => $list,
            'page_list' => $page_list,
            'model' => $order_model,
            'have_num' => $have_num,
        ));
    }

    public function actionorderwait() {
        $model = ProjectCollect::model();
        $userid = Yii::app()->user->id;

        $connection = Yii::app()->db;
        $sql = "select sum(p1.p_money) as tender_money,sum(p1.p_waitrepay) as wait_money,sum(p1.p_repayyesaccount) as have_money,sum(p1.p_waitinterest) as wait_interest,sum(p1.p_yesinterest) as have_interest from {{project_order}} as p1 left join {{project}} as p2 on p1.p_project_id=p2.p_id where p1.p_user_id='{$userid}' and p2.p_status in (3,7)";
        $money = $connection->createCommand($sql)->queryRow();

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
        $criteria->order = 'p_repaytime asc';
        $list = $model->findAll($criteria);
        $this->render("orderwait", array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
            'money' => $money,
        ));
    }

    public function actionorderend() {
        $model = ProjectCollect::model();
        $userid = Yii::app()->user->id;

        $connection = Yii::app()->db;
        $sql = "select sum(p1.p_money) as tender_money,sum(p1.p_waitrepay) as wait_money,sum(p1.p_repayyesaccount) as have_money,sum(p1.p_waitinterest) as wait_interest,sum(p1.p_yesinterest) as have_interest from {{project_order}} as p1 left join {{project}} as p2 on p1.p_project_id=p2.p_id where p1.p_user_id='{$userid}' and p2.p_status in (3,7)";
        $money = $connection->createCommand($sql)->queryRow();

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
        $this->render("orderend", array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
            'money' => $money,
        ));
    }

    public function actionproject() {
        $project_model = Project::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        if (isset($_GET['Project'])) {
            $project_model->attributes = $_GET['Project'];
        }
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time();
        $criteria->addCondition("p_addtime>'{$start_time}' and p_addtime<'{$end_time}'");
        $criteria->compare('p_name', $project_model->p_name, true);
        $criteria->compare('p_user_id', $userid);
        $total_count = $project_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $project_model->findAll($criteria);
        $this->render('project', array(
            'model' => $project_model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actiongetback($id) {
        $project_model = Project::model();
        $project_info = $project_model->findByPk($id);
        $message = 0;
        $status = array("0", "2", "4", "5");
        if (in_array($project_info->p_status, $status)) {
            $project_info->p_status = 6;
            $project_info->update();
            echo "1";
            exit;
        } else {
            echo "0";
            exit;
        }
    }

    public function actionrepay_project() {
        $project_model = Project::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('p_user_id', $userid);
        $criteria->compare('p_status', 3);
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time();
        $criteria->addCondition("p_addtime>'{$start_time}' and p_addtime<'{$end_time}'");
        $total_count = $project_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $project_model->findAll($criteria);
        $this->render('repay_project', array(
            'model' => $project_model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionrepay_view() {
        $project_model = ProjectRepay::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $project = Project::model();
        $project_info = null;
        if (isset($_GET['id'])) {
            $criteria->compare('p_project_id', $_GET['id']);
            $project_info = $project->findByPk($_GET['id']);
        }
        $criteria->join = 'left join {{project}} as t1 on t1.p_id = t.p_project_id';
        $criteria->compare('t1.p_user_id', $userid);
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time() + 86400 * 365 * 2;
        $criteria->addCondition("t.p_addtime>'{$start_time}' and t.p_addtime<'{$end_time}'");
        $total_count = $project_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $project_model->findAll($criteria);
        $this->render('repay_view', array(
            'model' => $project_model,
            'list' => $list,
            'page_list' => $page_list,
            'project_info' => $project_info,
        ));
    }

    public function actionrepay_end() {
        $project_model = Project::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('p_user_id', $userid);
        $criteria->compare('p_status', 7);
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time']) : time() + 86400 * 365 * 2;
        $criteria->addCondition("p_addtime>'{$start_time}' and p_addtime<'{$end_time}'");
        $total_count = $project_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $project_model->findAll($criteria);
        $this->render('repay_end', array(
            'model' => $project_model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionRepayment($id) {
        $project_model = Project::model();
        $repayment_model = ProjectRepay::model();
        $order_model = ProjectOrder::model();
        $collect_model = ProjectCollect::model();
        $assets_model = Assets::model();
        $userid = Yii::app()->user->id;
        $message = $success = 0;
	
        $repayment_info = $repayment_model->findByPk($id, array(
            'params' => array('p_status' => '0'),
        ));
        //算出共还款几期
        $repay_count = $repayment_model->countByAttributes(array('p_project_id' => $repayment_info->p_project_id, 'p_status' => 1));

        if ($repay_count >= $repayment_info->p_order) {
            if (!empty($repayment_info)) {
                if (LYCommon::Repay($repayment_info)) {
                    $success = array("还款成功",Yii::app()->controller->createUrl('userproject/repay_view', array('id' => $repayment_info->p_project_id)),1,1);
                } else {
                	$success = array("用户可用余额不足",Yii::app()->controller->createUrl('userproject/repay_view', array('id' => $repayment_info->p_project_id)),2,2);
                }
            } else {
                $success = array("该期借款已经偿还,请勿重复操作",Yii::app()->controller->createUrl('userproject/repay_view', array('id' => $repayment_info->p_project_id)),2,2);
            }
        } else {
            $success = array("您上期的借款还未偿还,请勿越期还款",Yii::app()->controller->createUrl('userproject/repay_view', array('id' => $repayment_info->p_project_id)),2,2);
        }
        $this->render('repayment', array(
            'message' => $message,
        	'success' => $success,
        ));
    }

    public function actionAppcredit() {
        $credit_model = new Credit;
        $credit_log_model = Creditlog::model();
        $userid = Yii::app()->user->id;
        $credit_info = $credit_model->findByAttributes(array('user_id' => $userid, 'status' => array(0, 1)), array(
            'order' => 'add_time DESC'
        ));
        $credit_log_list = $credit_log_model->findAllByAttributes(array('user_id' => $userid));
        $message = array();
        if (empty($credit_info)) {
            if (isset($_POST['Credit'])) {
                $credit_model->attributes = $_POST['Credit'];
                $credit_model->c_id = LYCommon::getInsertID();
                $credit_model->user_id = $userid;
                $credit_model->status = 0;
                $credit_model->add_time = time();
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($credit_model->save()) {
                        if (isset($_POST['Credit']['Creditpic'])) {
                            foreach ($_POST['Credit']['Creditpic'] as $k => $v) {
                                $credit_pic_model = new Creditpic;
                                $credit_pic_model->id = LYCommon::getInsertID();
                                $credit_pic_model->user_id = $userid;
                                $credit_pic_model->c_id = $credit_model->c_id;
                                $credit_pic_model->credit_pic = $v;
                                $credit_pic_model->add_time = $credit_model->add_time;
                                $credit_pic_model->insert();
                            }
                        }
                        $message['status'] = 1;
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }
        } else {
            $message['status'] = 2;
            $message['message'] = '您已经提交过申请了，正在审核中';
        }
        $this->render('appcredit', array(
            'credit_model' => $credit_model,
            'credit_info' => $credit_info,
            'credit_log_list' => $credit_log_list,
            'message' => $message,
        ));
    }

    public function actiondebt() {
        $userid = Yii::app()->user->id;
        $order_model = ProjectOrder::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('t.p_user_id', $userid);
        $criteria->compare('t.p_debt', '0');
        $criteria->addCondition('p_repayaccount>p_repayyesaccount');
        $criteria->join = 'left join {{project}} as t1 on t1.p_id = t.p_project_id';
        $criteria->compare('t1.p_status', '3');
        $criteria ->addCondition('t1.p_fullverifytime < :p_fullverifytime and t1.p_time_limit>1 and t1.p_time_limittype=0');
        $criteria -> params[':p_fullverifytime'] = time()-(3600*24*30);
        $total_count = $order_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $order_model->findAll($criteria);
        $this->render('debt', array(
            'model' => $order_model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actiondebtsuccess() {
        $userid = Yii::app()->user->id;
        $model = ProjectDebt::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('debt_status', '1');
        $criteria->compare('buy_userid', $userid);
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('debtsuccess', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionassignsuccess() {
        $userid = Yii::app()->user->id;
        $model = ProjectDebt::model();
        $userid = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $userid);
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('assignsuccess', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actiondebting() {
        $userid = Yii::app()->user->id;
        $model = ProjectDebt::model();
        $message = $success = 0;
        $criteria = new CDbCriteria;
        $criteria->compare('debt_status', '0');
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'addtime DESC';
        $list = $model->findAll($criteria);

        if (isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id'])) {
            $debt_one = $model->findByPk($_GET['id']);
            $assets_model = Assets::model();
            $user_assets = $assets_model->findByPk($userid);
            if ($debt_one->debt_status != 0) {
                $message = "债权状态有误,请不要乱操作";
            } elseif ($user_assets->real_money < $debt_one->to_money) {
                $message = "用户可用余额不足";
            } elseif ($debt_one->user_id == $userid) {
                $message = "您不能购买自己的债权";
            } elseif ($debt_one->project->p_user_id == $userid) {
                $message = "您不能购买自己的债权";
            }elseif($debt_one->project_order->p_waitrepay==0){
                $message = "债权已过期";
            } else {
                $debt_one->buy_userid = $userid;
                $debt_one->debt_status = 1;
                $debt_one->buy_time = time();
                if ($debt_one->update()) {
                    if (LYCommon::BuyDebt($debt_one)) {
                        $success = array("购买成功",Yii::app()->controller->createUrl('userproject/debtsuccess'),1,1);
                    } else {
                        $success = array("数据非法",Yii::app()->controller->createUrl('userproject/debt'),2,2);
                    }
                } else {
                     $success = array("数据非法",Yii::app()->controller->createUrl('userproject/debt'),2,2);
                }
            }
        }

        $this->render("debting", array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
            'message' => $message,
        	'success'=>$success,
        ));
    }

    public function actionassignment($id) {
        $order_model = ProjectOrder::model();
        $user_model = User::model();
        $userid = Yii::app()->user->id;
        $user_info = $user_model->findByPk($userid);
        $order_one = $order_model->findByPk($id);
        $message = $success = 0;
        $debt = new ProjectDebt;
        if (isset($_POST['ProjectDebt'])) {
            $debt->attributes = $_POST['ProjectDebt'];
            $debt->debt_id = LYCommon::getInsertID();
            $debt->user_id = $userid;
            $debt->order_id = $order_one->p_id;
            $debt->project_id = $order_one->p_project_id;
            $debt->debt_status = 0;
            $debt->have_money = LYCommon::sprintf_diy($order_one->p_repayaccount - $order_one->p_repayyesaccount);
            $debt->have_interest = $order_one->p_waitinterest;
            $debt->to_money = LYCommon::sprintf_diy(($order_one->p_money - ($order_one->p_repayyesaccount - $order_one->p_yesinterest)) * $debt->debt_expr / 100);
            $debt->addtime = time();
            $debt->addip = $_SERVER['REMOTE_ADDR'];
            if ($user_info->pay_pass != LYCommon::get_pass($user_info->user_id, $debt->pay_pass)) {
                $message = "交易密码输入有误";
            } elseif ($debt->debt_expr < 80 || $debt->debt_expr > 120) {
                $message ="转让比例有误!";
            } elseif ($order_one->project->p_status != 3) {
                $message = "借款标状态有误!";
            } elseif (!$debt->validate()) {
                $message = "验证码输入错误";
            } else {
                if ($debt->insert()) {
                    $order_one->p_debt = 1;
                    $order_one->update();
                    $success = array("转让成功",Yii::app()->controller->createUrl('userproject/debt'),1,1);
                } else {
                    $success = array("转让成功",Yii::app()->controller->createUrl('userproject/debt'),2,2);
                }
            }
        }
        $this->renderPartial('assignment', array(
            'message' => $message,
        	'success'=>$success,
            'debt' => $debt,
            'order' => $order_one,
        ),false,true);
    }

    public function actionUpload_usercredit_pic() {
        $pic_name = $_FILES['Filedata']['name'];
        $image = CUploadedFile::getInstanceByName("Filedata");
        if ($image) {
            if ($image->extensionName != 'jpg' && $image->extensionName != 'jpeg' && $image->extensionName != 'png' && $image->extensionName != 'gif')
                die('上传文件非法');
            if (!empty($image)) {
                $dir = dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'usercredit' . DIRECTORY_SEPARATOR;
                if (!is_dir($dir)) {
                    mkdir($dir);
                    if (!is_dir($dir)) {
                        die('文件夹不存在');
                    }
                }
                $name = time() . strtolower(rand(1000, 9999)) . strrchr($image->name, '.');
                $image->saveAs($dir . $name);
                LYCommon::saveThumb($dir . $name, $dir . 's_' . $name);    //保存图像的时候，生成缩略图。
            }
        }
        echo json_encode(array('pic_name' => $name));
    }

}

?>