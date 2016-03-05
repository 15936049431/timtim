<?php

class IntegralAddressController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = IntegralAddress::model();
            $model->unsetAttributes();
            $user_model=User::model();
            $criteria = new CDbCriteria;
            if(isset($_GET['IntegralAddress'])){
            	$model->attributes=$_GET['IntegralAddress'];
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
            					"序号",'ID','用户名','真实姓名','名称', "地址详情", "收件人", "收件人号码",  "默认", "状态", "添加时间", 
            			),
            	);
            	foreach($list as $k => $v){
            		$data[] = array(
            				$k+1,
            				$v->address_id,
            				$v->user->user_name,
            				$v->user->real_name,
            				$v->address_name,
            				$v->address_allwith,
            				$v->address_people,
            				$v->address_phone,
            				$model->itemAlias('is_default',$v->is_default),
            				$model->itemAlias('status',$v->is_default),
            				LYCommon::subtime($v->addtime,2),
            		);
            	}
            
            	$xls = new JPhpExcel('UTF-8', false,'地址报表');
            	$xls->addArray($data);
            	$xls->generateXML('integralAddress');
            	die;
            }
            
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
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
            $model = new IntegralAddress;
            
            if(isset($_POST['IntegralAddress'])){
				$model->i_id=LYCommon::getInsertID();
                $model->attributes = $_POST['IntegralAddress'];
				$model->i_addtime=time();
				$model->i_addip=$_SERVER['REMOTE_ADDR'];
                if($model->save()){
                    Yii::app()->user->setFlash('success','商品添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
			$area_model=Area::model();
			$area=$area_model->findAllByAttributes(array('pid'=>'0'));
			foreach($area as $key=>$value){
				$city_list[$value->id]=$value->name;
			}
            $this->render('create',array(
                'model'=>$model,
            	'city_list'=>$city_list,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            $area_model=Area::model();
            if(isset($_POST['IntegralAddress'])){
                $model->attributes = $_POST['IntegralAddress'];
                $city=$area_model->findByPk($model->address_city);
                $province=$area_model->findByPk($model->address_province);
                $model->address_allwith=$city->name.'-'.$province->name.'-'.$model->address_place;
                if($model->update()){
                    Yii::app()->user->setFlash('success','商品更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $area=$area_model->findAllByAttributes(array('pid'=>'0'));
            foreach($area as $key=>$value){
            	$city_list[$value->id]=$value->name;
            }
            $this->render('update',array(
                'model'=>$model,
           		'city_list'=>$city_list,
            ));                    
        }
        
        public function actionGetCity(){
        	$area_model=Area::model();
        	$area=$area_model->findAllByAttributes(array('pid'=>$_POST['city']));
        	if(!empty($area)){
        		$str="";
        		foreach($area as $key=>$value){
        			$str.="<option value='{$value->id}'>{$value->name}</option>";
        		}
        		echo $str;exit;
        	}
        	echo "error";exit;
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
            return IntegralAddress::model()->findByPk($id);
        }
}