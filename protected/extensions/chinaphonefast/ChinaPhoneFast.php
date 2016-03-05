<?php

class ChinaPhoneFast{
	
	//前台交易请求地址
	const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
//	const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';
	//后台交易请求地址
	const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';
//	const SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';
	//后台交易请求地址(若为有卡交易配置该地址)
	const SDK_Card_Request_Url = 'https://gateway.95516.com/gateway/api/cardTransReq.do';
//	const SDK_Card_Request_Url = 'https://101.231.204.80:5000/gateway/api/cardTransReq.do';
	//单笔查询请求地址
	const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';
//	const SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';
	//批量交易请求地址
	const SDK_BATCH_TRANS_URL = 'https://gateway.95516.com/gateway/api/batchTrans.do';
//	const SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do';
	//文件传输类交易地址
	const SDK_FILE_QUERY_URL = 'https://filedownload.95516.com/';
//	const SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/';
	//APP交易地址
	const SDK_App_Request_Url = 'https://gateway.95516.com/gateway/api/appTransReq.do';
//	const SDK_App_Request_Url = 'https://101.231.204.80:5000/gateway/api/appTransReq.do';
	//注意：请商户按以上域名地址配置通讯接口，强烈建议不要配置具体IP地址，以免出现通讯运营商故障时业务中断的情况
	
        const MERID='898330273920439';
	
	public $SDK_SIGN_CERT_PATH = "";  //签名证书
	public $SDK_SIGN_CERT_PWD = "";  //签名证书密码
	public $SDK_ENCRYPT_CERT_PATH = "" ;  //加密证书配置
	public $SDK_VERIFY_CERT_PATH = "" ; //验签证书路径
	//签名证书类型
	//acpsdk.signCert.type=PKCS12
        public $SDK_VERIFY_CERT_DIR='';
	
	public $SDK_FRONT_NOTIFY_URL = ""; //前台通知地址
	public $SDK_BACK_NOTIFY_URL = ""; //后台通知地址
	
	public $log;
	//注意：请需要配置通讯白名单的商户，将银联通知服务的全部地址都加入白名单中，以免出现通讯运营商故障时无法接收通知服务的情况。
	//文件下载目录
	const SDK_FILE_DOWN_PATH = 'd:/file/';	
	//日志 目录
	const SDK_LOG_FILE_PATH = 'D:/logs/';
	//日志级别
	const SDK_LOG_LEVEL = 'INFO';
	
	public function __construct() {
		$this->SDK_SIGN_CERT_PATH = Yii::getPathOfAlias('ext') . '/chinaphonefast/zs.pfx';//PM_700000000000001_acp.pfx  700000000000001_acp.p12 qq.pfcx
		$this->SDK_VERIFY_CERT_PATH = Yii::getPathOfAlias('ext') . '/chinaphonefast/EbppRsaCert.cer';
		$this->SDK_ENCRYPT_CERT_PATH = Yii::getPathOfAlias('ext') . '/chinaphonefast/encryptpub.cer';
		$this->SDK_SIGN_CERT_PWD = '000000';
                $this->SDK_VERIFY_CERT_DIR= Yii::getPathOfAlias('ext') . '/chinaphonefast/';
		$this->SDK_FRONT_NOTIFY_URL = Yii::app()->request->hostInfo . '/wap/async/cprechargeret.html';
		$this->SDK_BACK_NOTIFY_URL = Yii::app()->request->hostInfo . '/wap/async/cprechargenf.html';
		include_once Yii::getPathOfAlias('ext') . '/chinaphonefast/log.class.php';
		$this->log = new PhpLog(Yii::getPathOfAlias('ext') . '/chinaphonefast/', "PRC", 'DEBUG');
	}
	
	/**
	 * 数组 排序后转化为字体串
	 * @param array $params
	 * @return string
	 */
	function coverParamsToString($params) {
		$sign_str = '';
		// 排序
		ksort ( $params );
		foreach ( $params as $key => $val ) {
			if ($key == 'signature') {
				continue;
			}
			$sign_str .= sprintf ( "%s=%s&", $key, $val );
			// $sign_str .= $key . '=' . $val . '&';
		}
		return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
	}
	
