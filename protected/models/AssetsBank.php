<?php

/**
 * This is the model class for table "{{assets_bank}}".
 *
 * The followings are the available columns in table '{{assets_bank}}':
 * @property string $b_id
 * @property string $b_user_id
 * @property integer $b_status
 * @property string $b_cardNum
 * @property string $b_bank
 * @property string $b_branch
 * @property string $b_addtime
 * @property string $b_addip
 */
class AssetsBank extends CActiveRecord
{
	public $authcode;
	public $reb_cardNum;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{assets_bank}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('b_id, b_user_id, b_status, b_cardNum, b_city,b_province,b_bank, b_branch, b_addtime, b_addip', 'required'),
			array('b_status', 'numerical', 'integerOnly'=>true),
			array('b_cardNum','unique','message'=>'该卡号已存在'),
			array('b_id, b_user_id, b_bank', 'length', 'max'=>19,'message'=>'银行卡号不规则，添加失败'),
			array('b_cardNum','length','min'=>16,'message'=>'银行卡号不规则，添加失败'),
			array('b_cardNum, b_branch, b_addtime, b_addip', 'length', 'max'=>128),
			array('authcode','captcha','message'=>'验证码不正确'),
			array('reb_cardNum', 'compare', 'compareAttribute'=>'b_cardNum','message'=>'两次银行卡输入不一致'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('b_id, b_user_id, b_status, b_cardNum, b_bank, b_branch, b_addtime, b_addip', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'Item', 'b_bank'),
			'province'=>array(self::BELONGS_TO,'Area','b_province'),
			'city'=>array(self::BELONGS_TO,'Area','b_city'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'b_id' => '银行卡ID',
			'b_user_id' => '用户ID',
			'b_status' => '银行卡状态(0,关闭;2,激活)',
			'b_cardNum' => '银行卡号',
			'b_bank' => '银行ID',
			'b_branch' => '支行名称',
			'b_addtime' => '添加时间',
			'b_addip' => '添加IP',
			'reb_cardNum' => '重复输入银行卡',
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

		$criteria->compare('b_id',$this->b_id,true);
		$criteria->compare('b_user_id',$this->b_user_id,true);
		$criteria->compare('b_status',$this->b_status);
		$criteria->compare('b_cardNum',$this->b_cardNum,true);
		$criteria->compare('b_bank',$this->b_bank,true);
		$criteria->compare('b_branch',$this->b_branch,true);
		$criteria->compare('b_addtime',$this->b_addtime,true);
		$criteria->compare('b_addip',$this->b_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetsBank the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
