<?php

class AssetsCashController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = AssetsCash::model();
            $user_model=User::model();
            $model->unsetAttributes();
            $criteria = new CDbCriteria;
            if(isset($_GET['AssetsCash'])){
                $model->attributes=$_GET['AssetsCash'];
            }
            if(isset($_GET['User'])){
                    $user_model->attributes=$_GET['User'];
            }
            $criteria -> with = 'user';
            if($model->c_status != '-1'){
                $criteria ->compare('c_status', $model->c_status);
            }
            
            $criteria->compare('user.user_name', $user_model->user_name,true);
            $criteria->compare('user.real_name', $user_model->real_name,true);
            
            if(!empty($_GET['start_time'])){
                $criteria->addCondition('c_addtime > '. strtotime($_GET['start_time']));
            }
            if(!empty($_GET['end_time'])){
                $criteria->addCondition('c_addtime <= '. strtotime($_GET['end_time']. '23:59:59'));
            }
            if(isset($_GET['outfile_excel'])){
                Yii::import('application.extensions.phpexcel.JPhpExcel');
                $criteria -> order = 'c_addtime  DESC';
                $list = $model->findAll($criteria);
                $data = array(
                    array(
                        "序号",'提现ID','用户名','真实姓名', "省", "市","提现账号", "提现银行", "支行", "提现总额", "到账金额", "手续费", "提现时间", "状态"
                    ),
                );
                foreach($list as $k => $v){
                    $data[] = array(
                    	$k+1,
                        $v->c_id,
                        $v->user->user_name,
                        $v->user->real_name,
                        empty($v->c_city)?"未知":$v->area_c->name,
                        empty($v->c_province)?"未知":$v->area_p->name,
                    	$v->c_cardNum,
                    	$v->item->i_name,
                    	$v->c_branch,
                    	$v->c_money,
                    	$v->c_realmoney,
                    	$v->c_fee,
                    	LYCommon::subtime($v->c_addtime,2),
                    	$model->itemAlias('c_status',$v->c_status),
                    );
                }
                
                $xls = new JPhpExcel('UTF-8',true);
                $xls->addArray($data);
                $xls->generateXML('提现报表',false);
                die;
            }
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $criteria -> order = 'c_addtime  DESC';
            $list = $model->findAll($criteria);
            $this->render('list',array(
                'model'=>$model,
                'user_model'=>$user_model,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new AssetsCash;
            
            if(isset($_POST['Assets_cash'])){
                $model->attributes = $_POST['Assets_cash'];
                foreach(json_decode($mr_arr) as $k => $v){
                    if(!array_key_exists($v->field_name,$_POST['Assets_cash']) || empty($_POST['Assets_cash'][$v->field_name])){
                        $model->{$v->field_name} = $v->mr;
                    }
                }
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','提现添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('create',array(
                'model'=>$model,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            if(isset($_POST['AssetsCash'])){
                $model->attributes = $_POST['AssetsCash'];
                    if($_POST['AssetsCash']['c_fee']+$_POST['AssetsCash']['c_realmoney']==$model->c_money){
                        $model->c_verify_user=Yii::app()->user->id;
                        $model->c_verify_time=time();
                        $transaction = Yii::app()->db->beginTransaction();
                        try{
                            if($model->save()){
                                $assets=new Assets();
                                $user_assets=$assets->findByPk($model->c_user_id);
                                if($model->c_status==1){
                                    $bill['user_id']=$model->c_user_id;
                                    $bill['b_money']=$model->c_realmoney;
                                    $bill['b_type']=2;
                                    $bill['b_itemtype']="assets_cash_success";
                                    $bill['u_total_money']=$user_assets->total_money-$bill['b_money'];
                                    $bill['u_real_money']=$user_assets->real_money;
                                    $bill['u_frost_money']=$user_assets->frost_money-$bill['b_money'];
                                    $bill['u_wait_interest']=$user_assets->wait_interest;
                                    $bill['u_have_interest']=$user_assets->have_interest;
                                    $bill['u_wait_total_money']=$user_assets->wait_total_money;
                                    $bill['b_mark']=$model->c_id;
                                    $bill['b_time']=time();
                                    $bill['remark']="提现{$model->c_money}元成功！";
                                    LYCommon::AddBill($bill);

                                    $user_assets1=$assets->findByPk($model->c_user_id);
                                    $bill['user_id']=$model->c_user_id;
                                    $bill['b_money']=$model->c_fee;
                                    $bill['b_type']=2;
                                    $bill['b_itemtype']="assets_cash_fee";
                                    $bill['u_total_money']=$user_assets1->total_money-$bill['b_money'];
                                    $bill['u_real_money']=$user_assets1->real_money;
                                    $bill['u_frost_money']=$user_assets1->frost_money-$bill['b_money'];
                                    $bill['u_wait_interest']=$user_assets1->wait_interest;
                                    $bill['u_have_interest']=$user_assets1->have_interest;
                                    $bill['u_wait_total_money']=$user_assets1->wait_total_money;
                                    $bill['b_mark']=$model->c_id;
                                    $bill['b_time']=time();
                                    $bill['remark']="提现{$model->c_money}元扣除{$model->c_fee}元手续费！";
                                    LYCommon::AddBill($bill);
                                    //发送站内信
                                    LYCommon::send_message(0, $model->c_user_id, 'cash_suc', array(
                                        'cash_money' => number_format($model->c_money,2),
                                    ));
									//提现成功，发送短信
									if(!empty($model->user->user_phone) && !empty($model->user->is_phone_check)){
                                        LYCommon::sendSms($model->c_user_id,$model->user->user_phone,'cash_suc',array(
                                            'cash_money'=>number_format($model->c_money,2),
                                        ));
                                    }
                                }elseif($model->c_status==2){
                                    $bill['user_id']=$model->c_user_id;
                                    $bill['b_money']=$model->c_money;
                                    $bill['b_type']=0;
                                    $bill['b_itemtype']="assets_cash_false";
                                    $bill['u_total_money']=$user_assets->total_money;
                                    $bill['u_real_money']=$user_assets->real_money+$bill['b_money'];
                                    $bill['u_frost_money']=$user_assets->frost_money-$bill['b_money'];
                                    $bill['u_wait_interest']=$user_assets->wait_interest;
                                    $bill['u_have_interest']=$user_assets->have_interest;
                                    $bill['u_wait_total_money']=$user_assets->wait_total_money;
                                    $bill['b_mark']=$model->c_id;
                                    $bill['b_time']=time();
                                    $bill['remark']="提现{$model->c_money}元失败，冻结资金返还！";
                                    LYCommon::AddBill($bill);
                                    //发送站内信
                                    LYCommon::send_message(0, $model->c_user_id, 'cash_fail', array(
                                        'cash_money' => number_format($model->c_money,2),
                                    ));
									//提现失败，发送短信
									if(!empty($model->user->user_phone) && !empty($model->user->is_phone_check)){
                                        LYCommon::sendSms($model->c_user_id,$model->user->user_phone,'cash_fail',array(
                                            'cash_money'=>number_format($model->c_money,2),
                                        ));
                                    }
                                }
                                $transaction ->commit();
                                Yii::app()->user->setFlash('success','提现更新成功！');
                                $this->redirect(Yii::app()->controller->createUrl('list'));
                            }
                        }  catch (Exception $e){
                            $transaction ->rollback();
                        }
                    }else{
                            $model->addError('c_fee','手续费加到账金额大于所提现金额！');
                    }
            }
            $this->render('update',array(
                'model'=>$model,
            ));                    
        }
        
        /*
         * 删除单条记录
         */
        public function actionAjaxdelete($id){
            $model = self::loadmodel($id);
            if($model->delete()){
                echo json_encode(1);
                die;
            }else{
                echo json_encode(0);
                die;
            }
        }
        
        /*
         * 批量删除
         */
        public function actionAjaxdelmore(){
            if(isset($_POST['delarr'])){
                $del_result = array('status'=>0);
                $model = Assetscash::model();
                if($model->deleteAllByAttributes(array('assets_cash_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        
        public function actionOutfileexcel(){
            
        }
        public function loadmodel($id){
            return AssetsCash::model()->findByPk($id);
        }
}