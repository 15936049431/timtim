<?php

/**
 * This is the model class for table "{{worklog}}".
 *
 * The followings are the available columns in table '{{worklog}}':
 * @property string $worklog_id
 * @property string $worklog_url
 * @property string $manager_id
 * @property string $manager_name
 * @property string $operation_ip
 * @property integer $operation_time
 */
class Worklog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{worklog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('worklog_url, manager_id, manager_name, operation_ip, operation_time', 'required'),
			array('operation_time', 'numerical', 'integerOnly'=>true),
			array('worklog_url', 'length', 'max'=>128),
			array('manager_id', 'length', 'max'=>18),
			array('manager_name', 'length', 'max'=>32),
			array('operation_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('worklog_id, worklog_url, manager_id, manager_name, operation_ip, operation_time', 'safe', 'on'=>'search'),
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
			'worklog_id' => '日志id',
			'worklog_url' => '操作url',
			'manager_id' => '管理员id',
			'manager_name' => '管理员名字',
			'operation_ip' => '操作ip',
			'operation_time' => '操作时间',
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

		$criteria->compare('worklog_id',$this->worklog_id,true);
		$criteria->compare('worklog_url',$this->worklog_url,true);
		$criteria->compare('manager_id',$this->manager_id,true);
		$criteria->compare('manager_name',$this->manager_name,true);
		$criteria->compare('operation_ip',$this->operation_ip,true);
		$criteria->compare('operation_time',$this->operation_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Worklog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