	/**
	 * 字符串转换为 数组
	 * @param unknown_type $str
	 * @return multitype:unknown
	 */
	function coverStringToArray($str) {
		$result = array ();
		if (! empty ( $str )) {
			$temp = preg_split ( '/&/', $str );
			if (! empty ( $temp )) {
				foreach ( $temp as $key => $val ) {
					$arr = preg_split ( '/=/', $val, 2 );
					if (! empty ( $arr )) {
						$k = $arr ['0'];
						$v = $arr ['1'];
						$result [$k] = $v;
					}
				}
			}
		}
		return $result;
	}
	
	/**
	 * 处理返回报文 解码客户信息 , 如果编码为utf-8 则转为utf-8
	 * @param unknown_type $params
	 */
	function deal_params(&$params) {
		/**
		 * 解码 customerInfo
		 */
		if (! empty ( $params ['customerInfo'] )) {
			$params ['customerInfo'] = base64_decode ( $params ['customerInfo'] );
		}
	
		if (! empty ( $params ['encoding'] ) && strtoupper ( $params ['encoding'] ) == 'utf-8') {
			foreach ( $params as $key => $val ) {
				$params [$key] = iconv ( 'utf-8', 'UTF-8', $val );
			}
		}
	}
	
	/**
	 * 压缩文件 对应java deflate
	 * @param unknown_type $params
	 */
	function deflate_file(&$params) {
		global $log;
		foreach ( $_FILES as $file ) {
			$log->LogInfo ( "---------处理文件---------" );
			if (file_exists ( $file ['tmp_name'] )) {
				$params ['fileName'] = $file ['name'];
				$file_content = file_get_contents ( $file ['tmp_name'] );
				$file_content_deflate = gzcompress ( $file_content );
				$params ['fileContent'] = base64_encode ( $file_content_deflate );
				$log->LogInfo ( "压缩后文件内容为>" . base64_encode ( $file_content_deflate ) );
			} else {
				$log->LogInfo ( ">>>>文件上传失败<<<<<" );
			}
		}
	}
	
	/**
	 * 处理报文中的文件
	 *
	 * @param unknown_type $params
	 */
	function deal_file($params) {
		if (isset ( $params ['fileContent'] )) {
			$this->log->LogInfo ( "---------处理后台报文返回的文件---------" );
			$fileContent = $params ['fileContent'];
			if (empty ( $fileContent )) {
				$this->log->LogInfo ( '文件内容为空' );
			} else {
				// 文件内容 解压缩
				$content = gzuncompress ( base64_decode ( $fileContent ) );
				$root = self::SDK_FILE_DOWN_PATH;
				$filePath = null;
				if (empty ( $params ['fileName'] )) {
					$this->log->LogInfo ( "文件名为空" );
					$filePath = $root . $params ['merId'] . '_' . $params ['batchNo'] . '_' . $params ['txnTime'] . '.txt';
				} else {
					$filePath = $root . $params ['fileName'];
				}
				$handle = fopen ( $filePath, "w+" );
				if (! is_writable ( $filePath )) {
					$this->log->LogInfo ( "文件:" . $filePath . "不可写，请检查！" );
				} else {
					file_put_contents ( $filePath, $content );
					$this->log->LogInfo ( "文件位置 >:" . $filePath );
				}
				fclose ( $handle );
			}
		}
	}
	
	/**
	 * 构造自动提交表单
	 *
	 * @param unknown_type $params
	 * @param unknown_type $action
	 * @return string
	 */
	function create_html($params, $action) {
		$encodeType = isset ( $params ['encoding'] ) ? $params ['encoding'] : 'UTF-8';
		$html = <<<eot
			<html>
			<head>
    		<meta http-equiv="Content-Type" content="text/html; charset={$encodeType}" />
			</head>
			<body  onload="javascript://document.pay_form.submit();">
    		<form id="pay_form" name="pay_form" action="{$action}" method="post">		
eot;
		foreach ( $params as $key => $value ) {
			$html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
		}
		$html .= <<<eot
    		<input type="submit" >
    		</form>
			</body>
			</html>
eot;
		return $html;
	}
	
