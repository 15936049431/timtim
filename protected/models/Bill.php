<?php

/**
 * This is the model class for table "{{bill}}".
 *
 * The followings are the available columns in table '{{bill}}':
 * @property string $b_id
 * @property string $user_id
 * @property string $b_money
 * @property integer $b_type
 * @property string $b_itemtype
 * @property string $u_total_money
 * @property string $u_real_money
 * @property string $u_frost_money
 * @property string $u_have_interest
 * @property string $u_wait_interest
 * @property string $u_wait_total_money
 * @property string $b_mark
 * @property integer $b_time
 * @property string $remark
 * @property string $b_addip
 */
class Bill extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bill}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('b_id, user_id, b_money, b_type, b_itemtype, u_total_money, u_real_money, u_frost_money, u_have_interest, u_wait_interest, u_wait_total_money, b_mark, b_time, remark, b_addip', 'required'),
			array('b_type, b_time', 'numerical', 'integerOnly'=>true),
			array('b_id, user_id', 'length', 'max'=>18),
			array('b_money, u_total_money, u_real_money, u_frost_money, u_have_interest, u_wait_interest, u_wait_total_money', 'length', 'max'=>12),
			array('b_itemtype, remark, b_addip', 'length', 'max'=>128),
			array('b_mark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('b_id, user_id, b_money, b_type, b_itemtype, u_total_money, u_real_money, u_frost_money, u_have_interest, u_wait_interest, u_wait_total_money, b_mark, b_time, remark, b_addip', 'safe', 'on'=>'search'),
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
			'b_id' => 'B',
			'user_id' => 'User',
			'b_money' => 'B Money',
			'b_type' => 'B Type',
			'b_itemtype' => 'B Itemtype',
			'u_total_money' => 'U Total Money',
			'u_real_money' => 'U Real Money',
			'u_frost_money' => 'U Frost Money',
			'u_have_interest' => 'U Have Interest',
			'u_wait_interest' => 'U Wait Interest',
			'u_wait_total_money' => 'U Wait Total Money',
			'b_mark' => 'B Mark',
			'b_time' => 'B Time',
			'remark' => 'Remark',
			'b_addip' => 'B Addip',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('b_money',$this->b_money,true);
		$criteria->compare('b_type',$this->b_type);
		$criteria->compare('b_itemtype',$this->b_itemtype,true);
		$criteria->compare('u_total_money',$this->u_total_money,true);
		$criteria->compare('u_real_money',$this->u_real_money,true);
		$criteria->compare('u_frost_money',$this->u_frost_money,true);
		$criteria->compare('u_have_interest',$this->u_have_interest,true);
		$criteria->compare('u_wait_interest',$this->u_wait_interest,true);
		$criteria->compare('u_wait_total_money',$this->u_wait_total_money,true);
		$criteria->compare('b_mark',$this->b_mark,true);
		$criteria->compare('b_time',$this->b_time);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('b_addip',$this->b_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
