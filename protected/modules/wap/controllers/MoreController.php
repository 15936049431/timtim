<?php

class MoreController extends WController {

    public function actionindex() {

        $this->render('index', array(
        		
        ));
    }
    
    public function actionMessage(){
    	$message_model = Message::model();
    	$userid = Yii::app()->user->id;
    	$message_list = array();
    	if(empty($userid)){
    		$this->redirect(Yii::app()->controller->createUrl("site/login"));
    	}else{
    		$message_list = $message_model->findAll(array("limit"=>"10","condition"=>"get_user_id='{$userid}'","order"=>"add_time DESC"));
    	}
    	$this->render("message",array(
    		'message_list'=>$message_list,
    	));
    }

    /**
     * 抽奖页
     */
    public function actionDraw() {
        $model = Award::model();
        $awardList = $model->findAll();
        $this->render('draw', array('model' => $model, 'list' => $awardList));
    }

    /**
     * 抽奖实际页面
     */
    public function actiondodraw() {
        $userid = Yii::app()->user->id;
        if (Yii::app()->user->getIsGuest()) {
           $this->redirect(array('site/login'));
        }
        $user_model = User::model();
        //需要判断抽奖条件是否满足，积分或次数等
        $power = true;
        if (FALSE == $power) {
            die(-2); //用户没有抽奖资格
        }
        $model = Award::model();
        $awardList = $model->findAll();
        $str = '';
        $defaultPos = null; //默认奖品
        foreach ($awardList as $v) {
            $str.=str_repeat($v->id . ',', $v->award_ratio * 10000);
            if ($v->award_default == 1) {
                $defaultPos = $v->id;
            }
        }
        $drawArr = explode(',', $str);
        array_pop($drawArr);
        shuffle($drawArr);
        $rand = mt_rand(0, count($drawArr) - 1);
        $pos = $drawArr[$rand]; //返回该用户抽中的奖品
        $awardDetail = $model->findByPk($pos);
        if ($awardDetail->award_num - $awardDetail->award_snum <= 0 || 0 == $awardDetail->award_status) {
            //如果该奖品已抽完或不可用（不让用户抽此奖品） 
            $pos = $defaultPos;
        }
        if (null == $pos) {
            die(-1); //奖品已抽完，又没有设置默认奖品
        } else {
            switch ($awardDetail->award_type) {
                case 1://实物
                    break;
                case 2://积分
                    $data = array(
                        'user_id' => $userid,
                        'integral' => $awardDetail->point,
                        'type' => 1,
                        'i_cat_alias' => 'draw',
                        'remark' => '抽奖获得积分',
                    );
                    LYCommon::Addintegral($data);
                    break;
                case 3://现金
                    break;
                case 4://红包
                    break;
                case 5://体验金
                    Hook::giveExp($userid, $awardDetail->point, '抽奖');
                    break;
                default :
                    break;
            }
            $awardLog = new AwardLog;
            $awardLog->addtime = time();
            $awardLog->user_id = $userid;
            $awardLog->award_id = $pos;
            $awardLog->addip = yii::app()->request->userHostAddress;
            if (in_array($awardDetail->award_type, array(2, 3, 4, 5))) {
                //是虚拟物品，立即兑换
                $awardLog->dtime = time();
            }
            $awardLog->save();
            //发送站内信等
            die($pos);
        }
    }

}
