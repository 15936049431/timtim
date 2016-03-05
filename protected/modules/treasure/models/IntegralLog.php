<?php

/**
 * This is the model class for table "{{integral_log}}".
 *
 * The followings are the available columns in table '{{integral_log}}':
 * @property string $i_id
 * @property string $i_user_id
 * @property string $i_type_id
 * @property integer $i_value
 * @property string $i_to
 * @property integer $i_now
 * @property string $i_remark
 * @property string $i_addtime
 * @property string $i_addip
 */
class IntegralLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntegralLog the static model class
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
		return '{{integral_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_id, i_user_id, i_type_id, i_value, i_to, i_now, i_remark, i_addtime, i_addip', 'required'),
			array('i_value, i_now', 'numerical', 'integerOnly'=>true),
			array('i_id, i_user_id, i_type_id, i_to', 'length', 'max'=>18),
			array('i_remark', 'length', 'max'=>255),
			array('i_addtime, i_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('i_id, i_user_id, i_type_id, i_value, i_to, i_now, i_remark, i_addtime, i_addip', 'safe', 'on'=>'search'),
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
			'i_id' => 'I',
			'i_user_id' => 'I User',
			'i_type_id' => 'I Type',
			'i_value' => 'I Value',
			'i_to' => 'I To',
			'i_now' => 'I Now',
			'i_remark' => 'I Remark',
			'i_addtime' => 'I Addtime',
			'i_addip' => 'I Addip',
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

		$criteria->compare('i_id',$this->i_id,true);
		$criteria->compare('i_user_id',$this->i_user_id,true);
		$criteria->compare('i_type_id',$this->i_type_id,true);
		$criteria->compare('i_value',$this->i_value);
		$criteria->compare('i_to',$this->i_to,true);
		$criteria->compare('i_now',$this->i_now);
		$criteria->compare('i_remark',$this->i_remark,true);
		$criteria->compare('i_addtime',$this->i_addtime,true);
		$criteria->compare('i_addip',$this->i_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}