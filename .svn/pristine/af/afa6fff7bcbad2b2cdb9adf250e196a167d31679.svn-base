<?php

class CreditController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Credit::model();
            $user_model=User::model();
            $criteria = new CDbCriteria;
            if(isset($_GET['User'])){
            	$user_model->attributes=$_GET['User'];
            }
            $criteria -> with = 'user';
            $criteria->compare("user.user_name",$user_model->user_name,true);
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $criteria -> order = 'add_time  DESC';
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
            $model = new Credit;
            
            if(isset($_POST['Credit'])){
                $model->attributes = $_POST['Credit'];
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','资信审核添加成功！');
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
            $credit_pic_model = Creditpic::model();
            $credit_pic_list = $credit_pic_model ->findAllByAttributes(array('c_id'=>$id));
            if(isset($_POST['Credit'])){
                $model->attributes = $_POST['Credit'];
                $model->check_manager=Yii::app()->user->id;
                $model->check_time=time();
                if($model->status == 1){
                    $model->status = 2;
                }elseif($model->status == 2){
                    $model->status = 3;
                }
                if($model->save()){
                    if($model->status == 2){
                        $data = array(
                            'user_id'=>$model->user_id,
                            'type'=>1,
                            'style'=>'app_credit_suc',
                            'credit_num'=>$model -> real_amount,
                            'remark'=>'资信审核成功',
                        );
                        LYCommon::Addusercredit($data);
                    }
                    Yii::app()->user->setFlash('success','资信审核更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
                'credit_pic_list'=>$credit_pic_list,
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
                $model = Credit::model();
                if($model->deleteAllByAttributes(array('credit_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Credit::model()->findByPk($id);
        }
}