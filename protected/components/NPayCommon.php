<?php
/**
 * treasure
 * @author Lxy
 *
 */
class NPayCommon{
	
	const SX_sign_url = "http://119.254.111.198:8050/ips/mercExp/gwExpress/noSmsSign" ;
	//const SX_sign_url = "https://payment.shanqb.com/ips/mercExp/gwExpress/noSmsSign" ;
	const SX_recharge_url = "http://119.254.111.198:8050/ips/mercExp/gwExpress/noSmsSignPay" ;
	//const SX_recharge_url = "https://payment.shanqb.com/ips/mercExp/gwExpress/noSmsSignPay" ;
	const SX_member = "888000000000168" ;
	const SX_key = "aff167ff067e4dbe999d37af0bb848f6" ;
	
	const TL_REAL_URl = "http://113.108.182.3:8083/aipg/ProcessServlet";
	//const TL_REAL_URl = "https://tlt.allinpay.com/aipg/ProcessServlet" ;
	const TL_MEMBER = "200604000000445" ;
	const TL_USER = "20060400000044502" ;
	const TL_PASS = "`12qwe" ;
	const TL_PRIVATE = "/PayUtil/tl_private.pem" ;
	const TL_PUBLIC = "/PayUtil/tl_public.pem" ;
	const TL_KEY_PASS = "111111" ;
	
	public static function builderDes($key,$data){
		//$data = iconv("GBK","UTF-8", $data);
		$key = base64_decode($key);
		$blocksize = mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
		$pad = $blocksize - (strlen($data) % $blocksize);
		$data = $data . str_repeat(chr($pad), $pad);
		$td = mcrypt_module_open( MCRYPT_3DES, '', MCRYPT_MODE_ECB, '' );
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init( $td, $key , $iv);
		$result = mcrypt_generic( $td, $data );
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return base64_encode($result);
	}
	
	public static function builderSign($data){
		$treasure_submit['charset'] = "UTF-8" ;
		$treasure_submit['mercId'] = self::SX_member;
		$treasure_submit['requestId'] = time() . substr(microtime(), 2, 5) ;
		$treasure_submit['interfaceName'] = "gwNoSmsSign";
		$treasure_submit['version'] = "1.0";
		$treasure_submit['signType'] = "MD5";
		$treasure_submit['mobileNo'] = $data['mobile'] ;
		$treasure_submit['cardNo'] = self::builderDes(self::SX_key,str_replace(' ','',$data['bankcard'])) ;
		$treasure_submit['cardCVV2'] = "" ;
		$treasure_submit['cardExpDate'] = "" ;
		$treasure_submit['cardName'] = self::builderDes(self::SX_key,$data['real_name']) ;
		$treasure_submit['idType'] = "00" ;
		$treasure_submit['idNo'] = self::builderDes(self::SX_key,$data['idno']) ;
		$signStr = "" ;
		foreach($treasure_submit as $key=>$value){
			$signStr .= $value ;
		}
		$treasure_submit['hmac'] = md5($signStr.self::SX_key) ;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, self::SX_sign_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $treasure_submit);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$return_data = curl_exec($ch);
		curl_close($ch);
		$treasure_result = json_decode($return_data,true);
		return $treasure_result;
	}
	
	public static function builderRecharge($data){
		$billNo = time() . substr(microtime(), 2, 5);
		$treasure_submit['charset'] = "UTF-8" ;
		$treasure_submit['mercId'] = self::SX_member;
		$treasure_submit['requestId'] = $billNo;
		$treasure_submit['interfaceName'] = "gwNoSmsSignPay" ;
		$treasure_submit['version'] = "1.0" ;
		$treasure_submit['signType'] = "MD5" ;
		$treasure_submit['mobileNo'] = $data['mobile'];
		$treasure_submit['agrNo'] = $data['agrNo'] ;
		$treasure_submit['cardNo'] = self::builderDes(self::SX_key,$data['cardNo']) ;
		$treasure_submit['cardName'] = self::builderDes(self::SX_key,$data['cardName']) ;
		$treasure_submit['idType'] = "00";
		$treasure_submit['idNo'] = self::builderDes(self::SX_key,$data['idNo']);
		$treasure_submit['orderId'] = "treasure".$data['orderId'] ;
		$treasure_submit['amount'] = $data['amount'] ;
		$treasure_submit['validTime'] = "1h" ;
		$treasure_submit['notifyUrl'] = "" ;
		$treasure_submit['rmk'] = "" ;
		$treasure_submit['mercBusTyp'] = "" ;
		$signStr = "" ;
		foreach($treasure_submit as $key=>$value){
			$signStr .= $value ;
		}
		$treasure_submit['hmac'] = md5($signStr.self::SX_key) ;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, self::SX_recharge_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $treasure_submit);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$return_data = curl_exec($ch);
		curl_close($ch);
		$treasure_result = json_decode($return_data,true);
		return $treasure_result;
	}
	
	public static function builderXML($data,$root,$charset){
		$xml_result = simplexml_load_string('<?xml version="1.0" encoding="'.$charset.'"?><'.$root.'></'.$root.'>') ;
		foreach($data as $k=>$v){
			if(is_array($v)){
				$xml_result->addChild($k);
				foreach($v as $_k=>$_v){
					if(!empty($_v))
					$xml_result->$k->addChild($_k,$_v);
				}
			}else{
				if(!empty($v))
				$xml_result->addChild($k,$v) ;
			}
		}
		return $xml_result->asXML();
	}
	
	public static function builderRealName($data){
		$treasure_data['INFO']['TRX_CODE'] = "220001" ;
		$treasure_data['INFO']['VERSION'] = "03" ;
		$treasure_data['INFO']['DATA_TYPE'] = "2" ;
		$treasure_data['INFO']['LEVEL'] = "6" ;
		$treasure_data['INFO']['MERCHANT_ID'] = self::TL_MEMBER ;
		$treasure_data['INFO']['USER_NAME'] = self::TL_USER ;
		$treasure_data['INFO']['USER_PASS'] = self::TL_PASS ;
		$treasure_data['INFO']['REQ_SN'] = $treasure_data['INFO']['MERCHANT_ID'] .'-'. time() ;
		$treasure_data['IDVER']['NAME'] = $data['user_name'] ;
		$treasure_data['IDVER']['IDNO'] = $data['card_id'] ;
		$treasure_data['IDVER']['VALIDATE'] = "" ;
		$treasure_data['IDVER']['REMARK'] = "" ;
		$xml_result = self::builderXML($treasure_data,"AIPG","GBK");
		$private_key = file_get_contents(Yii::getPathOfAlias('ext').self::TL_PRIVATE);
		$private_key_get = openssl_pkey_get_private($private_key,self::TL_KEY_PASS);
		openssl_sign($xml_result, $signature, $private_key_get);
		openssl_free_key($private_key_get);
		$treasure_data['INFO']['SIGNED_MSG'] = bin2hex($signature);
		$xml_result = self::builderXML($treasure_data,"AIPG","GBK");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, self::TL_REAL_URl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_result);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$return_data = curl_exec($ch);
		curl_close($ch);
		$return_xml_result = simplexml_load_string($return_data);
		return $return_xml_result->INFO;
	}
	
}

?>