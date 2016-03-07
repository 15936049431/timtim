<?php

/**
 * This is the model class for table "{{identity}}".
 *
 * The followings are the available columns in table '{{identity}}':
 * @property string $identity_id
 * @property string $user_id
 * @property string $real_name
 * @property string $identity_num
 * @property string $identity_positive
 * @property string $identity_negative
 * @property integer $status
 * @property string $check_manager
 * @property integer $check_time
 * @property string $check_remark
 * @property integer $add_time
 * @property string $add_ip
 */
class Identity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{identity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identity_id, user_id, real_name, identity_num, status, add_time, add_ip', 'required'),
			array('identity_num','unique'),
			array('identity_num','checkCardNum'),
                        array('identity_num', 'length', 'max'=>18,'min'=>15,'tooLong'=>'请输入15-18位身份证号码','tooShort'=>'请输入15-18位身份证号码'),
			array('status, check_time, add_time', 'numerical', 'integerOnly'=>true),
			array('identity_id, user_id, check_manager', 'length', 'max'=>18),
			array('real_name', 'length', 'max'=>24),
			array('add_ip', 'length', 'max'=>20),
			array('identity_positive, identity_negative', 'length', 'max'=>50),
			array('check_remark', 'length', 'max'=>255),
			array('identity_positive, identity_negative', 'file', 'allowEmpty'=>false, 'types'=>'jpg, gif, png', 'maxSize'=>2048152, 'tooLarge'=>'{file}文件不能超过 2MB. 请上传小一点儿的文件.','on'=>'human'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('identity_id, user_id, real_name, identity_num, identity_positive, identity_negative, status, check_manager, check_time, check_remark, add_time, add_ip', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'identity_id' => 'Identity',
			'user_id' => '用户名',
			'real_name' => '真实姓名',
			'identity_num' => '身份证号',
			'identity_positive' => '身份证正面',
			'identity_negative' => '身份证反面',
			'status' => '状态',
			'check_manager' => 'Check Manager',
			'check_time' => 'Check Time',
			'check_remark' => 'Check Remark',
			'add_time' => 'Add Time',
			'add_ip' => 'Add Ip',
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

		$criteria->compare('identity_id',$this->identity_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('identity_num',$this->identity_num,true);
		$criteria->compare('identity_positive',$this->identity_positive,true);
		$criteria->compare('identity_negative',$this->identity_negative,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('check_manager',$this->check_manager,true);
		$criteria->compare('check_time',$this->check_time);
		$criteria->compare('check_remark',$this->check_remark,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_ip',$this->add_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Identity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function checkCardNum() {
            if(!$this->checkIdCard())
                $this -> addError('identity_num','身份证格式有误或不存在');
        }
        
        function checkIdCard() {
            $idcard = $this->identity_num;
            if (empty($idcard)) {
                return false;
            }

            $iSum = 0;
            $idCardLength = strlen($idcard);
            //长度验证
            if (!preg_match('/^\d{17}(\d|x)$/i', $idcard) and !preg_match('/^\d{15}$/i', $idcard)) {
                return false;
            }

            // 15位身份证验证生日，转换为18位
            if ($idCardLength == 15) {
                $sBirthday = '19' . substr($idcard, 6, 2) . '-' . substr($idcard, 8, 2) . '-' . substr($idcard, 10, 2);
                $d = new DateTime($sBirthday);
                $dd = $d->format('Y-m-d');
                if ($sBirthday != $dd) {
                    return false;
                }
                $idcard = substr($idcard, 0, 6) . "19" . substr($idcard, 6, 9); //15to18
                $Bit18 = $this->getVerifyBit($idcard); //算出第18位校验码
                $idcard = $idcard . $Bit18;
            }
            // 判断是否大于2078年，小于1900年
            $year = substr($idcard, 6, 4);
            if ($year < 1900 || $year > 2078) {
                return false;
            }

            //18位身份证处理
            $sBirthday = substr($idcard, 6, 4) . '-' . substr($idcard, 10, 2) . '-' . substr($idcard, 12, 2);
            $d = new DateTime($sBirthday);
            $dd = $d->format('Y-m-d');
            if ($sBirthday != $dd) {
                return false;
            }
            //身份证编码规范验证
            $idcard_base = substr($idcard, 0, 17);
            if (strtoupper(substr($idcard, 17, 1)) != $this->getVerifyBit($idcard_base)) {
                return false;
            } else {
                return true;
            }
        }

        // 计算身份证校验码，根据国家标准GB 11643-1999
        function getVerifyBit($idcard_base)
        {
                if(strlen($idcard_base) != 17)
                {
                        return false;
                }
                //加权因子
                $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                //校验码对应值
                $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4','3', '2');
                $checksum = 0;
                for ($i = 0; $i < strlen($idcard_base); $i++)
                {
                        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
                }
                $mod = $checksum % 11;
                $verify_number = $verify_number_list[$mod];
                return $verify_number;
        }
	
}
