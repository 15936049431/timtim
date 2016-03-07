<?php

/**
 * This is the model class for table "{{link}}".
 *
 * The followings are the available columns in table '{{link}}':
 * @property integer $link_id
 * @property string $link_name
 * @property string $link_pic
 * @property string $link_url
 * @property integer $link_order
 * @property integer $add_time
 * @property integer $update_time
 */
class Link extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Link the static model class
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
		return '{{link}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link_name, link_url, link_order,link_type,link_desc, add_time,link_pic', 'required'),
			array('link_order, add_time, update_time', 'numerical', 'integerOnly'=>true),
			array('link_pic, link_name, link_url', 'length', 'max'=>64),
			array('link_pic', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'maxSize'=>2048152, 'tooLarge' => '{file}文件不能超过 2MB. 请上传小一点儿的文件.',),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('link_id, link_name, link_pic, link_url, link_order, add_time, update_time', 'safe', 'on'=>'search'),
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
			'item'=>array(self::BELONGS_TO,'Item','link_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('link_id' => '链接ID','link_name' => '链接名称','link_pic' => '链接图片','link_url' => '链接URL','link_type' => '链接类型','link_order' => '链接排序','link_desc'=>'链接详情','add_time' => '添加时间','update_time' => '修改时间',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array('link_type' => array('1' =>'友情链接','2'=>'网站banner','3'=>'手机banner'),);
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

		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('link_name',$this->link_name,true);
		$criteria->compare('link_pic',$this->link_pic,true);
		$criteria->compare('link_url',$this->link_url,true);
		$criteria->compare('link_order',$this->link_order);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}