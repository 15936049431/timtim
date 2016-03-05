<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    
        private $id;    //重定义ID
        
        
	public function authenticate()
	{
           $user_model = User::model();
            $user_info = $user_model ->findByAttributes(array('user_name'=>$this->username));
            if(empty($user_info)){
                $user_info = $user_model ->findByAttributes(array('user_phone'=>$this->username,'is_phone_check'=>1));
                if(empty($user_info)){
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                    return false;
                }else{
					if($user_info->login_pass != LYCommon::get_pass($user_info->user_id,$this->password)){
						$this->errorCode=self::ERROR_USERNAME_INVALID;
						return false;
					}else{
						$this->id = $user_info -> user_id;
						$this->username = $user_info -> user_name;
						$this->errorCode = self::ERROR_NONE;
						return true;
					}
                }
            }elseif($user_info->login_pass != LYCommon::get_pass($user_info->user_id,$this->password)){//如果数据库里的密文不等于用户输入的密码(含算法)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
                return false;
            }else{
                $this->id = $user_info -> user_id;
                $this->username = $user_info -> user_name;
                $this->errorCode = self::ERROR_NONE;
                return true;
            }
	}
        
        
        public function getId() {
            return $this->id;
        }
}