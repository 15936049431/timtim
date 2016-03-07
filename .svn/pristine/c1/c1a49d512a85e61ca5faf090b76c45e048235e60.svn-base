<?php

class IntegralOrderController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = IntegralOrder::model();
            $model->unsetAttributes();
            $user_model=User::model();
            $criteria = new CDbCriteria;
            if(isset($_GET['IntegralOrder'])){
            	$model->attributes=$_GET['IntegralOrder'];
            }
            if(isset($_GET['User'])){
            	$user_model->attributes=$_GET['User'];
            }
            $criteria->with='user';
            $criteria->compare('status',$model->status);
            $criteria->compare('user.user_name',$user_model->user_name,true);
            
            if(isset($_GET['outfile_excel'])){
            	Yii::import('application.extensions.phpexcel.JPhpExcel');
            	$criteria -> order = 'addtime  DESC';
            	$list = $model->findAll($criteria);
            	$data = array(
            			array(
            					"序号",'用户名','商品名', "收获地址", "数量", "所需积分", "用户评价", "状态", "添加时间"
            			),
            	);
            	foreach($list as $k => $v){
            		$data[] = array(
            				$k+1,
            				$v->user->user_name,
            				$v->integral_shop->i_name,
            				empty($v->address_id)?"无":$v->integral_address->address_allwith,
            				$v->number,
            				$v->need_integral,
            				$v->user_remark,
            				$v->itemAlias('status',$v->status),
            				LYCommon::subtime($v->addtime,2),
            		);
            	}
            
            	$xls = new JPhpExcel('UTF-8', false,'订单报表');
            	$xls->addArray($data);
            	$xls->generateXML('integralOrder');
            	die;
            }
            
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
			$criteria -> order = 'addtime  DESC';
			$list = $model->findAll($criteria);
            $this->render('list',array(
                'model'=>$model,
                'list'=>$list,
                'page_list'=>$page_list,
            	'user_model'=>$user_model,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new IntegralOrder;
            
            if(isset($_POST['IntegralOrder'])){
				$model->i_id=LYCommon::getInsertID();
                $model->attributes = $_POST['IntegralOrder'];
				$model->i_addtime=time();
				$model->i_addip=$_SERVER['REMOTE_ADDR'];
                if($model->save()){
                    Yii::app()->user->setFlash('success','商品添加成功！');
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
            if(isset($_POST['IntegralOrder'])){
                $model->attributes = $_POST['IntegralOrder'];
                if($model->status==0){ //用户未确认收货，重新发货
                	
                }elseif($model->status==1){//正常审核成功
                	$model->verify_time=time();
                	$model->send_time=time();
                }elseif($model->status==5){//返还用户积分处理
                	$pintegral_model = Integral::model();
                	$integral_info = $pintegral_model ->findByPk($model->user_id);
                	$integral_info -> i_total_value = $integral_info -> i_total_value + $model->need_integral;
                	$integral_info -> i_real_value = $integral_info -> i_real_value + $model->need_integral;
                	$data = array(
                			'i_cat_alias'=>'exchange_phone_false',
                			'remark'=>'兑换'.$model->foods_name.'失败,积分返还',
                	);
                	LYCommon::Add_integral($integral_info, $data);
                }
                $model->verify_user=Yii::app()->user->id;
                if($model->update()){
                    Yii::app()->user->setFlash('success','订单更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
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
                $model = Integral_shop::model();
                if($model->deleteAllByAttributes(array('integral_shop_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return IntegralOrder::model()->findByPk($id);
        }
}