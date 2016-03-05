<?php

/**
 * This is the model class for table "{{bill}}".
 *
 * The followings are the available columns in table '{{bill}}':
 * @property string $b_id
 * @property string $user_id
 * @property string $b_money
 * @property integer $b_type
 * @property string $u_total_money
 * @property string $u_real_money
 * @property string $u_frost_money
 * @property integer $b_time
 * @property string $remark
 */
class Bill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

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
			array('b_money, u_total_money, u_real_money, u_frost_money, u_have_interest, u_wait_interest, u_wait_total_money', 'length', 'max'=>18),
			array('b_itemtype, remark, b_addip', 'length', 'max'=>128),
			array('b_mark', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
		return array('user' => array(self::BELONGS_TO, 'User', 'user_id'),);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'b_id' => 'ID',
			'user_id' => '登录名',
			'real_name'=>'真实姓名',
			'b_money' => '变动金额',
			'b_type' => '支出类型',
			'b_itemtype' => '操作类型',
			'u_total_money' => '总额',
			'u_real_money' => '可用金额',
			'u_frost_money' => '冻结金额',
			'u_have_interest' => '已收利息',
			'u_wait_interest' => '待收利息',
			'u_wait_total_money' => '待收总额',
			'b_mark' => 'B Mark',
			'b_time' => '添加时间',
			'remark' => '备注',
			'b_addip' => 'B Addip',
		);
	}
	
	public static function itemAlias($type, $code = NULL) {
        $_items = array('b_type' => array('1' =>'收入','2' =>'支出',),'user_sex' => array('0' =>'未知','1' =>'男','2' =>'女',),);
                if (isset($code))
                    return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
                else
                    return isset($_items[$type]) ? $_items[$type] : false;
                }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

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
}