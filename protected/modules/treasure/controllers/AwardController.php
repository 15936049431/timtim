<?php

/*
 * @author: 三氧化二砷 waitfox@qq.com
 * @Created:2015-8-27 15:21:25
 * @version:0.01
 * @desc:抽奖
 * 我只为你回眸一笑，即使不够倾国倾城，我只为你付出此生，换来生再次相守
 */

class AwardController extends BController {
	
	public function actionlist(){
		$model = Award::model();
		$criteria = new CDbCriteria;
		$total_count =  $model->count($criteria);
		$page = new Pagination($total_count,10);
		$page_list = $page->fpage(array(4,5,6, 3, 7));
		$page_list = $total_count<=$page->limitnum?"":$page_list;
		$criteria -> limit = $page->limitnum;
		$criteria -> offset = $page->offset;
		$criteria -> order = 'add_time  DESC';
		$list = $model->findAll($criteria);
		$this->render("list",array(
			"model"=>$model,
			"list"=>$list,
			"page_list"=>$page_list
		));
	}
	
	public function actioncreate(){
		$model = new Award;
		$type_model = AwardType::model()->findAllByAttributes(array("status"=>1));
		if(isset($_POST['Award'])){
			$model->attributes = $_POST['Award'];
			if(strtotime($model->start_time) > strtotime($model->end_time)){
				$model->addError('start_time','开始时间大于结束时间');
			}elseif(empty($_POST['award_check'])){
				$model->addError("award_check",'选择红包不可为空');
			}else{
				$model->award_check = join($_POST['award_check'],',');
				$model->id = LYCommon::getInsertID();
				$model->add_time = time();
				$model->add_ip = $_SERVER['REMOTE_ADDR'];
				$model->start_time = strtotime($model->start_time);
				$model->end_time = strtotime($model->end_time);
				if($model->save()){
					Yii::app()->user->setFlash('success','添加成功！');
					$this->redirect(Yii::app()->controller->createUrl('list'));
				}
			}
		}
		$this->render("create",array(
			"model"=>$model,
			"type_model"=>$type_model,
		));
	}
	
	public function actionupdate($id){
		$model = Award::model()->findByPk($id);
		$type_model = AwardType::model()->findAllByAttributes(array("status"=>1));
		if(isset($_POST['Award'])){
			$model->attributes = $_POST['Award'];
			if(strtotime($model->start_time) > strtotime($model->end_time)){
				$model->addError('start_time','开始时间大于结束时间');
			}elseif(empty($_POST['award_check'])){
				$model->addError("award_check",'选择红包不可为空');
			}else{
				$model->award_check = join($_POST['award_check'],',');
				$model->start_time = strtotime($model->start_time);
				$model->end_time = strtotime($model->end_time);
				if($model->update()){
					Yii::app()->user->setFlash('success','添加成功！');
					$this->redirect(Yii::app()->controller->createUrl('list'));
				}
			}
		}
		$model->start_time = date("Y-m-d",$model->start_time);
		$model->end_time = date("Y-m-d",$model->end_time);
		$model->award_check = explode(",",$model->award_check);
		$this->render("update",array(
			"model"=>$model,
			"type_model"=>$type_model,
		));
	}
	
	public function actionajaxdelete($id){
		$model = Award::model()->findByPk($id);
		if($model->delete()){
			echo json_encode(1);
			die;
		}else{
			echo json_encode(0);
			die;
		}
	}
	
	public function actiontlist(){
		$model = AwardType::model();
		$criteria = new CDbCriteria;
		$total_count =  $model->count($criteria);
		$page = new Pagination($total_count,10);
		$page_list = $page->fpage(array(4,5,6, 3, 7));
		$page_list = $total_count<=$page->limitnum?"":$page_list;
		$criteria -> limit = $page->limitnum;
		$criteria -> offset = $page->offset;
		$criteria -> order = 'money  ASC';
		$list = $model->findAll($criteria);
		$this->render("tlist",array(
			"model"=>$model,
			"list"=>$list,
			"page_list"=>$page_list
		));
	}
	
	public function actiontcreate(){
		$model = new AwardType;
		if(isset($_POST['AwardType'])){
			$model->attributes = $_POST['AwardType'];
			$model->id = LYCommon::getInsertID();
			$model->add_time = time();
			$model->add_ip = $_SERVER['REMOTE_ADDR'];
			$model->type = 0 ;
			$model->give_num = 0; 
			$model->give_money = 0; 
			$model->manager_id = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->user->setFlash('success','添加成功！');
				$this->redirect(Yii::app()->controller->createUrl('tlist'));
			}
		}
		$this->render("tcreate",array(
			"model"=>$model,
		));
	}
	
	public function actiontupdate($id){
		$model = AwardType::model()->findByPk($id);
		if(isset($_POST['AwardType'])){
			$model->attributes = $_POST['AwardType'];
			$model->add_time = time();
			$model->add_ip = $_SERVER['REMOTE_ADDR'];
			$model->manager_id = Yii::app()->user->id;
			if($model->update()){
				Yii::app()->user->setFlash('success','添加成功！');
				$this->redirect(Yii::app()->controller->createUrl('tlist'));
			}
		}
		$this->render("tupdate",array(
			"model"=>$model,
		));
	}
	
	public function actiontajaxdelete($id){
		$model = AwardType::model()->findByPk($id);
		if($model->delete()){
			echo json_encode(1);
			die;
		}else{
			echo json_encode(0);
			die;
		}
	}
	
}