<?php

/**
 * This is the model class for table "{{oauth}}".
 *
 * The followings are the available columns in table '{{oauth}}':
 * @property string $user_id
 * @property integer $o_type
 * @property string $oauth_id
 * @property integer $add_time
 * @property string $add_ip
 */
class Oauth extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{oauth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, o_type, oauth_id, add_time, add_ip', 'required'),
			array('o_type, add_time', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>18),
			array('oauth_id', 'length', 'max'=>128),
			array('add_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, o_type, oauth_id, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'o_type' => 'O Type',
			'oauth_id' => 'Oauth',
			'add_time' => 'Add Time',
			'add_ip' => 'Add Ip',
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
		$criteria->compare('o_type',$this->o_type);
		$criteria->compare('oauth_id',$this->oauth_id,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_ip',$this->add_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Oauth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
