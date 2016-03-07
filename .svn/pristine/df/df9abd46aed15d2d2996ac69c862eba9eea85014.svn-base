<?php

/**
 * This is the model class for table "{{project}}".
 *
 * The followings are the available columns in table '{{project}}':
 * @property string $p_id
 * @property string $p_user_id
 * @property string $p_name
 * @property string $p_account
 * @property string $p_account_yes
 * @property integer $p_time_limit
 * @property integer $p_valid_time
 * @property integer $p_time_limittype
 * @property integer $p_apr
 * @property integer $p_style
 * @property string $p_pic
 * @property integer $p_status
 * @property string $p_verifyuser
 * @property string $p_verifytime
 * @property string $p_verifyremark
 * @property string $p_fullverifyuser
 * @property string $p_fullverifytime
 * @property string $p_fullverifyremark
 * @property integer $p_type
 * @property string $p_dxb
 * @property string $p_content
 * @property integer $p_award_type
 * @property integer $p_award
 * @property integer $p_ordernum
 * @property integer $p_lowaccount
 * @property integer $p_mostaccount
 * @property string $p_success
 * @property string $p_endtime
 * @property integer $p_autorate
 * @property double $p_repayment
 * @property double $p_repayment_yes
 * @property string $p_expansion
 * @property string $p_addtime
 * @property string $p_addip
 * @property string $p_outord 小贷系统编号
 * @property string $p_brand 汽车品牌
 * @property string $p_plate 车牌号
 * @property integer $p_kilometer
 * @property string $p_carddate 上牌日期
 * @property string $p_carcolor 
 * @property integer $p_city 
 * @property integer $p_province
 * @property string $p_origin 籍贯
 * @property string $p_evaluation 评估价
 */
class Project extends CActiveRecord {

