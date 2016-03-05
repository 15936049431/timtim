<?php

/**
 * This is the model class for table "{{credit}}".
 *
 * The followings are the available columns in table '{{credit}}':
 * @property string $c_id
 * @property string $user_id
 * @property string $amount
 * @property string $real_amount
 * @property integer $status
 * @property string $check_manager
 * @property string $check_remark
 * @property integer $check_time
 * @property integer $add_time
 */
class Credit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{credit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_id, user_id, amount, real_amount, status, check_manager, check_remark, check_time, add_time', 'required'),
			array('status, check_time, add_time', 'numerical', 'integerOnly'=>true),
			array('c_id, user_id, check_manager', 'length', 'max'=>18),
			array('amount, real_amount', 'length', 'max'=>12),
			array('check_remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('c_id, user_id, amount, real_amount, status, check_manager, check_remark, check_time, add_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('manager' => array(self::BELONGS_TO, 'Manager', 'check_manager'),'user' => array(self::BELONGS_TO, 'User', 'user_id'),);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('c_id' => '资信申请ID','user_id' => '用户ID','amount' => '授信额度','real_amount' => '真实授信额度','status' => '状态','check_manager' => '审核管理员','check_remark' => '审核备注','check_time' => '审核时间','add_time' => '添加时间','manager_id' => 'manager_id','manager_name' => 'manager_name','manager_pass' => 'manager_pass','manager_realname' => 'manager_realname','manager_tel' => 'manager_tel','google_status' => 'google_status','google_secret' => 'google_secret','issuper' => 'issuper','login_time' => 'login_time','user_id' => 'user_id','user_name' => '用户名','login_pass' => 'login_pass','pay_pass' => 'pay_pass','user_email' => '用户邮箱','user_phone' => '用户手机','home_tel' => '家庭座机','user_qq' => 'user_qq','user_pic' => 'user_pic','real_name' => '真实姓名','card_num' => '证件号码','user_sex' => 'user_sex','user_age' => 'user_age','user_edu' => 'user_edu','birth_place' => 'birth_place','live_place' => 'live_place','user_address' => 'user_address','p_user_id' => 'p_user_id','user_type' => 'user_type','is_email_check' => 'is_email_check','is_phone_check' => 'is_phone_check','is_realname_check' => 'is_realname_check','vip_stop_time' => 'vip_stop_time','is_hook' => 'is_hook','register_time' => 'register_time','login_time' => 'login_time',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array('status' => array('0' =>'待审核','1' =>'审核中','2' =>'审核通过','3' =>'审核失败','3' =>'审核失败',),);
                if (isset($code))
                    return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
                else
                    return isset($_items[$type]) ? $_items[$type] : false;
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

		$criteria->compare('c_id',$this->c_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('real_amount',$this->real_amount,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('check_manager',$this->check_manager,true);
		$criteria->compare('check_remark',$this->check_remark,true);
		$criteria->compare('check_time',$this->check_time);
		$criteria->compare('add_time',$this->add_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Credit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
