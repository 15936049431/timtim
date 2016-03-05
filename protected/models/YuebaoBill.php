<?php

/**
 * This is the model class for table "{{yuebao_bill}}".
 *
 * The followings are the available columns in table '{{yuebao_bill}}':
 * @property string $y_id
 * @property string $user_id
 * @property integer $y_type
 * @property string $y_money
 * @property string $now_yuebao_money
 * @property integer $add_time
 * @property string $add_ip
 * @property string $remark
 */
class YuebaoBill extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{yuebao_bill}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('y_id, user_id, y_type, y_money, now_yuebao_money, add_time, add_ip, remark', 'required'),
			array('y_type, add_time', 'numerical', 'integerOnly'=>true),
			array('y_id, user_id', 'length', 'max'=>18),
			array('y_money, now_yuebao_money', 'length', 'max'=>12),
			array('add_ip', 'length', 'max'=>64),
			array('remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('y_id, user_id, y_type, y_money, now_yuebao_money, add_time, add_ip, remark', 'safe', 'on'=>'search'),
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
			'y_id' => '余额宝交易id',
			'user_id' => 'User',
			'y_type' => '收支类型（1，收入；2，支出）',
			'y_money' => '变动金额',
			'now_yuebao_money' => '余额宝操作后金额',
			'add_time' => '变动时间',
			'add_ip' => 'Add Ip',
			'remark' => '备注（可为空）',
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

		$criteria->compare('y_id',$this->y_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('y_type',$this->y_type);
		$criteria->compare('y_money',$this->y_money,true);
		$criteria->compare('now_yuebao_money',$this->now_yuebao_money,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_ip',$this->add_ip,true);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return YuebaoBill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
