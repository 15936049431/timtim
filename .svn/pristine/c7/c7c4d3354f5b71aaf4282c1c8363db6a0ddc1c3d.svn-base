<?php

class ArticlecatController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Articlecat::model();
            $total_count = $model->count();
            $list = $model->findAll(array('order'=>'tree ASC',));
            foreach($list as $k=>$v){
                $str = '';
                if(!empty($v->tree)){
                    $tree_arr = explode(',', $v->tree);
                    $tree_arr_count = count($tree_arr)-1;
                    if(!empty($tree_arr_count)){
                        $str .= '　|';
                        $str .= str_repeat(' -', $tree_arr_count);
                    }
                }
            	$list[$k]->nname=$str.$v->article_cat_name;
            }
            $this->render('list',array(
                'model'=>$model,
                'list'=>$list,
                //'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new Articlecat;
            
            if(isset($_POST['Articlecat'])){
                $model->attributes = $_POST['Articlecat'];
                $model -> article_cat_id = LYCommon::getInsertID();
                if(!empty($model->p_id)){
                    $p_info = $model ->findByPk($model->p_id);
                    $model -> tree = trim($p_info->tree).",".$model->article_cat_id;
                }else{
                    $model -> tree = $model->p_id;
                }
                
                $model -> pub_user_id = Yii::app()->user->id;
                $model->add_time = time();
                if($model->save()){
                    if($model -> cat_type == 2){
                        $article_model = new Article;
                        $article_model -> article_id = LYCommon::getInsertID();
                        $article_model -> article_cat_id = $model->article_cat_id;
                        $article_model -> pub_user_id = $model->pub_user_id;
                        $article_model -> article_title = $model->article_cat_name;
                        $article_model -> article_desc = $model->article_cat_desc;
                        $article_model -> article_cont = '';
                        $article_model -> add_time = $model->add_time;
                        $article_model -> update_time = $article_model -> add_time;
                        $article_model -> show_status = 1;
                        if($article_model->insert()){
                            Yii::app()->user->setFlash('success','文章分类添加成功！');
                            $this->redirect(Yii::app()->controller->createUrl('list'));
                        }else{
                            var_dump($article_model->getErrors());die;
                        }
                    }else{
                        Yii::app()->user->setFlash('success','文章分类添加成功！');
                        $this->redirect(Yii::app()->controller->createUrl('list'));
                    }
                    
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
            if(isset($_POST['Articlecat'])){
                $model->attributes = $_POST['Articlecat'];
                if(!empty($model->p_id)){
                    $p_info = $model ->findByPk($model->p_id);
                    $model -> tree = trim(trim($p_info->tree,',').','.$model->article_cat_id,',');
                }else{
                    $model -> tree = $model->p_id;
                }
                if($model->save()){
                    Yii::app()->user->setFlash('success','文章分类更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
            ));                    
        }
        
        public function actionPageupdate($id){
            $model = self::loadmodel($id);
            $article_model = Article::model();
            $article_info = $article_model ->findByAttributes(array('article_cat_id'=>$id),array(
                'limit'=>'1',
            ));
            
            if(isset($_POST['Articlecat']) && isset($_POST['Article'])){
                $model->attributes = $_POST['Articlecat'];
                $article_info -> attributes = $_POST['Article'];
                if($model->save()){
                    $article_info -> update();
                    Yii::app()->user->setFlash('success','文章分类更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this -> render('pageupdate',array(
                'model'=>$model,
                'article_info'=>$article_info,
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
                $model = Articlecat::model();
                if($model->deleteAllByAttributes(array('articlecat_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        
        public function getparent_arr($parentid=0){
            $model = Articlecat::model();
            $list = $model ->findAll(array(
                'order'=>' tree ASC',
            ));
            $data = array('0'=>'顶级栏目');
            
            
            foreach($list as $k=>$v){
                $str = '';
                if(!empty($v->tree)){
                    $tree_arr = explode(',', $v->tree);
                    $tree_arr_count = count($tree_arr)-1;
                    if(!empty($tree_arr_count)){
                        $str .= '　|';
                        $str .= str_repeat(' -', $tree_arr_count);
                    }
                }
            	$data[$v->article_cat_id]=$str.$v->article_cat_name;
            }
            return $data;
        }
        public function loadmodel($id){
            return Articlecat::model()->findByPk($id);
        }
}