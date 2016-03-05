<?php

/* 
 * @author: 三氧化二砷 waitfox@qq.com
 * @Created:2015-8-28 9:43:32
 * @version:0.01
 * @desc:抽奖记录
 * 我只为你回眸一笑，即使不够倾国倾城，我只为你付出此生，换来生再次相守
 * The followings are the available columns in table '{{award_log}}':
 * @property string $id
 * @property integer $award_id
 * @property string $user_id
 * @property integer $status
 * @property integer $dtime
 * @property integer $addtime
 * @property string $addip
 */
class AwardLog extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{award_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('award_id', 'required'),
            array('award_id, status, dtime, addtime', 'numerical', 'integerOnly'=>true),
            array('user_id', 'length', 'max'=>20),
            array('addip', 'length', 'max'=>15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, award_id, user_id, status, dtime, addtime, addip', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
                         'award'=>array(self::BELONGS_TO,'Award','award_id'),
                         'user'=>array(self::BELONGS_TO,'User','user_id')
		);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'award_id' => '奖品ID',
            'user_id' => '用户ID',
            'status' => '兑换状态，1为已兑换',
            'dtime' => '兑换时间',
            'addtime' => '添加时间',
            'addip' => 'IP',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('award_id',$this->award_id);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('dtime',$this->dtime);
        $criteria->compare('addtime',$this->addtime);
        $criteria->compare('addip',$this->addip,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AwardLog the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
