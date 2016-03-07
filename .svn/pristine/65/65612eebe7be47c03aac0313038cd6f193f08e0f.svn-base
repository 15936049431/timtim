<?php

/**
 * This is the model class for table "{{project_order}}".
 *
 * The followings are the available columns in table '{{project_order}}':
 * @property string $p_id
 * @property string $p_user_id
 * @property integer $p_status
 * @property string $p_project_id
 * @property string $p_money
 * @property string $p_realmoney
 * @property string $p_repayaccount
 * @property string $p_repayyesaccount
 * @property string $p_waitrepay
 * @property string $p_interest
 * @property string $p_yesinterest
 * @property string $p_waitinterest
 * @property integer $p_debt
 * @property integer $p_type
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_id, p_user_id, p_status, p_project_id, p_money, p_realmoney, p_repayaccount, p_waitrepay, p_interest, p_waitinterest, p_type, p_addtime,', 'required'),
			array('p_status, p_debt, p_type', 'numerical', 'integerOnly'=>true),
			array('p_id, p_user_id, p_project_id', 'length', 'max'=>18),
			array('p_money, p_realmoney, p_repayaccount, p_repayyesaccount, p_waitrepay, p_interest, p_yesinterest, p_waitinterest', 'length', 'max'=>11),
			array('p_addtime, p_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_user_id, p_status, p_project_id, p_money, p_realmoney, p_repayaccount, p_repayyesaccount, p_waitrepay, p_interest, p_yesinterest, p_waitinterest, p_debt, p_type, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'p_user_id'),
			'project' => array(self::BELONGS_TO, 'Project', 'p_project_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'p_id' => '投资编号',
			'p_user_id' => 'P User',
			'p_status' => 'P Status',
			'p_project_id' => '项目名称',
			'p_money' => 'P Money',
			'p_realmoney' => '投资金额',
			'p_repayaccount' => '应收金额',
			'p_repayyesaccount' => '已收金额',
			'p_waitrepay' => '应收利息',
			'p_interest' => '应收利息',
			'p_yesinterest' => 'P Yesinterest',
			'p_waitinterest' => 'P Waitinterest',
			'p_debt' => 'P Debt',
			'p_type' => 'P Type',
			'p_award'=>'奖励',
			'p_mold'=>'类型',
			'p_addtime' => '添加时间',
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
		$criteria->compare('p_user_id',$this->p_user_id,true);
		$criteria->compare('p_status',$this->p_status);
		$criteria->compare('p_project_id',$this->p_project_id,true);
		$criteria->compare('p_money',$this->p_money,true);
		$criteria->compare('p_realmoney',$this->p_realmoney,true);
		$criteria->compare('p_repayaccount',$this->p_repayaccount,true);
		$criteria->compare('p_repayyesaccount',$this->p_repayyesaccount,true);
		$criteria->compare('p_waitrepay',$this->p_waitrepay,true);
		$criteria->compare('p_interest',$this->p_interest,true);
		$criteria->compare('p_yesinterest',$this->p_yesinterest,true);
		$criteria->compare('p_waitinterest',$this->p_waitinterest,true);
		$criteria->compare('p_debt',$this->p_debt);
		$criteria->compare('p_type',$this->p_type);
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
	 * @return ProjectOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
