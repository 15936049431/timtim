<?php

/**
 * This is the model class for table "{{assets_recharge}}".
 *
 * The followings are the available columns in table '{{assets_recharge}}':
 * @property string $r_id
 * @property string $r_BillNo
 * @property string $r_user_id
 * @property integer $r_status
 * @property string $r_money
 * @property string $r_realmoney
 * @property string $r_fee
 * @property integer $r_type
 * @property string $r_recharge_type
 * @property string $r_return
 * @property string $r_verify_user
 * @property string $r_verify_time
 * @property string $r_verify_remark
 * @property string $r_addtime
 * @property string $r_addip
 */
class AssetsRecharge extends CActiveRecord
{
	public $authcode;
	public $bankCard;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{assets_recharge}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('r_id, r_BillNo, r_user_id, r_money, authcode, r_type, r_recharge_type, r_addtime, r_addip', 'required'),
			array('r_status, r_type', 'numerical', 'integerOnly'=>true),
			array('r_id, r_user_id, r_verify_user', 'length', 'max'=>18),
			array('r_BillNo, r_return, r_verify_remark', 'length', 'max'=>255),
			array('r_BillNo','length','min'=>6),
			array('r_money, r_realmoney, r_fee', 'length', 'max'=>11),
			array('r_recharge_type, r_verify_time, r_addtime, r_addip', 'length', 'max'=>128),
			array('authcode','captcha','message'=>'验证码不正确'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('r_id, r_BillNo, r_user_id, r_status, r_money, r_realmoney, r_fee, r_type, r_recharge_type, r_return, r_verify_user, r_verify_time, r_verify_remark, r_addtime, r_addip', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','r_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'authcode'=>'验证码',
			'r_id' => 'R',
			'r_BillNo' => '流水单号',
			'r_user_id' => 'R User',
			'r_status' => 'R Status',
			'r_money' => '充值金额',
			'r_realmoney' => 'R Realmoney',
			'r_fee' => 'R Fee',
			'r_type' => 'R Type',
			'r_recharge_type' => '充值方式',
			'r_return' => 'R Return',
			'r_verify_user' => 'R Verify User',
			'r_verify_time' => 'R Verify Time',
			'r_verify_remark' => 'R Verify Remark',
			'r_addtime' => 'R Addtime',
			'r_addip' => 'R Addip',
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

		$criteria->compare('r_id',$this->r_id,true);
		$criteria->compare('r_BillNo',$this->r_BillNo,true);
		$criteria->compare('r_user_id',$this->r_user_id,true);
		$criteria->compare('r_status',$this->r_status);
		$criteria->compare('r_money',$this->r_money,true);
		$criteria->compare('r_realmoney',$this->r_realmoney,true);
		$criteria->compare('r_fee',$this->r_fee,true);
		$criteria->compare('r_type',$this->r_type);
		$criteria->compare('r_recharge_type',$this->r_recharge_type,true);
		$criteria->compare('r_return',$this->r_return,true);
		$criteria->compare('r_verify_user',$this->r_verify_user,true);
		$criteria->compare('r_verify_time',$this->r_verify_time,true);
		$criteria->compare('r_verify_remark',$this->r_verify_remark,true);
		$criteria->compare('r_addtime',$this->r_addtime,true);
		$criteria->compare('r_addip',$this->r_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetsRecharge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
