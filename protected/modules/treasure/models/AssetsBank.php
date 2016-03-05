<?php

/**
 * This is the model class for table "{{assets_bank}}".
 *
 * The followings are the available columns in table '{{assets_bank}}':
 * @property string $b_id
 * @property string $b_user_id
 * @property integer $b_status
 * @property string $b_cardNum
 * @property integer $b_bank
 * @property string $b_branch
 * @property string $b_addtime
 * @property string $b_addip
 */
class AssetsBank extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AssetsBank the static model class
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
			array('b_id, b_user_id, b_status, b_cardNum,b_city,b_province, b_bank, b_branch, b_addtime, b_addip', 'required'),
			array('b_status, b_bank', 'numerical', 'integerOnly'=>true),
			array('b_id, b_user_id', 'length', 'max'=>18),
			array('b_cardNum, b_branch, b_addtime, b_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
		return array('user' => array(self::BELONGS_TO, 'User', 'b_user_id'),
			'item' => array(self::BELONGS_TO, 'Item', 'b_bank'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('b_id' => '银行卡ID','b_user_id' => '用户ID','b_status' => '银行卡状态','b_cardNum' => '银行卡号','b_city'=>'城市','b_bank' => '银行ID','b_branch' => '支行名称','b_addtime' => '添加时间','b_addip' => '添加IP','user_id' => '用户id','user_name' => '登录名','login_pass' => '登陆密码','pay_pass' => '支付密码','user_email' => '用户邮箱','user_phone' => '用户手机','home_tel' => '家庭电话','user_qq' => '用户QQ','user_pic' => '用户头像','real_name' => '真实姓名','card_num' => '证件号码','user_sex' => '用户性别','user_age' => '用户年龄','user_edu' => 'user_edu','birth_place' => '出生地','live_place' => '居住地','user_address' => '用户联系地址','p_user_id' => 'p_user_id','user_type' => 'user_type','is_email_check' => 'is_email_check','is_phone_check' => 'is_phone_check','is_realname_check' => 'is_realname_check','vip_stop_time' => 'vip_stop_time','is_hook' => 'is_hook','resiter_time' => 'resiter_time','login_time' => 'login_time',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array('b_status' => array('0' =>'关闭','1' =>'激活',),'user_sex' => array('0' =>'未知','1' =>'男','2' =>'女',),);
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
		$criteria->compare('b_user_id',$this->b_user_id,true);
		$criteria->compare('b_status',$this->b_status);
		$criteria->compare('b_cardNum',$this->b_cardNum,true);
		$criteria->compare('b_bank',$this->b_bank);
		$criteria->compare('b_branch',$this->b_branch,true);
		$criteria->compare('b_addtime',$this->b_addtime,true);
		$criteria->compare('b_addip',$this->b_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}