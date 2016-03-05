<?php

/**
 * This is the model class for table "{{award}}".
 *
 * The followings are the available columns in table '{{award}}':
 * @property string $id
 * @property string $award_name
 * @property string $award_alias
 * @property string $award_content
 * @property string $award_desc
 * @property string $award_check
 * @property integer $award_money
 * @property integer $award_user
 * @property integer $award_all
 * @property string $start_time
 * @property string $end_time
 * @property string $add_time
 * @property string $add_ip
 */
class Award extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{award}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, award_name, award_alias, award_desc, status,award_check, award_money,  start_time, end_time, add_time, add_ip', 'required'),
			array('award_money, award_user, award_all', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>18),
			array('award_name, award_alias, award_desc', 'length', 'max'=>255),
			array('start_time, end_time, add_time, add_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, award_name, award_alias, award_content, award_desc, award_check, award_money, award_user, award_all, start_time, end_time, add_time, add_ip', 'safe', 'on'=>'search'),
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
			'award_name' => '活动名称',
			'award_alias' => '活动别名',
			'award_content' => '活动内容',
			'award_desc' => '活动描述',
			'award_check' => '活动卡券',
			'award_money' => '活动金额',
			'award_user' => '参与人数',
			'award_all' => '参与总额',
			'start_time' => '开始时间',
			'end_time' => '结束时间',
			'status'=>'状态',
			'add_time' => '添加时间',
			'add_ip' => '添加ip',
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
		$criteria->compare('award_name',$this->award_name,true);
		$criteria->compare('award_alias',$this->award_alias,true);
		$criteria->compare('award_content',$this->award_content,true);
		$criteria->compare('award_desc',$this->award_desc,true);
		$criteria->compare('award_check',$this->award_check,true);
		$criteria->compare('award_money',$this->award_money);
		$criteria->compare('award_user',$this->award_user);
		$criteria->compare('award_all',$this->award_all);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
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
	 * @return Award the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
