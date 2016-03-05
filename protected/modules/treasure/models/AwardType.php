<?php

/**
 * This is the model class for table "{{award_type}}".
 *
 * The followings are the available columns in table '{{award_type}}':
 * @property string $id
 * @property string $name
 * @property integer $money
 * @property integer $use_time
 * @property integer $low_account
 * @property integer $most_account
 * @property integer $min_limit
 * @property integer $max_limit
 * @property string $type
 * @property integer $give_num
 * @property integer $give_money
 * @property string $manager_id
 * @property string $add_time
 * @property string $add_ip
 */
class AwardType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{award_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, money, use_time, low_account,status,description, most_account, min_limit, max_limit, type, give_num, give_money, manager_id, add_time, add_ip', 'required'),
			array('money, use_time, low_account, most_account, min_limit, max_limit, give_num, give_money', 'numerical', 'integerOnly'=>true),
			array('id, manager_id', 'length', 'max'=>18),
			array('name, type', 'length', 'max'=>255),
			array('add_time, add_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, money, use_time, low_account, most_account, min_limit, max_limit, type, give_num, give_money, manager_id, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'manager'=>array(self::BELONGS_TO,'Manager','manager_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名称',
			'money' => '金额',
			'use_time' => '使用期限',
			'low_account' => '最小投资',
			'most_account' => '最大投资',
			'min_limit' => '最小月份',
			'max_limit' => '最大月份',
			'type' => '类型',
			'give_num' => '发放人数',
			'give_money' => '发放总额',
			'manager_id' => '操作管理员',
			'add_time' => '添加时间',
			'add_ip' => '添加ip',
			'status'=>'状态',
			'description'=>'描述'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('use_time',$this->use_time);
		$criteria->compare('low_account',$this->low_account);
		$criteria->compare('most_account',$this->most_account);
		$criteria->compare('min_limit',$this->min_limit);
		$criteria->compare('max_limit',$this->max_limit);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('give_num',$this->give_num);
		$criteria->compare('give_money',$this->give_money);
		$criteria->compare('manager_id',$this->manager_id,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('add_ip',$this->add_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AwardType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
