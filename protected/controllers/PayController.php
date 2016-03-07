<?php
/**
 * 
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class PayController extends Controller{
	
	public function actionlianlianphone_back() {
		$return = file_get_contents("php://input");
		$return = json_decode($return,true);
		$item_model = new Item();
    	$data['oid_partner'] = $return['oid_partner'];
    	$data['sign_type'] = $return['sign_type'];
    	$data['dt_order'] = $return['dt_order'];
    	$data['no_order'] = $return['no_order'];
    	$data['oid_paybill'] = $return['oid_paybill'];
    	$data['money_order'] = $return['money_order'];
    	$data['result_pay'] = $return['result_pay'];
    	$data['settle_date'] = $return['settle_date'];
		$data['info_order'] = $return['info_order'];
		$data['bank_code'] = $return['bank_code'];
		$data['pay_type'] = $return['pay_type'];
 		$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$data['no_order']));
    	$recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	ksort($data);
    	$signText = "";
    	foreach ($data as $k => $v) {
    		if ($v != "") {
    			$signText.=$k . "=" . trim($v) . "&";
    		}
    	}
    	$signText = substr($signText, 0, count($signText) - 2);
    	if ($data['sign_type'] == "RSA") {
    		$private = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/ll_private_key.pem");
    		$rsa = openssl_get_privatekey($private);
    		openssl_sign($signText, $sign, $rsa, OPENSSL_ALGO_MD5);
    		openssl_free_key($rsa);
    		$signature = base64_encode($sign);
    	} else {
    		$signText.="&key=" . $pay_config['key'];
    		$signature = md5(trim($signText));
    	}
    	if ($return['sign'] == $signature) {
    		PayCommon::OnlineReturn($data['no_order'], $return);
    		echo json_encode(array("ret_code"=>"0000","ret_msg"=>"交易成功"));
    	} else {
    		return false;
    	}
    }
	
	public function actionlianlianauth_back() {
		$return = file_get_contents("php://input");
		$return = json_decode($return,true);
		$item_model = new Item();
    	$data['oid_partner'] = $return['oid_partner'];
    	$data['sign_type'] = $return['sign_type'];
    	$data['dt_order'] = $return['dt_order'];
    	$data['no_order'] = $return['no_order'];
    	$data['oid_paybill'] = $return['oid_paybill'];
    	$data['money_order'] = $return['money_order'];
    	$data['result_pay'] = $return['result_pay'];
    	$data['settle_date'] = $return['settle_date'];
		$data['info_order'] = $return['info_order'];
		$data['bank_code'] = $return['bank_code'];
		$data['pay_type'] = $return['pay_type'];
 		$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$data['no_order']));
    	$recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	ksort($data);
    	$signText = "";
    	foreach ($data as $k => $v) {
    		if ($v != "") {
    			$signText.=$k . "=" . trim($v) . "&";
    		}
    	}
    	$signText = substr($signText, 0, count($signText) - 2);
    	if ($data['sign_type'] == "RSA") {
    		$private = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/ll_private_key.pem");
    		$rsa = openssl_get_privatekey($private);
    		openssl_sign($signText, $sign, $rsa, OPENSSL_ALGO_MD5);
    		openssl_free_key($rsa);
    		$signature = base64_encode($sign);
    	} else {
    		$signText.="&key=" . $pay_config['key'];
    		$signature = md5(trim($signText));
    	}
    	if ($return['sign'] == $signature) {
    		PayCommon::OnlineReturn($data['no_order'], $return);
    		echo json_encode(array("ret_code"=>"0000","ret_msg"=>"交易成功"));
    	} else {
    		return false;
    	}
    }
	
	public function actionlianlian_back() {
    	$return = file_get_contents("php://input");
    	$return = json_decode($return,true);
    	$item_model = new Item();
    	$data['oid_partner'] = $return['oid_partner'];
    	$data['sign_type'] = $return['sign_type'];
    	$data['dt_order'] = $return['dt_order'];
    	$data['no_order'] = $return['no_order'];
    	$data['oid_paybill'] = $return['oid_paybill'];
    	$data['money_order'] = $return['money_order'];
    	$data['result_pay'] = $return['result_pay'];
    	$data['settle_date'] = $return['settle_date'];
    	$data['info_order'] = $return['info_order'];
    	$data['pay_type'] = $return['pay_type'];
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$data['no_order']));
    	$recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	ksort($data);
    	$signText = "";
    	foreach ($data as $k => $v) {
    		if ($v != "") {
    			$signText.=$k . "=" . trim($v) . "&";
    		}
    	}
    	$signText = substr($signText, 0, count($signText) - 2);
    	if ($data['sign_type'] == "RSA") {
    		$private = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/ll_private_key.pem");
    		$rsa = openssl_get_privatekey($private);
    		openssl_sign($signText, $sign, $rsa, OPENSSL_ALGO_MD5);
    		openssl_free_key($rsa);
    		$signature = base64_encode($sign);
    	} else {
    		$signText.="&key=" . $pay_config['key'];
    		$signature = md5(trim($signText));
    	}
    	if ($return['sign'] == $signature) {
    		PayCommon::OnlineReturn($data['no_order'], $return);
    		echo json_encode(array("ret_code"=>"0000","ret_msg"=>"交易成功"));
    	} else {
    		return false;
    	}
    }
    
    //通联支付返回
    public static function tonglian_pay_back() {
    	$return = $_POST ;
    	include_once(Yii::getPathOfAlias('ext') . "/PayUtil/php_rsa.php");
    	$var = array("merchantId", "version", "language", "signType", "payType", "issuerId", "paymentOrderId", "orderNo", "orderDatetime"
    			, "orderAmount", "payDatetime", "payAmount", "ext1", "ext2", "payResult", "errorCode", "returnDatetime");
    	$data = array();
    	$signstr = "";
    	foreach ($var as $k => $v) {
    		$data[$v] = $return[$v];
    	}
    	foreach ($data as $key => $value) {
    		$signstr.="{$key}={$value}&";
    	}
    	$signstr = substr($signstr, 0, strlen($signstr) - 1);
    	$publickeycontent = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/tlkey.txt");
    	$publickeyarray = explode(PHP_EOL, $publickeycontent);
    	$publickey = explode('=', $publickeyarray[0]);
    	$modulus = explode('=', $publickeyarray[1]);
    	$keylength = 1024;
    	$verifyResult = rsa_verify($signstr, $return['signMsg'], $publickey[1], $modulus[1], $keylength, "sha1");
    	if ($data['payResult'] == 1) {
    		PayCommon::OnlineReturn($data['orderNo'], $return);
    		return true;
    	} else {
    		return false;
    	}
    }
    
    //汇潮支付返回
    public static function actionhuichao_pay_back() {
    	$return = $_POST ;
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$return['BillNo']));
    	$recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	$BillNo = $return["BillNo"];
    	$Amount = $return["Amount"];
    	$Succeed = $return["Succeed"];
    	$Result = $return["Result"];
    	$MD5info = $return["MD5info"];
    	$Remark = empty($return['Remark']) ? "" : $return["Remark"];
    	$md5src = $BillNo . $Amount . $Succeed . $pay_config['PrivateKey'];
    	$md5sign = strtoupper(md5($md5src));
    	if ($MD5info == $md5sign) {
    		if ($Succeed == "88") {
    			PayCommon::OnlineReturn($BillNo, $return);
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
    
    //宝付支付返回
    public static function actionbaofu_pay_back() {
		file_put_contents("1.txt",serialize($_REQUEST));
    	$return = $_REQUEST ;
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$return['TransID']));
    	$recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
		$_MerchantID=$return['MerchantID'];//商户号
		$_TransID =$return['TransID'];//流水号
		$_Result=$return['Result'];//支付结果(1:成功,0:失败)
		$_resultDesc=$return['resultDesc'];//支付结果描述
		$_factMoney=$return['factMoney'];//实际成交金额
		$_additionalInfo=$return['additionalInfo'];//订单附加消息
		$_SuccTime=$return['SuccTime'];//交易成功时间
		$_Md5Sign=$return['Md5Sign'];//md5签名
    	$_Md5Key = $pay_config['PrivateKey'].",";
    	$_WaitSign=md5($_MerchantID.$_TransID.$_Result.$_resultDesc.$_factMoney.$_additionalInfo.$_SuccTime.$_Md5Key);
    	if ($_Md5Sign == $_WaitSign) {
    		PayCommon::OnlineReturn($_TransID, $return);
    		return true;
    	} else {
    		return false;
    	}
    }
    
    //国付宝支付返回
    public static function actionguofubao_pay_back() {
    	$return = $_POST ;
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$return['BillNo']));
    	$recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	$version = $return["version"];
    	$charset = $return["charset"];
    	$language = $return["language"];
    	$signType = $return["signType"];
    	$tranCode = $return["tranCode"];
    	$merchantID = $return["merchantID"];
    	$merOrderNum = $return["merOrderNum"];
    	$tranAmt = $return["tranAmt"];
    	$feeAmt = $return["feeAmt"];
    	$frontMerUrl = $return["frontMerUrl"];
    	$backgroundMerUrl = $return["backgroundMerUrl"];
    	$tranDateTime = $return["tranDateTime"];
    	$tranIP = $return["tranIP"];
    	$respCode = $return["respCode"];
    	$msgExt = $return["msgExt"];
    	$orderId = $return["orderId"];
    	$gopayOutOrderId = $return["gopayOutOrderId"];
    	$bankCode = $return["bankCode"];
    	$tranFinishTime = $return["tranFinishTime"];
    	$merRemark1 = $return["merRemark1"];
    	$merRemark2 = $return["merRemark2"];
    	$signValue = $return["signValue"];
    	$Mer_key = $pay_config['PrivateKey'];
    	$signValue2 = 'version=[' . $version . ']tranCode=[' . $tranCode . ']merchantID=[' . $merchantID . ']merOrderNum=[' . $merOrderNum . ']tranAmt=[' . $tranAmt . ']feeAmt=[' . $feeAmt . ']tranDateTime=[' . $tranDateTime . ']frontMerUrl=[' . $frontMerUrl . ']backgroundMerUrl=[' . $backgroundMerUrl . ']orderId=[' . $orderId . ']gopayOutOrderId=[' . $gopayOutOrderId . ']tranIP=[' . $tranIP . ']respCode=[' . $respCode . ']VerficationCode=[' . $Mer_key . ']';
    	$signValue2 = md5($signValue2);
    	if ($signValue == $signValue2) {
    		if ($respCode == '0000') {
    			PayCommon::OnlineReturn($merOrderNum, $return);
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
    
    //网银在线支付返回
    public static function actionwangyin_pay_back() {
    	$return = $_POST ;
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>$return['BillNo']));
    	$recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = PayCommon::LoadConfig($recharge_type);
    	$v_oid = trim($return['v_oid']);       // 商户发送的v_oid定单编号
    	$v_pstatus = trim($return['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
    	$v_pstring = trim($return['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）；
    	$v_amount = trim($return['v_amount']);     // 订单实际支付金额
    	$v_moneytype = trim($return['v_moneytype']); //订单实际支付币种
    	$v_md5str = trim($return['v_md5str']);   //拼凑后的MD5校验值
    	$key = $pay_config['PrivateKey'];
    	$md5string = strtoupper(md5($v_oid . $v_pstatus . $v_amount . $v_moneytype . $key));
    	if ($v_md5str == $md5string) {
    		if ($v_pstatus == "20") {
    			PayCommon::OnlineReturn($v_oid, $return);
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
    
    public static function actionliandong_pay_back(){
    	$return = $_POST ;
    	$data['pay_seq']=$return['pay_seq'];
    	$data['media_type']=$return['media_type'];
    	$data['pay_date']=$return['pay_date'];
    	$data['charset']=$return['charset'];
    	$data['amt_type']=$return['amt_type'];
    	$data['sign']=$return['sign'];
    	$data['version']=$return['version'];
    	$data['settle_date']=$return['settle_date'];
    	$data['amount']=$return['amount'];
    	$data['service']=$return['service'];
    	$data['trade_state']=$return['trade_state'];
    	$data['mer_id']=$return['mer_id'];
    	$data['trade_no']=$return['trade_no'];
    	$data['sign_type']=$return['sign_type'];
    	$data['order_id']=$return['order_id'];
    	$data['pay_type']=$return['pay_type'];
    	$data['mer_date']=$return['mer_date'];
    	ksort($data); $signText = "";
    	foreach ($data as $k => $v) {
    		if($k!="sign_type" && $k!="sign"){
    			$signText.=$k . "=" . trim($v) . "&";
    		}
    	}
    	$signText = substr($signText, 0, count($signText) - 2);
    	$sign = urldecode($data['sign']);
    	$sign = base64_decode($data['sign']);
    	$public = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/ld_public_key.pem");
    	$public_key = openssl_get_publickey($public);
    	$success = openssl_verify($signText, $sign, $public_key);
    	@openssl_free_key($success);
    	if ($success == 1 && $data['trade_state'] == "TRADE_SUCCESS") {
    		self::OnlineReturn($data['order_id'], $return);
    		return true;
    	} else {
    		return false;
    	}
    }
    
    /**
     * 银联支付返回
     * @param type $model
     * @param type $return
     */
    public static function actionchinapay_pay_back($model, $return) {
    	file_put_contents('yinlian.txt', date('Ymd H:i:s',time()).json_encode($_REQUEST).PHP_EOL,8);
    	$data = array();
    	$data['merid'] = $return['merid'];
    	$data['orderno'] = $return['orderno'];
    	$data['transdate'] = $return['transdate'];
    	$data['amount'] = $return['amount'];
    	$data['currencycode'] = $return['currencycode'];
    	$data['transtype'] = $return['transtype'];
    	$data['status'] = $return['status'];
    	$data['checkvalue'] = $return['checkvalue'];
    	$data['GateId'] = $return['GateId'];
    	$data['Priv1'] = $return['Priv1'];
    	$item_model = new Item;
    	$recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	if ($data['status'] == '1001') {
    		include_once Yii::getPathOfAlias('ext') . '/chinapay/netpayclient_src.php'; //逗逼给的加密文件有错。。
    		$MerPrk = Yii::getPathOfAlias('ext') . '/chinapay/MerPrK.key';
    		$pub = Yii::getPathOfAlias('ext') . '/chinapay/Pub.key';
    		$flag = buildKey($pub);
    		$plain = $data['merid'] . $data['orderno'] . $data['amount'] . $data['currencycode'] . $data['transdate'] . $data['transtype'] . $data['status'] ;
    		$flags = verify($plain, $data['checkvalue']);////银联是SB
    		if ($flags) {
    			self::OnlineReturn($data['orderno'], $return);
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
    
    public static function actionshanxin_pay_back() {
    	$return = $_REQUEST;
    	$return_code = $return['payRsltCd'];
    	$model = AssetsRecharge::model()->findByAttributes(array("r_BillNo"=>str_replace("treasure","",$return['orderId'])));
    	if($return_code == "IPS0000"){
    		if(!empty($model) && $model->r_status != 1){
    			$real_amount = ($return['amount'] - $return['fee']) / 100 ;
    			$fee = $return['fee'] / 100 ;
    			PayCommon::OnlineReturn($model->r_BillNo, $return);
    			$recharge_model = AssetsRecharge::model()->findByPk($model->r_id);
    			$recharge_model->r_realmoney = $real_amount ;
    			$recharge_model->r_fee = $fee ;
    			if($fee > 0 && $recharge_model->update()){
    				$user_assets = Assets::model()->findByPk($recharge_model->r_user_id);
    				$bill['user_id'] = $recharge_model->r_user_id;
    				$bill['b_money'] = $fee;
    				$bill['b_type'] = 2;
    				$bill['b_itemtype'] = "assets_recharge_fee";
    				$bill['u_total_money'] = $user_assets->total_money - $bill['b_money'];
    				$bill['u_real_money'] = $user_assets->real_money - $bill['b_money'];
    				$bill['u_frost_money'] = $user_assets->frost_money;
    				$bill['u_wait_interest'] = $user_assets->wait_interest;
    				$bill['u_have_interest'] = $user_assets->have_interest;
    				$bill['u_wait_total_money'] = $user_assets->wait_total_money;
    				$bill['b_mark'] = $recharge_model->r_id;
    				$bill['b_time'] = time();
    				$bill['remark'] = "线上充值{$recharge_model->r_money}元扣除手续费{$recharge_model->r_fee}元！";
    				LYCommon::AddBill($bill);
    			}
    			$return_data['mercId'] = $return['mercId'];
    			$return_data['requestId'] = $return['requestId'] ;
    			$return_data['interfaceName'] = "gwNoSmsSignPayNotify" ;
    			$return_data['version'] = "1.0";
    			$return_data['signType'] = "MD5" ;
    			$return_data['returnCode'] = $return['payRsltCd'] ;
    			$return_data['message'] = $return['payRsltMsg'] ;
    			$return_data['orderId'] = $return['orderId'] ;
    			$signStr = "" ;
				foreach($return_data as $key=>$value){
					$signStr .= $value ;
				}
				$return_data['hmac'] = md5($signStr.NPayCommon::SX_key) ;
				echo json_encode($return_data);
    		}
    	}
    }
	
}

?>