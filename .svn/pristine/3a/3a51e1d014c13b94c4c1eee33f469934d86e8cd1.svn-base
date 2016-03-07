<?php

/**
 * This is the model class for table "{{integral_shop}}".
 *
 * The followings are the available columns in table '{{integral_shop}}':
 * @property string $i_id
 * @property string $i_name
 * @property string $i_type
 * @property integer $i_order
 * @property integer $i_num
 * @property integer $i_price
 * @property string $i_pic
 * @property string $i_desc
 * @property integer $i_selenum
 * @property integer $i_twice
 * @property string $i_addtime
 * @property string $i_addip
 */
class IntegralShop extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntegralShop the static model class
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
		return '{{integral_shop}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_id, i_name, i_type, i_order, i_ntype,i_pic, i_num, i_price, i_desc, i_selenum, i_twice, i_addtime, i_addip', 'required'),
			array('i_order, i_num, i_price, i_selenum, i_twice', 'numerical', 'integerOnly'=>true),
			array('i_id, i_type', 'length', 'max'=>18),
			array('i_name, i_desc', 'length', 'max'=>255),
                        //array('i_pic', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'maxSize'=>2048152, 'tooLarge' => '{file}文件不能超过 2MB. 请上传小一点儿的文件.',),
			array('i_addtime, i_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('i_id, i_name, i_type, i_order, i_num, i_price, i_pic, i_desc, i_selenum, i_twice, i_addtime, i_addip', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'Item', 'i_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
        {
                return array('i_id' => '商品id','i_name' => '物品名称','i_ntype'=>'物品类别','i_type' => '物品类型','i_order' => '排序','i_num' => '物品数量','i_price' => '物品单价','i_pic' => '物品图片','i_desc' => '物品描述','i_selenum' => '已售数量','i_twice' => '是否可多次兑换','i_addtime' => '添加时间','i_addip' => '添加IP',);
                }
public static function itemAlias($type, $code = NULL) {
        $_items = array(
			'i_twice' => array('0' =>'可多次兑换','1' =>'不可多次兑换'),
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
		$criteria->compare('i_type',$this->i_type,true);
		$criteria->compare('i_order',$this->i_order);
		$criteria->compare('i_num',$this->i_num);
		$criteria->compare('i_price',$this->i_price);
		$criteria->compare('i_pic',$this->i_pic,true);
		$criteria->compare('i_desc',$this->i_desc,true);
		$criteria->compare('i_selenum',$this->i_selenum);
		$criteria->compare('i_twice',$this->i_twice);
		$criteria->compare('i_addtime',$this->i_addtime,true);
		$criteria->compare('i_addip',$this->i_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}