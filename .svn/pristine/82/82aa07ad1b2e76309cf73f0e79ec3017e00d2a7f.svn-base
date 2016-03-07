<?php

class MessageController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Message::model();
            $total_count = $model->count();
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $list = $model->findAll(array(
                'limit'=>$page->limitnum,
                'offset'=>$page->offset,
            ));
            $this->render('list',array(
                'model'=>$model,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new Message;
            
            if(isset($_POST['Message'])){
                $model->attributes = $_POST['Message'];
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','添加成功！');
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
            if(isset($_POST['Message'])){
                $model->attributes = $_POST['Message'];
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','更新成功！');
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
                $model = Message::model();
                if($model->deleteAllByAttributes(array('message_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Message::model()->findByPk($id);
        }
}