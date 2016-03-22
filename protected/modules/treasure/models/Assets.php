<?php

/**
 * This is the model class for table "{{assets}}".
 *
 * The followings are the available columns in table '{{assets}}':
 * @property string $user_id
 * @property string $total_money
 * @property string $real_money
 * @property string $frost_money
 * @property string $have_interest
 * @property string $wait_interest
 * @property string $wait_total_money
 * @property string $exp_money
 * @property string $exp_use_money
 */
class Assets extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Assets the static model class
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
		return '{{assets}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, total_money, real_money, frost_money, have_interest, wait_interest, wait_total_money', 'required'),
			array('user_id', 'length', 'max'=>18),
			array('total_money, real_money, frost_money, have_interest, wait_interest, wait_total_money', 'length', 'max'=>18),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, total_money, real_money, frost_money, have_interest, wait_interest, wait_total_money', 'safe', 'on'=>'search'),
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
                return array('user_id' => '用户ID','total_money' => '资金总额','real_money' => '可用资金','frost_money' => '冻结资金','have_interest' => '已收利息','wait_interest' => '待收利息','wait_total_money' => '待收总额',"yuebao_money"=>"商城余额",'user_id' => '用户id','user_name' => '登录名','login_pass' => '登陆密码','pay_pass' => '支付密码','user_email' => '用户邮箱','user_phone' => '用户手机','home_tel' => '家庭电话','user_qq' => '用户QQ','user_pic' => '用户头像','real_name' => '真实姓名','card_num' => '证件号码','user_sex' => '用户性别','user_age' => '用户年龄','user_edu' => 'user_edu','birth_place' => '出生地','live_place' => '居住地','user_address' => '用户联系地址','p_user_id' => 'p_user_id','user_type' => 'user_type','is_email_check' => 'is_email_check','is_phone_check' => 'is_phone_check','is_realname_check' => 'is_realname_check','vip_stop_time' => 'vip_stop_time','is_hook' => 'is_hook','resiter_time' => 'resiter_time','login_time' => 'login_time',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array('user_sex' => array('0' =>'未知','1' =>'男','2' =>'女',),);
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('total_money',$this->total_money,true);
		$criteria->compare('real_money',$this->real_money,true);
		$criteria->compare('frost_money',$this->frost_money,true);
		$criteria->compare('have_interest',$this->have_interest,true);
		$criteria->compare('wait_interest',$this->wait_interest,true);
		$criteria->compare('wait_total_money',$this->wait_total_money,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}