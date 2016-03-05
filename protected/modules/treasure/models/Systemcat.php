<?php

/**
 * This is the model class for table "{{systemcat}}".
 *
 * The followings are the available columns in table '{{systemcat}}':
 * @property integer $systemcat_id
 * @property string $systemcat_name
 * @property string $systemcat_alias
 * @property string $systemcat_desc
 *
 * The followings are the available model relations:
 * @property System[] $systems
 */
class Systemcat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Systemcat the static model class
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
		return '{{systemcat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('systemcat_name, systemcat_alias, systemcat_desc', 'required'),
			array('systemcat_id, systemcat_parent', 'numerical', 'integerOnly'=>true),
			array('systemcat_name', 'length', 'max'=>64),
			array('systemcat_alias', 'length', 'max'=>32),
			array('systemcat_desc', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('systemcat_id, systemcat_name, systemcat_alias, systemcat_desc', 'safe', 'on'=>'search'),
		);
	}
        
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
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
			'systems' => array(self::HAS_MANY, 'System', 'systemcat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'systemcat_id' => 'Systemcat',
			'systemcat_name' => '类别名称',
			'systemcat_alias' => '类别别名',
			'systemcat_desc' => '类别简介',
			'systemcat_parent' => '父籍',
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

		$criteria->compare('systemcat_id',$this->systemcat_id);
		$criteria->compare('systemcat_name',$this->systemcat_name,true);
		$criteria->compare('systemcat_alias',$this->systemcat_alias,true);
		$criteria->compare('systemcat_desc',$this->systemcat_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}