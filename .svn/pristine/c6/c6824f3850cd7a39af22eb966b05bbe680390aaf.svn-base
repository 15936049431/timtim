<?php

/**
 * This is the model class for table "{{articlecat}}".
 *
 * The followings are the available columns in table '{{articlecat}}':
 * @property string $article_cat_id
 * @property string $article_cat_name
 * @property string $article_cat_alias
 * @property string $article_cat_desc
 * @property integer $cat_type
 * @property string $p_id
 * @property string $list_tmp_path
 * @property string $page_tmp_path
 * @property string $special_tmp_path
 * @property string $pub_user_id
 * @property integer $add_time
 * @property integer $update_time
 */
class Articlecat extends CActiveRecord
{
	public $nname;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{articlecat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_cat_id, article_cat_name, article_cat_alias, article_cat_desc, cat_type, p_id, list_tmp_path, page_tmp_path, special_tmp_path, pub_user_id', 'required'),
			array('cat_type, add_time, is_show, sort, update_time', 'numerical', 'integerOnly'=>true),
			array('article_cat_id, p_id, pub_user_id', 'length', 'max'=>18),
			array('article_cat_name', 'length', 'max'=>64),
			array('article_cat_alias', 'length', 'max'=>32),
			array('article_cat_desc', 'length', 'max'=>255),
			array('list_tmp_path, page_tmp_path, special_tmp_path', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('article_cat_id, article_cat_name, article_cat_alias, article_cat_desc, cat_type, p_id, list_tmp_path, page_tmp_path, special_tmp_path, pub_user_id, add_time, update_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_cat_id' => 'Article Cat',
			'article_cat_name' => '栏目名称',
			'article_cat_alias' => '栏目别名',
			'article_cat_desc' => '栏目简介',
			'cat_type' => '栏目类型',
			'p_id' => '父栏目',
			'list_tmp_path' => '列表模板路径',
			'page_tmp_path' => '内容页模板路径',
			'special_tmp_path' => '封面页模板路径',
			'is_show' => '是否显示',
			'sort' => '排序',
			'pub_user_id' => '发布用户',
			'add_time' => '添加时间',
			'update_time' => '更新时间',
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

		$criteria->compare('article_cat_id',$this->article_cat_id,true);
		$criteria->compare('article_cat_name',$this->article_cat_name,true);
		$criteria->compare('article_cat_alias',$this->article_cat_alias,true);
		$criteria->compare('article_cat_desc',$this->article_cat_desc,true);
		$criteria->compare('cat_type',$this->cat_type);
		$criteria->compare('p_id',$this->p_id,true);
		$criteria->compare('list_tmp_path',$this->list_tmp_path,true);
		$criteria->compare('page_tmp_path',$this->page_tmp_path,true);
		$criteria->compare('special_tmp_path',$this->special_tmp_path,true);
		$criteria->compare('pub_user_id',$this->pub_user_id,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function itemAlias($type, $code = NULL) {
            $_items = array(
                'cat_type' => array(
                    '1' =>'列表类型',
                    '2' =>'单页类型',
                    '3' =>'封面类型',
                ),
            );
            if (isset($code))
                return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
            else
                return isset($_items[$type]) ? $_items[$type] : false;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Articlecat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
