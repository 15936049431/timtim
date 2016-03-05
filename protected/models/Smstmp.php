<?php

/**
 * This is the model class for table "{{smstmp}}".
 *
 * The followings are the available columns in table '{{smstmp}}':
 * @property string $tmp_id
 * @property string $tmp_alias
 * @property string $tmp_name
 * @property string $tmp_con
 * @property integer $tmp_type
 * @property integer $add_time
 *
 * The followings are the available model relations:
 * @property Codecat[] $codecats
 */
class Smstmp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{smstmp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tmp_id, tmp_alias, tmp_name, tmp_con, tmp_type, add_time', 'required'),
			array('tmp_type, add_time', 'numerical', 'integerOnly'=>true),
			array('tmp_id', 'length', 'max'=>18),
			array('tmp_alias, tmp_name', 'length', 'max'=>48),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tmp_id, tmp_alias, tmp_name, tmp_con, tmp_type, add_time', 'safe', 'on'=>'search'),
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
			'codecats' => array(self::HAS_MANY, 'Codecat', 'sms_tmp_alias'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tmp_id' => '模板ID',
			'tmp_alias' => '模板别名',
			'tmp_name' => '模板名称',
			'tmp_con' => '模板内容',
			'tmp_type' => '模板类型',
			'add_time' => '添加时间',
		);
	}
        
        
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
                'tmp_type' => array(
                    '0' =>'所有',
                    '1' =>'站内信',
                    '2' => '短信',
                    '3' => '邮件',
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

		$criteria->compare('tmp_id',$this->tmp_id,true);
		$criteria->compare('tmp_alias',$this->tmp_alias,true);
		$criteria->compare('tmp_name',$this->tmp_name,true);
		$criteria->compare('tmp_con',$this->tmp_con,true);
		$criteria->compare('tmp_type',$this->tmp_type);
		$criteria->compare('add_time',$this->add_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Smstmp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
