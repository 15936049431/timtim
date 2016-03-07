<?php

/**
 * This is the model class for table "{{assets_our}}".
 *
 * The followings are the available columns in table '{{assets_our}}':
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $total
 * @property string $money
 * @property string $fee
 * @property string $outmoney
 * @property string $verify_user
 * @property string $verify_remark
 * @property string $verify_time
 * @property string $addtime
 * @property string $addip
 */
class AssetsOur extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{assets_our}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, type, total, money, fee, outmoney,status, verify_user, verify_remark, verify_time, addtime, addip', 'required'),
			array('id, user_id, total, money, fee, outmoney, verify_user', 'length', 'max'=>18),
			array('type, verify_time, addtime, addip', 'length', 'max'=>128),
			array('verify_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, total, money, fee, outmoney, verify_user,status, verify_remark, verify_time, addtime, addip', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','user_id'),
			'verify_user'=>array(self::BELONGS_TO,'Manager','verify_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => '用户名',
			'type' => '类型',
			'total' => '总额',
			'money' => '实际金额',
			'status'=>'状态',
			'fee' => '手续费',
			'outmoney' => '转出金额',
			'verify_user' => '审核人',
			'verify_remark' => '审核备注',
			'verify_time' => '审核时间',
			'addtime' => '添加时间',
			'addip' => '添加ip',
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
		$criteria->compare('outmoney',$this->outmoney,true);
		$criteria->compare('verify_user',$this->verify_user,true);
		$criteria->compare('verify_remark',$this->verify_remark,true);
		$criteria->compare('verify_time',$this->verify_time,true);
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
	 * @return AssetsOur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
