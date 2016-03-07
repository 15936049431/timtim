<?php

/**
 * This is the model class for table "{{itemcat}}".
 *
 * The followings are the available columns in table '{{itemcat}}':
 * @property string $i_id
 * @property string $i_name
 * @property integer $i_order
 * @property string $i_nid
 * @property string $i_addtime
 * @property string $i_addip
 */
class Itemcat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Itemcat the static model class
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
		return '{{itemcat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_cat_id, i_name, i_order, i_nid, i_addtime, i_addip', 'required'),
			array('i_order', 'numerical', 'integerOnly'=>true),
			array('i_cat_id', 'length', 'max'=>18),
			array('i_name', 'length', 'max'=>255),
			array('i_nid, i_addtime, i_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('i_id, i_name, i_order, i_nid, i_addtime, i_addip', 'safe', 'on'=>'search'),
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
			'i_cat_id' => 'ID',
			'i_name' => '名称',
			'i_order' => '排序',
			'i_nid' => '标示',
			'i_addtime' => '添加时间',
			'i_addip' => '添加IP',
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

		$criteria->compare('i_cat_id',$this->i_cat_id,true);
		$criteria->compare('i_name',$this->i_name,true);
		$criteria->compare('i_order',$this->i_order);
		$criteria->compare('i_nid',$this->i_nid,true);
		$criteria->compare('i_addtime',$this->i_addtime,true);
		$criteria->compare('i_addip',$this->i_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}