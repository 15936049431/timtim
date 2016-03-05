<?php

/**
 * 支持onBeforUpload和onAfterUpload事件
 * 同SWFUpload Widget一起使用
 * 
 * @author luochong <luochong1987@gmail.com>
 * @version 1.0.2  2010.10.19 14:08 
 */
class SWFUploadAction extends CAction {

    public $filepath = ''; //文件路径 c:/wamp/www/a.EXT 
    protected $callbackJS = '';

    public function run() {
        $this->init();
        $randname = rand(100000,999999);
        $newfilename = Yii::app()->user->id.'_'.Yii::app()->session['credit_id'].'_'.$randname;
        $filepath = $this->upload($newfilename);
        
        $user_credit = new UserCredit();
        $user_credit->user_credit_id = P2PCommon::getInsertID();
        $user_credit->user_id = Yii::app()->user->id;
        $user_credit->credit_id = Yii::app()->session['credit_id'];
        $user_credit->cert_check = 1;
        $user_credit->path_pic = $newfilename;
        $user_credit->credit_posttime = time();
        $user_credit->save();
        
        exit();
    }

    public function onAfterUpload($event) {
        $this->raiseEvent('onAfterUpload', $event);
    }

    public function onBeforeUpload($event) {
        $this->raiseEvent('onBeforeUpload', $event);
    }

    protected function init() {
        if (!isset($_POST['SWFUpload'])) {
            Yii::app()->getRequest()->redirect(Yii::app()->homeUrl);
            return;
        }
        
        $this->callbackJS = isset($_POST['callbackJS']) ? $_POST['callbackJS'] : '';
        if ($this->filepath === '') {
            throw new Exception('文件路径没有指定');
        }
        //删除上一个临时文件
        /* if(isset($_SESSION['temp_file'])&&is_file($_SESSION['temp_file'])&&(intval($_POST['fileQuenueLimit']) == 1))
          {
          unlink($_SESSION['temp_file']);                     //删除swfupload 的临时文件
          } */
    }

    protected function upload($file_name = 'abc.jpg') {
        $file = CUploadedFile::getInstanceByName('Filedata');
        
        $this->onBeforeUpload(new CEvent(array('uploadedFile' => &$file)));
        $this->filepath = str_replace('.EXT', '.' . $file->extensionName, $this->filepath);

        $filename = substr(strrchr($this->filepath, '/'), 1);
        $this->filepath = str_replace('\\', '/', $this->filepath);
        
        $filedir = str_replace(array("/$filename", Yii::app()->params['uploadDir']), '', $this->filepath);
        $filename=$file_name.'.'.$file->extensionName;
        if (!is_dir(Yii::app()->params['uploadDir'] . $filedir)) {
            mkdir(Yii::app()->params['uploadDir'] . $filedir, 0777, true);
        }
        $this->filepath = Yii::app()->params['uploadDir'] . $filedir. "/" . $filename;
        $file->saveAs($this->filepath);
        
        $_SESSION['temp_file'] = $this->filepath;
        echo 'JS:(' . $this->callbackJS . ")('$filename','$filedir','{$file->getName()}');";
        $this->onAfterUpload(new CEvent(array('uploadedFile' => &$file, 'name' => $filename, 'path' => $filedir)));
        return $this->filepath;
    }

}
