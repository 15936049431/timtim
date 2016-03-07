<?php

/**
 * This is the model class for table "{{sms}}".
 *
 * The followings are the available columns in table '{{sms}}':
 * @property string $sms_id
 * @property string $get_user_id
 * @property string $get_user_contact
 * @property string $sms_con
 * @property integer $sms_type
 * @property integer $send_type
 * @property integer $timing
 * @property integer $status
 * @property integer $send_time
 * @property string $remark
 */
class Sms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sms}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sms_id, get_user_id, get_user_contact, sms_con, sms_type, send_type, timing, status, send_time, remark', 'required'),
			array('sms_type, send_type, timing, status, send_time', 'numerical', 'integerOnly'=>true),
            //array('get_user_contact', 'match', 'pattern'=>'/^1[0-9]{10}$/','message'=>'请输入正确的手机号码'),
			array('sms_id, get_user_id', 'length', 'max'=>18),
			array('get_user_contact', 'length', 'max'=>32),
			array('sms_con', 'length', 'max'=>1024),
			array('remark', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sms_id, get_user_id, get_user_contact, sms_con, sms_type, send_type, timing, status, send_time, remark', 'safe', 'on'=>'search'),
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
			'sms_id' => '短信ID',
			'get_user_id' => '接收用户',
			'get_user_contact' => '接收手机',
			'sms_con' => '短信内容',
			'sms_type' => '短信类型',
			'send_type' => '发送类型',
			'timing' => '发送时间',
			'status' => '状态',
			'send_time' => '发送时间',
			'remark' => '备注',
			'send_ip' => '发送ip',
		);
	}
        
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
                'status' => array(
                    '0' =>'未发送',
                    '1' => '发送成功',
                    '2' => '发送失败',
                ),
            );
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

		$criteria->compare('sms_id',$this->sms_id,true);
		$criteria->compare('get_user_id',$this->get_user_id,true);
		$criteria->compare('get_user_contact',$this->get_user_contact,true);
		$criteria->compare('sms_con',$this->sms_con,true);
		$criteria->compare('sms_type',$this->sms_type);
		$criteria->compare('send_type',$this->send_type);
		$criteria->compare('timing',$this->timing);
		$criteria->compare('status',$this->status);
		$criteria->compare('send_time',$this->send_time);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
