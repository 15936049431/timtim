<?php

/**
 * This is the model class for table "{{project_debt}}".
 *
 * The followings are the available columns in table '{{project_debt}}':
 * @property string $debt_id
 * @property string $user_id
 * @property string $order_id
 * @property string $project_id
 * @property string $buy_userid
 * @property integer $debt_expr
 * @property integer $debt_status
 * @property string $have_money
 * @property string $have_interest
 * @property string $to_money
 * @property string $addtime
 * @property string $addip
 */
class ProjectDebt extends CActiveRecord
{
	public $authcode;
	public $pay_pass;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_debt}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('debt_id, user_id, order_id, project_id,pay_pass,authcode, debt_expr, debt_status, have_money, have_interest, to_money, addtime, addip', 'required'),
			array('debt_expr, debt_status', 'numerical', 'integerOnly'=>true),
			array('order_id','unique'),
			array('debt_id, user_id, order_id, project_id, buy_userid', 'length', 'max'=>18),
			array('have_money, have_interest, to_money', 'length', 'max'=>11),
			array('addtime, addip', 'length', 'max'=>128),
			array('authcode','captcha','message'=>'验证码不正确'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('debt_id, user_id, order_id, project_id, buy_userid, debt_expr, debt_status, have_money, have_interest, to_money, addtime, addip', 'safe', 'on'=>'search'),
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
			'project'=>array(self::BELONGS_TO,'Project','project_id'),
			'project_order'=>array(self::BELONGS_TO,'ProjectOrder','order_id'),
			'buy_user'=>array(self::BELONGS_TO,'User','buy_userid'),
			'user'=>array(self::BELONGS_TO,'User','user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'debt_id' => 'Debt',
			'user_id' => 'User',
			'order_id' => 'Order',
			'project_id' => 'Project',
			'buy_userid' => 'Buy Userid',
			'debt_expr' => 'Debt Expr',
			'debt_status' => 'Debt Status',
			'have_money' => 'Have Money',
			'have_interest' => 'Have Interest',
			'to_money' => 'To Money',
			'addtime' => 'Addtime',
			'addip' => 'Addip',
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

		$criteria->compare('debt_id',$this->debt_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('buy_userid',$this->buy_userid,true);
		$criteria->compare('debt_expr',$this->debt_expr);
		$criteria->compare('debt_status',$this->debt_status);
		$criteria->compare('have_money',$this->have_money,true);
		$criteria->compare('have_interest',$this->have_interest,true);
		$criteria->compare('to_money',$this->to_money,true);
		$criteria->compare('addtime',$this->addtime,true);
		$criteria->compare('addip',$this->addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectDebt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
