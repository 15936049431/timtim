<?php

class ItemController extends BController
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionList(){
        $model = Item::model();
		$model->unsetAttributes();
		$criteria = new CDbCriteria;
		if(isset($_GET['Item'])){
			$model->attributes=$_GET['Item'];
		}
		$criteria->compare('i_cat_id',$model->i_cat_id);
		
        $total_count = $model->count($criteria);
        $page = new Pagination($total_count,10);
        $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
        $page_list = $total_count<=$page->limitnum?"":$page_list;
        $criteria -> limit = $page->limitnum;
        $criteria -> offset = $page->offset;
		$list = $model->findAll($criteria);
		
		$itemcat_model=Itemcat::model();
		$itemcat=$itemcat_model->findAll();
		foreach($itemcat as $key=>$value){
			$cat_list[$value->i_cat_id]=$value->i_name;
		}
        $this->render('list',array(
            'model'=>$model,
			'cat_list'=>$cat_list,
            'list'=>$list,
            'page_list'=>$page_list,
        ));
    }
	
	public function actionCreate(){
        $model = new Item;
        if(isset($_POST['Item'])){
			$item_cat=$model->findByAttributes(array('i_cat_id'=>$_POST['Item']['i_cat_id'],'i_nid'=>$_POST['Item']['i_nid']));
			if(empty($item_cat)){
				$model->attributes = $_POST['Item'];
				$model -> i_id = LYCommon::getInsertID();
				$model->i_addtime = time();
				$model->i_addip=$_SERVER['REMOTE_ADDR'];
				if($model->save()){
					Yii::app()->user->setFlash('success','联动分类添加成功！');
					$this->redirect(Yii::app()->controller->createUrl('list'));
				}
			}else{
				$model->addError('i_nid','该类别中该标示已经存在！');
			}
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
	
	public function actionUpdate($id){
        $model = self::loadmodel($id);
        if(isset($_POST['Item'])){
            $model->attributes = $_POST['Item'];
               
            if($model->update()){
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
            $model = Item::model();
            if($model->deleteAllByAttributes(array('i_id'=>$_POST['delarr']))){
                $del_result['status'] = 1;
            }else{
                $del_result['message'] = '删除失败';
            }
            echo json_encode($del_result);
        }
    }
	
	public function loadmodel($id){
        return Item::model()->findByPk($id);
    }
	
	public function GetIcat(){
        $icat_model = Itemcat::model();
        $icat_list = $icat_model -> findAll();
        $icat_arr = array();
        foreach($icat_list as $k => $v){
            $icat_arr[$v->i_cat_id] = $v->i_name;
        }
        return $icat_arr;
    }
	
}