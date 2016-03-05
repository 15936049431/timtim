<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $user_id
 * @property string $user_name
 * @property string $login_pass
 * @property string $pay_pass
 * @property string $user_email
 * @property string $user_phone
 * @property string $home_tel
 * @property string $user_qq
 * @property string $user_pic
 * @property string $real_name
 * @property string $card_num
 * @property integer $user_sex
 * @property integer $user_age
 * @property integer $user_edu
 * @property string $birth_place
 * @property string $live_place
 * @property string $user_address
 * @property string $p_user_id
 * @property integer $user_type
 * @property integer $is_email_check
 * @property integer $is_phone_check
 * @property integer $is_realname_check
 * @property integer $vip_stop_time
 * @property integer $is_hook
 * @property integer $resiter_time
 * @property integer $login_time
 */
class Userprofile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
        public $code;//验证码
        public $new_pass;//新密码
        public $re_new_pass;//重复新密码
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            return array(
                array('login_pass , new_pass, re_new_pass', 'required','on'=>'setnewpass','message'=>'{attribute}不可为空白'),
                array('re_new_pass', 'compare', 'compareAttribute'=>'new_pass','on'=>'setnewpass', 'message'=>'两次密码输入不一致'),
            	array('new_pass','yz_compare_pay_pass','on'=>'setnewpass'),
            	array('new_pass','yz_compare_login_pass','on'=>'setnewpass'),
                
            	//实名认证
            	array('real_name, card_num','required','on'=>'real_name'),
            	array('card_num','unique','on'=>'real_name','message'=>'身份证号码已被使用'),
            	array('card_num','checkCardNum','on'=>'real_name'),
            	array('card_num', 'length', 'max'=>18,'min'=>15, 'on'=>'real_name'),
            	array('card_num', 'match', 'pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/','on'=>'real_name','message'=>'请输入正确的身份证号码'),
                
                //修改支付密码
                array('pay_pass, new_pass, re_new_pass','required','on'=>'change_pay_pass'),//验证原新密码和确认新密码不可为空
                array('re_new_pass','compare','compareAttribute'=>'new_pass','on'=>'change_pay_pass','message'=>'两次密码不一致'),//验证新密码和确认新密码是否一致
                array('pay_pass', 'yz_oldpaypass','on'=>'change_pay_pass'),//验证原密码是否正确
                array('new_pass','yz_compare_login_pass','on'=>'change_pay_pass'),//验证新密码跟登陆密码是否一直。必须不能一致
                array('new_pass','compare','compareAttribute'=>'pay_pass', 'operator'=>'!=','on'=>'change_pay_pass','message'=>'新密码和原密码不可一致'),//验证新密码和确认新密码是否一致
                //设置新支付密码
                array('new_pass, re_new_pass','required','on'=>'setnew_pay_pass'),//验证新密码和确认新密码不可为空
                array('re_new_pass','compare','compareAttribute'=>'new_pass','on'=>'setnew_pay_pass','message'=>'两次密码不一致'),//验证新密码和确认新密码是否一致
                array('new_pass','yz_compare_login_pass','on'=>'setnew_pay_pass'),//验证新密码跟登陆密码是否一直。必须不能一致
            
            	array('code','required','message'=>"验证码不能为空",'on'=>'changephone'),
            	
            	array('code,user_phone','required','message'=>'{attribute}不能为空','on'=>'setphone'),
            	array('user_phone', 'match', 'pattern'=>'/^1[0-9]{10}$/','on'=>'setphone','message'=>'请输入正确的手机号码'),
            		
            	//绑定邮箱
            	array('user_email, code', 'required','on'=>'bind_email'),
            	array('user_email', 'email', 'on'=>'bind_email','message'=>'邮箱格式不正确'),
            );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'user_id' => 'User',
                'user_name' => 'User Name',
                'login_pass' => '原登录密码',
                'pay_pass' => '交易密码',
                'user_email' => '邮箱',
                'user_phone' => '手机号码',
                'home_tel' => 'Home Tel',
                'user_qq' => 'User Qq',
                'user_pic' => 'User Pic',
                'real_name' => '真实姓名',
                'card_num' => '身份证号码',
                'user_sex' => 'User Sex',
                'user_age' => 'User Age',
                'user_edu' => 'User Edu',
                'birth_place' => 'Birth Place',
                'live_place' => 'Live Place',
                'user_address' => 'User Address',
                'p_user_id' => 'P User',
                'user_type' => 'User Type',
                'is_email_check' => 'Is Email Check',
                'is_phone_check' => 'Is Phone Check',
                'is_realname_check' => 'Is Realname Check',
                'vip_stop_time' => 'Vip Stop Time',
                'is_hook' => 'Is Hook',
                'resiter_time' => 'Resiter Time',
                'login_time' => 'Login Time',
                'code'=>'验证码',
                're_new_pass'=>'重复密码',
                'new_pass'=>'新密码',
            );
	}
	
            public function yz_compare_pay_pass(){
            $user_info = $this ->findByPk($this -> user_id);
            if($user_info -> pay_pass == LYCommon::get_pass($user_info->user_id, $this -> new_pass)){
                $this ->addError('pay_pass', '新密码不能跟交易密码相同');
                return false;
            }else{
                return true;
            }
		}
        
        public function yz_oldpaypass(){
            $user_info = $this ->findByPk($this -> user_id);
            if($user_info -> pay_pass == LYCommon::get_pass($user_info->user_id, $this -> pay_pass)){
                return true;
            }else{
                $this ->addError('pay_pass', '原支付密码错误');
                return false;
            }
        }
        
        //验证设置的新密码是否跟登陆密码一样。如果一样则不允许修改
        public function yz_compare_login_pass(){
            $user_info = $this ->findByPk($this -> user_id);
            if($user_info -> login_pass == LYCommon::get_pass($user_info->user_id, $this -> new_pass)){
                $this ->addError('new_pass', '新密码不能跟登陆密码相同');
                return false;
            }else{
                return true;
            }
        }
        
        
        public function checkCardNum() {
            if(!$this->checkIdCard())
                $this -> addError('card_num','身份证格式有误或不存在');
        }
        
        function checkIdCard() {
            $idcard = $this->card_num;
            if (empty($idcard)) {
                return false;
            }

            $iSum = 0;
            $idCardLength = strlen($idcard);
            //长度验证
            if (!preg_match('/^\d{17}(\d|x)$/i', $idcard) and !preg_match('/^\d{15}$/i', $idcard)) {
                return false;
            }

            // 15位身份证验证生日，转换为18位
            if ($idCardLength == 15) {
                $sBirthday = '19' . substr($idcard, 6, 2) . '-' . substr($idcard, 8, 2) . '-' . substr($idcard, 10, 2);
                $d = new DateTime($sBirthday);
                $dd = $d->format('Y-m-d');
                if ($sBirthday != $dd) {
                    return false;
                }
                $idcard = substr($idcard, 0, 6) . "19" . substr($idcard, 6, 9); //15to18
                $Bit18 = $this->getVerifyBit($idcard); //算出第18位校验码
                $idcard = $idcard . $Bit18;
            }
            // 判断是否大于2078年，小于1900年
            $year = substr($idcard, 6, 4);
            if ($year < 1900 || $year > 2078) {
                return false;
            }

            //18位身份证处理
            $sBirthday = substr($idcard, 6, 4) . '-' . substr($idcard, 10, 2) . '-' . substr($idcard, 12, 2);
            $d = new DateTime($sBirthday);
            $dd = $d->format('Y-m-d');
            if ($sBirthday != $dd) {
                return false;
            }
            //身份证编码规范验证
            $idcard_base = substr($idcard, 0, 17);
            if (strtoupper(substr($idcard, 17, 1)) != $this->getVerifyBit($idcard_base)) {
                return false;
            } else {
                return true;
            }
        }

        // 计算身份证校验码，根据国家标准GB 11643-1999
        function getVerifyBit($idcard_base)
        {
                if(strlen($idcard_base) != 17)
                {
                        return false;
                }
                //加权因子
                $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                //校验码对应值
                $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4','3', '2');
                $checksum = 0;
                for ($i = 0; $i < strlen($idcard_base); $i++)
                {
                        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
                }
                $mod = $checksum % 11;
                $verify_number = $verify_number_list[$mod];
                return $verify_number;
        }
        
}