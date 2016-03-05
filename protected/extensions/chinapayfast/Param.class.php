<?php

/*
 * @author: 三氧化二砷 waitfox@qq.com
 * @Created:2015-8-10 18:45:02
 * @version:0.01
 * @desc:参数封装类
 * 我只为你回眸一笑，即使不够倾国倾城，我只为你付出此生，换来生再次相守
 */

class Param {
    public $version='5.0.0';//版本号--M
    public $encoding='UTF-8';//编码方式
    public $certId='';//证书ID
    public $signature;//填写对报文摘要的签名
    public $signMethod='01';//取值：01（表示采用RSA）
    public $txnType='';//交易类型，取值72
    public $txnSubType;//交易子类
    public $bizType;//产品类型
    public $channelType;//渠道类型
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        if (!isset($this->$name)) {
            $this->$name ='';
        }
        return $this->$name;
    }
      
}
