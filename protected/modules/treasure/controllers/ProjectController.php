<?php

class ProjectController extends BController {

    public function actionIndex() {
        $this->render('index');
    }

    /*
     * 列表
     */

    public function actionList() {
        $model = Project::model();
        $criteria = new CDbCriteria;
        if (isset($_GET['Project'])) {
            $model->attributes = $_GET['Project'];
        }
        if (isset($model->p_status)) {
            $criteria->compare('p_status', $model->p_status);
        }
        if (!empty($model->p_type)) {
            $criteria->compare('p_type', $model->p_type);
        }

        $criteria->compare('p_name', $model->p_name, true);
        if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $list = $model->findAll();
            $data = array(
                array(
                    "序号", "项目编号", "用户名", "真实姓名", "借款名称", "借款类型", "借款金额", "借款时长", "有效时间", "年化收益", "还款方式", "奖励", "添加时间", "状态"
                ),
            );
            foreach ($list as $k => $v) {
                if ($v->p_award_type == 1) {
                    $award = $v->p_award . "%";
                } elseif ($v->p_award_type == 2) {
                    $award = $v->p_award . "元";
                } else {
                    $award = "无";
                }
                $data[] = array(
                    $k + 1,
                    $v->p_id,
                    $v->user->user_name,
                    $v->user->real_name,
                    $v->p_name,
                    LYCommon::findcat('project_type', $v->p_type),
                    $v->p_account . "元",
                    $v->p_time_limit . (($v->p_time_limittype == 1) ? "天" : "个月"),
                    $v->p_valid_time . "天",
                    $v->p_apr . "%",
                    LYCommon::GetItem_of_value($v->p_style, 'project_repay_type'),
                    $award,
                    LYCommon::subtime($v->p_addtime, 2),
                    LYCommon::findcat('project_status', $v->p_status),
                );
            }

            $xls = new JPhpExcel('UTF-8', true, '借款列表');
            $xls->addArray($data);
            $xls->generateXML('借款列表',false);
            die;
        }

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7 ,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('list', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }
    
    
    public function actionProject_info($id){
        $model = self::loadmodel($id);
        
        $area_model = Area::model();
        $province_list = $area_model ->findAllByAttributes(array('pid'=>0));
        $province_arr = array('0'=>'请选择省份');
        foreach($province_list as $k => $v){
            $province_arr[$v->id] = $v->name;
        }
        $city_arr = array('0'=>'请选择市区');
        if(!empty($model->p_province)){
            $city_list = $area_model ->findAllByAttributes(array('pid'=>$model->p_province));
            foreach($city_list as $k => $v){
                $city_arr[$v->id] = $v->name;
            }
        }
        $brand_arr = array('0'=>'请选择品牌');
        $brand_list = LYCommon::GetItemList('car_brand');
        foreach($brand_list as $k => $v){
            $brand_arr[$v->i_id] = $v->i_name;
        }
        
        
        $color_arr = array('0'=>'请选择颜色');
        $brand_list = LYCommon::GetItemList('car_color');
        foreach($brand_list as $k => $v){
            $color_arr[$v->i_id] = $v->i_name;
        }
        
        if(isset($_POST['Project'])){
            $model->attributes = $_POST['Project'];
            
            if($model -> update()){
                
            }
        }
        
        $this -> render('project_info',array(
            'model'=>$model,
            'province_arr'=>$province_arr,
            'city_arr'=>$city_arr,
            'brand_arr'=>$brand_arr,
            'color_arr'=>$color_arr,
        ));
    }
    
    public function actiongetCity_ajax($pid){
        $area_model = Area::model();
        $city_arr = array(
            array('id'=>'0','name'=>'请选择市区')
        );
        if(!empty($pid)){
            $city_list = $area_model ->findAllByAttributes(array('pid'=>$pid));
            foreach($city_list as $k => $v){
                $city_arr[] = array('id'=>$v->id,'name'=>$v->name);
            }
        }
        echo json_encode($city_arr);
        
    }

    /*
     * 发标待审列表
     */

