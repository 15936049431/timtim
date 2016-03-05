<?php

/**
 * This is the model class for table "{{everyday}}".
 *
 * The followings are the available columns in table '{{everyday}}':
 * @property string $id
 * @property string $date
 * @property string $recharge
 * @property integer $recharge_num
 * @property integer $cash_num
 * @property string $order
 * @property integer $order_num
 * @property string $cash
 * @property string $addtime
 * @property string $addip
 * @property string $lasttime
 */
class Everyday extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{everyday}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, date, recharge, recharge_num, cash_num, order, order_num, cash, addtime, addip, lasttime', 'required'),
			array('recharge_num, cash_num, order_num', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>18),
			array('date, addtime, addip, lasttime', 'length', 'max'=>128),
			array('recharge, order, cash', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, recharge, recharge_num, cash_num, order, order_num, cash, addtime, addip, lasttime', 'safe', 'on'=>'search'),
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
			'recharge_num' => 'Recharge Num',
			'cash_num' => 'Cash Num',
			'order' => 'Order',
			'order_num' => 'Order Num',
			'cash' => 'Cash',
			'addtime' => 'Addtime',
			'addip' => 'Addip',
			'lasttime' => 'Lasttime',
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
		$criteria->compare('recharge_num',$this->recharge_num);
		$criteria->compare('cash_num',$this->cash_num);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('cash',$this->cash,true);
		$criteria->compare('addtime',$this->addtime,true);
		$criteria->compare('addip',$this->addip,true);
		$criteria->compare('lasttime',$this->lasttime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Everyday the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
