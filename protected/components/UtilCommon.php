<?php

/**
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class UtilCommon{
	
	public static function giveRegisterMoney($user_id){
		$money = Yii::app()->params['user_register_money'] ;
		if($money > 0){
			$user_assets = Assets::model()->findByPk($user_id);
			$bill['user_id'] = $user_id;
			$bill['b_money'] = $money;
			$bill['b_type'] = 2;
			$bill['b_itemtype'] = "assets_new_person";
			$bill['u_total_money'] = $user_assets->total_money + $bill['b_money'];
			$bill['u_real_money'] = $user_assets->real_money + $bill['b_money'];
			$bill['u_frost_money'] = $user_assets->frost_money;
			$bill['u_have_interest'] = $user_assets->have_interest;
			$bill['u_wait_interest'] = $user_assets->wait_interest;
			$bill['u_wait_total_money'] = $user_assets->wait_total_money;
			$bill['b_mark'] = 1;
			$bill['b_time'] = time();
			$bill['remark'] = "用户注册奖励发放";
			LYCommon::AddBill($bill);
		}
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

}

?>