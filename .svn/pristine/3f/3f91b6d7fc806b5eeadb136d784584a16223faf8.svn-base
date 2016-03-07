<?php

/**
 * This is the model class for table "{{credit}}".
 *
 * The followings are the available columns in table '{{credit}}':
 * @property string $c_id
 * @property string $user_id
 * @property string $amount
 * @property string $real_amount
 * @property integer $status
 * @property string $check_manager
 * @property string $check_remark
 * @property integer $check_time
 * @property integer $add_time
 */
class Credit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{credit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_id, user_id, amount, status, add_time', 'required'),
			array('status, check_time, add_time', 'numerical', 'integerOnly'=>true),
			array('c_id, user_id, check_manager', 'length', 'max'=>18),
			array('amount, real_amount', 'length', 'max'=>12),
			array('check_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('c_id, user_id, amount, real_amount, status, check_manager, check_remark, check_time, add_time', 'safe', 'on'=>'search'),
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
			'c_id' => 'C',
			'user_id' => 'User',
			'amount' => '授信额度',
			'real_amount' => 'Real Amount',
			'status' => '状态(0,已提交、待审核，1；审核中；2，审核通过；3，审核失败)',
			'check_manager' => 'Check Manager',
			'check_remark' => 'Check Remark',
			'check_time' => 'Check Time',
			'add_time' => 'Add Time',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('real_amount',$this->real_amount,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('check_manager',$this->check_manager,true);
		$criteria->compare('check_remark',$this->check_remark,true);
		$criteria->compare('check_time',$this->check_time);
		$criteria->compare('add_time',$this->add_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Credit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
