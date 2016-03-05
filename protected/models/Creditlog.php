<?php

/**
 * This is the model class for table "{{creditlog}}".
 *
 * The followings are the available columns in table '{{creditlog}}':
 * @property string $c_id
 * @property string $user_id
 * @property integer $c_type
 * @property string $c_style
 * @property string $c_credit
 * @property string $now_credit
 * @property string $remark
 * @property integer $add_time
 * @property string $add_ip
 */
class Creditlog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{creditlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_id, user_id, c_type, c_style, c_credit, now_credit, remark, add_time, add_ip', 'required'),
			array('c_type, add_time', 'numerical', 'integerOnly'=>true),
			array('c_id, user_id', 'length', 'max'=>18),
			array('c_style', 'length', 'max'=>128),
			array('c_credit, remark', 'length', 'max'=>255),
			array('now_credit', 'length', 'max'=>12),
			array('add_ip', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('c_id, user_id, c_type, c_style, c_credit, now_credit, remark, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'c_id' => 'C',
			'user_id' => 'User',
			'c_type' => '收支类型（1，收入；2，支出）',
			'c_style' => '场景对应item表',
			'c_credit' => 'C Credit',
			'now_credit' => 'Now Credit',
			'remark' => 'Remark',
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

		$criteria->compare('c_id',$this->c_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('c_type',$this->c_type);
		$criteria->compare('c_style',$this->c_style,true);
		$criteria->compare('c_credit',$this->c_credit,true);
		$criteria->compare('now_credit',$this->now_credit,true);
		$criteria->compare('remark',$this->remark,true);
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
	 * @return Creditlog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
