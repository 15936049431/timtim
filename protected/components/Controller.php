<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
        public $page_title = null;
        public $page_ftitle = null;
        public $page_desc = null;
        
        public $css = array();
        public $js = array();
        public $ucss = array();
        public $ujs = array();
        public $load_jquery = true;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        protected $_baseUrl;
        protected $_theme;
        protected $_themePath;
        
        public function init(){
            $this->_baseUrl = Yii::app()->baseUrl;
            $this->_theme = Yii::app()->theme;
            $this->_themePath = str_replace(array('\\', '\\\\'), '/', Yii::app()->theme->basePath);
            require_once(WWWPATH . DS .'protected'.DS.'config'.DS.'global.php');
            require_once(Yii::getPathOfAlias('ext').'/360safe/360webscan.php');
            Yii::app()->params = require(WWWPATH . DS .'protected'.DS.'config'.DS.'params.php');
            
            if(Yii::app()->params['site_switch'] == 2){
                die(Yii::app()->params['why_close_site']);
            }
        }
        
}