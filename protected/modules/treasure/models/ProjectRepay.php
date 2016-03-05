<?php

/**
 * This is the model class for table "{{project_repay}}".
 *
 * The followings are the available columns in table '{{project_repay}}':
 * @property string $p_id
 * @property integer $p_status
 * @property integer $p_order
 * @property string $p_project_id
 * @property string $p_repaytime
 * @property string $p_repayyestime
 * @property string $p_repayaccount
 * @property string $p_repayyesaccount
 * @property integer $p_lateday
 * @property string $p_lateinterest
 * @property string $p_money
 * @property string $p_interest
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectRepay extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_repay}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_id, p_status, p_order, p_project_id, p_repaytime, p_repayaccount, p_money, p_interest, p_addtime, p_addip', 'required'),
			array('p_status, p_order, p_lateday', 'numerical', 'integerOnly'=>true),
			array('p_id, p_project_id', 'length', 'max'=>18),
			array('p_repaytime, p_repayyestime, p_addtime, p_addip', 'length', 'max'=>128),
			array('p_repayaccount, p_repayyesaccount, p_lateinterest, p_money, p_interest', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_status, p_order, p_project_id, p_repaytime, p_repayyestime, p_repayaccount, p_repayyesaccount, p_lateday, p_lateinterest, p_money, p_interest, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'p_project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'p_id' => 'P',
			'p_status' => '状态',
			'p_order' => '期数',
			'p_project_id' => 'P Project',
			'p_repaytime' => '应还款时间',
			'p_fullverifytime' => '满标时间',
			'p_style' => '还款方式',
			'p_repayyestime' => '还款时间',
			'p_repayaccount' => '还款总额',
			'p_repayyesaccount' => 'P Repayyesaccount',
			'p_lateday' => 'P Lateday',
			'p_lateinterest' => 'P Lateinterest',
			'p_money' => '还款本金',
			'p_interest' => '还款利息',
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
		$criteria->compare('p_status',$this->p_status);
		$criteria->compare('p_order',$this->p_order);
		$criteria->compare('p_project_id',$this->p_project_id,true);
		$criteria->compare('p_repaytime',$this->p_repaytime,true);
		$criteria->compare('p_repayyestime',$this->p_repayyestime,true);
		$criteria->compare('p_repayaccount',$this->p_repayaccount,true);
		$criteria->compare('p_repayyesaccount',$this->p_repayyesaccount,true);
		$criteria->compare('p_lateday',$this->p_lateday);
		$criteria->compare('p_lateinterest',$this->p_lateinterest,true);
		$criteria->compare('p_money',$this->p_money,true);
		$criteria->compare('p_interest',$this->p_interest,true);
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
	 * @return ProjectRepay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
