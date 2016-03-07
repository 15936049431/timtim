<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property string $article_id
 * @property string $article_cat_id
 * @property string $pub_user_id
 * @property string $article_title
 * @property string $article_pic
 * @property string $article_desc
 * @property string $article_cont
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $show_status
 * @property integer $issupport
 */
class Article extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return '{{article}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, article_cat_id, pub_user_id, article_title, article_desc, article_cont, add_time', 'required','message'=>'{attribute}不能为空'),
			array('add_time, update_time, show_status, issupport', 'numerical', 'integerOnly'=>true),
			array('article_id, article_cat_id, pub_user_id', 'length', 'max'=>18),
			array('article_title', 'length', 'max'=>64),
			array('article_desc', 'length', 'max'=>255),
                        array('article_pic', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png', 'maxSize'=>2048152, 'tooLarge' => '{file}文件不能超过 2MB. 请上传小一点儿的文件.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('article_id, article_cat_id, pub_user_id, article_title, article_pic, article_desc, article_cont, add_time, update_time, show_status, issupport', 'safe', 'on'=>'search'),
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
                         'manager'=>array(self::BELONGS_TO,'Manager','pub_user_id'),
			 'articlecat'=>array(self::BELONGS_TO,'Articlecat','article_cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'article_id' => '文章ID',
                'article_cat_id' => '文章分类',
                'pub_user_id' => '发布用户',
                'article_title' => '文章标题',
                'article_pic' => '标题图片',
                'article_desc' => '文章简介',
                'article_cont' => '文章内容',
                'add_time' => '添加时间',
                'update_time' => '更新时间',
                'show_status' => '显示状态',
                'issupport' => '是否推荐',
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

		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('article_cat_id',$this->article_cat_id,true);
		$criteria->compare('pub_user_id',$this->pub_user_id,true);
		$criteria->compare('article_title',$this->article_title,true);
		$criteria->compare('article_pic',$this->article_pic,true);
		$criteria->compare('article_desc',$this->article_desc,true);
		$criteria->compare('article_cont',$this->article_cont,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('show_status',$this->show_status);
		$criteria->compare('issupport',$this->issupport);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}