<?php

/**
 * This is the model class for table "jy_user".
 *
 * The followings are the available columns in table 'jy_user':
 * @property string $user_id
 * @property string $user_name
 * @property string $login_pass
 * @property string $pay_pass
 * @property string $user_pic
 * @property integer $user_sex
 * @property string $user_email
 * @property string $home_tel
 * @property string $user_phone
 * @property string $real_name
 * @property string $card_num
 * @property integer $user_type
 * @property string $user_attr
 * @property integer $check_realname_status
 * @property integer $register_time
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
			array('user_id, user_name, login_pass, pay_pass, user_sex, user_email, user_phone, real_name, card_num, user_type, register_time', 'required'),
			array('user_sex, user_type, register_time', 'numerical', 'integerOnly'=>true),
                        array('user_email','unique'),
			array('user_id, card_num', 'length', 'max'=>18),
			array('user_name, real_name', 'length', 'max'=>32),
			array('login_pass, pay_pass, user_pic', 'length', 'max'=>64),
			array('user_email', 'length', 'max'=>48),
			array('home_tel, user_phone', 'length', 'max'=>24),
                        array('user_pic', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'maxSize'=>2048152, 'tooLarge' => '{file}文件不能超过 2MB. 请上传小一点儿的文件.',),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, login_pass, pay_pass, user_pic, user_sex, user_email, home_tel, user_phone, real_name, card_num, user_type, user_attr, register_time', 'safe', 'on'=>'search'),
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
                    'assets'=>array(self::BELONGS_TO,'Assets','user_id'),
					'invite'=>array(self::BELONGS_TO,'User','p_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('user_id' => '用户ID','user_name' => '用户名','login_pass' => '用户密码','pay_pass' => '支付密码','user_pic' => '用户头像','user_sex' => '用户性别','user_email' => '用户邮箱','home_tel' => '家庭电话','user_phone' => '用户手机','real_name' => '真实姓名','card_num' => '证件号码','user_address' => '联系地址','user_type' => '用户类型','user_attr' => 'user_attr','register_time' => '注册时间',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array(
		'user_sex' => array('0' =>'保密','1' =>'男','2' =>'女',)
		,);
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('p_user_id',$this->p_user_id,true);
		$criteria->compare('login_pass',$this->login_pass,true);
		$criteria->compare('pay_pass',$this->pay_pass,true);
		$criteria->compare('user_pic',$this->user_pic,true);
		$criteria->compare('user_sex',$this->user_sex);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('home_tel',$this->home_tel,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('card_num',$this->card_num,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('user_attr',$this->user_attr,true);
		$criteria->compare('check_realname_status',$this->check_realname_status);
		$criteria->compare('register_time',$this->register_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}