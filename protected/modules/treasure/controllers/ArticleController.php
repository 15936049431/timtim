<?php

class ArticleController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Article::model();
            $model->unsetAttributes();
            $criteria = new CDbCriteria;
            if(isset($_GET['Article'])){
            	$model->attributes=$_GET['Article'];
            }
            $criteria->compare('article_cat_id',$model->article_cat_id);
            $criteria->compare('article_title',$model->article_title,true);
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7 ,0 ,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $criteria -> order = 'add_time DESC';
            
            $article_list = $model->findAll($criteria);
            $article_cat=Articlecat::model();
            $cat_list=$article_cat->findAll();
            $type_list = array();
            foreach($cat_list as $key=>$value){
            	$type_list[$value->article_cat_id]=$value->article_cat_name;
            }
            $this->render('list',array(
                'model'=>$model,
                'article_list'=>$article_list,
                'page_list'=>$page_list,
            	'type_list'=>$type_list,
            ));
        }
        
        /*
         * 创建文章
         */
        public function actionCreate(){
            $model = new Article;
            
            if(isset($_POST['Article'])){
                $model->attributes = $_POST['Article'];
                $model->article_id = LYCommon::getInsertId();
                $model->pub_user_id = Yii::app()->user->id;
                $model->add_time = time();
                $model->article_pic = LYCommon::uploadimage($model,'article_pic',trim(trim($model->tableName(),'}}'),'{{'));
                if($model->validate() && $model->save()){
                    Yii::app()->user->setFlash('success','文章添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('article/list'));
                }
            }
            $this->render('create',array(
                'model'=>$model,
            ));
        }
        
        /*
         * 更新文章
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            $old_article_pic = $model->article_pic;
            if(isset($_POST['Article'])){
                $model->attributes = $_POST['Article'];
                $model->unsetAttributes(array('article_pic'));
                $upload_img = LYCommon::uploadimage($model,'article_pic',trim(trim($model->tableName(),'}}'),'{{'));
                if(!empty($upload_img)){
                    $model->article_pic = $upload_img;
                }else{
                    $model->article_pic = $old_article_pic;
                }
                if($model->update()){
                    Yii::app()->user->setFlash('success','文章更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('article/list'));
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
                $model = Article::model();
                if($model->deleteAllByAttributes(array('article_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        
        public function getcatlist(){
            $articlecat_model = Articlecat::model();
            $articlecat_list = $articlecat_model->findAll(array(
				'order'=>' tree ASC',
			));
            $articlecat_arr = array(''=>'请选择');
			foreach($articlecat_list as $k=>$v){
                $str = '';
                if(!empty($v->tree)){
                    $tree_arr = explode(',', $v->tree);
                    $tree_arr_count = count($tree_arr)-1;
                    if(!empty($tree_arr_count)){
                        $str .= '　|';
                        $str .= str_repeat(' -', $tree_arr_count);
                    }
                }
            	$articlecat_arr[$v->article_cat_id]=$str.$v->article_cat_name;
            }
            
            return $articlecat_arr;
            
        }
        public function loadmodel($id){
            return Article::model()->findByPk($id);
        }
}