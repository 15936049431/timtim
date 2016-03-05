<?php

class TreasureModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'treasure.models.*',
			'treasure.components.*',
		));
                Yii::app()->setComponents(array(
                    'user'=>array(
                        'stateKeyPrefix' =>'treasure_',
                        'loginUrl'=>Yii::app()->baseUrl.'/index.php/treasure/login/login',
                    ),
                    'errorHandler'=>array(
                        //'errorAction'=>'work/error/index',
                    ),
                ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
                    if(!($controller->getID() == 'login')){
                        if(!Yii::app()->user->getIsGuest()){
                            if(empty(Yii::app()->session['issecloginval'])){
                                $controller->redirect(array('login/seclogin'));
                                die('二次登陆');
                            }
                            if(!Yii::app()->user->issuper){
                                if(!Yii::app()->user->checkAccess('treasure.'.$controller->getID().'.'.$action->getID())){
                                    header("Content-type:text/html;charset=utf-8");
                                    die('权限不足');
                                }
                            }
                        }else{
                            $controller->redirect(array('login/login'));
                        }
                    }
                    return true;
		}
		else
                    return false;
	}
}
