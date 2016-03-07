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
 * @property string $p_addip
 */
class Project extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public $sh_status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

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
            array('p_id, p_user_id, p_name, p_account, p_time_limit, p_valid_time, p_time_limittype, p_apr, p_style, p_status, p_type,  p_content, p_award_type,p_award, p_lowaccount, p_mostaccount, p_autorate, p_addtime, p_addip', 'required'),
            array('p_time_limit, p_valid_time, p_time_limittype, p_style, p_status, p_type, p_award_type, p_ordernum, p_lowaccount, p_mostaccount, p_autorate', 'numerical', 'integerOnly' => true),
            array('p_repayment, p_repayment_yes', 'numerical'),
            
            array('sh_status', 'required', 'on' => 'wait_check_oper'),
            array('sh_status', 'numerical', 'on' => 'wait_check_oper'),
            array('sh_status', 'required', 'on' => 'full_check_oper'),
            array('sh_status', 'numerical', 'on' => 'full_check_oper'),
            array('p_id, p_user_id, p_verifyuser, p_fullverifyuser', 'length', 'max' => 18),
            array('p_name, p_success, p_endtime, p_addtime, p_addip', 'length', 'max' => 128),
            array('p_account, p_account_yes', 'length', 'max' => 11),
            array('p_pic, p_verifytime, p_verifyremark, p_fullverifytime, p_fullverifyremark, p_dxb, p_expansion', 'length', 'max' => 255),

            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
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
            'manager' => array(self::BELONGS_TO, 'Manager', 'p_verifyuser'),
            'full_manager' => array(self::BELONGS_TO, 'Manager', 'p_fullverifyuser'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'p_id' => '项目id',
            'p_user_id' => '发布者id',
            'p_name' => '项目名称',
            'p_account' => '项目总额',
            'p_account_yes' => '已投标总额',
            'p_time_limit' => '借款周期',
            'p_valid_time' => '项目有效时间',
            'p_time_limittype' => '项目期限单位',
            'p_apr' => '年化利率',
            'p_style' => '还款方式',
            'p_pic' => '项目图片',
            'p_status' => '状态',
            'p_verifyuser' => '项目审核人员',
            'p_verifytime' => '项目审核时间',
            'p_verifyremark' => '项目审核备注',
            'p_fullverifyuser' => '满标审核人员',
            'p_fullverifytime' => '满标审核时间',
            'p_fullverifyremark' => '满标审核备注',
            'p_type' => '借款种类',
            'p_dxb' => '定向标密码',
            'p_content' => '项目详细内容描述',
            'p_award_type' => '奖励类型',
            'p_award' => '奖励',
            'p_ordernum' => '投资次数',
            'p_lowaccount' => '最少投标金额',
            'p_mostaccount' => '最大投标金额',
            'p_success' => '满标时间',
            'p_endtime' => '项目结束投标时间',
            'p_autorate' => '自动投标比例',
            'p_repayment' => '还款总额',
            'p_repayment_yes' => '已还款总额',
            'p_expansion' => 'p_expansion',
            'p_addtime' => '添加时间',
            'p_addip' => 'p_addip',
            'user_id' => '用户id',
            'user_name' => '登录名',
            'login_pass' => '登陆密码',
            'pay_pass' => '支付密码',
            'user_email' => '用户邮箱',
            'user_phone' => '用户手机',
            'home_tel' => '家庭电话',
            'user_qq' => '用户QQ',
            'user_pic' => '用户头像',
            'real_name' => '真实姓名',
            'card_num' => '证件号码',
            'user_sex' => '用户性别',
            'user_age' => '用户年龄',
            'user_edu' => 'user_edu',
            'birth_place' => '出生地',
            'live_place' => '居住地',
            'user_address' => '用户联系地址',
            'p_user_id' => 'p_user_id',
            'user_type' => 'user_type',
            'is_email_check' => 'is_email_check',
            'is_phone_check' => 'is_phone_check',
            'is_realname_check' => 'is_realname_check',
            'vip_stop_time' => 'vip_stop_time',
            'is_hook' => 'is_hook',
            'resiter_time' => 'resiter_time',
            'login_time' => 'login_time',
        );
    }

    public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'user_sex' => array(
                '0' => '未知',
                '1' => '男',
                '2' => '女',
            ),
            'p_time_limittype' => array(
                '0' => '月',
                '1' => '天',
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
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

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

        $criteria->compare('p_addtime', $this->p_addtime, true);
        $criteria->compare('p_addip', $this->p_addip, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
