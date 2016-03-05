<?php

class ArticleController extends WController{
    public $p_id;
    public $article_cat_name;
    public $article_name;
    public $article_alias;
    public $article_p;
    
    public function actionIndex(){
        $this -> render('index');
    }
    
    public function actionList($p,$cat=null){
        $article_cat_model = Articlecat::model();
        $p_info = $article_cat_model ->findByAttributes(array('article_cat_alias'=>$p));
        if(!empty($p_info)){
            $this -> p_id = $p_info -> article_cat_id;
            $this -> article_cat_name = $p_info -> article_cat_name;
            $this -> article_p = $p;
            if(empty($cat)){
                $_GET['cat'] = $p_info -> article_cat_alias;
                $cat = $p_info -> article_cat_alias;
            }
        }
        
        $article_cat_info = $article_cat_model ->findByAttributes(array('article_cat_alias'=>$cat));
        if(!empty($article_cat_info)){
        	$this->article_name = $article_cat_info -> article_cat_name; 
        	$this->article_alias = $article_cat_info -> article_cat_alias;
            switch ($article_cat_info -> cat_type){
                case 1:
                    $article_model = Article::model();
                    $criteria = new CDbCriteria;
                    $criteria->compare('article_cat_id',$article_cat_info->article_cat_id);
                    $criteria->order = "`order` ASC, `add_time` DESC";
                    $total_count = $article_model->count($criteria);
                        $page = new Pagination($total_count,20);
                        $page_list = $page->fpage(array(4,5,6));
                        $page_list = $total_count<=$page->limitnum?"":$page_list;
                        $criteria -> limit = $page->limitnum;
                        $criteria -> offset = $page->offset;
                        $article_list = $article_model->findAll($criteria);
                        
                    $this->render(($article_cat_info->article_cat_alias=="notice") ? "news_list" : $article_cat_info->list_tmp_path,array(
                        'article_cat_info'=>$article_cat_info,
                        'article_list'=>$article_list,
                        'page_list'=>$page_list,
                    ));
                    break;
                case 2:
                    $article_model = Article::model();
                    $article_info = $article_model ->findByAttributes(array('article_cat_id'=>$article_cat_info->article_cat_id));
                    $this->render($article_cat_info->page_tmp_path,array(
                        'article_cat_info'=>$article_cat_info,
                        'article_info'=>$article_info,
                    ));
                    break;
                case 3:
                    break;
            }
        }
    }
    
    public function actionView($id){
    	$article_modle = Article::model();
    	$article_info = $article_modle -> findByPk($id);
        $this->p_id = $article_info->acat->p_id;
        $_POST['cat'] = $article_info->acat->article_cat_alias;
        $_POST['p'] = $article_info->acat->p->article_cat_alias;
        $this->article_cat_name = $article_info->acat->p->article_cat_name;
       	$this->article_name=$article_info->acat->article_cat_name;
       	$this->article_alias = $article_info->acat->article_cat_alias;
       	$this->article_p =  $article_info->acat->p->article_cat_alias;
        
    	$this -> render($article_info ->acat->page_tmp_path,array(
    		'article_info'=>$article_info,
    	));
    }
}