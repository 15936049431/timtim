<?php

class IntegralShopController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = IntegralShop::model();
            $model->unsetAttributes();
            $criteria = new CDbCriteria;
            if(isset($_GET['IntegralShop'])){
            	$model->attributes=$_GET['IntegralShop'];
            }
            $criteria->compare('i_type',$model->i_type);
            $criteria->compare('i_name',$model->i_name,true);
            
            if(isset($_GET['outfile_excel'])){
            	Yii::import('application.extensions.phpexcel.JPhpExcel');
            	$criteria -> order = 'i_addtime  DESC';
            	$list = $model->findAll($criteria);
            	$data = array(
            			array(
            					"序号",'ID','商品名称','商品类型','商品总数量', "已售数量", "商品单价", "商品描述",  "是否可重复兑换", "添加时间",
            			),
            	);
            	foreach($list as $k => $v){
            		$data[] = array(
            				$k+1,
            				$v->i_id,
            				$v->i_name,
            				$v->item->i_name,
            				$v->i_num,
            				$v->i_selenum,
            				$v->i_price,
            				$v->i_desc,
            				$model->itemAlias('i_twice',$v->i_twice),
            				LYCommon::subtime($v->i_addtime,2),
            		);
            	}
            	$xls = new JPhpExcel('UTF-8', false,'商品报表');
            	$xls->addArray($data);
            	$xls->generateXML('integralShop');
            	die;
            }
            
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $list = $model->findAll($criteria);
            
            $item=LYCommon::GetItemList('integral_type');
            foreach($item as $key=>$value){
            	$type_list[$value->i_id]=$value->i_name;
            }
            $this->render('list',array(
                'model'=>$model,
                'list'=>$list,
                'page_list'=>$page_list,
           		'type_list'=>$type_list,
            ));
        }
        
        public function actionuserintegral(){
      		$model=Integral::model();
      		$user_model=User::model();
      		$criteria = new CDbCriteria;
      		if(isset($_GET['User'])){
      			$user_model->attributes=$_GET['User'];
      		}
      		$criteria->with='user';
      		$criteria->compare('user.user_name',$user_model->user_name,true);
      		$total_count = $model->count($criteria);
      		$page = new Pagination($total_count,10);
      		$page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
      		$page_list = $total_count<=$page->limitnum?"":$page_list;
      		$criteria -> limit = $page->limitnum;
      		$criteria -> offset = $page->offset;
      		$list = $model->findAll($criteria);
      		$this->render('userintegral',array(
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
            $model = new IntegralShop;
            
            if(isset($_POST['IntegralShop'])){
                $model->i_id=LYCommon::getInsertID();
                $model->attributes = $_POST['IntegralShop'];
                $model->i_addtime=time();
                $model->i_addip=$_SERVER['REMOTE_ADDR'];
                //$model->i_pic = LYCommon::uploadimage($model,'i_pic',trim(trim($model->tableName(),'}}'),'{{'));
                $pic_arr = array();
                if(isset($_POST['IntegralShop']['productpic'])){
                    foreach($_POST['IntegralShop']['productpic'] as $k => $v){
                        $pic_arr[] = $v;
                    }
                }
                $model->i_pic = serialize($pic_arr);
                if($model->save()){
                    Yii::app()->user->setFlash('success','商品添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
			$item=LYCommon::GetItemList('integral_type');
			foreach($item as $key=>$value){
				$typeitem[$value->i_id]=$value->i_name;
			}
            $this->render('create',array(
                'model'=>$model,
				'typeitem'=>$typeitem,
            ));
        }
        
        public function actionexchange(){
        	$model = Exchange::model();
        	$user_model = User::model();
        	$criteria = new CDbCriteria;
        	if(isset($_GET['User'])){
        		$user_model->attributes=$_GET['User'];
        	}
        	$criteria->with='user';
        	$criteria->compare('user.user_name',$user_model->user_name,true);
                if(isset($_GET['Exchange'])){
                    $model->attributes = $_GET['Exchange'];
                    $criteria ->compare('t.exchange_status', $model->exchange_status);
                }
                if(isset($_GET['outfile_excel'])){
            	Yii::import('application.extensions.phpexcel.JPhpExcel');
            	$list = $model->findAll($criteria);
            	$data = array(
            			array(
            					"序号",'ID','用户名','兑换金额','所需积分', "兑换类型", "兑换状态", "兑换手机", "添加时间",
            			),
            	);
            	foreach($list as $k => $v){
            		$data[] = array(
            				$k+1,
            				$v->exchange_id,
            				$v->user->user_name,
            				$v->exchange_money,
            				$v->exchange_useintegral,
            				$v->item->i_name,
            				$v->exchange_status==1?'兑换成功':($v->exchange_status==2?"兑换失败":"未审核"),
            				$v->exchange_phone,
            				LYCommon::subtime($v->exchange_time,2),
            		);
            	}
            
            	$xls = new JPhpExcel('UTF-8', false,'积分兑换');
            	$xls->addArray($data);
            	$xls->generateXML('exchange');
            	die;
            }
        	$total_count = $model->count($criteria);
        	$page = new Pagination($total_count,10);
        	$page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
        	$page_list = $total_count<=$page->limitnum?"":$page_list;
        	$criteria -> limit = $page->limitnum;
        	$criteria -> offset = $page->offset;
        	$list = $model->findAll($criteria);
        	$this->render("exchange",array(
        		"model"=>$model,
        		"user_model"=>$user_model,
        		"list"=>$list,
        		"page_list"=>$page_list,
        	));
        }
        
        public function actionexchangeview($id){
        	$model = Exchange::model();
        	$exchange_model = $model->findByPk($id);
        	if(isset($_POST['Exchange'])){
        		$exchange_model->attributes = $_POST['Exchange'];
        		$exchange_model->exchange_verify = Yii::app()->user->id;
        		$exchange_model->exchange_verifytime = time();
        		if($exchange_model->update()){
        			if($exchange_model->exchange_status==2){
        				$pintegral_model = Integral::model();
        				$integral_info = $pintegral_model ->findByPk($exchange_model->exchange_user);
        				$integral_info -> i_total_value = $integral_info -> i_total_value + $exchange_model->exchange_useintegral;
        				$integral_info -> i_real_value = $integral_info -> i_real_value + $exchange_model->exchange_useintegral;
        				$data = array(
        						'i_cat_alias'=>'exchange_phone_false',
        						'remark'=>'兑换话费'.$exchange_model->exchange_money.'元失败,积分返还',
        				);
        				LYCommon::Add_integral($integral_info, $data);
        			}
        			Yii::app()->user->setFlash('success','更新成功！');
        			$this->redirect(Yii::app()->controller->createUrl('exchange'));
        		}
        	}
        	
        	$this->render('exchangeview',array(
        		'model'=>$exchange_model,
        		
        	));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            if(isset($_POST['IntegralShop'])){
                $model->attributes = $_POST['IntegralShop'];
                //$model->i_pic = LYCommon::uploadimage($model,'i_pic',trim(trim($model->tableName(),'}}'),'{{'));
                $pic_arr = array();
                if(isset($_POST['IntegralShop']['productpic'])){
                    foreach($_POST['IntegralShop']['productpic'] as $k => $v){
                        $pic_arr[] = $v;
                    }
                }
                $model->i_pic = serialize($pic_arr);
                if($model->update()){
                    Yii::app()->user->setFlash('success','商品更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
			$item=LYCommon::GetItemList('integral_type');
			foreach($item as $key=>$value){
				$typeitem[$value->i_id]=$value->i_name;
			}
            $this->render('update',array(
                'model'=>$model,
				'typeitem'=>$typeitem,
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
            return IntegralShop::model()->findByPk($id);
        }
        
}