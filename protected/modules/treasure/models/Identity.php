<?php

/**
 * This is the model class for table "{{identity}}".
 *
 * The followings are the available columns in table '{{identity}}':
 * @property string $identity_id
 * @property string $user_id
 * @property string $real_name
 * @property string $identity_num
 * @property string $identity_positive
 * @property string $identity_negative
 * @property integer $status
 * @property string $check_manager
 * @property integer $check_time
 * @property string $check_remark
 * @property integer $add_time
 * @property string $add_ip
 */
class Identity extends CActiveRecord
{
    public $sh_status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Identity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{identity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identity_id, user_id, real_name, identity_num, identity_positive, identity_negative, status, check_manager, check_time, check_remark, add_time, add_ip', 'required'),
			array('status, check_time, add_time', 'numerical', 'integerOnly'=>true),
                        array('sh_status','required','on'=>'wait_oper'),
                        array('sh_status','numerical','on'=>'wait_oper'),
			array('identity_id, user_id, check_manager', 'length', 'max'=>18),
			array('real_name', 'length', 'max'=>24),
			array('identity_num, add_ip', 'length', 'max'=>20),
			array('identity_positive, identity_negative', 'length', 'max'=>50),
			array('check_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('identity_id, user_id, real_name, identity_num, identity_positive, identity_negative, status, check_manager, check_time, check_remark, add_time, add_ip', 'safe', 'on'=>'search'),
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
                    'manager' => array(self::BELONGS_TO, 'Manager', 'manager_id'),
                    'user' => array(self::BELONGS_TO, 'User', 'user_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
            return array(
                'identity_id' => '认证id',
                'user_id' => '用户id',
                'real_name' => '真实姓名',
                'identity_num' => '证件号码',
                'identity_positive' => '身份证正面',
                'identity_negative' => '身份证背面',
                'status' => '审核状态',
                'check_manager' => '审核人',
                'check_time' => '审核时间',
                'check_remark' => '审核备注',
                'add_time' => '申请时间',
                'add_ip' => '申请ip',
                'manager_id' => 'manager_id',
                'manager_name' => 'manager_name',
                'manager_pass' => 'manager_pass',
                'manager_realname' => 'manager_realname',
                'manager_tel' => 'manager_tel',
                'google_status' => 'google_status',
                'google_secret' => 'google_secret',
                'issuper' => 'issuper',
                'login_time' => 'login_time',
                'user_id' => 'user_id',
                'user_name' => '用户名',
                'login_pass' => 'login_pass',
                'pay_pass' => 'pay_pass',
                'user_email' => 'user_email',
                'user_phone' => 'user_phone',
                'home_tel' => 'home_tel',
                'user_qq' => 'user_qq',
                'user_pic' => 'user_pic',
                'real_name' => '真实姓名',
                'card_num' => '证件号码',
                'user_sex' => 'user_sex',
                'user_age' => 'user_age',
                'user_edu' => 'user_edu',
                'birth_place' => 'birth_place',
                'live_place' => 'live_place',
                'user_address' => 'user_address',
                'p_user_id' => 'p_user_id',
                'user_type' => 'user_type',
                'is_email_check' => 'is_email_check',
                'is_phone_check' => 'is_phone_check',
                'is_realname_check' => 'is_realname_check',
                'vip_stop_time' => 'vip_stop_time',
                'is_hook' => 'is_hook',
                'resiter_time' => 'resiter_time',
                'login_time' => 'login_time',
            );
        }
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
                'status' => array(
                    '0' =>'待审核',
                    '1' =>'审核通过',
                    '2' =>'审核失败',
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

		$criteria->compare('identity_id',$this->identity_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('identity_num',$this->identity_num,true);
		$criteria->compare('identity_positive',$this->identity_positive,true);
		$criteria->compare('identity_negative',$this->identity_negative,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('check_manager',$this->check_manager,true);
		$criteria->compare('check_time',$this->check_time);
		$criteria->compare('check_remark',$this->check_remark,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_ip',$this->add_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}