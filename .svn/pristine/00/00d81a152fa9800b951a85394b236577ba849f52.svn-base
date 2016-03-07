<?php

/**
 * This is the model class for table "jy_manager".
 *
 * The followings are the available columns in table 'jy_manager':
 * @property string $manager_id
 * @property string $manager_name
 * @property string $manager_pass
 * @property string $manager_realname
 * @property integer $manager_role
 * @property integer $add_time
 * @property integer $login_time
 */
class Myself extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JyManager the static model class
	 */
        public $oldpassword;
        public $newpassword;
        public $repassword;
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{manager}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('manager_id', 'required','message'=>'{attribute}不能为空'),
			array('manager_tel, add_time, google_status, login_time', 'numerical', 'integerOnly'=>true),
			array('manager_id', 'length', 'max'=>18),
                        array('manager_tel', 'match', 'pattern'=>'/^1[0-9]{10}$/', 'message'=>'{attribute}格式不正确'),
			array('manager_name, manager_realname', 'unsafe'),
			array('manager_pass', 'length', 'max'=>64),
                        array('google_secret', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        //修改密码  开始
                        array('oldpassword', 'validataold','on'=>'updatepwd'),
                        array('oldpassword, newpassword, repassword','required','on'=>'updatepwd'),
                        array('newpassword, repassword','length','min'=>6,'max'=>18,'tooShort'=>'密码不能小于6位','tooLong'=>'密码不能大于18位','on'=>'updatepwd'),
                        array('repassword','compare','compareAttribute'=>'newpassword','message'=>'两次密码不一致','on'=>'updatepwd'),
                        //修改密码  结束
                    
			array('manager_id, manager_name, manager_pass, google_status, google_secret, manager_realname, manager_role, add_time, login_time', 'safe', 'on'=>'search'),
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
			'manager_id' => 'Manager',
			'manager_name' => '管理员用户名',
			'manager_pass' => '管理员密码',
			'oldpassword' => '原管理员密码',
			'newpassword' => '新管理员密码',
			'repassword' => '确认管理员密码',
			'manager_realname' => '管理员真实姓名',
			'manager_tel' => '管理员手机',
                        'google_status'=>'Google认证',
			'add_time' => '添加时间',
			'login_time' => '登陆时间',
		);
	}
        
        public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'google_status' => array(
                '0' =>'关闭',
                '1' =>'开启',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('manager_id',$this->manager_id,true);
		$criteria->compare('manager_name',$this->manager_name,true);
		$criteria->compare('manager_pass',$this->manager_pass,true);
		$criteria->compare('manager_realname',$this->manager_realname,true);
		$criteria->compare('manager_role',$this->manager_role);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('login_time',$this->login_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function validataold(){
            if(!empty($this->newpassword) && !empty($this->repassword)){
                if($this->manager_pass != LYCommon::get_pass($this -> manager_id, $this -> oldpassword)){
                    $this->addError('oldpassword', '管理员密码错误');
                    return false;
                }else{
                    $this->manager_pass = LYCommon::get_pass($this -> manager_id, $this -> newpassword);
                    return true;
                }
            }
        }
}