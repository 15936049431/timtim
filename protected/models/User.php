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
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
			array('user_id, user_name, login_pass, pay_pass, user_email, user_phone, home_tel, user_qq, user_pic, real_name, card_num, user_sex, user_age, user_edu, birth_place, live_place, user_address, p_user_id, user_type, is_email_check, is_phone_check, is_realname_check, vip_stop_time, is_hook, resiter_time, login_time', 'required'),
			array('user_sex, user_age, user_edu, user_type, is_email_check, is_phone_check, is_realname_check, vip_stop_time, is_hook, resiter_time, login_time', 'numerical', 'integerOnly'=>true),
			array('user_id, p_user_id', 'length', 'max'=>18),
			array('user_name, home_tel, real_name', 'length', 'max'=>16),
			array('login_pass, pay_pass', 'length', 'max'=>32),
			array('user_email, user_pic', 'length', 'max'=>64),
			array('user_phone', 'length', 'max'=>11),
			array('user_qq', 'length', 'max'=>20),
			array('card_num', 'length', 'max'=>40),
			array('birth_place, live_place, user_address', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, login_pass, pay_pass, user_email, user_phone, home_tel, user_qq, user_pic, real_name, card_num, user_sex, user_age, user_edu, birth_place, live_place, user_address, p_user_id, user_type, is_email_check, is_phone_check, is_realname_check, vip_stop_time, is_hook, resiter_time, login_time', 'safe', 'on'=>'search'),
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
			'login_pass' => 'Login Pass',
			'pay_pass' => 'Pay Pass',
			'user_email' => 'User Email',
			'user_phone' => 'User Phone',
			'home_tel' => 'Home Tel',
			'user_qq' => 'User Qq',
			'user_pic' => 'User Pic',
			'real_name' => 'Real Name',
			'card_num' => 'Card Num',
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
		);
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('login_pass',$this->login_pass,true);
		$criteria->compare('pay_pass',$this->pay_pass,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('home_tel',$this->home_tel,true);
		$criteria->compare('user_qq',$this->user_qq,true);
		$criteria->compare('user_pic',$this->user_pic,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('card_num',$this->card_num,true);
		$criteria->compare('user_sex',$this->user_sex);
		$criteria->compare('user_age',$this->user_age);
		$criteria->compare('user_edu',$this->user_edu);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('live_place',$this->live_place,true);
		$criteria->compare('user_address',$this->user_address,true);
		$criteria->compare('p_user_id',$this->p_user_id,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('is_email_check',$this->is_email_check);
		$criteria->compare('is_phone_check',$this->is_phone_check);
		$criteria->compare('is_realname_check',$this->is_realname_check);
		$criteria->compare('vip_stop_time',$this->vip_stop_time);
		$criteria->compare('is_hook',$this->is_hook);
		$criteria->compare('resiter_time',$this->resiter_time);
		$criteria->compare('login_time',$this->login_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}