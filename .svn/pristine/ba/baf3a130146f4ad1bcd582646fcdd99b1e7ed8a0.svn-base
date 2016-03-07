<?php

/**
 * This is the model class for table "{{codecat}}".
 *
 * The followings are the available columns in table '{{codecat}}':
 * @property string $codecat_id
 * @property string $codecat_alias
 * @property string $codecat_name
 * @property string $codecat_desc
 * @property integer $codecat_type
 * @property integer $add_time
 *
 * The followings are the available model relations:
 * @property Code[] $codes
 */
class Codecat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{codecat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codecat_id, codecat_alias, codecat_name, codecat_desc, codecat_type, add_time', 'required'),
			array('codecat_type, add_time', 'numerical', 'integerOnly'=>true),
			array('codecat_id', 'length', 'max'=>18),
			array('codecat_alias, codecat_name', 'length', 'max'=>32),
			array('codecat_desc', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codecat_id, codecat_alias, codecat_name, codecat_desc, codecat_type, add_time', 'safe', 'on'=>'search'),
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
			'codes' => array(self::HAS_MANY, 'Code', 'codecat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codecat_id' => 'Codecat',
			'codecat_alias' => 'Codecat Alias',
			'codecat_name' => 'Codecat Name',
			'codecat_desc' => 'Codecat Desc',
			'codecat_type' => 'Codecat Type',
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

		$criteria->compare('codecat_id',$this->codecat_id,true);
		$criteria->compare('codecat_alias',$this->codecat_alias,true);
		$criteria->compare('codecat_name',$this->codecat_name,true);
		$criteria->compare('codecat_desc',$this->codecat_desc,true);
		$criteria->compare('codecat_type',$this->codecat_type);
		$criteria->compare('add_time',$this->add_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Codecat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
