<?php

/**
 * This is the model class for table "{{code}}".
 *
 * The followings are the available columns in table '{{code}}':
 * @property string $code_id
 * @property string $codecat_id
 * @property string $target
 * @property string $code
 * @property integer $status
 * @property string $add_time
 * @property string $exc_time
 * @property integer $error_num
 *
 * The followings are the available model relations:
 * @property Codecat $codecat
 */
class Code extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{code}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code_id, codecat_id, target, code, status, add_time, exc_time, error_num', 'required'),
			array('status, error_num', 'numerical', 'integerOnly'=>true),
			array('code_id, codecat_id', 'length', 'max'=>18),
			array('target', 'length', 'max'=>32),
			array('code', 'length', 'max'=>6),
			array('add_time, exc_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('code_id, codecat_id, target, code, status, add_time, exc_time, error_num', 'safe', 'on'=>'search'),
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
			'codecat' => array(self::BELONGS_TO, 'Codecat', 'codecat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'code_id' => '验证码ID',
			'codecat_id' => '验证码分类ID',
			'codecat_name' => '验证码分类名称',
			'target' => '接收人',
			'code' => '验证码',
			'status' => '状态',
			'add_time' => '添加时间',
			'exc_time' => '过期时间',
			'error_num' => '错误次数',
			'add_ip' => '添加ip',
		);
	}
        
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
                'status' => array(
                    '0' =>'未使用',
                    '1' => '已使用',
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

		$criteria->compare('code_id',$this->code_id,true);
		$criteria->compare('codecat_id',$this->codecat_id,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('exc_time',$this->exc_time,true);
		$criteria->compare('error_num',$this->error_num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Code the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
