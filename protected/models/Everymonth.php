<?php

/**
 * This is the model class for table "{{everymonth}}".
 *
 * The followings are the available columns in table '{{everymonth}}':
 * @property string $id
 * @property string $date
 * @property string $recharge
 * @property string $cash
 * @property string $order
 * @property integer $recharge_num
 * @property integer $cash_num
 * @property integer $order_num
 * @property integer $recharge_user
 * @property integer $cash_user
 * @property integer $order_user
 * @property string $project_success
 * @property integer $register_user
 * @property string $pay_interest
 * @property string $cash_fee
 * @property string $manage_fee
 * @property integer $project_num
 * @property string $addtime
 * @property string $addip
 */
class Everymonth extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{everymonth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, date, recharge, cash, order, recharge_num, cash_num, order_num, recharge_user, cash_user, order_user, project_success, register_user, pay_interest, cash_fee, manage_fee, project_num, addtime, addip', 'required'),
			array('recharge_num, cash_num, order_num, recharge_user, cash_user, order_user, register_user, project_num', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>18),
			array('date, addtime, addip', 'length', 'max'=>128),
			array('recharge, cash, order, project_success, pay_interest, cash_fee, manage_fee', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, recharge, cash, order, recharge_num, cash_num, order_num, recharge_user, cash_user, order_user, project_success, register_user, pay_interest, cash_fee, manage_fee, project_num, addtime, addip', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'recharge' => 'Recharge',
			'cash' => 'Cash',
			'order' => 'Order',
			'recharge_num' => 'Recharge Num',
			'cash_num' => 'Cash Num',
			'order_num' => 'Order Num',
			'recharge_user' => 'Recharge User',
			'cash_user' => 'Cash User',
			'order_user' => 'Order User',
			'project_success' => 'Project Success',
			'register_user' => 'Register User',
			'pay_interest' => 'Pay Interest',
			'cash_fee' => 'Cash Fee',
			'manage_fee' => 'Manage Fee',
			'project_num' => 'Project Num',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('recharge',$this->recharge,true);
		$criteria->compare('cash',$this->cash,true);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('recharge_num',$this->recharge_num);
		$criteria->compare('cash_num',$this->cash_num);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('recharge_user',$this->recharge_user);
		$criteria->compare('cash_user',$this->cash_user);
		$criteria->compare('order_user',$this->order_user);
		$criteria->compare('project_success',$this->project_success,true);
		$criteria->compare('register_user',$this->register_user);
		$criteria->compare('pay_interest',$this->pay_interest,true);
		$criteria->compare('cash_fee',$this->cash_fee,true);
		$criteria->compare('manage_fee',$this->manage_fee,true);
		$criteria->compare('project_num',$this->project_num);
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
	 * @return Everymonth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