    public $authcode;
    public $scalar;
    public $valid_use;
    public $valid_have;
    public $typename;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{project}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('p_id, p_user_id, p_name, p_account, p_time_limit, p_valid_time, p_time_limittype, p_apr, p_style, p_status, p_type, p_content, p_award_type, p_lowaccount, p_mostaccount, p_autorate, p_addtime, p_addip', 'required'),
            array('p_time_limit, p_valid_time, p_time_limittype, p_apr, p_style, p_status, p_type, p_award_type, p_award, p_ordernum, p_lowaccount, p_mostaccount, p_autorate', 'numerical', 'integerOnly' => true),
            array('p_repayment, p_repayment_yes', 'numerical'),
            array('p_id, p_user_id, p_verifyuser, p_fullverifyuser', 'length', 'max' => 18),
            array('p_name, p_success, p_endtime, p_addtime, p_addip', 'length', 'max' => 128),
            array('p_account, p_account_yes', 'length', 'max' => 11),
            array('authcode', 'captcha', 'message' => '验证码不正确'),
            array('p_autorate', 'compare', 'compareValue' => 100, 'operator' => '<='),
            array('p_autorate', 'compare', 'compareValue' => 0, 'operator' => '>='),
            array('p_pic, p_verifytime, p_verifyremark, p_fullverifytime, p_fullverifyremark, p_dxb, p_expansion', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('p_id, p_user_id, p_name, p_account, p_account_yes, p_time_limit, p_valid_time, p_time_limittype, p_apr, p_style, p_pic, p_status, p_verifyuser, p_verifytime, p_verifyremark, p_fullverifyuser, p_fullverifytime, p_fullverifyremark, p_type, p_dxb, p_content, p_award_type, p_award, p_ordernum, p_lowaccount, p_mostaccount, p_success, p_endtime, p_autorate, p_repayment, p_repayment_yes, p_expansion, p_addtime, p_addip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'p_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'p_id' => 'P',
            'p_user_id' => 'P User',
            'p_name' => '项目名称',
            'p_account' => '借款金额',
            'p_account_yes' => 'P Account Yes',
            'p_time_limit' => 'P Time Limit',
            'p_valid_time' => 'P Valid Time',
            'p_time_limittype' => 'P Time Limittype',
            'p_apr' => '年化利率',
            'p_style' => 'P Style',
            'p_pic' => 'P Pic',
            'p_status' => 'P Status',
            'p_verifyuser' => 'P Verifyuser',
            'p_verifytime' => 'P Verifytime',
            'p_verifyremark' => 'P Verifyremark',
            'p_fullverifyuser' => 'P Fullverifyuser',
            'p_fullverifytime' => 'P Fullverifytime',
            'p_fullverifyremark' => 'P Fullverifyremark',
            'p_type' => 'P Type',
            'p_dxb' => 'P Dxb',
            'p_content' => '借款详情',
            'p_award_type' => 'P Award Type',
            'p_award' => 'P Award',
            'p_ordernum' => 'P Ordernum',
            'p_lowaccount' => 'P Lowaccount',
            'p_mostaccount' => 'P Mostaccount',
            'p_success' => 'P Success',
            'p_endtime' => 'P Endtime',
            'p_autorate' => '自动投标比例',
            'p_repayment' => 'P Repayment',
            'p_repayment_yes' => 'P Repayment Yes',
            'p_expansion' => 'P Expansion',
            'p_outord' => '小贷系统编号',
            'p_brand' => '汽车品牌',
            'p_plate' => '车牌号',
            'p_kilometer' => '行驶公里', 'p_carddate' => '上牌日期',
            'p_carcolor'=>'颜色','p_city'=>'城市','p_province'=>'省份','p_origin'=>'籍贯',
            'p_evaluation'=>'评估价',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('p_id', $this->p_id, true);
        $criteria->compare('p_user_id', $this->p_user_id, true);
        $criteria->compare('p_name', $this->p_name, true);
        $criteria->compare('p_account', $this->p_account, true);
        $criteria->compare('p_account_yes', $this->p_account_yes, true);
        $criteria->compare('p_time_limit', $this->p_time_limit);
        $criteria->compare('p_valid_time', $this->p_valid_time);
        $criteria->compare('p_time_limittype', $this->p_time_limittype);
        $criteria->compare('p_apr', $this->p_apr);
        $criteria->compare('p_style', $this->p_style);
        $criteria->compare('p_pic', $this->p_pic, true);
        $criteria->compare('p_status', $this->p_status);
        $criteria->compare('p_verifyuser', $this->p_verifyuser, true);
        $criteria->compare('p_verifytime', $this->p_verifytime, true);
        $criteria->compare('p_verifyremark', $this->p_verifyremark, true);
        $criteria->compare('p_fullverifyuser', $this->p_fullverifyuser, true);
        $criteria->compare('p_fullverifytime', $this->p_fullverifytime, true);
        $criteria->compare('p_fullverifyremark', $this->p_fullverifyremark, true);
        $criteria->compare('p_type', $this->p_type);
        $criteria->compare('p_dxb', $this->p_dxb, true);
        $criteria->compare('p_content', $this->p_content, true);
        $criteria->compare('p_award_type', $this->p_award_type);
        $criteria->compare('p_award', $this->p_award);
        $criteria->compare('p_ordernum', $this->p_ordernum);
        $criteria->compare('p_lowaccount', $this->p_lowaccount);
        $criteria->compare('p_mostaccount', $this->p_mostaccount);
        $criteria->compare('p_success', $this->p_success, true);
        $criteria->compare('p_endtime', $this->p_endtime, true);
        $criteria->compare('p_autorate', $this->p_autorate);
        $criteria->compare('p_repayment', $this->p_repayment);
        $criteria->compare('p_repayment_yes', $this->p_repayment_yes);
        $criteria->compare('p_expansion', $this->p_expansion, true);
        $criteria->compare('p_addtime', $this->p_addtime, true);
        $criteria->compare('p_addip', $this->p_addip, true);
        
        $criteria->compare('p_outord', $this->p_outord, true);
        $criteria->compare('p_brand', $this->p_brand, true);
        $criteria->compare('p_plate', $this->p_plate, true);
        $criteria->compare('p_kilometer', $this->p_kilometer, true);
        $criteria->compare('p_carddate', $this->p_carddate, true);
        $criteria->compare('p_carcolor', $this->p_carcolor, true);
        $criteria->compare('p_city', $this->p_city, true);
        $criteria->compare('p_province', $this->p_province, true);
        $criteria->compare('p_origin', $this->p_origin, true);
        $criteria->compare('p_evaluation', $this->p_evaluation, true);
        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
