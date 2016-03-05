<?php

/**
 * This is the model class for table "{{project_autolog}}".
 *
 * The followings are the available columns in table '{{project_autolog}}':
 * @property string $p_id
 * @property string $p_user_id
 * @property string $p_project_id
 * @property integer $p_project_minmoney
 * @property integer $p_project_money
 * @property integer $p_project_maxmoney
 * @property integer $p_status
 * @property string $p_content
 * @property string $p_addtime
 * @property string $p_addip
 */
class ProjectAutolog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_autolog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('p_id, p_user_id, p_project_id, p_project_minmoney, p_project_money, p_project_maxmoney, p_status, p_content, p_addtime, p_addip', 'required'),
			array('p_project_minmoney, p_project_money, p_project_maxmoney, p_status', 'numerical', 'integerOnly'=>true),
			array('p_id, p_user_id, p_project_id', 'length', 'max'=>18),
			array('p_content', 'length', 'max'=>255),
			array('p_addtime, p_addip', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('p_id, p_user_id, p_project_id, p_project_minmoney, p_project_money, p_project_maxmoney, p_status, p_content, p_addtime, p_addip', 'safe', 'on'=>'search'),
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
			'p_id' => 'P',
			'p_user_id' => 'P User',
			'p_project_id' => 'P Project',
			'p_project_minmoney' => 'P Project Minmoney',
			'p_project_money' => 'P Project Money',
			'p_project_maxmoney' => 'P Project Maxmoney',
			'p_status' => 'P Status',
			'p_content' => 'P Content',
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
		$criteria->compare('p_project_id',$this->p_project_id,true);
		$criteria->compare('p_project_minmoney',$this->p_project_minmoney);
		$criteria->compare('p_project_money',$this->p_project_money);
		$criteria->compare('p_project_maxmoney',$this->p_project_maxmoney);
		$criteria->compare('p_status',$this->p_status);
		$criteria->compare('p_content',$this->p_content,true);
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
	 * @return ProjectAutolog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
