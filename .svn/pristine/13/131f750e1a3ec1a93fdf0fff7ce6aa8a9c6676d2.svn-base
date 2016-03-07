<?php

/**
 * This is the model class for table "{{safequestion}}".
 *
 * The followings are the available columns in table '{{safequestion}}':
 * @property string $sq_id
 * @property string $user_id
 * @property string $name_one
 * @property string $name_two
 * @property string $name_three
 * @property string $answer_one
 * @property string $answer_two
 * @property string $answer_three
 * @property integer $add_time
 * @property string $add_ip
 * @property integer $update_time
 * @property string $update_ip
 */
class Safequestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{safequestion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sq_id, user_id, name_one, name_two, name_three, answer_one, answer_two, answer_three', 'required' , 'on'=>'set_safe'),
			array('name_one, name_two, name_thre', 'vali_empty', 'on'=>'set_safe'),
			array('add_time, update_time', 'numerical', 'integerOnly'=>true, 'on'=>'set_safe'),
			array('sq_id, user_id', 'length', 'max'=>18, 'on'=>'set_safe'),
			array('name_one, name_two, name_three, answer_one, answer_two, answer_three', 'length', 'max'=>128),
			array('add_ip, update_ip', 'length', 'max'=>20),
                    
                    
                        //验证密保问题
                        array('answer_one, answer_two, answer_three','required','on'=>'vali_safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sq_id, user_id, name_one, name_two, name_three, answer_one, answer_two, answer_three, add_time, add_ip, update_time, update_ip', 'safe', 'on'=>'search'),
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
			'sq_id' => 'Sq',
			'user_id' => 'User',
			'name_one' => '安全问题一',
			'name_two' => '安全问题二',
			'name_three' => '安全问题三',
			'answer_one' => '答案一',
			'answer_two' => '答案二',
			'answer_three' => '答案三',
			'add_time' => 'Add Time',
			'add_ip' => 'Add Ip',
			'update_time' => 'Update Time',
			'update_ip' => 'Update Ip',
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

		$criteria->compare('sq_id',$this->sq_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name_one',$this->name_one,true);
		$criteria->compare('name_two',$this->name_two,true);
		$criteria->compare('name_three',$this->name_three,true);
		$criteria->compare('answer_one',$this->answer_one,true);
		$criteria->compare('answer_two',$this->answer_two,true);
		$criteria->compare('answer_three',$this->answer_three,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('add_ip',$this->add_ip,true);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('update_ip',$this->update_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function vali_empty(){
		if(empty($this -> name_one)){
			$this -> addError('name_one','安全问题一不可为空');
			return false;
		}elseif(empty($this -> name_two)){
			$this -> addError('name_two','安全问题二不可为空');
			return false;
		}elseif(empty($this -> name_three)){
			$this -> addError('name_three','安全问题三不可为空');
			return false;
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Safequestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
