<?php

/**
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class UtilCommon{
	
	public static function registerInsert($model){
		//插入资金表
		$assets_model = new Assets;
		$assets_model->user_id = $model->user_id;
		$assets_model->insert();
		LYCommon::encryptSign($assets_model); //资金加签
		//插入用户统计表
		$every_user = new Everyuser;
		$every_user->user_id = $model->user_id;
		$every_user->addtime = time();
		$every_user->insert();
		//插入积分表
		$integral_model = new Integral;
		$integral_model->user_id = $model->user_id;
		$integral_model->i_addtime = time();
		$integral_model->i_addip = $_SERVER['REMOTE_ADDR'];
		$integral_model->insert();
		
		if (!empty($model->p_user_id)) {
			$invite_num = $model->findByPk($model->p_user_id)->invite_num;
			if ($invite_num < 100) {//如果邀请人数小于100
				$pintegral_model = Integral::model();
				$integral_info = $pintegral_model->findByPk($model->p_user_id);
				$integral_info->i_total_value += Yii::app()->params['invite_give_user'];
				$integral_info->i_real_value += Yii::app()->params['invite_give_user'];
				$data = array(
						'i_cat_alias' => 'invite_user',
						'remark' => '邀请用户积分增加',
				);
				LYCommon::Add_integral($integral_info, $data);
			}
			$p_user = User::model()->findByPk($model->p_user_id);
			$p_user->invite_num = $p_user->invite_num + 1;
			$p_user->update();
		}
		
		//插入授信额度
		$usercredit = new Usercredit;
		$usercredit->user_id = $model->user_id;
		$usercredit->insert();
	}
	
	public static function giveRegisterMoney($user_id,$type){
		$award_model = Award::model()->findByAttributes(array("award_alias"=>$type));
		if(!empty($award_model) && $award_model->start_time < time() && $award_model->end_time > time()){
			$award_array = explode(",",$award_model->award_check);
			$user_model = User::model()->findByPk($user_id);
			$award_have = json_decode($user_model->award_have,true) ;
			$is_have = in_array($type,empty($award_have) ? array() : $award_have);
			if(!$is_have){
				foreach($award_array as $k=>$v){
					$award_type = AwardType::model()->findByPk($v);
					if(!empty($award_type)){
						$bill_model = new AwardBill;
						$bill_model->id = LYCommon::getInsertID();
						$bill_model->user_id = $user_id;
						$bill_model->award_id = $award_model->id ;
						$bill_model->type_id = $award_type->id ;
						$bill_model->name = $award_type->name ;
						$bill_model->get_time = time();
						$bill_model->end_time = time() + $award_type->use_time * 86400 ;
						$bill_model->award_alias = $award_model->award_alias ;
						$bill_model->money = $award_type->money ;
						$bill_model->low_account = $award_type->low_account;
						$bill_model->most_account = $award_type->most_account;
						$bill_model->min_limit = $award_type->min_limit ;
						$bill_model->max_limit = $award_type->max_limit ;
						$bill_model->type = $award_type->type ;
						$bill_model->status = 0 ;
						$bill_model->add_time = time();
						$bill_model->add_ip = $_SERVER['REMOTE_ADDR'];
						if($bill_model->save()){
							$award_type->give_num = $award_type->give_num + 1 ;
							$award_type->give_money = $award_type->give_money + $award_type->money ;
							$award_type->update();

							//发送站内信
							LYCommon::send_message(0, $user_id, 'award_give', array(
								'award_money' => $award_type->money,
							));
						}
					}
				}
				$award_model->award_user = $award_model->award_user + 1 ;
				$award_model->award_all = $award_model->award_all + $award_model->award_money ; 
				$award_model->update();
				$award_have[] = $type ;
				$user_model->award_have = json_encode($award_have);
				$user_model->update();
			}
		}
	}
	
	public static function useAwardBill($project_order_model,$project_info){
		if(!empty($project_order_model->p_award_bill)){
			$award_bill = AwardBill::model()->findByPk($project_order_model->p_award_bill);
			if(!empty($award_bill) && $award_bill->status==0 && $project_info->p_time_limittype==0){
				if($project_info->p_time_limit >= $award_bill->min_limit && $project_info->p_time_limit <= $award_bill->max_limit){
					if($project_order_model->p_money >= $award_bill->low_account && $project_order_model->p_money <= $award_bill->most_account){
						$award_bill->status = 1 ;
						$award_bill->order_id = $project_order_model->p_id ;
						$award_bill->project_id = $project_info->p_id;
						$award_bill->update();
						$money = $project_order_model->p_money - $award_bill->money ;
						return $money;
					}
				}
			}
		}
		return $project_order_model->p_money ;
	}
	
	public static function WxCode($name,$content,$type){
		Yii::$enableIncludePath = false;
		Yii::import('application.extensions.phpqrcode.phpqrcode',1);
		$dir = dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR; 
		if(!is_dir($dir)){
			mkdir($dir);
		}
		//定义纠错级别
		$errorLevel = "L";
		//定义生成图片宽度和高度;默认为3
		$size = "4";
		//调用QRcode类的静态方法png生成二维码图片//
		$file_name =  $dir.$name.".png" ;
		if(!file_exists($file_name)){
			QRcode::png($content,$file_name, $errorLevel, $size);
		}
		$file_src = SITE_UPLOAD.$type."/".$name.".png";
		return $file_src;
	}
	
	public static function checkParent($project_order_model){
		$user_model = User::model() ;
		if($project_order_model->user->invite_order_num >= 7 && empty($project_order_model->user->invite_order_id) && $project_order_model->project->p_type != 1){
			$interest = 0 ; 
			$collect = ProjectCollect::model()->findAll(array("limit"=>"1","condition"=>"p_project_order='{$project_order_model->p_id}'","order"=>"p_order DESC"));
			if($project_order_model->p_money > 100000){
				$interest = LYCommon::sprintf_diy($project_order_model->p_interest/$project_order_model->p_money*100000);
			}else{
				$interest = $project_order_model->p_interest;
			}
			$project_order_model->p_interest = $project_order_model->p_interest + $interest;
			$project_order_model->p_repayaccount = $project_order_model->p_repayaccount + $interest;
			$project_order_model->p_add_interest = $interest;
			$project_order_model->p_waitrepay = $project_order_model->p_waitrepay + $interest;
			$project_order_model->update();
			$collect[0]->p_repayaccount = $collect[0]->p_repayaccount + $interest;
			$collect[0]->p_interest = $collect[0]->p_interest + $interest;
			$collect[0]->update();
			$now_user = $user_model->findByPk($project_order_model->p_user_id);
			$now_user->invite_order_id = $project_order_model->p_id;
			$now_user->update();
		}elseif(!empty($project_order_model->user->p_user_id)){
			if(empty($project_order_model->user->invite_order_have) && $project_order_model->project->p_type != 1){
				$now_user = $user_model->findByPk($project_order_model->p_user_id);
				$now_user->invite_order_have = 1 ; 
				$now_user->update();
				$user_info = $user_model->findByPk($project_order_model->user->p_user_id);
				$user_info->invite_order_num = $user_info->invite_order_num + 1 ;
				$user_info->update();
			}
		}
	}

}

?>