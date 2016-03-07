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
		$manager_info = Manager::model()->findByAttributes(array('manager_name'=>$this->username));
                if(empty($manager_info)){
                    $this->errorCode = self::ERROR_USERNAME_INVALID;
                    return false;
                }elseif($manager_info->manager_pass != LYCommon::get_pass($manager_info ->manager_id,$this -> password)){
                    //密码判断
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                    return false;
                }else{
                    $this->id = $manager_info->manager_id;
                    $this->errorCode = self::ERROR_NONE;
                    return true;
                }
	}
        
        public function getId() {
            return $this->id;
        }
        
}