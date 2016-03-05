<?php

/**
 * This is the model class for table "{{assets_cash}}".
 *
 * The followings are the available columns in table '{{assets_cash}}':
 * @property string $c_id
 * @property string $c_user_id
 * @property integer $c_status
 * @property string $c_cardNum
 * @property string $c_bank
 * @property string $c_branch
 * @property string $c_money
 * @property string $c_realmoney
 * @property string $c_fee
 * @property string $c_verify_user
 * @property string $c_verify_time
 * @property string $c_verify_remark
 * @property string $c_addtime
 * @property string $c_addip
 */
class AssetsCash extends CActiveRecord
{
	public $authcode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{assets_cash}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_id, c_user_id, c_status, c_cardNum, c_bank, c_money, c_realmoney, c_fee, c_addtime, c_addip', 'required'),
			array('c_status', 'numerical', 'integerOnly'=>true),
			array('c_id, c_user_id, c_bank, c_verify_user', 'length', 'max'=>18),
			array('c_cardNum, c_verify_time, c_addtime, c_addip', 'length', 'max'=>128),
			array('c_branch, c_verify_remark', 'length', 'max'=>255),
			array('c_money, c_realmoney, c_fee', 'length', 'max'=>11),
			array('authcode','captcha','message'=>'验证码不正确'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('c_id, c_user_id, c_status, c_cardNum, c_bank, c_branch, c_money, c_realmoney, c_fee, c_verify_user, c_verify_time, c_verify_remark, c_addtime, c_addip', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'Item', 'c_bank'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'c_id' => 'C',
			'c_user_id' => '用户ID',
			'c_status' => '状态0未审，1通过，2失败',
			'c_cardNum' => '银行卡号',
			'c_bank' => '银行',
			'c_branch' => '银行支行',
			'c_money' => '提现金额',
			'c_realmoney' => '到账金额',
			'c_fee' => '提现手续费',
			'c_verify_user' => '提现审核人员',
			'c_verify_time' => '提现审核时间',
			'c_verify_remark' => '提现审核备注',
			'c_addtime' => '添加时间',
			'c_addip' => '添加IP',
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

		$criteria->compare('c_id',$this->c_id,true);
		$criteria->compare('c_user_id',$this->c_user_id,true);
		$criteria->compare('c_status',$this->c_status);
		$criteria->compare('c_cardNum',$this->c_cardNum,true);
		$criteria->compare('c_bank',$this->c_bank,true);
		$criteria->compare('c_branch',$this->c_branch,true);
		$criteria->compare('c_money',$this->c_money,true);
		$criteria->compare('c_realmoney',$this->c_realmoney,true);
		$criteria->compare('c_fee',$this->c_fee,true);
		$criteria->compare('c_verify_user',$this->c_verify_user,true);
		$criteria->compare('c_verify_time',$this->c_verify_time,true);
		$criteria->compare('c_verify_remark',$this->c_verify_remark,true);
		$criteria->compare('c_addtime',$this->c_addtime,true);
		$criteria->compare('c_addip',$this->c_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetsCash the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
