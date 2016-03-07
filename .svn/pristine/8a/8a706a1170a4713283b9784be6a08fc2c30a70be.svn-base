<?php

/**
 * This is the model class for table "{{integral_order}}".
 *
 * The followings are the available columns in table '{{integral_order}}':
 * @property string $order_id
 * @property string $user_id
 * @property string $foods_id
 * @property string $address_id
 * @property integer $number
 * @property integer $need_integral
 * @property integer $status
 * @property string $address_allwith
 * @property string $send_time
 * @property string $send_order
 * @property string $send_yestime
 * @property string $user_remark
 * @property string $verify_time
 * @property string $verify_user
 * @property string $verify_remark
 * @property string $addtime
 * @property string $addip
 */
class IntegralOrder extends CActiveRecord
{
	public $authcode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{integral_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, user_id, foods_id, number, need_integral,need_all,need_fee, status, address_allwith, addtime, addip', 'required'),
			array('number, need_integral, status', 'numerical', 'integerOnly'=>true),
			array('order_id, user_id, foods_id, address_id, verify_user', 'length', 'max'=>18),
			array('address_allwith, user_remark, verify_remark', 'length', 'max'=>255),
			array('send_time, send_order, send_yestime, verify_time, addtime, addip', 'length', 'max'=>128),
			array('authcode','captcha','message'=>'验证码不正确'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, user_id, foods_id, address_id, number, need_integral, status, address_allwith, send_time, send_order, send_yestime, user_remark, verify_time, verify_user, verify_remark, addtime, addip', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'integral_shop' => array(self::BELONGS_TO, 'IntegralShop', 'foods_id'),
			'integral_address'=>array(self::BELONGS_TO, 'IntegralAddress', 'address_id'),
		);
	}
	
	public static function itemAlias($type, $code = NULL) {
		$_items = array(
				'status' => array('0' =>'申请','1' =>'发货','2'=>'审核拒绝','3'=>'未到货','4'=>'已收件','5'=>'已返还积分'),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'user_id' => 'User',
			'foods_id' => 'Foods',
			'address_id' => 'Address',
			'number' => 'Number',
			'need_integral' => 'Need Integral',
			'status' => 'Status',
			'address_allwith' => 'Address Allwith',
			'send_time' => 'Send Time',
			'send_order' => 'Send Order',
			'send_yestime' => 'Send Yestime',
			'user_remark' => 'User Remark',
			'verify_time' => 'Verify Time',
			'verify_user' => 'Verify User',
			'verify_remark' => 'Verify Remark',
			'addtime' => 'Addtime',
			'addip' => 'Addip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('foods_id',$this->foods_id,true);
		$criteria->compare('address_id',$this->address_id,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('need_integral',$this->need_integral);
		$criteria->compare('status',$this->status);
		$criteria->compare('address_allwith',$this->address_allwith,true);
		$criteria->compare('send_time',$this->send_time,true);
		$criteria->compare('send_order',$this->send_order,true);
		$criteria->compare('send_yestime',$this->send_yestime,true);
		$criteria->compare('user_remark',$this->user_remark,true);
		$criteria->compare('verify_time',$this->verify_time,true);
		$criteria->compare('verify_user',$this->verify_user,true);
		$criteria->compare('verify_remark',$this->verify_remark,true);
		$criteria->compare('addtime',$this->addtime,true);
		$criteria->compare('addip',$this->addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IntegralOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
