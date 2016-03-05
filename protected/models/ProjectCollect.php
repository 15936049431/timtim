<?php

/**
 * This is the model class for table "{{project_collect}}".
 *
 * The followings are the available columns in table '{{project_collect}}':
 * @property string $p_id
 * @property integer $p_order
 * @property integer $p_status
 * @property string $p_project_order
 * @property string $p_repaytime
 * @property string $p_repayyestime
 * @property string $p_repayaccount
 * @property string $p_repayyesaccount
 * @property string $p_interest
 * @property string $p_realmoney
 * @property integer $p_latedays
 * @property string $p_lateinterest
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectCollect extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_collect}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_id, p_order, p_status, p_user_id,p_project_id, p_project_order, p_repaytime, p_repayaccount, p_interest, p_realmoney, p_addtime, p_addip', 'required'),
			array('p_order, p_status, p_latedays', 'numerical', 'integerOnly'=>true),
			array('p_id, p_project_id, p_project_order', 'length', 'max'=>18),
			array('p_repaytime, p_repayyestime, p_addtime, p_addip', 'length', 'max'=>128),
			array('p_repayaccount, p_repayyesaccount, p_interest, p_realmoney, p_lateinterest', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_order, p_status, p_project_order, p_repaytime, p_repayyestime, p_repayaccount, p_repayyesaccount, p_interest, p_realmoney, p_latedays, p_lateinterest, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
             'project'=>array(self::BELONGS_TO,'Project','p_project_id'),
			 'project_order'=>array(self::BELONGS_TO,'ProjectOrder','p_project_order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'p_id' => 'P',
			'p_order' => 'P Order',
			'p_status' => 'P Status',
			'p_project_order' => 'P Project Order',
			'p_repaytime' => 'P Repaytime',
			'p_repayyestime' => 'P Repayyestime',
			'p_repayaccount' => 'P Repayaccount',
			'p_repayyesaccount' => 'P Repayyesaccount',
			'p_interest' => 'P Interest',
			'p_realmoney' => 'P Realmoney',
			'p_latedays' => 'P Latedays',
			'p_lateinterest' => 'P Lateinterest',
			'p_addtime' => 'P Addtime',
			'p_addip' => 'P Addip',
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

		$criteria->compare('p_id',$this->p_id,true);
		$criteria->compare('p_order',$this->p_order);
		$criteria->compare('p_status',$this->p_status);
		$criteria->compare('p_project_order',$this->p_project_order,true);
		$criteria->compare('p_repaytime',$this->p_repaytime,true);
		$criteria->compare('p_repayyestime',$this->p_repayyestime,true);
		$criteria->compare('p_repayaccount',$this->p_repayaccount,true);
		$criteria->compare('p_repayyesaccount',$this->p_repayyesaccount,true);
		$criteria->compare('p_interest',$this->p_interest,true);
		$criteria->compare('p_realmoney',$this->p_realmoney,true);
		$criteria->compare('p_latedays',$this->p_latedays);
		$criteria->compare('p_lateinterest',$this->p_lateinterest,true);
		$criteria->compare('p_addtime',$this->p_addtime,true);
		$criteria->compare('p_addip',$this->p_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectCollect the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
