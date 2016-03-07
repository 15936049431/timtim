<?php

class LinkController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Link::model();
            $total_count = $model->count();
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
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
            $model = new Link;
            $link_type_list = LYCommon::GetItemList("site_link");
            $link_type = array ();
            foreach($link_type_list as $k=>$v){
            	$link_type[$v->i_id] = $v->i_name;
            }
            if(isset($_POST['Link'])){
            	$model->link_id=LYCommon::getInsertID();
                $model->attributes = $_POST['Link'];
                $model->add_time = time();
                $model->link_pic = LYCommon::uploadimage($model,'link_pic',trim(trim($model->tableName(),'}}'),'{{'));
                if($model->save()){
                    Yii::app()->user->setFlash('success','链接添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('create',array(
                'model'=>$model,
            	'link_type'=>$link_type,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            $link_type_list = LYCommon::GetItemList("site_link");
            $link_type = array ();
            foreach($link_type_list as $k=>$v){
            	$link_type[$v->i_id] = $v->i_name;
            }
            if(isset($_POST['Link'])){
                $model->attributes = $_POST['Link'];
				$upload_link_pic = LYCommon::uploadimage($model,'link_pic',trim(trim($model->tableName(),'}}'),'{{'));
				if($upload_link_pic !== false){
					$model->link_pic = $upload_link_pic;
				}
                if($model->update()){
                    Yii::app()->user->setFlash('success','链接更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
            	'link_type'=>$link_type,
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
                $model = Link::model();
                if($model->deleteAllByAttributes(array('link_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Link::model()->findByPk($id);
        }
}