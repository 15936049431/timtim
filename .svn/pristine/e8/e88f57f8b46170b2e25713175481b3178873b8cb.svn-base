<?php

class AssetsRechargeController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = AssetsRecharge::model();
			$model->unsetAttributes();
			$user_model=User::model();
			$criteria = new CDbCriteria;
			if(isset($_GET['AssetsRecharge'])){
                            $model->attributes=$_GET['AssetsRecharge'];
			}
			if(!empty($model->r_recharge_type) && $model->r_recharge_type!="0"){
				$criteria->compare("r_recharge_type",$model->r_recharge_type);
			}
			if(isset($_GET['User'])){
                            $user_model->attributes=$_GET['User'];
			}
			$criteria->with='user';
                        if($model->r_status != '-1'){
                            $criteria->compare('r_status',$model->r_status);
                        }
                        if($model->r_type != '-1'){
                            $criteria->compare('r_type',$model->r_type);
                        }
			
			$criteria->compare('user.user_name',$user_model->user_name,true);
			if(!empty($_GET['start_time'])){
                            $criteria->addCondition('r_addtime > '. strtotime($_GET['start_time']));
                        }
                        if(!empty($_GET['end_time'])){
                            $criteria->addCondition('r_addtime <= '. strtotime($_GET['end_time']. '23:59:59'));
                        }
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$criteria -> order = 'r_addtime  DESC';
				$list = $model->findAll($criteria);
				$data = array(
						array(
							"序号","ID", "订单编号", "用户名称","真实姓名", "类型", "所属银行", "充值金额", "费用", "到账金额", "添加时间", "状态"
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->r_id,
							$v->r_BillNo,
							$v->user->user_name,
							$v->user->real_name,
							$model->itemAlias('r_type',$v->r_type),
							LYCommon::GetItem($v->r_recharge_type,($v->r_type==1)?'assets_recharge_type':'assets_oevrrecharge_type'),
							$v->r_money,
							$v->r_fee,
							$v->r_money,
							LYCommon::subtime($v->r_addtime,2),
							$model->itemAlias('r_status',$v->r_status),
					);
				}
			
				$xls = new JPhpExcel('UTF-8');
				$xls->addArray($data);
				$xls->generateXML('充值列表',false);
				die;
			}
			
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $criteria -> order = 'r_addtime DESC';
			$list = $model->findAll($criteria);
			
			$online_recharge = LYCommon::GetItemList("assets_recharge_type",'i_order ASC');
			$recharge_list = array();
			foreach ($online_recharge as $k => $v) {
				$recharge_list[$v->i_nid] = $v->i_name;
			}
            $this->render('list',array(
                'model'=>$model,
				'user_model'=>$user_model,
                'list'=>$list,
                'page_list'=>$page_list,
				'recharge_list'=>$recharge_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new AssetsRecharge;
            
            if(isset($_POST['Assets_recharge'])){
                $model->attributes = $_POST['Assets_recharge'];
                if($model->save()){
                    Yii::app()->user->setFlash('success','充值添加成功！');
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
            if(isset($_POST['AssetsRecharge'])){
                $model->attributes = $_POST['AssetsRecharge'];
                $model->r_verify_user=Yii::app()->user->id;
				$model->r_verify_time=time();
				$model->r_addip=$_SERVER['REMOTE_ADDR'];
				$transaction = Yii::app()->db->beginTransaction();
                try{
					if($model->save()){
						if($model->r_status==1){
							$assets=new Assets();
                            $user_assets=$assets->findByPk($model->r_user_id);
							$bill['user_id']=$model->r_user_id;
                            $bill['b_money']=$model->r_money;
                            $bill['b_type']=1;
                            $bill['b_itemtype']="assets_recharge";
                            $bill['u_total_money']=$user_assets->total_money+$bill['b_money'];
                            $bill['u_real_money']=$user_assets->real_money+$bill['b_money'];
                            $bill['u_frost_money']=$user_assets->frost_money;
                            $bill['u_wait_interest']=$user_assets->wait_interest;
                            $bill['u_have_interest']=$user_assets->have_interest;
                            $bill['u_wait_total_money']=$user_assets->wait_total_money;
                            $bill['b_mark']=$model->r_id;
                            $bill['b_time']=time();
                            $bill['remark']="充值{$model->r_money}元成功！";
                            LYCommon::AddBill($bill);
                            
                            $award=$model->r_money*Yii::app()->params['assets_overline'];
                            if(($model->r_money>Yii::app()->params['assets_overmin']) && ($award>0)){
                            	$user_assets1=$assets->findByPk($model->r_user_id);
                            	$bill1['user_id']=$model->r_user_id;
                            	$bill1['b_money']=$award;
                            	$bill1['b_type']=1;
                            	$bill1['b_itemtype']="assets_recharge_line";
                            	$bill1['u_total_money']=$user_assets1->total_money+$bill1['b_money'];
                            	$bill1['u_real_money']=$user_assets1->real_money+$bill1['b_money'];
                            	$bill1['u_frost_money']=$user_assets1->frost_money;
                            	$bill1['u_wait_interest']=$user_assets1->wait_interest;
                            	$bill1['u_have_interest']=$user_assets1->have_interest;
                            	$bill1['u_wait_total_money']=$user_assets1->wait_total_money;
                            	$bill1['b_mark']=$model->r_id;
                            	$bill1['b_time']=time();
                            	$bill1['remark']="线下充值的奖励{$award}元！";
                            	LYCommon::AddBill($bill1);
                            }
                            
						}
						$transaction ->commit();
						Yii::app()->user->setFlash('success','充值更新成功！');
						$this->redirect(Yii::app()->controller->createUrl('list'));
					}
				}catch (Exception $e){
                    $transaction ->rollback();
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
                $model = Assets_recharge::model();
                if($model->deleteAllByAttributes(array('assets_recharge_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return AssetsRecharge::model()->findByPk($id);
        }
}