<?php

/**
 * This is the model class for table "{{integral_address}}".
 *
 * The followings are the available columns in table '{{integral_address}}':
 * @property string $address_id
 * @property string $user_id
 * @property string $address_name
 * @property string $address_place
 * @property string $address_people
 * @property string $address_phone
 * @property integer $address_province
 * @property integer $address_city
 * @property string $address_allwith
 * @property integer $is_default
 * @property integer $status
 * @property string $addtime
 * @property string $addip
 */
class IntegralAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntegralAddress the static model class
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
		return '{{integral_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address_id, user_id, address_name, address_place, address_people, address_phone, address_province, address_city, address_allwith, is_default, status, addtime, addip', 'required'),
			array('address_province, address_city, is_default, status', 'numerical', 'integerOnly'=>true),
			array('address_id, user_id', 'length', 'max'=>18),
			array('address_name, address_people, address_phone, addtime, addip', 'length', 'max'=>128),
			array('address_place, address_allwith', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('address_id, user_id, address_name, address_place, address_people, address_phone, address_province, address_city, address_allwith, is_default, status, addtime, addip', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'city' => array(self::BELONGS_TO, 'Area', 'city'),
			'province' => array(self::BELONGS_TO, 'Area', 'province'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'address_id' => 'Id',
			'user_id' => '用户名',
			'address_name' => '地址名称',
			'address_place' => '详细地址',
			'address_people' => '收件人',
			'address_phone' => '手机号码',
			'address_province' => '省市',
			'address_city' => '城市',
			'address_allwith' => '地址信息',
			'is_default' => '是否默认',
			'status' => '状态',
			'addtime' => '添加时间',
			'addip' => 'Addip',
		);
	}
	
	public static function itemAlias($type, $code = NULL) {
        $_items = array(
			'status' => array('0' =>'关闭','1' =>'开启'),
			'is_default' => array('0' =>'否','1' =>'是'),
		);
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

		$criteria->compare('address_id',$this->address_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('address_name',$this->address_name,true);
		$criteria->compare('address_place',$this->address_place,true);
		$criteria->compare('address_people',$this->address_people,true);
		$criteria->compare('address_phone',$this->address_phone,true);
		$criteria->compare('address_province',$this->address_province);
		$criteria->compare('address_city',$this->address_city);
		$criteria->compare('address_allwith',$this->address_allwith,true);
		$criteria->compare('is_default',$this->is_default);
		$criteria->compare('status',$this->status);
		$criteria->compare('addtime',$this->addtime,true);
		$criteria->compare('addip',$this->addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}