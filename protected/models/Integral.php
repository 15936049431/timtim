<?php

/**
 * This is the model class for table "{{integral}}".
 *
 * The followings are the available columns in table '{{integral}}':
 * @property string $user_id
 * @property integer $i_total_value
 * @property integer $i_real_value
 * @property integer $i_used_value
 * @property string $i_updatetime
 * @property string $i_addtime
 * @property string $i_addip
 */
class Integral extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{integral}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, i_total_value, i_real_value, i_used_value, i_updatetime, i_addtime, i_addip', 'required'),
			array('i_total_value, i_real_value, i_used_value', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>18),
			array('i_updatetime, i_addtime, i_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, i_total_value, i_real_value, i_used_value, i_updatetime, i_addtime, i_addip', 'safe', 'on'=>'search'),
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
			'i_total_value' => 'I Total Value',
			'i_real_value' => 'I Real Value',
			'i_used_value' => 'I Used Value',
			'i_updatetime' => 'I Updatetime',
			'i_addtime' => 'I Addtime',
			'i_addip' => 'I Addip',
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
		$criteria->compare('i_total_value',$this->i_total_value);
		$criteria->compare('i_real_value',$this->i_real_value);
		$criteria->compare('i_used_value',$this->i_used_value);
		$criteria->compare('i_updatetime',$this->i_updatetime,true);
		$criteria->compare('i_addtime',$this->i_addtime,true);
		$criteria->compare('i_addip',$this->i_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Integral the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
