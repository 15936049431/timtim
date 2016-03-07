<?php

/**
 * This is the model class for table "{{system}}".
 *
 * The followings are the available columns in table '{{system}}':
 * @property integer $system_id
 * @property integer $systemcat_id
 * @property string $system_name
 * @property string $system_alias
 * @property string $system_value
 * @property integer $input_type
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $isdefault
 *
 * The followings are the available model relations:
 * @property Systemcat $systemcat
 */
class System extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return System the static model class
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
		return '{{system}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('systemcat_id, system_name, system_alias, input_type, add_time, isdefault', 'required'),
			array('systemcat_id, input_type, add_time, update_time, isdefault', 'numerical', 'integerOnly'=>true),
			array('system_name, system_alias, system_desc', 'length', 'max'=>64),
                        array('system_value,data','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('system_id, systemcat_id, system_name, system_alias, system_value, system_desc, input_type, add_time, update_time, isdefault', 'safe', 'on'=>'search'),
		);
	}
        
        
        public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'input_type' => array(
                '0' =>'-- 请选择 --',
                '1' => '文本框',
                '2' => '文本域',
                '3' => '下拉列表',
                '4' => '单选按钮',
                '5' => '复选按钮',
                '6' => '上传组件',
            ),
            'isdefault'=>array(
                '0'=>'是',
                '1'=>'否'
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
        }
        
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'systemcat' => array(self::BELONGS_TO, 'Systemcat', 'systemcat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'system_id' => 'System',
			'systemcat_id' => '字段类别',
			'systemcat_name' => '字段类别',
			'system_name' => '字段名称',
			'system_alias' => '字段别名',
			'system_desc' => '字段简介',
			'system_value' => '字段值',
			'input_type' => '控件类型',
			'add_time' => '添加时间',
			'update_time' => '修改时间',
			'data' => '数据',
			'isdefault' => '系统默认',
		);
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

		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('systemcat_id',$this->systemcat_id);
		$criteria->compare('system_name',$this->system_name,true);
		$criteria->compare('system_alias',$this->system_alias,true);
		$criteria->compare('system_value',$this->system_value,true);
		$criteria->compare('input_type',$this->input_type);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('isdefault',$this->isdefault);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}