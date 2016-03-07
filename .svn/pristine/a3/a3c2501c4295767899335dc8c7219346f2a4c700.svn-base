<?php

/**
 * This is the model class for table "{{project_apply}}".
 *
 * The followings are the available columns in table '{{project_apply}}':
 * @property string $p_id
 * @property string $p_userid
 * @property string $p_name
 * @property integer $p_money
 * @property integer $p_time_limit
 * @property string $p_phone
 * @property string $p_realname
 * @property integer $p_province
 * @property integer $p_city
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectApply extends CActiveRecord
{
	public $authcode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_apply}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_name, p_money, p_time_limit, p_phone, p_realname, p_province, p_city, p_addtime, p_addip', 'required'),
			array('p_money, p_time_limit, p_province, p_city', 'numerical', 'integerOnly'=>true),
			array('p_id, p_userid', 'length', 'max'=>18),
			array('p_name', 'length', 'max'=>255),
			array('p_phone, p_realname, p_addtime, p_addip', 'length', 'max'=>128),
			array('authcode','captcha','message'=>'验证码不正确'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_userid, p_name, p_money, p_time_limit, p_phone, p_realname, p_province, p_city, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
			'p_id' => 'P',
			'p_userid' => '用户id',
			'p_name' => '用户名',
			'p_money' => '借款金额',
			'p_time_limit' => '借款时长',
			'p_phone' => '联系号码',
			'p_realname' => '真实姓名',
			'p_province' => '城市',
			'p_city' => '省份',
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
		$criteria->compare('p_userid',$this->p_userid,true);
		$criteria->compare('p_name',$this->p_name,true);
		$criteria->compare('p_money',$this->p_money);
		$criteria->compare('p_time_limit',$this->p_time_limit);
		$criteria->compare('p_phone',$this->p_phone,true);
		$criteria->compare('p_realname',$this->p_realname,true);
		$criteria->compare('p_province',$this->p_province);
		$criteria->compare('p_city',$this->p_city);
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
	 * @return ProjectApply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
