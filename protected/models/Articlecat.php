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
 * @property string $tree
 * @property string $list_tmp_path
 * @property string $page_tmp_path
 * @property string $special_tmp_path
 * @property integer $is_show
 * @property integer $sort
 * @property string $pub_user_id
 * @property integer $add_time
 * @property integer $update_time
 */
class Articlecat extends CActiveRecord
{
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
			array('article_cat_id, article_cat_name, article_cat_alias, article_cat_desc, cat_type, p_id, tree, list_tmp_path, page_tmp_path, special_tmp_path, is_show, sort, pub_user_id, add_time, update_time', 'required'),
			array('cat_type, is_show, sort, add_time, update_time', 'numerical', 'integerOnly'=>true),
			array('article_cat_id, p_id, pub_user_id', 'length', 'max'=>18),
			array('article_cat_name', 'length', 'max'=>64),
			array('article_cat_alias', 'length', 'max'=>32),
			array('article_cat_desc', 'length', 'max'=>255),
			array('list_tmp_path, page_tmp_path, special_tmp_path', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('article_cat_id, article_cat_name, article_cat_alias, article_cat_desc, cat_type, p_id, tree, list_tmp_path, page_tmp_path, special_tmp_path, is_show, sort, pub_user_id, add_time, update_time', 'safe', 'on'=>'search'),
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
                    'p'=>array(self::BELONGS_TO,'Articlecat','p_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_cat_id' => 'Article Cat',
			'article_cat_name' => 'Article Cat Name',
			'article_cat_alias' => 'Article Cat Alias',
			'article_cat_desc' => 'Article Cat Desc',
			'cat_type' => 'Cat Type',
			'p_id' => 'P',
			'tree' => 'Tree',
			'list_tmp_path' => 'List Tmp Path',
			'page_tmp_path' => 'Page Tmp Path',
			'special_tmp_path' => 'Special Tmp Path',
			'is_show' => 'Is Show',
			'sort' => 'Sort',
			'pub_user_id' => 'Pub User',
			'add_time' => 'Add Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('tree',$this->tree,true);
		$criteria->compare('list_tmp_path',$this->list_tmp_path,true);
		$criteria->compare('page_tmp_path',$this->page_tmp_path,true);
		$criteria->compare('special_tmp_path',$this->special_tmp_path,true);
		$criteria->compare('is_show',$this->is_show);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('pub_user_id',$this->pub_user_id,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
