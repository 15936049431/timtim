<?php

class AssetsBankController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = AssetsBank::model();
			$model->unsetAttributes();
			$user_model=User::model();
			$criteria = new CDbCriteria;
			if(isset($_GET['AssetsBank'])){
				$model->attributes=$_GET['AssetsBank'];
			}
			if(isset($_GET['User'])){
				$user_model->attributes=$_GET['User'];
			}
			$criteria->with='user';
			$criteria->compare('b_status',$model->b_status);
                        if(!empty($model->b_bank)){
                            $criteria->compare('b_bank',$model->b_bank);
                        }
			$criteria->compare('user.user_name',$user_model->user_name,true);
			$criteria->compare('user.real_name',$user_model->real_name,true);
			if(!empty($_GET['start_time'])){
                            $criteria->addCondition('b_addtime > '. strtotime($_GET['start_time']));
                        }
                        if(!empty($_GET['end_time'])){
                            $criteria->addCondition('b_addtime <= '. strtotime($_GET['end_time']. '23:59:59'));
                        }
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$criteria -> order = 'b_addtime  DESC';
				$list = $model->findAll($criteria);
				$data = array(
						array(
								"序号",'ID','用户名','真实姓名',"银行卡号", "银行", "支行", "添加时间", "状态"
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->b_id,
							$v->user->user_name,
							$v->user->real_name,
							$v->b_cardNum,
							$v->item->i_name,
							$v->b_branch,
							LYCommon::subtime($v->b_addtime,2),
							$model->itemAlias('b_status',$v->b_status),
					);
				}
			
				$xls = new JPhpExcel();
				$xls->addArray($data);
				$xls->generateXML('bankcard');
				die;
			}
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
			$list = $model->findAll($criteria);
			
			$item=LYCommon::GetItemList('bank_type');
			foreach($item as $key=>$value){
				$bank_list[$value->i_id]=$value->i_name;
			}
            $this->render('list',array(
                'model'=>$model,
				'user_model'=>$user_model,
				'bank_list'=>$bank_list,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new AssetsBank;
            
            if(isset($_POST['AssetsBank'])){
                $model->attributes = $_POST['AssetsBank'];                
                if($model->save()){
                    Yii::app()->user->setFlash('success','银行卡添加成功！');
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
			$area = $banktype_list = array();
			$area_model = Area::model();
			$area_result = $area_model->findAllByAttributes(array('pid' => '0'));
			foreach ($area_result as $key => $value) {
				$area[$value->id] = $value->name;
			}
			$bank_type = LYCommon::GetItemList('bank_type');
			foreach ($bank_type as $key => $value) {
				$banktype_list[$value->i_id] = $value->i_name;
			}
            if(isset($_POST['AssetsBank'])){
                $model->attributes = $_POST['AssetsBank'];
                if($model->save()){
                    Yii::app()->user->setFlash('success','银行卡更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
				"city"=>$area,
				"banktype_list"=>$banktype_list,
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
                $model = Assets_bank::model();
                if($model->deleteAllByAttributes(array('assets_bank_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return AssetsBank::model()->findByPk($id);
        }
}