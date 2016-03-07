<?php

class ItemcatController extends BController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionList(){
        $model = Itemcat::model();
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
	
	public function actionCreate(){
        $model = new Itemcat;
        if(isset($_POST['Itemcat'])){
            $model->attributes = $_POST['Itemcat'];
            $model -> i_cat_id = LYCommon::getInsertID();
            $model->i_addtime = time();
			$model->i_addip=$_SERVER['REMOTE_ADDR'];
            if($model->save()){
                Yii::app()->user->setFlash('success','联动分类添加成功！');
                $this->redirect(Yii::app()->controller->createUrl('list'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
	
	public function actionUpdate($id){
        $model = self::loadmodel($id);
        if(isset($_POST['Itemcat'])){
            $model->attributes = $_POST['Itemcat'];
               
            if($model->save()){
                Yii::app()->user->setFlash('success','联动分类更新成功！');
                $this->redirect(Yii::app()->controller->createUrl('list'));
            }
        }
        $this->render('update',array(
            'model'=>$model,
        ));                    
    }
	
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
	
	public function actionAjaxdelmore(){
        if(isset($_POST['delarr'])){
            $del_result = array('status'=>0);
            $model = Itemcat::model();
            if($model->deleteAllByAttributes(array('i_id'=>$_POST['delarr']))){
                $del_result['status'] = 1;
            }else{
                $del_result['message'] = '删除失败';
            }
            echo json_encode($del_result);
        }
    }
	
	public function loadmodel($id){
        return Itemcat::model()->findByPk($id);
    }
	
}