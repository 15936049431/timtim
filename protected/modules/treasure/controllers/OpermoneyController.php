<?php

class OpermoneyController extends BController{
    public function actionList(){
        $user_model = User::model();
        $list = array();
        $page_list = null;
        if(isset($_GET['Search'])){
            $criteria = new CDbcriteria;
            switch($_GET['Search']['search_type']){
                case 'user_id':
                    $criteria ->compare('user_id', $_GET['Search']['search_value'],true);
                    break;
                case 'user_name':
                    $criteria ->compare('user_name', $_GET['Search']['search_value'],true);
                    break;
                case 'real_name':
                    $criteria ->compare('real_name', $_GET['Search']['search_value'],true);
                    break;
            }
            $list = $user_model ->findAll($criteria);
        }
        $this->render('list',array(
            'user_model'=>$user_model,
            'list'=>$list,
            'page_list'=>$page_list,
        ));
    }
    
    public function actionPaymoney($id){
        $assets_model = Assets::model();
        $assets_info = $assets_model ->findByPk($id);
        if(!empty($assets_info)){
            $opermoney_post = null;
            $error_list = array();
            if(isset($_POST['Opermoney'])){
                $opermoney_post = $_POST['Opermoney'];
                if(!empty($opermoney_post['paymoney'])){
                    if(is_numeric($opermoney_post['paymoney'])){
                        $bill = array();
                        $bill['user_id'] = $assets_info->user_id;
                        $bill['b_money'] = $opermoney_post['paymoney'];
                        $bill['b_type'] = 1;
                        $bill['b_itemtype'] = $opermoney_post['b_itemtype'];
                        $bill['u_total_money']=$assets_info->total_money+$bill['b_money'];
                        $bill['u_real_money']=$assets_info->real_money+$bill['b_money'];
                        $bill['u_frost_money']=$assets_info->frost_money;
                        $bill['u_wait_interest']=$assets_info->wait_interest;
                        $bill['u_have_interest']=$assets_info->have_interest;
                        $bill['u_wait_total_money']=$assets_info->wait_total_money;
                        $bill['b_mark']=0;
                        $bill['b_time']=time();
                        $bill['remark']="后台充值{$bill['b_money']}元成功！";
                        $transaction = Yii::app()->db->beginTransaction();
                        try{
                            if(LYCommon::AddBill($bill)){
                                LYCommon::send_message(0,$assets_info->user_id,'back_pay',array('pay_money'=>$opermoney_post['paymoney']));
                            }
                            $transaction ->commit();
                            Yii::app()->user->setFlash('success',"充值成功，充值用户为{$assets_info->user->user_name}！");
                            $this->redirect(Yii::app()->controller->createUrl('opermoney/list'));
                        }  catch (Exception $e){
                            $transaction ->rollback();
                        }
                    }else{
                        $error_list['paymoney'] = '充值金额不是有效数字';
                    }
                }else{
                    $error_list['paymoney'] = '充值金额不可为空';
                }
            }
            $this->render('paymoney',array(
                'assets_info'=>$assets_info,
                'opermoney_post'=>$opermoney_post,
                'error_list'=>$error_list,
            ));
        }else{
            throw new CHttpException('500');
        }
    }
    
    
    public function actionOutmoney($id){
        $assets_model = Assets::model();
        $assets_info = $assets_model ->findByPk($id);
        if(!empty($assets_info)){
            $opermoney_post = null;
            $error_list = array();
            if(isset($_POST['Opermoney'])){
                $opermoney_post = $_POST['Opermoney'];
                if(!empty($opermoney_post['outmoney'])){
                    if(is_numeric($opermoney_post['outmoney'])){
                        if(($assets_info -> real_money - $opermoney_post['outmoney']) >= 0){
                            $bill = array();
                            $bill['user_id'] = $assets_info->user_id;
                            $bill['b_money'] = $opermoney_post['outmoney'];
                            $bill['b_type'] = 2;
                            $bill['b_itemtype'] = 'assets_back_outmoney';
                            $bill['u_total_money']=$assets_info->total_money-$bill['b_money'];
                            $bill['u_real_money']=$assets_info->real_money-$bill['b_money'];
                            $bill['u_frost_money']=$assets_info->frost_money;
                            $bill['u_wait_interest']=$assets_info->wait_interest;
                            $bill['u_have_interest']=$assets_info->have_interest;
                            $bill['u_wait_total_money']=$assets_info->wait_total_money;
                            $bill['b_mark']=0;
                            $bill['b_time']=time();
                            $bill['remark']="系统扣款{$bill['b_money']}元！";
                            $transaction = Yii::app()->db->beginTransaction();
                            try{
                                if(LYCommon::AddBill($bill)){
                                    LYCommon::send_message(0,$assets_info->user_id,'back_out_money',array('pay_money'=>$bill['b_money']));
                                }
                                $transaction ->commit();
                                Yii::app()->user->setFlash('success',"扣除成功，扣除用户为 {$assets_info->user->user_name}！");
                                $this->redirect(Yii::app()->controller->createUrl('opermoney/list'));
                            }  catch (Exception $e){
                                $transaction ->rollback();
                            }
                        }else{
                            $error_list['outmoney'] = "用户资金不足。无法扣除，用户当前可用余额为{$assets_info->real_money}!";
                        }
                    }else{
                        $error_list['outmoney'] = '扣除金额不是有效数字';
                    }
                }else{
                    $error_list['outmoney'] = '扣除金额不可为空';
                }
            }
            $this->render('outmoney',array(
                'assets_info'=>$assets_info,
                'opermoney_post'=>$opermoney_post,
                'error_list'=>$error_list,
            ));
        }else{
            throw new CHttpException('500');
        }
    }
}