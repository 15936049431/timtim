<?php
/**
 * 
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class PayCommon {

    public static function GetRechargeType($recharge_model) {
        $name = $recharge_model->r_recharge_type;
        $recharge_list = LYCommon::GetItemList("assets_recharge_type");
        $recharge_listname = array();
        foreach ($recharge_list as $k => $v) {
            $recharge_listname[$v->i_id] = $v->i_nid;
        }
        $item_model = new Item();
        $recharge_type = $item_model->findByAttributes(array("i_nid" => $name));
        if (in_array($name, $recharge_listname) && !empty($recharge_type)) {
            $pay_config = self::LoadConfig($recharge_type);
            $result = self::$name($recharge_model, $pay_config);
            return $result;
        } else {
            return false;
        }
    }

    //加载配置信息
    public static function LoadConfig($recharge_type) {
        $config = explode(",,", $recharge_type->i_value);
        foreach ($config as $k => $v) {
            $config_key[$k] = explode(":::", $v);
            $config_result[$config_key[$k][0]] = $config_key[$k][1];
        }
        return $config_result;
    }

    //form加载
    public static function LoadForm($uri, $data = array()) {
        if (isset($uri) && $uri != "") {
            $str = "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\"></head><body><form name='form1' action='{$uri}' method='post' >";
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $str.="<input type='hidden' name='{$key}' id='{$key}' value='{$value}' />";
                }
            }
            $str.="</form></body></html>";
            $str.="<script>window.onload=function(){document.form1.submit();}</script>";
            return $str;
        }
        
        return false;
    }

    //统一返回接口
    public static function GetBack($back) {
        $return = "";
        $recharge_model = AssetsRecharge::model();
        if (isset($back['merchantId'])) { //通联支付
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['orderNo']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['Succeed']) && isset($back['MD5info'])) { //汇潮支付
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['BillNo']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['TransID']) && isset($back['MemberID']) && isset($back['TerminalID'])) { //宝付支付
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['TransID']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['respCode']) && isset($back['gopayOutOrderId'])) {  //国付宝支付
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['merOrderNum']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['v_pstatus'])) { //网银在线
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['v_oid']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['oid_partner'])) { //练练支付
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['no_order']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['Priv1'])) {//银联PC端
            $recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['orderno']));
            $fun_name = $recharge_now->r_recharge_type . "_back";
            $return = self::$fun_name($recharge_now, $back);
        } elseif (isset($back['res_data'])) { //连连手机端
        	$back = json_decode($back['res_data'],true);
        	$recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['no_order']));
        	$fun_name = $recharge_now->r_recharge_type . "_back";
        	$return = self::$fun_name($recharge_now, $back);
        } elseif( isset($back['trade_state'])){	//联动支付
        	$recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => $back['order_id']));
        	$fun_name = $recharge_now->r_recharge_type . "_back";
        	$return = self::$fun_name($recharge_now, $back);
        } elseif( isset($back['interfaceName'])){//闪信支付
        	$recharge_now = $recharge_model->findByAttributes(array("r_BillNo" => str_replace("treasure","",$back['orderId'])));
        	$fun_name = $recharge_now->r_recharge_type . "_back";
        	$return = self::$fun_name($recharge_now, $back);
        }else{
        	
        }
        return $return;
    }

    //线上充值增加资金
    public static function OnlineReturn($BillNo, $back) {
        $model = AssetsRecharge::model();

        $recharge_now = $model->findByAttributes(array("r_BillNo" => $BillNo));
        if ($recharge_now->r_status != 1) {
			$recharge_now->r_status = 1;
            $recharge_now->r_verify_user = "1";
            $recharge_now->r_verify_time = time();
            $recharge_now->r_verify_remark = "线上充值成功";
            $recharge_now->r_return = json_encode($back);
            $recharge_now->update();
			
            $assets = new Assets();
            $user_assets = $assets->findByPk($recharge_now->r_user_id);
            $bill['user_id'] = $recharge_now->r_user_id;
            $bill['b_money'] = $recharge_now->r_money;
            $bill['b_type'] = 1;
            $bill['b_itemtype'] = "assets_recharge";
            $bill['u_total_money'] = $user_assets->total_money + $bill['b_money'];
            $bill['u_real_money'] = $user_assets->real_money + $bill['b_money'];
            $bill['u_frost_money'] = $user_assets->frost_money;
            $bill['u_wait_interest'] = $user_assets->wait_interest;
            $bill['u_have_interest'] = $user_assets->have_interest;
            $bill['u_wait_total_money'] = $user_assets->wait_total_money;
            $bill['b_mark'] = $recharge_now->r_id;
            $bill['b_time'] = time();
            $bill['remark'] = "线上充值{$recharge_now->r_money}元成功！";
            LYCommon::AddBill($bill);

			if(!empty($recharge_now->user->user_phone) && !empty($recharge_now->user->is_phone_check)){
                LYCommon::sendSms($recharge_now->r_user_id,$recharge_now->user->user_phone,'online_pay',array(
                    'pay_money'=>$bill['b_money'],
                ));
            }
        }
        return true;
    }

    //通联支付返回
    public static function tonglian_pay_back($model, $return) {
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
            self::OnlineReturn($data['orderNo'], $return);
            return true;
        } else {
            return false;
        }
    }

    //汇潮支付返回
    public static function huichao_pay_back($model, $return) {
        $recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
        $BillNo = $return["BillNo"];
        $Amount = $return["Amount"];
        $Succeed = $return["Succeed"];
        $Result = $return["Result"];
        $MD5info = $return["MD5info"];
        $Remark = empty($return["Remark"]) ? "" : $return['Remark'];
        $md5src = $BillNo . $Amount . $Succeed . $pay_config['PrivateKey'];
        $md5sign = strtoupper(md5($md5src));
        if ($MD5info == $md5sign) {
            if ($Succeed == "88") {
                self::OnlineReturn($BillNo, $return);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //宝付支付返回
    public static function baofu_pay_back($model, $return) {
        $recharge_type = Item::model()->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
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
            self::OnlineReturn($_TransID, $return);
            return true;
        } else {
            return false;
        }
    }

    //国付宝支付返回
    public static function guofubao_pay_back($model, $return) {
        $recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
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
                self::OnlineReturn($merOrderNum, $return);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //网银在线支付返回
    public static function wangyin_pay_back($model, $return) {
        $item_model = new Item();
        $recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
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
                self::OnlineReturn($v_oid, $return);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //连连支付返回
    public static function lianlian_pay_back($model, $return) {
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
        $data['bank_code'] = $return['bank_code'];
        $recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
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
            self::OnlineReturn($data['no_order'], $return);
            return true;
        } else {
            return false;
        }
    }

    //连连认证支付返回
    public static function lianlianauth_pay_back($model, $return) {
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
        $data['bank_code'] = $return['bank_code'];
        $recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
        $pay_config = self::LoadConfig($recharge_type);
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
            self::OnlineReturn($data['no_order'], $return);
            return true;
        } else {
            return false;
        }
    }

    //通联支付提交
    public static function tonglian_pay($recharge_model, $pay_config) {
        $data['inputCharset'] = 1; //字符集
        $data['pickupUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return");  //付款客户的取货url地址
        $data['receiveUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/tonglian_pay_back"); //服务器接受支付结果的后台地址
        $data['version'] = "v1.0";  //网关接收支付请求接口版本 1.0
        $data['language'] = 1; //网关页面显示语言种类
        $data['signType'] = 1; //签名类型
        $data['merchantId'] = trim($pay_config['merchantId']); //商户号
        $data['payerName'] = ""; //payerName	付款人姓名
        $data['payerEmail'] = ""; //付款人邮件联系方式
        $data['payerTelephone'] = ""; //付款人电话联系方式
        $data['payerIDCard'] = ""; //付款人类型及证件号
        $data['pid'] = ""; //合作伙伴的商户号
        $data['orderNo'] = $recharge_model->r_BillNo; //商户订单号
        $data['orderAmount'] = $recharge_model->r_money * 100;  //商户订单金额
        $data['orderCurrency'] = "0"; //订单金额币种类型
        $data['orderDatetime'] = date("Ymdhis", time()); //商户订单提交时间
        $data['orderExpireDatetime'] = ""; //订单过期时间
        $data['productName'] = ""; //商品名称
        $data['productPrice'] = ""; //商品价格
        $data['productNum'] = ""; //商品数量
        $data['productId'] = ""; //商品代码
        $data['productDesc'] = ""; //商品描述
        $data['ext1'] = ""; //扩展字段1
        $data['ext2'] = ""; //扩展字段2
        $data['extTL'] = ""; //业务扩展字段
        $data['payType'] = "0"; //支付方式
        $data['issuerId'] = "";
        $data['pan'] = ""; //付款人支付卡号
        $data['tradeNature'] = "GOODS"; //贸易类型
        $data['customsExt'] = ""; //海关扩展字段
        $str = "";
        foreach ($data as $k => $v) {
            if ($v != "") {
                $str.="{$k}={$v}&";
            }
        }
        $signText = $str . "key=" . trim($pay_config['PrivateKey']);
        $data['signText'] = $signText;
        $data['signMsg'] = strtoupper(md5($signText)); //签名字符串
        $form['form'] = self::LoadForm($pay_config['Action'], $data);
        return $form;
    }

    //汇潮支付提交
    public static function huichao_pay($recharge_model, $pay_config) {
        $MD5key = $pay_config['PrivateKey'];  //MD5私钥
        $MerNo = $pay_config['member_id'];     //商户号
        $BillNo = $recharge_model->r_BillNo; //订单号		//[必填]订单号(商户自己产生：要求不重复)
        $Amount = $recharge_model->r_money;    //[必填]订单金额
        $ReturnURL = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
        $Remark = "";  //[选填]升级。
        $md5src = $MerNo . "&" . $BillNo . "&" . $Amount . "&" . $ReturnURL . "&" . $MD5key;   //校验源字符串
        $SignInfo = strtoupper(md5($md5src)); //MD5检验结果
        $AdviceURL = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/huichao_pay_back");   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
        $orderTime = date("Ymdhis", time());   //[必填]交易时间yyyyymmddsshhss
        $defaultBankNumber = "";   //[必填]银行代码s
        $products = date("Ymdhis", time()); // '------------------物品信息
        $submitUrl = $pay_config['gatePurl'];
        $url = $submitUrl;
        $url .= "MerNo={$MerNo}&";     //商户号
        $url .= "BillNo={$BillNo}&";  //[必填]订单号(商户自己产生：要求不重复)
        $url .= "Amount={$Amount}&";    //[必填]订单金额
        $url .= "ReturnURL={$ReturnURL}&";    //[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
        $url .= "Remark={$Remark}&";  //[选填]升级。
        $url .= "SignInfo={$SignInfo}&";  //MD5检验结果
        $url .= "AdviceURL={$AdviceURL}&";   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
        $url .= "orderTime={$orderTime}&";   //[必填]交易时间yyyyymmddsshhss
        $url .= "defaultBankNumber={$defaultBankNumber}&";   //[必填]银行代码s
        $url .= "products={$products}&";
        $form['url'] = $url;
        return $form;
    }

    //宝付支付提交
    public static function baofu_pay($recharge_model, $pay_config) {
    	$_MerchantID=$pay_config['member_id'];//商户号
    	$_TransID=$recharge_model->r_BillNo;//流水号
    	$_PayID=1000;//支付方式
    	$_TradeDate=date("Ymdhis");//交易时间
    	$_OrderMoney=$recharge_model->r_money * 100;//订单金额
    	$_ProductName="";//产品名称
    	$_Amount=1;//数量
    	$_ProductLogo="";//产品logo
    	$_Username=$pay_config['username'];//支付用户名
    	$_Email="";
    	$_Mobile="";
    	$_AdditionalInfo="";//订单附加消息
    	$_Merchant_url=Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return");
    	$_Return_url=Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/baofu_pay_back");//用户通知地址
    	$_NoticeType=1;//通知方式
    	$_Md5Key=$pay_config['PrivateKey'].",";	//密钥
    	$_Md5Sign=md5($_MerchantID.$_PayID.$_TradeDate.$_TransID.$_OrderMoney.$_Merchant_url.$_Return_url.$_NoticeType.$_Md5Key);
    	$url = $pay_config['gatePurl'];
    	$url .= "MerchantID={$_MerchantID}&";//网关版本号
    	$url .= "PayID={$_PayID}&";//字符集 1 GBK 2 UTF-8
    	$url .= "TradeDate={$_TradeDate}&";//1 中文 2 英文
    	$url .= "TransID={$_TransID}&";//报文加密方式 1 MD5 2 SHA
    	$url .= "OrderMoney={$_OrderMoney}&";//交易代码 本域指明了交易的类型，支付网关接口必须为8888
    	$url .= "ProductName={$_ProductName}&";//商户代码
    	$url .= "Amount={$_Amount}&";//订单号
    	$url .= "ProductLogo={$_ProductLogo}&";//交易金额
    	$url .= "Username={$_Username}&";//
    	$url .= "Email={$_Email}&";//156，代表人民币
    	$url .= "Mobile={$_Mobile}&";//商户前台通知地址
    	$url .= "AdditionalInfo={$_AdditionalInfo}&";//
    	$url .= "Merchant_url={$_Merchant_url}&";//本域为订单发起的交易时间
    	$url .= "Return_url={$_Return_url}&";//本域指卖家在国付宝平台开设的国付宝账户号
    	$url .= "NoticeType={$_NoticeType}&";//发起交易的客户IP地址
    	$url .= "Md5Sign={$_Md5Sign}&";//	0不允许重复 1 允许重复
    	$form['url'] = $url;
    	return $form;
    }

    //国付宝支付
    public static function guofubao_pay($recharge_model, $pay_config) {
        $Mer_key = $pay_config['PrivateKey'];
        $version = "2.0";
        $charset = 1;
        $language = 1;
        $signType = 1;
        $tranCode = 8888;
        $merchantID = $pay_config['member_id'];
        $merOrderNum = $recharge_model->r_BillNo;
        $tranAmt = number_format($recharge_model->r_money, 2, '.', '');
        $feeAmt = "";
        $bankCode = "0000";
        $currencyType = 156;
        $frontMerUrl = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return");
        $backgroundMerUrl = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/guofubao_pay_back");
        $tranDateTime = date("YmdHis", time());
        $virCardNoIn = $pay_config['CardNo'];
        $tranIP = $_SERVER['REMOTE_ADDR'];
        $isRepeatSubmit = 1;
        $goodsName = "p2pLC";
        $goodsDetail = "";
        $buyerName = $pay_config['member_id'];
        $buyerContact = "";
        $signValue = 'version=[' . $version . ']tranCode=[' . $tranCode . ']merchantID=[' . $merchantID . ']merOrderNum=[' . $merOrderNum . ']tranAmt=[' . $tranAmt . ']feeAmt=[' . $feeAmt . ']tranDateTime=[' . $tranDateTime . ']frontMerUrl=[' . $frontMerUrl . ']backgroundMerUrl=[' . $backgroundMerUrl . ']orderId=[]gopayOutOrderId=[]tranIP=[' . $tranIP . ']respCode=[]VerficationCode=[' . $Mer_key . ']';
        $signValue = md5($signValue);
        $url = $pay_config['gatePurl'];
        $url .= "version={$version}&"; //网关版本号
        $url .= "charset={$charset}&"; //字符集 1 GBK 2 UTF-8
        $url .= "language={$language}&"; //1 中文 2 英文
        $url .= "signType={$signType}&"; //报文加密方式 1 MD5 2 SHA
        $url .= "tranCode={$tranCode}&"; //交易代码 本域指明了交易的类型，支付网关接口必须为8888
        $url .= "merchantID={$merchantID}&"; //商户代码
        $url .= "merOrderNum={$merOrderNum}&"; //订单号
        $url .= "tranAmt={$tranAmt}&"; //交易金额
        $url .= "feeAmt={$feeAmt}&"; //
        $url .= "currencyType={$currencyType}&"; //156，代表人民币
        $url .= "frontMerUrl={$frontMerUrl}&"; //商户前台通知地址
        $url .= "backgroundMerUrl={$backgroundMerUrl}&"; //
        $url .= "tranDateTime={$tranDateTime}&"; //本域为订单发起的交易时间
        $url .= "virCardNoIn={$virCardNoIn}&"; //本域指卖家在国付宝平台开设的国付宝账户号
        $url .= "tranIP={$tranIP}&"; //发起交易的客户IP地址
        $url .= "isRepeatSubmit={$isRepeatSubmit}&"; //	0不允许重复 1 允许重复 
        $url .= "goodsName={$goodsName}&"; //
        $url .= "buyerName={$buyerName}&"; //
        $url .= "signValue={$signValue}&"; //
        $url .= "bankCode={$bankCode}&"; //
        $url .= "userType=1&"; //
        $url .= "gopayServerTime="; //本域为订单发起的交易时间
        $form['url'] = $url;
        return $form;
    }

    //网银在线支付
    public static function wangyin_pay($recharge_model, $pay_config) {
        $v_mid = $pay_config['member_id'];
        $key = $pay_config['PrivateKey'];
        $v_url = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return");; //返回地址
        $v_oid = $recharge_model->r_BillNo;
        $v_amount = $recharge_model->r_money; //支付金额                 
        $v_moneytype = "CNY";
        $text = $v_amount . $v_moneytype . $v_oid . $v_mid . $v_url . $key; //md5加密拼凑串,注意顺序不能变
        $v_md5info = strtoupper(md5($text)); //md5函数加密并转化成大写字母
        $url = $pay_config['gatePurl']; //网关提交地址
        $data = array(
            'v_mid' => $v_mid,
            'v_oid' => $v_oid,
            'v_amount' => $v_amount,
            'v_moneytype' => $v_moneytype,
            'v_url' => $v_url,
            'v_md5info' => $v_md5info
        );
        $url.=http_build_query($data);
        $form['url'] = $url;
        return $form;
    }

    //连连支付
    public static function lianlian_pay($recharge_model, $pay_config) {
        $data['version'] = "1.0"; //版本号
        //$data['charset_name']="UTF-8";	//编码格式
        $data['oid_partner'] = $pay_config['oid_partner']; //商户识别码
        $data['user_id'] = $recharge_model->r_user_id; //用户id
        $data['timestamp'] = date("YmdHis", time());
        $data['sign_type'] = "MD5";
        $data['busi_partner'] = $pay_config['busi_partner']; //商户业务类型
        $data['no_order'] = $recharge_model->r_BillNo;
        $data['dt_order'] = date("YmdHis", time());
        $data['name_goods'] = "p2p"; //商品名称
        $data['info_order'] = "recharge"; //订单描述
        $data['id_type'] = "0"; //证件类型
        $data['money_order'] = $recharge_model->r_money; //交易金额
        $data['notify_url'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/lianlian_back"); //异步地址
        $data['url_return'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //同步地址
        $data['userreq_ip'] = str_replace(".", "_", $recharge_model->r_addip); //用户端申请 IP
        $data['url_order'] = ""; //订单地址
        $data['valid_order'] = "10080";  //订单有效时间
        $data['bank_code'] = ""; //指定银行网银编号
        $data['pay_type'] = ""; //支付方式
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
            $data['sign'] = base64_encode($sign);
        } else {
            $signText.="&key=" . $pay_config['key'];
            $data['sign'] = md5(trim($signText));
        }
        $form['form'] = self::LoadForm($pay_config['gatePurl'], $data);
        return $form;
    }

    //连连认证支付
    public static function lianlianauth_pay($recharge_model, $pay_config) {
        $data['version'] = "1.0";
        $data['charset_name']="UTF-8";
        $data['oid_partner'] = $pay_config['oid_partner']; //商户识别码
        //$data['platform']="lxy";	//平台来源标示 
        $data['user_id'] = $recharge_model->r_user_id; //用户id
        $data['timestamp'] = date("YmdHis", time());
        $data['sign_type'] = "MD5";
        $data['busi_partner'] = $pay_config['busi_partner']; //商户业务类型
        $data['no_order'] = $recharge_model->r_BillNo;
        $data['dt_order'] = date("YmdHis", time());
        $data['name_goods'] = "p2p"; //商品名称
        $data['info_order'] = "recharge"; //订单描述
        $data['id_type'] = "0"; //证件类型
        $data['money_order'] = $recharge_model->r_money; //交易金额
        $data['notify_url'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/lianlianauth_back"); //异步地址
        $data['url_return'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //同步地址
        $data['userreq_ip'] = str_replace(".", "_", $recharge_model->r_addip); //用户端申请 IP
        $data['url_order'] = ""; //订单地址
        $data['valid_order'] = "10080";  //订单有效时间
        $data['bank_code'] = ""; //指定银行网银编号
        $data['pay_type'] = "D"; //支付方式
        $data['no_agree'] = ""; //签约协议号
        $data['id_type'] = "0";  //证件类型
        $data['id_no'] = $recharge_model->user->card_num;
        $data['acct_name'] = $recharge_model->user->real_name;
        $data['card_no'] = $recharge_model->bankCard;
		$risk_item['frms_ware_category']=2009;
        $risk_item['user_info_mercht_userno']=$recharge_model->r_user_id;
        $risk_item['user_info_dt_register'] = date("YmdHis",$recharge_model->user->register_time);
		$risk_item['user_info_full_name'] = ($recharge_model->user->real_name!="") ? $recharge_model->user->real_name : "" ;
        $risk_item['user_info_id_type '] = "0";
        $risk_item['user_info_id_no'] = ($recharge_model->user->card_num!="") ? $recharge_model->user->card_num : "" ;
        $risk_item['user_info_identify_state'] = $recharge_model->user->is_realname_check;
        $risk_item['user_info_identify_type'] = ($recharge_model->user->is_realname_check==1) ? "3" : "3" ;
        $data['risk_item'] = json_encode($risk_item);
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
            $data['sign'] = base64_encode($sign);
        } else {
            $signText.="&key=" . $pay_config['key'];
            $data['sign'] = md5(trim($signText));
        }
        $form['form'] = self::LoadForm($pay_config['gatePurl'], $data);
        return $form;
    }
    
    //连连wap认证支付
    public static function lianlianphone_pay($recharge_model, $pay_config) {
    	$data['version'] = "1.0";
    	//$data['charset_name']="UTF-8";
    	$data['oid_partner'] = $pay_config['oid_partner']; //商户识别码
    	//$data['platform']="lxy";	//平台来源标示
    	$data['user_id'] = $recharge_model->r_user_id; //用户id
    	$data['app_request'] = "3";
    	$data['timestamp'] = date("YmdHis", time());
    	$data['sign_type'] = "MD5";
    	$data['busi_partner'] = $pay_config['busi_partner']; //商户业务类型
    	$data['no_order'] = $recharge_model->r_BillNo;
    	$data['dt_order'] = date("YmdHis", time());
    	$data['name_goods'] = "p2p"; //商品名称
    	$data['info_order'] = "recharge"; //订单描述
    	$data['id_type'] = "0"; //证件类型
    	$data['money_order'] = $recharge_model->r_money; //交易金额
    	$data['notify_url'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/lianlianphone_back"); //异步地址
    	$data['url_return'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //同步地址
    	//$data['userreq_ip'] = str_replace(".", "_", $recharge_model->r_addip); //用户端申请 IP
    	//$data['url_order'] = ""; //订单地址
    	$data['valid_order'] = "10080";  //订单有效时间
    	//$data['bank_code'] = ""; //指定银行网银编号
    	//$data['pay_type'] = "D"; //支付方式
    	$data['no_agree'] = ""; //签约协议号
    	$data['id_type'] = "0";  //证件类型
    	$data['id_no'] = $recharge_model->user->card_num;
    	$data['acct_name'] = $recharge_model->user->real_name;
    	$data['card_no'] = $recharge_model->bankCard;
		$risk_item['frms_ware_category']=2009;
        $risk_item['user_info_mercht_userno']=$recharge_model->r_user_id;
        $risk_item['user_info_dt_register'] = date("YmdHis",$recharge_model->user->register_time);
		$risk_item['user_info_full_name'] = ($recharge_model->user->real_name!="") ? $recharge_model->user->real_name : "" ;
        $risk_item['user_info_id_type '] = "0";
        $risk_item['user_info_id_no'] = ($recharge_model->user->card_num!="") ? $recharge_model->user->card_num : "" ;
        $risk_item['user_info_identify_state'] = $recharge_model->user->is_realname_check;
        $risk_item['user_info_identify_type'] = ($recharge_model->user->is_realname_check==1) ? "3" : "3" ;
        $data['risk_item'] = json_encode($risk_item);
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
    		$data['sign'] = base64_encode($sign);
    	} else {
    		$signText.="&key=" . $pay_config['key'];
    		$data['sign'] = md5(trim($signText));
    	}
    	$content['req_data']=json_encode($data);
    	$form['form'] = self::LoadForm($pay_config['gatePurl'], $content);
    	return $form;
    }
    
    public static function lianlianphone_pay_back($model,$return){
    	$item_model = new Item();
    	$data['oid_partner'] = $return['oid_partner'];
    	$data['sign_type'] = $return['sign_type'];
    	$data['dt_order'] = $return['dt_order'];
    	$data['no_order'] = $return['no_order'];
    	$data['oid_paybill'] = $return['oid_paybill'];
    	$data['money_order'] = $return['money_order'];
    	$data['result_pay'] = $return['result_pay'];
    	$data['settle_date'] = $return['settle_date'];
    	$recharge_type = $item_model->findByAttributes(array("i_nid" => $model->r_recharge_type));
    	$pay_config = self::LoadConfig($recharge_type);
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
    		self::OnlineReturn($data['no_order'], $return);
    		return true;
    	} else {
    		return false;
    	}
    }
    
    //联动优势充值
    public static function liandong_pay($recharge_model,$pay_config){
    	$data['service'] = "req_front_page_pay"; //接口名称
    	$data['charset'] = "UTF-8"; //参数字符编码集
    	$data['mer_id'] = "9496"; //商户编号
    	$data['sign_type'] = "RSA"; //签名方式
    	$data['ret_url'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //页面跳转同步通知页面路径
    	$data['notify_url'] =Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/liandong_pay_back");  //服务器异步通知页面路径
    	//$data['res_format'] = "HTML"; //响应数据格式
    	$data['version'] = "4.0"; //版本号
    	$data['goods_id'] = ""; //商品号
    	$data['goods_inf'] = ""; //商品描述信息
    	$data['media_id'] = "";   //媒介标识
    	$data['media_type'] = "";  //媒介类型
    	$data['order_id'] = $recharge_model->r_BillNo;  //商户唯一订单号
    	$data['mer_date'] = date("Ymd");  //商户订单日期
    	$data['amount'] = $recharge_model->r_money*100;  //付款金额
    	$data['amt_type'] = "RMB"; //   付款币种
    	$data['pay_type']='B2CDEBITBANK';//默认支付方式
    	$data['gate_id']='';  //默认银行
    	$data['mer_priv']='';  //商户私有域
    	$data['user_ip']='';   //用户IP地址 用作防钓鱼校验
    	$data['expand'] = '';   //业务扩展信息
    	$data['expire_time']='';   //订单过期时长
    	$data['interface_type']="01";//01---收银台（网银非直连、网银借记卡非直连、信用卡快捷、借记卡快捷、一键快捷）
    	ksort($data); $signText = "";
    	foreach ($data as $k => $v) {
    		if($k!="sign_type"){
	    		$signText.=$k . "=" . trim($v) . "&";
    		}
    	}
    	$signText = substr($signText, 0, count($signText) - 2);
    	$private = file_get_contents(Yii::getPathOfAlias('ext') . "/PayUtil/ld_private_key.pem");
    	$rsa = openssl_get_privatekey($private);
    	openssl_sign($signText, $sign, $rsa);
    	openssl_free_key($rsa);
    	$signature = base64_encode($sign);
    	$url = $pay_config['gatePurl'];
    	$data['sign']=urlencode($signature);
    	foreach($data as $k=>$v){
    		$url.=$k."=".$v."&";
    	}
    	$form['url']=$url;
    	return $form;
    }
    
    public static function liandong_pay_back($model,$return){
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
     * 银联PC端支付提交
     * @param type $recharge_model
     * @param type $pay_config
     */
    public static function chinapay_pay($recharge_model, $pay_config) {
        $data['MerId'] = $pay_config['MerId']; //商户号
        $data['OrdId'] = $recharge_model->r_BillNo; //订单号
        $data['TransAmt'] = str_pad($recharge_model->r_money * 100, 12, '0', STR_PAD_LEFT); //订单交易金额， 12 位长度，左补 0
        $data['CuryId'] = 156; //订单交易币种， 3 位长度，固定为人民币 156
        $data['TransDate'] = date("Ymd", time()); //订单交易日期， 8 位长度， 必填
        $data['TransType'] = '0001'; //交易类型， 4 位长度
        $data['Version'] = '20141120'; //支付接入版本号
        $data['BgRetUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/chinapay_pay_back"); //后台交易接收 URL
        $data['PageRetUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return"); //页面返回
        $data['GateId'] = '';
        $data['Priv1'] = $recharge_model->r_user_id;
        //商户私有域，备注
        $data['ChkValue'] = ''; //签名
        include_once Yii::getPathOfAlias('ext') . '/chinapay/netpayclient_src.php'; //傻逼给的加密文件有错，用破解版的修改了下
        $MerPrk = Yii::getPathOfAlias('ext') . '/chinapay/MerPrK.key';
        $build = buildKey($MerPrk); //引入私钥，放入全局变量
        if ($build) {
            $signStr = $data['MerId'] . $data['OrdId'] . $data['TransAmt'] . $data['CuryId'] . $data['TransDate'] . $data['TransType'] . $data['Version'] . $data['BgRetUrl'] . $data['PageRetUrl'];
            $signStr.=$data['GateId'] . $data['Priv1'];
            $data['ChkValue'] = sign($signStr);
        }
        $form['form'] = self::LoadForm($pay_config['gatePurl'], $data);
        return $form;
    }

    /**
     * 银联支付返回
     * @param type $model
     * @param type $return
     */
    public static function chinapay_pay_back($model, $return) {
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
    
    /**
     * 银联手机WAP支付-快捷-提交
     * @param type $recharge_model
     * @param type $pay_config
     */
    public  static function cpphonefast_pay($recharge_model, $pay_config) {
	   // error_reporting(E_ALL);
       include_once Yii::getPathOfAlias('ext') . '/chinaphonefast/ChinaPhoneFast.php';
        $cp = new ChinaPhoneFast();
        $certId = $cp->getSignCertId();
        $params = array(
		'version' => '5.0.0',				//版本号
		'encoding' => 'UTF-8',				//编码方式
		'certId' => $certId,			//证书ID
		'txnType' => '01',				//交易类型	
		'txnSubType' => '01',				//交易子类
		'bizType' => '000201',				//业务类型
		'frontUrl' =>  $cp->SDK_FRONT_NOTIFY_URL,  		//前台通知地址
		'backUrl' => $cp->SDK_BACK_NOTIFY_URL,		//后台通知地址	
		'signMethod' => '01',		//签名方法
		'channelType' => '08',		//渠道类型，07-PC，08-手机
		'accessType' => '0',		//接入类型
		'merId' => ChinaPhoneFast::MERID,	//商户代码，请改自己的测试商户号
		'orderId' => $recharge_model->r_BillNo,	//商户订单号，8-40位数字字母
		'txnTime' => date('YmdHis'),	//订单发送时间
		'txnAmt' => $recharge_model->r_money * 100,		//交易金额，单位分
		'currencyCode' => '156',	//交易币种
		//'orderDesc' => 'www.wpcf.net',  //订单描述，可不上送，上送时控件中会显示该信息
		'reqReserved' =>'www.wpcf.net', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);
        $cp->sign ( $params );
        $front_uri=  ChinaPhoneFast::SDK_FRONT_TRANS_URL;
        $form['form'] = self::LoadForm($front_uri, $params);
        return $form;       
    }
    
    public static function yinlianauth_pay($recharge_model,$pay_config){
    	include_once Yii::getPathOfAlias('ext') . '/chinapayfast/ChinaPayFast.php';
    	$cp = new ChinaPayFast();
    	$data['version'] = "5.0.0";	//版本号
    	$data['encoding'] = "UTF-8";  	//编码方式
    	$data['certId'] = $cp->getSignCertId();	 //证书ID
    	$data['signature'] = "" ; //签名域
    	$data['signMethod'] = "01" ; //签名方法
    	$data['txnType'] = "01" ; //交易类型
    	$data['txnSubType'] = "01"; //交易子类型
    	$data['bizType'] = "000301"; //业务类型
    	$data['channelType'] = "07"; //渠道类型
    	$data['frontUrl'] = $cp->SDK_FRONT_NOTIFY_URL ; //前台地址
    	$data['backUrl'] = $cp->SDK_BACK_NOTIFY_URL ; //后台地址
    	$data['accessType'] = "0" ; //接入类型
    	$data['merId'] = $pay_config['merId'] ; //商户ID
    	$data['orderId'] = $recharge_model->r_BillNo; // 订单号
    	$data['txnTime'] = date('YmdHis');// 订单发送时间
    	//$data['acqInsCode'] = "" ; // 收单机构代码 ，直连商户不需要填，收单机构需上送 
    	//$data['merCatCode'] = "" ; //商户类别
    	//$data['merName'] = "" ; // 商户名称
    	//$data['merAbbr'] = "" ; //商户简称
    	//$data['subMerId'] = "" ; //二级商户代码
    	//$data['subMerName'] = "" ; //二级商户名称
    	//$data['subMerAbbr'] = "" ;  //二级商户简称
    	//$data['accType'] = "" ; //账号类型
    	$data['accNo'] = $recharge_model->bankCard ;  //卡号可选上送
    	$data['txnAmt'] =  $recharge_model->r_money * 100 ; // 交易金额 分
     	$data['currencyCode'] = "156" ; //交易币种
     	//$data['customerInfo'] = "" ; //银行卡验证信息及身份信息
     	//$data['orderTimeout'] = "12" ; //订单超时时间
     	//$data['payTimeout'] = "" ; //订单支付超时时间
     	//$data['termId'] = "" ; //终端号
     	//$data['reqReserved'] = "" ; //商户保留域
     	//$data['reserved'] = "" ; //保留域
     	//$data['riskRateInfo'] = ""; //风险信息域
     	//$data['encryptCertId'] = "" ; //加密证书ID
     	//$data['frontFailUrl'] = "" ; //失败前台跳转地址
     	//$data['instalTransInfo'] = "" ; //分期付款信息域
     	//$data['defaultPayType'] = "" ; //默认支付方式
     	//$data['issInsCode'] = "" ;  //发卡机构代码
     	//$data['supPayType'] = "" ; //支持支付方式
     	//$data['userMac'] = "" ; //终端信息域
     	$data['customerIp'] = $_SERVER['REMOTE_ADDR']; //持卡人ip 
     	//$data['bindId'] = "" ; //绑定标识号
     	//$data['payCardType'] = "" ; //支付卡类型
     	//$data['securityType'] = "" ; //安全类型
     	//$data['cardTransData'] = "" ; //有卡交易信息域
     	//$data['vpcTransData'] = "" ; //VPC交易信息域
     	//$data['orderDesc'] = "" ; //订单描述
     	$cp->sign ( $data );
     	$front_uri= ChinaPayFast::SDK_FRONT_TRANS_URL;
     	$form['form'] = self::LoadForm($front_uri, $data);
     	return $form;
    }
    
    public static function shanxin_pay($recharge_model,$pay_config){
    	$user_info = User::model()->findByPk($recharge_model->r_user_id);
    	$bank_info = AssetsBank::model()->findByPk($recharge_model->sign);
    	$treasure_submit['charset'] = "UTF-8" ;
    	$treasure_submit['mercId'] = $pay_config['member'];
    	$treasure_submit['requestId'] = $recharge_model->r_id;
    	$treasure_submit['interfaceName'] = "gwNoSmsSignPay" ;
    	$treasure_submit['version'] = "1.0" ;
    	$treasure_submit['signType'] = "MD5" ;
    	$treasure_submit['mobileNo'] = $user_info->user_phone;
    	$treasure_submit['agrNo'] = $bank_info->sign ;
    	$treasure_submit['cardNo'] = NPayCommon::builderDes($pay_config['key'],$bank_info->b_cardNum) ;
    	$treasure_submit['cardName'] = NPayCommon::builderDes($pay_config['key'],$user_info->real_name) ;
    	$treasure_submit['idType'] = "00";
    	$treasure_submit['idNo'] = NPayCommon::builderDes($pay_config['key'],$user_info->card_num);
    	$treasure_submit['orderId'] = "treasure".$recharge_model->r_BillNo ;
    	$treasure_submit['amount'] = $recharge_model->r_realmoney * 100;
    	$treasure_submit['validTime'] = "1h" ;
    	$treasure_submit['notifyUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/shanxin_pay_back"); ;
    	$treasure_submit['rmk'] = "" ;
    	$treasure_submit['mercBusTyp'] = "" ;
    	$signStr = "" ;
    	foreach($treasure_submit as $key=>$value){
    		$signStr .= $value ;
    	}
    	$treasure_submit['hmac'] = md5($signStr.$pay_config['key']) ;
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_URL, $pay_config['gateurl']);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $treasure_submit);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    	$return_data = curl_exec($ch);
    	curl_close($ch);
    	$treasure_result = json_decode($return_data,true);
    	$treasure_result['treasure'] = true;
    	return $treasure_result;
    }
    
    public static function shanxin_pay_back($model, $return) {
    	$return_code = $return['payRsltCd'];
    	if($return_code == "IPS0000"){
    		if(!empty($model)){
    			$real_amount = ($return['amount'] - $return['fee']) / 100 ;
    			$fee = $return['fee'] / 100 ;
    			self::OnlineReturn($model->r_BillNo, $return);
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
    		}
    	}
    }
    
    public static function tonglianphone_pay($recharge_model,$pay_config){
    	$submit['inputCharset'] = 1 ;
    	$submit['pickupUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("usercenter/recharge_return");
    	$submit['receiveUrl'] = Yii::app()->request->hostInfo . Yii::app()->controller->createUrl("/pay/tonglianphone_pay_back");
    	$submit['version'] = "v1.0" ;
    	$submit['language'] = 1 ;
    	$submit['signType'] = 1 ;
    	$submit['merchantId'] = trim($pay_config['merchantId']) ;
    	$submit['payerName'] = "" ;
    	$submit['payerEmail'] = "" ;
    	$submit['payerTelephone'] = "" ;
    	$submit['payerIDCard'] = "" ;
    	$submit['pid'] = "" ;
    	$submit['orderNo'] = $recharge_model->r_BillNo ;
    	$submit['orderAmount'] = $recharge_model->r_money * 100 ;
    	$submit['orderCurrency'] = "0" ;
    	$submit['orderDatetime'] = date("Ymdhis",time()) ;
    	$submit['orderExpireDatetime'] = "" ;
    	$submit['productName'] = "" ;
    	$submit['productPrice'] = "" ;
    	$submit['productNum'] = "" ;
    	$submit['productId'] = "" ;
    	$submit['productDesc'] = "" ;
    	$submit['ext1'] = "phone" ;
    	$submit['ext2'] = "" ;
    	$submit['extTL'] = "" ;
    	$submit['payType'] = "0" ;
    	$submit['issuerId'] = "" ;
    	$submit['pan'] = "" ;
    	$submit['tradeNature'] = "GOODS" ;
    	$signText = "" ;
    	foreach($submit as $k=>$v){
    		if($v != "") $signText .= "{$k}={$v}&" ;
    	}
    	$signText.= "key=".trim($pay_config['PrivateKey']);
    	$submit['signMsg'] = strtoupper(md5($signText));
    	$form['form'] = self::LoadForm($pay_config['gateUrl'],$submit);
    	return $form;
    }
    
    public static function tonglianphone_pay_back($model, $return) {
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
    		self::OnlineReturn($data['orderNo'], $return);
    		return true;
    	} else {
    		return false;
    	}
    }

}