	/**
	 * 后台交易 HttpClient通信
	 * @param unknown_type $params
	 * @param unknown_type $url
	 * @return mixed
	 */
	function sendHttpRequest($params, $url) {
		$opts = getRequestParamString ( $params );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);//不验证证书
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false);//不验证HOST
		curl_setopt ( $ch, CURLOPT_SSLVERSION, 3);
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-type:application/x-www-form-urlencoded;charset=UTF-8'
		) );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );
		/**
		 * 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
		*/
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$html = curl_exec ( $ch );
		curl_close ( $ch );
		return $html;
	}
	
	/**
	 * 组装报文
	 * @param unknown_type $params
	 * @return string
	 */
	function getRequestParamString($params) {
		$params_str = '';
		foreach ( $params as $key => $value ) {
			$params_str .= ($key . '=' . (!isset ( $value ) ? '' : urlencode( $value )) . '&');
		}
		return substr ( $params_str, 0, strlen ( $params_str ) - 1 );
	}
	
	/**
	 * Author: gu_yongkang
	 * data: 20110510
	 * 密码转PIN
	 * Enter description here ...
	 * @param $spin
	 */
	function  Pin2PinBlock( &$sPin ){
		//	$sPin = "123456";
		$iTemp = 1;
		$sPinLen = strlen($sPin);
		$sBuf = array();
		//密码域大于10位
		$sBuf[0]=intval($sPinLen, 10);
		if($sPinLen % 2 ==0){
			for ($i=0; $i<$sPinLen;){
				$tBuf = substr($sPin, $i, 2);
				$sBuf[$iTemp] = intval($tBuf, 16);
				unset($tBuf);
				if ($i == ($sPinLen - 2)){
					if ($iTemp < 7){
						$t = 0;
						for ($t=($iTemp+1); $t<8; $t++){
						$sBuf[$t] = 0xff;
							}
					}
				}
				$iTemp++;
				$i = $i + 2;	//linshi
			}
		}else{
			for ($i=0; $i<$sPinLen;){
				if ($i ==($sPinLen-1)){
					$mBuf = substr($sPin, $i, 1) . "f";
					$sBuf[$iTemp] = intval($mBuf, 16);
					unset($mBuf);
					if (($iTemp)<7){
						$t = 0;
						for ($t=($iTemp+1); $t<8; $t++){
							$sBuf[$t] = 0xff;
						}
					}
				}else{
					$tBuf = substr($sPin, $i, 2);
					$sBuf[$iTemp] = intval($tBuf, 16);
					unset($tBuf);
				}
				$iTemp++;
				$i = $i + 2;
			}
		}
		return $sBuf;
	}
	/**
	 * Author: gu_yongkang
	 * data: 20110510
	 * Enter description here ...
	 * @param $sPan
	 */
	 function FormatPan(&$sPan){
		$iPanLen = strlen($sPan);
		$iTemp = $iPanLen - 13;
		$sBuf = array();
		$sBuf[0] = 0x00;
		$sBuf[1] = 0x00;
		for ($i=2; $i<8; $i++){
			$tBuf = substr($sPan, $iTemp, 2);
			$sBuf[$i] = intval($tBuf, 16);
			$iTemp = $iTemp + 2;
		}
		return $sBuf;
	}
	
	function Pin2PinBlockWithCardNO(&$sPin, &$sCardNO){
		$sPinBuf = Pin2PinBlock($sPin);
		$iCardLen = strlen($sCardNO);
		//		$log->LogInfo("CardNO length : " . $iCardLen);
		if ($iCardLen <= 10){
			return (1);
		}elseif ($iCardLen==11){
			$sCardNO = "00" . $sCardNO;
		}elseif ($iCardLen==12){
			$sCardNO = "0" . $sCardNO;
		}
		$sPanBuf = FormatPan($sCardNO);
		$sBuf = array();
		for ($i=0; $i<8; $i++){
			//			$sBuf[$i] = $sPinBuf[$i] ^ $sPanBuf[$i];	//十进制
			//			$sBuf[$i] = vsprintf("%02X", ($sPinBuf[$i] ^ $sPanBuf[$i]));
			$sBuf[$i] = vsprintf("%c", ($sPinBuf[$i] ^ $sPanBuf[$i]));
		}
		unset($sPinBuf);
		unset($sPanBuf);
		//		return $sBuf;
		$sOutput = implode("", $sBuf);	//数组转换为字符串
		return $sOutput;
	}
	
	function EncryptedPin($sPin, $sCardNo ,$sPubKeyURL){
		$sPubKeyURL = trim(SDK_ENCRYPT_CERT_PATH," ");
		//	$log->LogInfo("DisSpaces : " . PubKeyURL);
		$fp = fopen($sPubKeyURL, "r");
		if ($fp != NULL){
			$sCrt = fread($fp, 8192);
			//		$log->LogInfo("fread PubKeyURL : " . $sCrt);
			fclose($fp);
		}
		$sPubCrt = openssl_x509_read($sCrt);
		if ($sPubCrt === FALSE){
			print("openssl_x509_read in false!");
			return (-1);
		}
		//	$log->LogInfo($sPubCrt);
		//	$sPubKeyId = openssl_x509_parse($sCrt);
		//	$log->LogInfo($sPubKeyId);
		$sPubKey = openssl_x509_parse($sPubCrt);
		//	$log->LogInfo($sPubKey);
		//	openssl_x509_free($sPubCrt);
		//	print_r(openssl_get_publickey($sCrt));
		$sInput = Pin2PinBlockWithCardNO($sPin, $sCardNo);
		if ($sInput == 1){
			print("Pin2PinBlockWithCardNO Error ! : " . $sInput);
			return (1);
		}
		$iRet = openssl_public_encrypt($sInput, $sOutData, $sCrt, OPENSSL_PKCS1_PADDING);
		if ($iRet === TRUE){
			//		$log->LogInfo($sOutData);
			$sBase64EncodeOutData = base64_encode($sOutData);
			//print("PayerPin : " . $sBase64EncodeOutData);
			return $sBase64EncodeOutData;
		}else{
			print("openssl_public_encrypt Error !");
			return (-1);
		}
	}
	
	function sign(&$params) {
		$this->log->LogInfo ( '=====sign begin======' );
		if(isset($params['transTempUrl'])){
			unset($params['transTempUrl']);
		}
		// 转换成key=val&串
		$params_str = $this->coverParamsToString ( $params );
		$this->log->LogInfo ( "sign key=val&... >" . $params_str );
	
		$params_sha1x16 = sha1 ( $params_str, FALSE );
		$this->log->LogInfo ( "sha1x16 >" . $params_sha1x16 );
		// 签名证书路径
		$cert_path = $this->SDK_SIGN_CERT_PATH;
		$private_key = $this->getPrivateKey ( $cert_path );
		// 签名
		$sign_falg = openssl_sign ( $params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1 );
		if ($sign_falg) {
			$signature_base64 = base64_encode ( $signature );
			$this->log->LogInfo ( "sign result >" . $signature_base64 );
			$params ['signature'] = $signature_base64;
		} else {
			$this->log->LogInfo ( ">>>>>sign failure<<<<<<<" );
		}
		$this->log->LogInfo ( '=====sign over======' );
	}
	
	/**
	 * 验签
	 *
	 * @param String $params_str
	 * @param String $signature_str
	 */
	function verify($params) {
		// 公钥
		$public_key = $this->getPulbicKeyByCertId ($params ['certId'] );
		//	echo $public_key.'<br/>';
		// 签名串
		$signature_str = $params ['signature'];
		unset ( $params ['signature'] );
		$params_str = $this->coverParamsToString ( $params );
		$this->log->LogInfo ( 'sign withput[signature] key=val&>:' . $params_str );
		$signature = base64_decode ( $signature_str );
		//	echo date('Y-m-d',time());
		$params_sha1x16 = sha1 ( $params_str, FALSE );
		$this->log->LogInfo ( 'shax16>' . $params_sha1x16 );
		$isSuccess = openssl_verify ( $params_sha1x16, $signature,$public_key, OPENSSL_ALGO_SHA1 );
		$this->log->LogInfo ( $isSuccess ? 'ok' : 'false' );
		return $isSuccess;
	}
	
	/**
	 * 根据证书ID 加载 证书
	 *
	 * @param unknown_type $certId
	 * @return string NULL
	 */
	function getPulbicKeyByCertId($certId) {
		$this->log->LogInfo ( 'return ID>' . $certId );
		// 证书目录
		$cert_dir = $this->SDK_VERIFY_CERT_DIR;
		$this->log->LogInfo ( 'zhengshumulu :>' . $cert_dir );
		$handle = opendir ( $cert_dir );
		if ($handle) {
			while ( $file = readdir ( $handle ) ) {
				clearstatcache ();
				$filePath = $cert_dir . '/' . $file;
				if (is_file ( $filePath )) {
					if (pathinfo ( $file, PATHINFO_EXTENSION ) == 'cer') {
						if (@$this->getCertIdByCerPath ( $filePath ) == $certId) {
							closedir ( $handle );
							$this->log->LogInfo ( 'jiazaizhengshu ok' );
							return $this->getPublicKey ( $filePath );
						}
					}
				}
			}
			$this->log->LogInfo ( 'can find[' . $certId . ']dezshu ' );
		} else {
			$this->log->LogInfo ( 'zhengshumulu ' . $cert_dir . 'not ok' );
		}
		closedir ( $handle );
		return null;
	}
	
	/**
	 * 取证书ID(.pfx)
	 * @return unknown
	 */
	function getCertId($cert_path) {
		$pkcs12certdata = file_get_contents ( $cert_path );
		openssl_pkcs12_read ( $pkcs12certdata, $certs, $this->SDK_SIGN_CERT_PWD );
		$x509data = $certs ['cert'];
		openssl_x509_read ( $x509data );
		$certdata = openssl_x509_parse ( $x509data );
		$cert_id = $certdata ['serialNumber'];
		return $cert_id;
	}
	
	/**
	 * 取证书ID(.cer)
	 * @param unknown_type $cert_path
	 */
	function getCertIdByCerPath($cert_path) {
		$x509data = file_get_contents ( $cert_path );
		openssl_x509_read ( $x509data );
		$certdata = openssl_x509_parse ( $x509data );
		$cert_id = $certdata ['serialNumber'];
		return $cert_id;
	}
	
	/**
	 * 签名证书ID
	 * @return unknown
	 */
	function getSignCertId() {
		// 签名证书路径
		return $this->getCertId ( $this->SDK_SIGN_CERT_PATH );
	}
	function getEncryptCertId() {
		// 签名证书路径
		return $this->getCertIdByCerPath ( $this->SDK_ENCRYPT_CERT_PATH );
	}
	
	/**
	 * 取证书公钥 -验签
	 * @return string
	 */
	function getPublicKey($cert_path) {
		return file_get_contents ( $cert_path );
	}
	
	/**
	 * 返回(签名)证书私钥 -
	 * @return unknown
	 */
	function getPrivateKey($cert_path) {
		$pkcs12 = file_get_contents ( $cert_path );
		openssl_pkcs12_read ( $pkcs12, $certs, $this->SDK_SIGN_CERT_PWD );
		return $certs ['pkey'];
	}
	
	/**
	 * 加密 卡号
	 * @param String $pan
	 *        	卡号
	 * @return String
	 */
	function encryptPan($pan) {
		$cert_path = MPI_ENCRYPT_CERT_PATH;
		$public_key = getPublicKey ( $cert_path );
		openssl_public_encrypt ( $pan, $cryptPan, $public_key );
		return base64_encode ( $cryptPan );
	}
	/**
	 * pin 加密
	 * @param unknown_type $pan
	 * @param unknown_type $pwd
	 * @return Ambigous <number, string>
	 */
	function encryptPin($pan, $pwd) {
		$cert_path = SDK_ENCRYPT_CERT_PATH;
		$public_key = getPublicKey ( $cert_path );
		return EncryptedPin ( $pwd, $pan, $public_key );
	}
	/**
	 * cvn2 加密
	 * @param unknown_type $cvn2
	 * @return unknown
	 */
	function encryptCvn2($cvn2) {
		$cert_path = SDK_ENCRYPT_CERT_PATH;
		$public_key = getPublicKey ( $cert_path );
		openssl_public_encrypt ( $cvn2, $crypted, $public_key );
		return base64_encode ( $crypted );
	}
	/**
	 * 加密 有效期
	 * @param unknown_type $certDate
	 * @return unknown
	 */
	function encryptDate($certDate) {
		$cert_path = SDK_ENCRYPT_CERT_PATH;
		$public_key = getPublicKey ( $cert_path );
		openssl_public_encrypt ( $certDate, $crypted, $public_key );
		return base64_encode ( $crypted );
	}
	
	/**
	 * 加密 数据
	 * @param unknown_type $certDatatype
	 * @return unknown
	 */
	function encryptDateType($certDataType) {
		$cert_path = SDK_ENCRYPT_CERT_PATH;
		$public_key = getPublicKey ( $cert_path );
		openssl_public_encrypt ( $certDataType, $crypted, $public_key );
		return base64_encode ( $crypted );
	}
	
}

?>