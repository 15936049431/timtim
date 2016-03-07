<?php

/**
 * This is the model class for table "{{assets_yue}}".
 *
 * The followings are the available columns in table '{{assets_yue}}':
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $total
 * @property string $money
 * @property string $fee
 * @property string $yuebao_money
 * @property string $addtime
 * @property string $addip
 */
class AssetsYue extends CActiveRecord
{
	public $authcode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{assets_yue}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, type,intype, total, money, fee, yuebao_money,remark, addtime, addip', 'required'),
			array('authcode','required','on'=>'usercenter'),
			array('authcode','captcha','message'=>'验证码不正确','on'=>'usercenter'),
			array('id, user_id, total, money, fee, yuebao_money', 'length', 'max'=>18),
			array('type, addtime, addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, total, money, fee, yuebao_money, addtime, addip', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'total' => 'Total',
			'money' => 'Money',
			'fee' => 'Fee',
			'yuebao_money' => 'Yuebao Money',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('money',$this->money,true);
		$criteria->compare('fee',$this->fee,true);
		$criteria->compare('yuebao_money',$this->yuebao_money,true);
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
	 * @return AssetsYue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
