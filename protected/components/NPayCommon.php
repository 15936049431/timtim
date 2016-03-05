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
	
}

?>