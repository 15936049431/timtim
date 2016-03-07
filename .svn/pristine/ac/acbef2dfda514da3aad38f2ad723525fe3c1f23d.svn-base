<?php

/**
 * This is the model class for table "{{assets_recharge}}".
 *
 * The followings are the available columns in table '{{assets_recharge}}':
 * @property string $r_id
 * @property string $r_BillNo
 * @property string $r_user_id
 * @property integer $r_status
 * @property string $r_money
 * @property string $r_realmoney
 * @property string $r_fee
 * @property integer $r_type
 * @property integer $r_recharge_type
 * @property string $r_return
 * @property string $r_verify_user
 * @property string $r_verify_time
 * @property string $r_verify_remark
 * @property string $r_addtime
 * @property string $r_addip
 */
class AssetsRecharge extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AssetsRecharge the static model class
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
		return '{{assets_recharge}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('r_id, r_BillNo, r_user_id, r_status, r_money, r_realmoney, r_fee, r_type, r_recharge_type, r_verify_user, r_verify_time, r_verify_remark, r_addtime, r_addip', 'required'),
			array('r_status, r_type', 'numerical', 'integerOnly'=>true),
			array('r_id, r_user_id, r_verify_user', 'length', 'max'=>18),
			array('r_BillNo, r_verify_remark', 'length', 'max'=>255),
                        array('r_return','safe'),
			array('r_money, r_realmoney, r_fee', 'length', 'max'=>11),
			array('r_verify_time, r_addtime, r_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('r_id, r_BillNo, r_user_id, r_status, r_money, r_realmoney, r_fee, r_type, r_recharge_type, r_return, r_verify_user, r_verify_time, r_verify_remark, r_addtime, r_addip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('user' => array(self::BELONGS_TO, 'User', 'r_user_id'),
			'verify_user' => array(self::BELONGS_TO, 'Manager', 'r_verify_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('r_id' => '充值ID','r_BillNo' => '充值订单流水','r_user_id' => '充值用户id','r_status' => '充值状态','r_money' => '充值金额','r_realmoney' => '实际到账金额','r_fee' => '充值手续费','r_type' => '充值类型','r_recharge_type' => '充值通道','r_return' => '线上充值返回参数序列化存储','r_verify_user' => '审核人','r_verify_time' => '审核时间','r_verify_remark' => '审核备注','r_addtime' => '添加时间','r_addip' => 'r_addip','user_id' => '用户id','user_name' => '登录名','login_pass' => '登陆密码','pay_pass' => '支付密码','user_email' => '用户邮箱','user_phone' => '用户手机','home_tel' => '家庭电话','user_qq' => '用户QQ','user_pic' => '用户头像','real_name' => '真实姓名','card_num' => '证件号码','user_sex' => '用户性别','user_age' => '用户年龄','user_edu' => 'user_edu','birth_place' => '出生地','live_place' => '居住地','user_address' => '用户联系地址','p_user_id' => 'p_user_id','user_type' => 'user_type','is_email_check' => 'is_email_check','is_phone_check' => 'is_phone_check','is_realname_check' => 'is_realname_check','vip_stop_time' => 'vip_stop_time','is_hook' => 'is_hook','resiter_time' => 'resiter_time','login_time' => 'login_time',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array('r_status' => array('0' =>'申请','1' =>'成功','2' =>'失败',),'r_type' => array('1' =>'线上充值','2' =>'线下充值',),'user_sex' => array('0' =>'未知','1' =>'男','2' =>'女',),);
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

		$criteria->compare('r_id',$this->r_id,true);
		$criteria->compare('r_BillNo',$this->r_BillNo,true);
		$criteria->compare('r_user_id',$this->r_user_id,true);
		$criteria->compare('r_status',$this->r_status);
		$criteria->compare('r_money',$this->r_money,true);
		$criteria->compare('r_realmoney',$this->r_realmoney,true);
		$criteria->compare('r_fee',$this->r_fee,true);
		$criteria->compare('r_type',$this->r_type);
		$criteria->compare('r_recharge_type',$this->r_recharge_type);
		$criteria->compare('r_return',$this->r_return,true);
		$criteria->compare('r_verify_user',$this->r_verify_user,true);
		$criteria->compare('r_verify_time',$this->r_verify_time,true);
		$criteria->compare('r_verify_remark',$this->r_verify_remark,true);
		$criteria->compare('r_addtime',$this->r_addtime,true);
		$criteria->compare('r_addip',$this->r_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}