    public function actionWait_check_list() {
        $model = Project::model();
        $user_model = User::model();
        $criteria = new CDbcriteria;
        $criteria->addCondition('p_status = 0');
        if (isset($_GET['User'])) {
            $user_model->attributes = $_GET['User'];
        }
        if (isset($_GET['Project'])) {
            $model->attributes = $_GET['Project'];
        }
        $criteria->with = "user";
        $criteria->compare("user.user_name", $user_model->user_name, true);
        $criteria->compare("p_name", $model->p_name, true);
        if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $list = $model->findAll($criteria);
            $data = array(
                array(
                    "序号", "ID", "用户名", "真实姓名", "借款名称", "借款类型", "借款金额", "借款时长", "有效时间", "年化收益", "还款方式", "奖励", "添加时间", "状态"
                ),
            );
            foreach ($list as $k => $v) {
                if ($v->p_award_type == 1) {
                    $award = $v->p_award . "%";
                } elseif ($v->p_award_type == 2) {
                    $award = $v->p_award . "元";
                } else {
                    $award = "无";
                }
                $data[] = array(
                    $k + 1,
                    $v->p_id,
                    $v->user->user_name,
                    $v->user->real_name,
                    $v->p_name,
                    LYCommon::findcat('project_type', $v->p_type),
                    $v->p_account . "元",
                    $v->p_time_limit . (($v->p_time_limittype == 1) ? "天" : "个月"),
                    $v->p_valid_time . "天",
                    $v->p_apr . "%",
                    LYCommon::GetItem_of_value($v->p_style, 'project_repay_type'),
                    $award,
                    LYCommon::subtime($v->p_addtime, 2),
                    LYCommon::findcat('project_status', $v->p_status),
                );
            }

            $xls = new JPhpExcel('UTF-8', true, '待审列表');
            $xls->addArray($data);
            $xls->generateXML('待审列表',false);
            die;
        }

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7 ,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('wait_check_list', array(
            'model' => $model,
            'list' => $list,
            'user_model' => $user_model,
            'page_list' => $page_list,
        ));
    }

    /*
     * 满标待审列表
     */

    public function actionFull_check_list() {
        $model = Project::model();
        $user_model = User::model();
        $criteria = new CDbcriteria;
        $criteria->addCondition('p_status = 1 and p_account = p_account_yes');
        if (isset($_GET['User'])) {
            $user_model->attributes = $_GET['User'];
        }
        if (isset($_GET['Project'])) {
            $model->attributes = $_GET['Project'];
        }
        $criteria->with = "user";
        $criteria->compare("user.user_name", $user_model->user_name, true);
        $criteria->compare("p_name", $model->p_name, true);
        if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $list = $model->findAll($criteria);
            $data = array(
                array(
                    "序号", "ID", "用户名", "真实姓名", "借款名称", "借款类型", "借款金额", "借款时长", "有效时间", "年化收益", "还款方式", "奖励", "添加时间", "状态"
                ),
            );
            foreach ($list as $k => $v) {
                if ($v->p_award_type == 1) {
                    $award = $v->p_award . "%";
                } elseif ($v->p_award_type == 2) {
                    $award = $v->p_award . "元";
                } else {
                    $award = "无";
                }
                $data[] = array(
                    $k + 1,
                    $v->p_id,
                    $v->user->user_name,
                    $v->user->real_name,
                    $v->p_name,
                    LYCommon::findcat('project_type', $v->p_type),
                    $v->p_account . "元",
                    $v->p_time_limit . (($v->p_time_limittype == 1) ? "天" : "个月"),
                    $v->p_valid_time . "天",
                    $v->p_apr . "%",
                    LYCommon::GetItem_of_value($v->p_style, 'project_repay_type'),
                    $award,
                    LYCommon::subtime($v->p_addtime, 2),
                    LYCommon::findcat('project_status', $v->p_status),
                );
            }

            $xls = new JPhpExcel('UTF-8', true, '满标待审列表');
            $xls->addArray($data);
            $xls->generateXML('满标列表',false);
            die;
        }

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('full_check_list', array(
            'model' => $model,
            'list' => $list,
            'user_model' => $user_model,
            'page_list' => $page_list,
        ));
    }

    /*
     * 满标审核失败列表
     */

    public function actionFail_full_check_list() {
        $model = Project::model();
        $user_model = User::model();
        $criteria = new CDbcriteria;
        $criteria->addCondition('p_status = 4');
        if (isset($_GET['User'])) {
            $user_model->attributes = $_GET['User'];
        }
        if (isset($_GET['Project'])) {
            $model->attributes = $_GET['Project'];
        }
        $criteria->with = "user";
        $criteria->compare("user.user_name", $user_model->user_name, true);
        $criteria->compare("p_name", $model->p_name, true);
        if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $list = $model->findAll($criteria);
            $data = array(
                array(
                    "序号", "ID", "用户名", "真实姓名", "借款名称", "借款类型", "借款金额", "借款时长", "有效时间", "年化收益", "还款方式", "奖励", "添加时间", "状态"
                ),
            );
            foreach ($list as $k => $v) {
                if ($v->p_award_type == 1) {
                    $award = $v->p_award . "%";
                } elseif ($v->p_award_type == 2) {
                    $award = $v->p_award . "元";
                } else {
                    $award = "无";
                }
                $data[] = array(
                    $k + 1,
                    $v->p_id,
                    $v->user->user_name,
                    $v->user->real_name,
                    $v->p_name,
                    LYCommon::findcat('project_type', $v->p_type),
                    $v->p_account . "元",
                    $v->p_time_limit . (($v->p_time_limittype == 1) ? "天" : "个月"),
                    $v->p_valid_time . "天",
                    $v->p_apr . "%",
                    LYCommon::GetItem_of_value($v->p_style, 'project_repay_type'),
                    $award,
                    LYCommon::subtime($v->p_addtime, 2),
                    LYCommon::findcat('project_status', $v->p_status),
                );
            }

            $xls = new JPhpExcel('UTF-8', true, '满标失败列表');
            $xls->addArray($data);
            $xls->generateXML('满标失败列表',false);
            die;
        }

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('fail_full_check_list', array(
            'model' => $model,
            'list' => $list,
            'user_model' => $user_model,
            'page_list' => $page_list,
        ));
    }

    /*
     * 更新
     */

    public function actionUpdate($id) {
        $model = self::loadmodel($id);
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '项目更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('list'));
            }
        }
        $project_pic_model = ProjectPic::model();
        $project_pic = $project_pic_model->findAllByAttributes(array("p_project_id" => $id));
		
		//获取投资记录
        $project_order_model = ProjectOrder::model();
        $project_order_list = $project_order_model->findAllByAttributes(array('p_project_id' => $id));
		
        $this->render('update', array(
            'model' => $model,
            "project_pic" => $project_pic,
			'project_order_list'=>$project_order_list
        ));
    }

    public function actionWait_check_oper($id) {
        $model = self::loadmodel($id);
        $model->scenario = 'wait_check_oper';
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->p_verifyuser = Yii::app()->user->id;
            $model->p_verifytime = time();
            if ($model->sh_status == 1) {
                $model->p_status = 1;
                $model->p_endtime = $model->p_valid_time * (3600 * 24) + time();
            } elseif ($model->sh_status == 2) {
                $model->p_status = 2;
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->update()) {
                    if ($model->p_status == 1) {
                        if (empty($model->p_dxb) && $model->p_type != 4 && Yii::app()->params['project_autoorder']==1) {
                            self::Autoproject($id);
                        }
                        //发送站内信
                        LYCommon::send_message(0, $model->p_user_id, 'first_check_suc', array(
                            'project_name' => $model->p_name,
                        ));
                    } elseif ($model->p_status == 2) {
                        LYCommon::send_message(0, $model->p_user_id, 'first_check_fail', array(
                            'project_name' => $model->p_name,
                        ));
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '项目更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('wait_check_list'));
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
		
		$project_day_type_arr = array();  //借款天分
        foreach (LYCommon::GetItemList('project_day_type') as $k => $v) {
            $project_day_type_arr[$v->i_value] = $v->i_name;
        }
		
		$project_month_type_arr = array();  //借款月份
        foreach (LYCommon::GetItemList('project_month_type') as $k => $v) {
            $project_month_type_arr[$v->i_value] = $v->i_name;
        }
        $project_pic_model = ProjectPic::model();
        $project_pic = $project_pic_model->findAllByAttributes(array("p_project_id" => $id));
        $this->render('wait_check_oper', array(
            'model' => $model,
            'projectpic' => $project_pic,
			'project_month_type_arr'=>$project_month_type_arr,
			'project_day_type_arr'=>$project_day_type_arr,
        ));
    }

    public function actionFull_check_oper($id) {
        $model = self::loadmodel($id);
        //获取投资记录
        $project_order_model = ProjectOrder::model();
        $project_order_list = $project_order_model->findAllByAttributes(array('p_project_id' => $id));

        $model->scenario = 'full_check_oper';
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->p_fullverifyuser = Yii::app()->user->id;
            $model->p_fullverifytime = time();
            $have_status = $model->p_status;
            if ($model->sh_status == 1) {
                $model->p_status = 3;
            } elseif ($model->sh_status == 2) {
                $model->p_status = 4;
            }
            if ($have_status != $model->p_status) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->update()) {
                        LYCommon::AddRepay($model, $project_order_list);
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', '满标审核成功！');
                        $this->redirect(Yii::app()->controller->createUrl('full_check_list'));
                    }
                } catch (Exception $e) {
                    $transaction->rollback(); ////未知错误，数据回滚
                }
            } else {
                $model->addError('p_fullverifyremark', '请不要重复审核');
            }
        }
        $this->render('full_check_oper', array(
            'model' => $model,
            'project_order_list' => $project_order_list,
        ));
    }

    /*
     * 删除单条记录
     */

    public function actionAjaxdelete($id) {
        $model = self::loadmodel($id);
        if ($model->delete()) {
            echo json_encode(1);
            die;
        } else {
            echo json_encode(0);
            die;
        }
    }

    /*
     * 批量删除
     */

    public function actionAjaxdelmore() {
        if (isset($_POST['delarr'])) {
            $del_result = array('status' => 0);
            $model = Project::model();
            if ($model->deleteAllByAttributes(array('project_id' => $_POST['delarr']))) {
                $del_result['status'] = 1;
            } else {
                $del_result['message'] = '删除失败';
            }
            echo json_encode($del_result);
        }
    }

    public function loadmodel($id) {
        return Project::model()->findByPk($id);
    }

    public function actionapplylist() {
        $model = ProjectApply::model();

		
		$criteria = new CDbcriteria;
        if (isset($_GET['money_type'])) {     
			switch ($_GET['money_type']){	
				case 1:
					$criteria->addCondition('p_money < 10000');
					break;
				case 2:
					$criteria->addCondition('p_money>=10000 and p_money<100000');
					break;
				case 3:
					$criteria->addCondition('p_money>=100000 and p_money<=1000000');
					break;
				case 'all':
					$criteria->addCondition('');
			}
			                
        }
		
		if (isset($_GET['time_type'])&&!empty($_GET['time_type'])){
			
				$criteria->addCondition('p_time_limit ='. $_GET['time_type']);
			
			
		}
		
		
		
        if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $list = $model->findAll($criteria);
            $data = array(
                array(
                    "序号", "ID", "企业名称", "真实姓名", "申请金额", "申请时长", "手机号码", "城市", "地区", "添加时间", "状态"
                ),
            );
            foreach ($list as $k => $v) {
                $data[] = array(
                    $k + 1,
                    $v->p_id,
                    $v->p_name,
                    $v->p_realname,
                    $v->p_money . "元",
                    $v->p_time_limit . "个月",
                    $v->p_phone,
                    $v->city->name,
                    $v->province->name,
                    LYCommon::subtime($v->p_addtime, 2),
                    ($v->p_status == 1) ? "成功" : "申请中",
                );
            }

            $xls = new JPhpExcel('UTF-8', false, '借款申请');
            $xls->addArray($data);
            $xls->generateXML('借款申请',false);
            die;
        }

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $list = $model->findAll($criteria,array(
            'limit' => $page->limitnum,
            'offset' => $page->offset,
            'order' => 'p_addtime DESC'
        ));
        $this->render('applylist', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionUpdateapply($id) {
        $model = ProjectApply::model()->findByPk($id);
        if (isset($_POST['ProjectApply'])) {
            $model->attributes = $_POST['ProjectApply'];
            $model->p_verifytime = time();
            $model->p_verifyuser = Yii::app()->user->id;
            if ($model->update()) {
                Yii::app()->user->setFlash('success', '项目更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('applylist'));
            }
        }
        $this->render('updateapply', array(
            'model' => $model,
        ));
    }

    public function Autoproject($id) {
        $model = self::loadmodel($id);
        $auto_total_money = $model->p_account * ($model->p_autorate / 100); //本项目自动可以自动投标总金额
        $auto_money_yes = 0; //已投金额
        $auto_model = ProjectAutoorder::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition('p_order_status = 1 AND (:project_time >= p_order_minmonth AND :project_time <= p_order_maxmonth) AND (p_order_minapr <= :project_apr AND p_order_maxapr >= :project_apr)');
        $criteria->with = 'assets';
        $criteria->addCondition('assets.real_money-p_retain >= :p_lowaccount AND assets.real_money-p_retain >= p_order_minmoney');
        $criteria->params = array(
            ':project_time' => $model->p_time_limittype == 0 ? $model->p_time_limit : 0,
            ':project_apr' => $model->p_apr,
            ':p_lowaccount' => $model->p_lowaccount,
        );
        $criteria->order = 't.p_order_autotime ASC';
        $auto_list = $auto_model->findAll($criteria);
        foreach ($auto_list as $k => $v) {
            $p_type_arr = json_decode($v->p_project_style);
            if (in_array($model->p_type, $p_type_arr)) {//如果此项目在用户设置的自动投标项目类型内
                if ($auto_money_yes + $v->p_order_maxmoney <= $auto_total_money) {//如果本项目剩余自动投标可投金额加上用户设置的最大投资金额小于本项目可自动投标总额
                    $assets_model = Assets::model();
                    $assets_info = $assets_model->findByPk($v->p_user_id);
                    if ($assets_info->real_money - $v->p_retain >= $v->p_order_maxmoney) {//如果用户可用资金减去保留金额，足够投资本用户设置的最大投资金额最大金额，则投资最大金额
                        $the_yes_money = $v->p_order_maxmoney;
                        if ($the_yes_money <= $model->p_mostaccount) {//如果用户可用资金减去保留金额 大于 项目最大投资金额
                            $invest_pay_data['project_info'] = $model;
                            $invest_pay_data['user_id'] = $v->p_user_id;
                            $invest_pay_data['invest_money'] = $the_yes_money;
                            if (self::Invest_pay($invest_pay_data)) {
                                $auto_money_yes += $invest_pay_data['invest_money'];
                                $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                $v->update();
                            }
                        } else {
                            $the_yes_money = $model->p_mostaccount;
                            if ($the_yes_money > $v->p_order_minmoney) {
                                $invest_pay_data['project_info'] = $model;
                                $invest_pay_data['user_id'] = $v->p_user_id;
                                $invest_pay_data['invest_money'] = $the_yes_money;
                                if (self::Invest_pay($invest_pay_data)) {
                                    $auto_money_yes += $invest_pay_data['invest_money'];
                                    $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                    $v->update();
                                }
                            } else {
                                $the_yes_money = $v->p_order_minmoney;
                                $invest_pay_data['project_info'] = $model;
                                $invest_pay_data['user_id'] = $v->p_user_id;
                                $invest_pay_data['invest_money'] = $the_yes_money;
                                if (self::Invest_pay($invest_pay_data)) {
                                    $auto_money_yes += $invest_pay_data['invest_money'];
                                    $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                    $v->update();
                                }
                            }
                        }
                    } else {//否则投资用户（剩余金额-保留金额）。
                        $the_yes_money = $assets_info->real_money - $v->p_retain;
                        if ($the_yes_money >= $model->p_lowaccount) {
                            $invest_pay_data['project_info'] = $model;
                            $invest_pay_data['user_id'] = $v->p_user_id;
                            $invest_pay_data['invest_money'] = $the_yes_money;
                            if (self::Invest_pay($invest_pay_data)) {
                                $auto_money_yes += $invest_pay_data['invest_money'];
                                $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                $v->update();
                            }
                        }
                    }
                } else {
                    $the_yes_money = $auto_total_money - $auto_money_yes; //算出本次可投金额
                    if ($the_yes_money <= 0) {
                        return false;
                    }
                    if ($the_yes_money >= $v->p_order_minmoney) {//可投金额必须大于最小投标金额
                        $assets_model = Assets::model();
                        $assets_info = $assets_model->findByPk($v->p_user_id);
                        if ($assets_info->real_money - $v->p_retain >= $the_yes_money) {//如果用户可用资金减去保留金额，足够投资本用户设置的最大投资金额最大金额，则投资最大金额
                            $invest_pay_data['project_info'] = $model;
                            $invest_pay_data['user_id'] = $v->p_user_id;
                            $invest_pay_data['invest_money'] = $the_yes_money;
                            if (self::Invest_pay($invest_pay_data)) {
                                $auto_money_yes += $invest_pay_data['invest_money'];
                                $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                $v->update();
                            }
                        } else {//否则投资用户（剩余金额-保留金额）。
                            $the_yes_money = $assets_info->real_money - $v->p_retain;
                            if ($the_yes_money >= $v->p_order_minmoney) {//可投金额必须大于最小投标金额
                                if ($the_yes_money >= $model->p_lowaccount) {
                                    $invest_pay_data['project_info'] = $model;
                                    $invest_pay_data['user_id'] = $v->p_user_id;
                                    $invest_pay_data['invest_money'] = $the_yes_money;
                                    if (self::Invest_pay($invest_pay_data)) {
                                        $auto_money_yes += $invest_pay_data['invest_money'];
                                        $v->p_order_autotime = time() . substr(microtime(), 2, 6);
                                        $v->update();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                //不在投标类型范围内
            }
        }
    }

    public function Invest_pay($invest_data = array()) {
        $order_model = new ProjectOrder;
        $order_model->p_id = LYCommon::getInsertID();
        $order_model->p_user_id = $invest_data['user_id'];
        $order_model->p_money = intval($invest_data['invest_money']);
        $order_model->p_realmoney = intval($invest_data['invest_money']);
        $order_model->p_status = 1;
        $order_model->p_type = 1;
        if (LYCommon::AddOrder($invest_data['project_info'], $order_model, true)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionSearchUser() {
        $user_model = User::model();
        $criteria = new CDbcriteria;
        if (isset($_GET['Search'])) {
            switch ($_GET['Search']['search_type']) {
                case 'user_id':
                    $criteria->compare('user_id', $_GET['Search']['search_value'], true);
                    break;
                case 'user_name':
                    $criteria->compare('user_name', $_GET['Search']['search_value'], true);
                    break;
                case 'real_name':
                    $criteria->compare('real_name', $_GET['Search']['search_value'], true);
                    break;
            }
        }
        $total_count = $user_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $user_model->findAll($criteria);
        $this->render('searchuser', array(
            'user_model' => $user_model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionAdduserproject($uid) {
        if (empty(Yii::app()->session['new_project_id'])) {
            Yii::app()->session['new_project_id'] = LYCommon::getInsertID();
        }
        $project_model = new Project;
        $project_pic_modle = ProjectPic::model();

        $user_model = User::model();
        $user_info = $user_model->findByPk($uid);

        $repayment_type_arr = array(); //还款方式
        $repayment_type_day = array();
        $day_style = array("3", "4");
        $month_style = array("1", "2", "5");
        foreach (LYCommon::GetItemList('project_repay_type') as $k => $v) {
            if (in_array($v->i_value, $day_style)) {
                $repayment_type_day[$v->i_value] = $v->i_name;
            }
            if (in_array($v->i_value, $month_style)) {
                $repayment_type_arr[$v->i_value] = $v->i_name;
            }
        }

        $project_type_arr = LYCommon::findcat('project_type', '');

        $project_minorder_type_arr = array();  //最小投标金额
        foreach (LYCommon::GetItemList('project_minorder_type') as $k => $v) {
            $project_minorder_type_arr[$v->i_value] = $v->i_name;
        }

        $project_maxorder_type_arr = array();  //最多投标金额
        foreach (LYCommon::GetItemList('project_maxorder_type') as $k => $v) {
            $project_maxorder_type_arr[$v->i_value] = $v->i_name;
        }
        $project_maxorder_type_arr = array_reverse($project_maxorder_type_arr);

        $project_day_type_arr = array();  //借款天分
        foreach (LYCommon::GetItemList('project_day_type') as $k => $v) {
            $project_day_type_arr[$v->i_value] = $v->i_name;
        }

        $project_month_type_arr = array();  //借款月份
        foreach (LYCommon::GetItemList('project_month_type') as $k => $v) {
            $project_month_type_arr[$v->i_value] = $v->i_name;
        }

        $project_validtime_arr = array(); //借款有效时间
        foreach (LYCommon::GetItemList('project_valid_type') as $k => $v) {
            $project_validtime_arr[$v->i_value] = $v->i_name;
        }

        if (isset($_POST['Project'])) {
            $project_model->attributes = $_POST['Project'];
            $project_model->p_user_id = $uid;
            $project_model->p_status = 0;
            $project_model->p_addtime = time();
            $project_model->p_addip = $_SERVER['REMOTE_ADDR'];
            $project_model->p_id = LYCommon::getInsertID();
            $project_pic_modle->updateAll(array('p_project_id' => $project_model->p_id), array(
                'condition' => 'p_project_id = :p_project_id',
                'params' => array(':p_project_id' => Yii::app()->session['new_project_id']),
            ));
            Yii::app()->session['new_project_id'] = $project_model->p_id;
            if ($project_model->validate()) {
                if ($project_model->p_account < 50 || $project_model->p_account > 5000000) {
                    $project_model->addError('p_account', '借款金额最小50最大500万！');
                } elseif ($project_model->p_apr < 1 || $project_model->p_apr > 24) {
                    $project_model->addError('p_account', '借款利率要在1%-24%之间！');
                } elseif ($project_model->p_award_type == 1 && ($project_model->p_award < 0 || $project_model->p_award > 100 )) {
                    $project_model->addError('p_account', '设置奖励非法！');
                } elseif ($project_model->p_award_type == 2 && ($project_model->p_award < 0 || $project_model->p_award > 100000 )) {
                    $project_model->addError('p_account', '设置奖励非法！');
                } elseif (isset($_POST['is_dxb']) && $_POST['is_dxb'] == 1 && $project_model->p_dxb == "") {
                    $project_model->addError('p_account', '定向标密码不能为空！');
                } elseif ($project_model->p_style == 5 && ($project_model->p_time_limit % 3 != 0)) {
                    $project_model->addError('p_account', '按季还款月份必须为3的倍数！');
                } elseif ($project_model->p_autorate < 0 || $project_model->p_autorate > 100) {
                    $project_model->addError('p_account', '自动投标比例设置非法！');
                } else {
                    $upload_img = LYCommon::uploadimage($project_model, 'p_pic', trim(trim($project_model->tableName(), '}}'), '{{'));
                    if (!empty($upload_img)) {
                        $project_model->p_pic = $upload_img;
                    }
                    if ($project_model->insert()) {
                        unset(Yii::app()->session['new_project_id']);
                        Yii::app()->user->setFlash('success', '项目发布成功！');
                        $this->redirect(Yii::app()->controller->createUrl('list'));
                        $this->redirect(Yii::app()->controller->createUrl('list'));
                    }
                }
            }
        }

        $project_pic_list = $project_pic_modle->findAllByAttributes(array('p_project_id' => $project_model->p_id));
        $project_pic_list = $project_pic_list? : $project_pic_modle->findAllByAttributes(array('p_project_id' => Yii::app()->session['new_project_id']));
        $this->render('adduserproject', array(
            'model' => $project_model,
            'user_info' => $user_info,
            'project_pic_list' => $project_pic_list,
            'repayment_type_arr' => $repayment_type_arr,
            'repayment_type_day' => $repayment_type_day,
            'project_minorder_type_arr' => $project_minorder_type_arr,
            'project_maxorder_type_arr' => $project_maxorder_type_arr,
            'project_day_type_arr' => $project_day_type_arr,
            'project_month_type_arr' => $project_month_type_arr,
            'project_validtime_arr' => $project_validtime_arr,
            'project_type_arr' => $project_type_arr,
        ));
    }

    public function actionwaitrepay() {
        $model = ProjectRepay::model();
        $criteria = new CDbCriteria;
        $criteria->compare("t.p_status", "0");
        $criteria->join = 'left join {{project}} as t1 on t1.p_id = t.p_project_id';
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . '23:59:59') : time() + 86400 * 365 * 2;
        $criteria->addCondition("t.p_repaytime>'{$start_time}' and t.p_repaytime<'{$end_time}'");
		if (!empty($_GET['style'])){            
            $criteria->addCondition("t1.p_style = {$_GET['style']}");
        }
        if (!empty($_GET['user_name'])) {
            $criteria->join .= ' left join {{user}} as t2 on t1.p_user_id = t2.user_id';
            $criteria->addCondition("t2.user_name like '%{$_GET['user_name']}%'");
        }
        if (!empty($_GET['p_name'])) {
            $criteria->addCondition("t1.p_name like '%{$_GET['p_name']}%'");
        }
        if(!empty($_GET['expire'])){
            if($_GET['expire'] == 1){
                $criteria ->addCondition("t1.p_time_limit = (t.p_order+1)");
            }
        }
		
        if(isset($_GET['outfile_excel'])){
            Yii::import('application.extensions.phpexcel.JPhpExcel');
			$criteria->order = "t.p_repaytime ASC";
            $list = $model->findAll($criteria);
            $data = array(
                            array(
                                            "序号","项目编号","借款人", "借款标题", "期数","应还款时间", "满标时间", "还款方式", "还款总额", "还款本金",  "还款利息","项目总利息",
                            ),
            );
            foreach($list as $k => $v){
                    $data[] = array(
                                    $k+1,
									$v->p_project_id,
                                    $v->project->user->user_name,
                                    $v->project->p_name,
                                    $v->p_order+1 . '/' . $v->project->p_time_limit,
                                    LYCommon::subtime($v->p_repaytime,2),
                                    LYCommon::subtime($v->project->p_fullverifytime,2),
                                    LYCommon::GetItem_of_value($v->project->p_style,'project_repay_type'),
                                    $v->p_repayaccount,
                                    $v->p_money,
                                    $v->p_interest,
                                    sprintf("%.2f", ($v->project->p_repayment - $v->project->p_account)),
                    );
            }

            $xls = new JPhpExcel('UTF-8', true,'用户报表');
            $xls->addArray($data);
            $xls->generateXML('待还记录',false);
            die;
        }
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = "t.p_repaytime ASC";
        $list = $model->findAll($criteria);
        $this->render("waitrepay", array(
            "model" => $model,
            "list" => $list,
            "page_list" => $page_list,
        ));
    }

    public function actionhaverepay() {
        $model = ProjectRepay::model();
        $criteria = new CDbCriteria;
        $criteria->compare("t.p_status", "1");
        $criteria->join = 'left join {{project}} as t1 on t1.p_id = t.p_project_id';
        $start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . '23:59:59') : time() + 86400 * 365 * 2;
        $criteria->addCondition("t.p_repayyestime>'{$start_time}' and t.p_repayyestime<'{$end_time}'");
        if (!empty($_GET['style'])){            
            $criteria->addCondition("t1.p_style = {$_GET['style']}");
        }
        if (!empty($_GET['user_name'])) {
            $criteria->join .= ' left join {{user}} as t2 on t1.p_user_id = t2.user_id';
            $criteria->addCondition("t2.user_name like '%{$_GET['user_name']}%'");
        }
        if (!empty($_GET['p_name'])) {
            $criteria->addCondition("t1.p_name like '%{$_GET['p_name']}%'");
        }
        if(!empty($_GET['expire'])){
            if($_GET['expire'] == 1){
                $criteria ->addCondition("t1.p_time_limit = (t.p_order+1)");
            }
        }
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $list = $model->findAll($criteria);
        $this->render("haverepay", array(
            "model" => $model,
            "list" => $list,
            "page_list" => $page_list,
        ));
    }

    public function actionlaterepay() {
        $model = ProjectRepay::model();
        $criteria = new CDbCriteria;
        $criteria->compare("t.p_status", "0");
        $criteria->join = 'left join {{project}} as t1 on t1.p_id = t.p_project_id';
        $criteria->addCondition("t.p_repaytime<'".time()."'");
        //$criteria->addCondition("t.p_repaytime<'" . time() . "'");
        if (!empty($_GET['user_name'])) {
            $criteria->join .= ' left join {{user}} as t2 on t1.p_user_id = t2.user_id';
            $criteria->addCondition("t2.user_name like '%{$_GET['user_name']}%'");
        }
        if (!empty($_GET['p_name'])) {
            $criteria->addCondition("t1.p_name like '%{$_GET['p_name']}%'");
        }
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = "t.p_repaytime ASC";
        $list = $model->findAll($criteria);
        $this->render("laterepay", array(
            "model" => $model,
            "list" => $list,
            "page_list" => $page_list,
        ));
    }

    public function actionrepayview($id) {
        $model = ProjectRepay::model();
        $project_collect_model = ProjectCollect::model();
        $assets = Assets::model();
        $repay_view = $model->findByPk($id);
        $user_assets = $assets->findByPk($repay_view->project->p_user_id);
        $project_collect_list = $project_collect_model->findAllByAttributes(array("p_project_id" => $repay_view->p_project_id, "p_order" => $repay_view->p_order));
        if (isset($_POST['repay']) && $repay_view->p_status == 0) {
            if (LYCommon::Repay($repay_view)) {
                Yii::app()->user->setFlash('success', '代还款成功！');
                $this->redirect(Yii::app()->controller->createUrl('haverepay'));
            } else {
                Yii::app()->user->setFlash('success', '该用户可用余额不足！');
                $this->redirect(Yii::app()->controller->createUrl('waitrepay'));
            }
        }
        $this->render("repayview", array(
            "model" => $model,
            "repay_view" => $repay_view,
            'project_collect_list' => $project_collect_list,
            "user_assets" => $user_assets,
        ));
    }

    public function actionaddexpProject() {
        $projectexp_model = new ProjectExp();
        $repayment_type_arr = array(); //还款方式
        $repayment_type_day = array();
        $day_style = array("3", "4");
        $month_style = array("3");
        foreach (LYCommon::GetItemList('project_repay_type') as $k => $v) {
            if (in_array($v->i_value, $day_style)) {
                $repayment_type_day[$v->i_value] = $v->i_name;
            }
            if (in_array($v->i_value, $month_style)) {
                $repayment_type_arr[$v->i_value] = $v->i_name;
            }
        }
        $project_type_arr = LYCommon::findcat('project_type', '');

        $project_minorder_type_arr = array();  //最小投标金额
        foreach (LYCommon::GetItemList('project_minorder_type') as $k => $v) {
            $project_minorder_type_arr[$v->i_value] = $v->i_name;
        }

        $project_maxorder_type_arr = array();  //最多投标金额
        foreach (LYCommon::GetItemList('project_maxorder_type') as $k => $v) {
            $project_maxorder_type_arr[$v->i_value] = $v->i_name;
        }
        $project_maxorder_type_arr = array_reverse($project_maxorder_type_arr);

        $project_day_type_arr = array();  //借款天分
        foreach (LYCommon::GetItemList('project_day_type') as $k => $v) {
            $project_day_type_arr[$v->i_value] = $v->i_name;
        }

        $project_month_type_arr = array();  //借款月份
        foreach (LYCommon::GetItemList('project_month_type') as $k => $v) {
            $project_month_type_arr[$v->i_value] = $v->i_name;
        }

        if (isset($_POST['ProjectExp'])) {
            $projectexp_model->attributes = $_POST['ProjectExp'];
            $projectexp_model->p_status = 0;
            $projectexp_model->p_addtime = time();
            $projectexp_model->p_addip = yii::app()->request->userHostAddress;
            $projectexp_model->p_id = LYCommon::getInsertID();
            if ($projectexp_model->validate()) {
                if ($projectexp_model->p_account < 50 || $projectexp_model->p_account > 5000000) {
                    $projectexp_model->addError('p_account', '借款金额最小50最大500万！');
                } elseif ($projectexp_model->p_apr < 12 || $projectexp_model->p_apr > 24) {
                    $projectexp_model->addError('p_account', '借款利率要在12%-24%之间！');
                } else {

                    if ($projectexp_model->insert()) {
                        Yii::app()->user->setFlash('success', '项目发布成功！');
                        $this->redirect(Yii::app()->controller->createUrl('explist'));
                        $this->redirect(Yii::app()->controller->createUrl('explist'));
                    }
                }
            }
        }

        $this->render('addexpproject', array('model' => $projectexp_model, 'repayment_type_arr' => $repayment_type_arr,
            'repayment_type_day' => $repayment_type_day,
            'project_minorder_type_arr' => $project_minorder_type_arr,
            'project_maxorder_type_arr' => $project_maxorder_type_arr,
            'project_day_type_arr' => $project_day_type_arr,
            'project_month_type_arr' => $project_month_type_arr,
            'project_type_arr' => $project_type_arr,));
    }

    public function actionexpList() {
        $model = ProjectExp::model();
        $criteria = new CDbCriteria;
        if (isset($_GET['ProjectExp'])) {
            $model->attributes = $_GET['ProjectExp'];
        }
        if (!empty($model->p_status)) {
            $criteria->compare('p_status', $model->p_status);
        }
        if (!empty($model->p_type)) {
            $criteria->compare('p_type', $model->p_type);
        }

        $criteria->compare('p_name', $model->p_name, true);

        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('explist', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionexpinvestList() {
        $model = ProjectExporder::model();
        $id = yii::app()->request->getParam('id');
        $criteria = new CDbCriteria;
        $criteria->compare('p_project_id', $id);
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 'p_addtime DESC';
        $list = $model->findAll($criteria);
        $this->render('expinvestlist', array(
            'list' => $list,
            'page_list' => $page_list,
        ));
    }

    public function actionexpview() {
        $id = yii::app()->request->getParam('id');
        $model = ProjectExp::model()->findByPk($id);
        if (isset($_POST['ProjectExp'])) {
            $model->attributes = $_POST['ProjectExp'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '项目更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('explist'));
            }
        }
        $this->render('expview', array(
            'model' => $model
        ));
    }

    public function actionexpdel() {
        $id = yii::app()->request->getParam('id');
        $model = ProjectExp::model()->findByPk($id);
        if (empty($model)) {
            $ret = '标不存在，删除失败';
            die($ret);
        }
        $conn = yii::app()->db;
        $sql = "SELECT * FROM {{project_exporder}} WHERE p_id=$id and p_repay_yestime<=0";
        $list = $conn->createCommand($sql)->queryAll();
        if(empty($list) && $model->p_account==$model->p_account_yes){
           $model->delete();
           $ret='已删除';
           die($ret);
        }else{
           $ret='标不为空或者未全部还款，不能删除';
          die($ret);  
        }
    }
	
	public function actionorderlist(){
		$order_model = ProjectOrder::model();
		$project_model = Project::model();
		$criteria = new CDbCriteria;
		if(isset($_GET['user_name'])){
			$criteria->join = ' left join {{user}} as t1 on t.p_user_id = t1.user_id';
            $criteria->addCondition("t1.user_name like '%{$_GET['user_name']}%'");
		}
		if(isset($_GET['Project'])){
			$criteria->with="project";
			$project_model->attributes = $_GET['Project'];
			$criteria->compare("project.p_name",$project_model->p_name,true);
			if($project_model->p_time_limittype != '-1'){
				$criteria->compare("project.p_time_limittype",$project_model->p_time_limittype);
			}
			
			if(!empty($project_model->p_time_limit)){
				$criteria->compare("project.p_time_limit",$project_model->p_time_limit);
			}
		}
		$start_time = (isset($_GET['start_time']) && $_GET['start_time'] != "") ? strtotime($_GET['start_time']) : 0;
        $end_time = (isset($_GET['end_time']) && $_GET['end_time'] != "") ? strtotime($_GET['end_time'] . '23:59:59') : time() + 86400 * 365 * 2;
        $criteria->addCondition("t.p_addtime>'{$start_time}' and t.p_addtime<'{$end_time}'");
		if (isset($_GET['outfile_excel'])) {
            Yii::import('application.extensions.phpexcel.JPhpExcel');
			$criteria->order = 't.p_addtime DESC';
            $list = $order_model->findAll($criteria);
            $data = array(
                array(
                    "序号","项目编号", "用户名", "真实姓名", "项目id","项目名称", "还款方式", "投资金额", "应收金额", "已收金额", "应收利息", "添加时间"
                ),
            );
            foreach ($list as $k => $v) {
                $data[] = array(
                    $k + 1,
                    $v->p_project_id,
                    $v->user->user_name,
                    $v->user->real_name,
					$v->project->p_id,
                    $v->project->p_name,
					LYCommon::GetItem_of_value($v->project->p_style,'project_repay_type'),
                    $v->p_realmoney . "元",
                    $v->p_repayaccount. "元",
                    $v->p_repayyesaccount. "元",
                    $v->p_interest."元",
                    LYCommon::subtime($v->p_addtime, 2),
                );
            }

            $xls = new JPhpExcel('UTF-8', false, '投资列表');
            $xls->addArray($data);
            $xls->generateXML('投资列表',false);
            die;
        }
		$total_count = $order_model->count($criteria);
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6, 3, 7,0,2));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $criteria->limit = $page->limitnum;
        $criteria->offset = $page->offset;
        $criteria->order = 't.p_addtime DESC';
        $list = $order_model->findAll($criteria);
		
		$project_day_type_arr = array();  //借款天分
        foreach (LYCommon::GetItemList('project_day_type') as $k => $v) {
            $project_day_type_arr[$v->i_value] = $v->i_name;
        }

        $project_month_type_arr = array();  //借款月份
        foreach (LYCommon::GetItemList('project_month_type') as $k => $v) {
            $project_month_type_arr[$v->i_value] = $v->i_name;
        }
		$this->render("orderlist",array(
			"list"=>$list,
			"order_model"=>$order_model,
			"page_list"=>$page_list,
			"project_model"=>$project_model,
			"project_month_type_arr"=>$project_month_type_arr,
			"project_day_type_arr"=>$project_day_type_arr,
		));
	}
	
	public function actioncallback($id){
		$model = Project::model();
		$model_one = $model->findByPk($id);
		if(!empty($model_one)){
			if(LYCommon::liubiao($model_one)){
				echo json_encode(1);
			}
		}
		echo json_encode(0);
	}

}
