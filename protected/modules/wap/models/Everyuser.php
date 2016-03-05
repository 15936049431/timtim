<?php

/**
 * This is the model class for table "{{everyuser}}".
 *
 * The followings are the available columns in table '{{everyuser}}':
 * @property string $user_id
 * @property string $user_recharge
 * @property string $user_cash
 * @property string $user_order
 * @property string $user_project
 * @property string $user_cashfee
 * @property string $user_haverepay
 * @property integer $user_order_num
 * @property integer $user_recharge_num
 * @property integer $user_cash_num
 * @property integer $user_age_area
 * @property integer $user_city_area
 */
class Everyuser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{everyuser}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, user_recharge, user_cash, user_order, user_project, user_cashfee, user_haverepay, user_order_num, user_recharge_num, user_cash_num', 'required'),
			array('user_order_num, user_recharge_num, user_cash_num, user_age_area, user_city_area', 'numerical', 'integerOnly'=>true),
			array('user_id, user_recharge, user_cash, user_order, user_project, user_cashfee, user_haverepay', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_recharge, user_cash, user_order, user_project, user_cashfee, user_haverepay, user_order_num, user_recharge_num, user_cash_num, user_age_area, user_city_area', 'safe', 'on'=>'search'),
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
			'user_recharge' => 'User Recharge',
			'user_cash' => 'User Cash',
			'user_order' => 'User Order',
			'user_project' => 'User Project',
			'user_cashfee' => 'User Cashfee',
			'user_haverepay' => 'User Haverepay',
			'user_order_num' => 'User Order Num',
			'user_recharge_num' => 'User Recharge Num',
			'user_cash_num' => 'User Cash Num',
			'user_age_area' => 'User Age Area',
			'user_city_area' => 'User City Area',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_recharge',$this->user_recharge,true);
		$criteria->compare('user_cash',$this->user_cash,true);
		$criteria->compare('user_order',$this->user_order,true);
		$criteria->compare('user_project',$this->user_project,true);
		$criteria->compare('user_cashfee',$this->user_cashfee,true);
		$criteria->compare('user_haverepay',$this->user_haverepay,true);
		$criteria->compare('user_order_num',$this->user_order_num);
		$criteria->compare('user_recharge_num',$this->user_recharge_num);
		$criteria->compare('user_cash_num',$this->user_cash_num);
		$criteria->compare('user_age_area',$this->user_age_area);
		$criteria->compare('user_city_area',$this->user_city_area);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Everyuser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
