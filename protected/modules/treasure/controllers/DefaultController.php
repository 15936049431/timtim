<?php

class DefaultController extends BController
{
	public function actionIndex(){
		$connection = Yii::app()->db;
		$platform = array(); 
		$sql="select sum(real_money) as money,sum(wait_total_money) as collect from ly_assets ";
		$result = $connection->createCommand($sql)->queryRow();
		$sql_project="select sum(p_account) as money from ly_project where p_status in (3,7)";
		$result_project = $connection->createCommand($sql_project)->queryRow();
		$sql_recharge = "select sum(r_money) as money from ly_assets_recharge where r_status=1";
		$result_recharge = $connection->createCommand($sql_recharge)->queryRow();
		$sql_cash = "select sum(c_money) as money , sum(c_fee) as fee from ly_assets_cash where c_status=1";
		$result_cash = $connection->createCommand($sql_cash)->queryRow();
		$platform['money'] = !empty($result['money']) ? $result['money'] : 0 ;
		$platform['collect'] = !empty($result['collect']) ? $result['collect'] : 0 ;
		$platform['project'] = !empty($result_project['money']) ? $result_project['money'] : 0 ;
		$platform['recharge'] = !empty($result_recharge['money']) ? $result_recharge['money'] : 0 ;
		$platform['cash'] = !empty($result_cash['money']) ? $result_cash['money'] : 0 ;
		$platform['cash_fee'] = !empty($result_cash['fee']) ? $result_cash['fee'] : 0 ;
        $this->render('index',array(
        	"platform"=>$platform,
        ));
	}
}