<?php

/**
 * This is the model class for table "{{item}}".
 *
 * The followings are the available columns in table '{{item}}':
 * @property string $i_id
 * @property string $i_name
 * @property string $i_nid
 * @property string $i_cat_id
 * @property integer $i_order
 * @property integer $i_status
 * @property string $i_value
 * @property string $i_addtime
 * @property string $i_addip
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
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
		return '{{item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_id, i_name, i_nid, i_cat_id, i_order, i_status, i_value, i_addtime, i_addip', 'required'),
			array('i_order, i_status', 'numerical', 'integerOnly'=>true),
			array('i_id, i_cat_id', 'length', 'max'=>18),
			array('i_name, i_addtime, i_addip', 'length', 'max'=>128),
			array('i_nid, i_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('i_id, i_name, i_nid, i_cat_id, i_order, i_status, i_value, i_addtime, i_addip', 'safe', 'on'=>'search'),
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
			'itemcat' => array(self::BELONGS_TO, 'Itemcat', 'i_cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'i_id' => 'ID',
			'i_name' => '名称',
			'i_nid' => '标示',
			'i_cat_id' => '类型',
			'i_order' => '排序',
			'i_status' => '状态',
			'i_value' => '键值',
			'i_addtime' => '添加时间',
			'i_addip' => '添加IP',
		);
	}
	
	public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'i_status'=>array(
                '0'=>'关闭',
                '1'=>'开启',
            ),
        );
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

		$criteria->compare('i_id',$this->i_id,true);
		$criteria->compare('i_name',$this->i_name,true);
		$criteria->compare('i_nid',$this->i_nid,true);
		$criteria->compare('i_cat_id',$this->i_cat_id,true);
		$criteria->compare('i_order',$this->i_order);
		$criteria->compare('i_status',$this->i_status);
		$criteria->compare('i_value',$this->i_value,true);
		$criteria->compare('i_addtime',$this->i_addtime,true);
		$criteria->compare('i_addip',$this->i_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}