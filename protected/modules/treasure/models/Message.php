<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property string $m_id
 * @property string $send_user_id
 * @property string $get_user_id
 * @property string $m_con
 * @property integer $is_view
 * @property integer $add_time
 * @property string $remark
 */
class Message extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('m_id, send_user_id, get_user_id, m_con, is_view, add_time, remark', 'required'),
			array('is_view, add_time', 'numerical', 'integerOnly'=>true),
			array('m_id, send_user_id, get_user_id', 'length', 'max'=>18),
			array('m_con', 'length', 'max'=>1024),
			array('remark', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('m_id, send_user_id, get_user_id, m_con, is_view, add_time, remark', 'safe', 'on'=>'search'),
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
			'm_id' => 'M',
			'send_user_id' => 'Send User',
			'get_user_id' => 'Get User',
			'm_con' => 'M Con',
			'is_view' => 'Is View',
			'add_time' => 'Add Time',
			'remark' => 'Remark',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('m_id',$this->m_id,true);
		$criteria->compare('send_user_id',$this->send_user_id,true);
		$criteria->compare('get_user_id',$this->get_user_id,true);
		$criteria->compare('m_con',$this->m_con,true);
		$criteria->compare('is_view',$this->is_view);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}