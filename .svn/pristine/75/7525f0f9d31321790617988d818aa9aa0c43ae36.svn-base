<?php

/**
 * This is the model class for table "{{project_autoorder}}".
 *
 * The followings are the available columns in table '{{project_autoorder}}':
 * @property string $p_id
 * @property string $p_user_id
 * @property string $p_project_style
 * @property integer $p_order_minmoney
 * @property integer $p_order_maxmoney
 * @property integer $p_order_minapr
 * @property integer $p_order_maxapr
 * @property integer $p_order_minmonth
 * @property integer $p_order_maxmonth
 * @property integer $p_order_num
 * @property integer $p_order_status
 * @property string $p_order_autotime
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectAutoorder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_autoorder}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_id, p_user_id, p_project_style, p_order_minmoney, p_order_maxmoney, p_order_minapr, p_order_maxapr, p_order_minmonth, p_order_maxmonth, p_order_status, p_addtime, p_addip', 'required'),
			array('p_order_minmoney, p_order_maxmoney, p_order_minapr, p_retain, p_order_maxapr, p_order_minmonth, p_order_maxmonth, p_order_num, p_order_status', 'numerical', 'integerOnly'=>true),
			array('p_id, p_user_id', 'length', 'max'=>18),
			array('p_project_style', 'length', 'max'=>255),
			array('p_order_autotime, p_addtime, p_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_user_id, p_project_style, p_order_minmoney, p_order_maxmoney, p_order_minapr, p_order_maxapr, p_order_minmonth, p_order_maxmonth, p_order_num, p_order_status, p_order_autotime, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
                     'user' => array(self::BELONGS_TO, 'User', 'p_user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'p_id' => 'P',
			'p_user_id' => '用户名',
			'p_project_style' => '自动投标类型',
			'p_order_minmoney' => '最小投标金额',
			'p_order_maxmoney' => '最大投标金额',
			'p_order_minapr' => '最小投标利率',
			'p_order_maxapr' => '最大投标利率',
			'p_order_minmonth' => '最小月份',
			'p_order_maxmonth' => '最大月份',
			'p_order_num' => '自动投标次数',
			'p_order_status' => '自动投标状态',
			'p_order_autotime' => 'P Order Autotime',
			'p_retain'=>'保留可用余额',
			'p_addtime' => 'P Addtime',
			'p_addip' => 'P Addip',
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

		$criteria->compare('p_id',$this->p_id,true);
		$criteria->compare('p_user_id',$this->p_user_id,true);
		$criteria->compare('p_project_style',$this->p_project_style,true);
		$criteria->compare('p_order_minmoney',$this->p_order_minmoney);
		$criteria->compare('p_order_maxmoney',$this->p_order_maxmoney);
		$criteria->compare('p_order_minapr',$this->p_order_minapr);
		$criteria->compare('p_order_maxapr',$this->p_order_maxapr);
		$criteria->compare('p_order_minmonth',$this->p_order_minmonth);
		$criteria->compare('p_order_maxmonth',$this->p_order_maxmonth);
		$criteria->compare('p_order_num',$this->p_order_num);
		$criteria->compare('p_order_status',$this->p_order_status);
		$criteria->compare('p_order_autotime',$this->p_order_autotime,true);
		$criteria->compare('p_addtime',$this->p_addtime,true);
		$criteria->compare('p_addip',$this->p_addip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProjectAutoorder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
