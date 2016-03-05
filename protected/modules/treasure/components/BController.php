<?php

class BController extends CController{
    public $layout = '/layouts/backmain';
    /*
     * 初始化
     */
    protected $_baseUrl;
    protected $_theme;
    protected $_themePath;
    protected $page_title;//页面标题
    protected $page_desc;//页面简介
    protected $leftmenu;
    protected $js=array();
    protected $css=array();
    
    protected $system_menu;//系统设置菜单
    
    public function init(){
        $this->_baseUrl = Yii::app()->baseUrl;
        $this->_theme = Yii::app()->theme;
        $this->_themePath = str_replace(array('\\', '\\\\'), '/', Yii::app()->theme->basePath);
        require_once(WWWPATH . DS .'protected'.DS.'config'.DS.'global.php');
        require_once(Yii::getPathOfAlias('ext').'/360safe/360webscan.php');
        Yii::app()->params = require(WWWPATH . DS .'protected'.DS.'config'.DS.'params.php');
        $this -> system_menu = Systemcat::model()->findAll(array(
            'condition'=>'systemcat_parent = 0',
        ));
    }
    
    public function beforeAction($action) {
        if(parent::beforeAction($action)){
            //访问页面不是list则插入日志
            if($action->getid() != 'list'){
                self::addworklog();
            }
            return true;
        }
    }
    
    public function addworklog(){
        $worklog_model = new Worklog;
        $worklog_model -> worklog_url = Yii::app()->request->hostInfo.Yii::app()->request->getUrl();
        if(!Yii::app()->user->getIsGuest()){
            $worklog_model -> manager_id = Yii::app()->user->id;
        }else{
            $worklog_model -> manager_id = "0";
        }
        $worklog_model -> manager_name = Yii::app()->user->name;
        $worklog_model -> operation_ip = Yii::app()->request->userHostAddress;
        $worklog_model -> operation_time = time();
        $worklog_model -> save();
        
    }
    
    /**
    * 编辑器文件上传
    */
    public function actionUpload ()
    {
        if (LYCommon::method() == 'POST') {
            Yii::import('application.extensions.XUpload');
            //$accountUserId = Yii::app()->session['work__id'];
            //$adminiUserId = self::_sessionGet('adminiUserId');
            $file = XUpload::upload($_FILES['imgFile']);
            if (is_array($file)) {
                exit(CJSON::encode(array ('error' => 0 , 'url' => Yii::app()->baseUrl . '/' . $file['pathname'] )));

            } else {
                exit(CJSON::encode(array ('error' => 1 , 'message' => '上传错误' )));
            }
        }
    }
    
    public function get_notoper_count($type){
        if($type == 'wait_check_oper'){
            $project_model = Project::model();
            return $project_model ->countByAttributes(array(
                'p_status'=>0,
            ));
        }
        if($type == 'full_check_oper'){
            $project_model = Project::model();
            return $project_model ->countByAttributes(array(
                'p_status'=>1,
            ),array(
                'condition'=>'p_account = p_account_yes'
            ));
        }
        if($type == 'assetsRecharge_update'){
            $assets_recharge_model = AssetsRecharge::model();
            return $assets_recharge_model ->countByAttributes(array(
                'r_type'=>2,
                'r_status'=>0,
            ));
        }
        if($type == 'assetsCash_update'){
            $assets_cash_model = AssetsCash::model();
            return $assets_cash_model ->countByAttributes(array(
                'c_status'=>0,
            ));
        }
        if($type == 'identity_wait_oper'){
            $identity_model = Identity::model();
            return $identity_model->countByAttributes(array(
                'status'=>0,
            ));
        }
    }
    
    public function set_treasure_menu($menu_arr=null){
        $userid = Yii::app()->user->id;
        $manager_model = Manager::model();
        $manager_info = $manager_model -> findByPk($userid);
        $manager_info -> work_menu = json_encode($menu_arr);
        $manager_info -> update();
    }
    
    
    public function get_treasure_menu($menu_arr=null){
        $userid = Yii::app()->user->id;
        $manager_model = Manager::model();
        $manager_info = $manager_model -> findByPk($userid);
        if(empty($manager_info->work_menu)){
            return false;
        }else{
            return json_decode($manager_info->work_menu,true);
        }
    }
}