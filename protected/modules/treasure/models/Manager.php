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
class Manager extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JyManager the static model class
	 */
    
        public $repassowrd;
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
			array('manager_id, manager_name, manager_pass, repassowrd, manager_realname, add_time', 'required','message'=>'{attribute}不能为空','on'=>'create'),
			array('manager_id, manager_name', 'required','message'=>'{attribute}不能为空','on'=>'update'),
			array('manager_tel, issuper, google_status, add_time, login_time', 'numerical', 'integerOnly'=>true),
                        array('manager_pass,repassowrd','length','min'=>'8','tooShort'=>'管理员密码最少为8位'),
			array('manager_id', 'length', 'max'=>18),
                        array('repassowrd','compare','compareAttribute'=>'manager_pass','message'=>'两次密码不一致'),
                        array('manager_tel','match','pattern'=>'/^1[0-9]{10}$/'),
			array('manager_name, manager_realname', 'length', 'max'=>32),
			array('manager_pass', 'length', 'max'=>64),
			array('google_secret', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('manager_id, manager_name, manager_pass, manager_realname, manager_role, issuper, google_status, google_secret, add_time, login_time', 'safe', 'on'=>'search'),
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
			'repassowrd' => '确认管理员密码',
			'manager_realname' => '管理员真实姓名',
			'manager_tel' => '管理员手机',
			'google_status' => 'Google认证',
			'google_secret' => 'Google验证码',
			'issuper' => '超级管理员',
			'add_time' => '添加时间',
			'login_time' => '登录时间',
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
}