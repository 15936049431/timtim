<?php

class AgreementController extends Controller{
    public function actionInvest($id=null){
        $project_order_model = ProjectOrder::model();
        $project_model = Project::model();
        $project_order_info = null;
        $project_order_list = array();
        $visit_type = null;
		$project_info = $project_model->findByPk($id);
        if(empty($project_info)){
            /*$visit_type = 'invester';
            $project_order_info = $project_order_model ->findByPk($id);
            $project_info = $project_model -> findByPk($project_order_info -> p_project_id);
			$project_order_list = $project_order_model ->findAllByAttributes(array('p_project_id'=>$project_order_info->p_project_id));*/
			throw new CHttpException(404);
        }else{
            $visit_type = 'loaner';
            //$project_info = $project_model -> findByPk($pid);
			$project_order_info = $project_order_model->findByAttributes(array("p_project_id"=>$id,"p_user_id"=>Yii::app()->user->id));
            $project_order_list = $project_order_model ->findAllByAttributes(array('p_project_id'=>$id));
        }
        
        switch($project_info->p_type){
            case 1://信用标
                $mPDF1 = Yii::app()->ePdf->mpdf();
                $mPDF1 = Yii::app()->ePdf->mpdf('UTF-8', 'A4', '', '', 15, 15, 30, 15);
                $mPDF1->useAdobeCJK = true;
                $mPDF1->SetAutoFont(AUTOFONT_ALL);

                $mPDF1->WriteHTML($this ->renderPartial('invest/credit_project',array(
                    'visit_type'=>$visit_type,
                    'project_info'=>$project_info,
                    'project_order_info'=>$project_order_info,
                    'project_order_list'=>$project_order_list,
                ), true));

                $mPDF1->Output();
                die;
                
                $this ->renderPartial('invest/credit_project',array(
                    'visit_type'=>$visit_type,
                    'project_info'=>$project_info,
                    'project_order_info'=>$project_order_info,
                    'project_order_list'=>$project_order_list,
                ));
                break;
            case 2://担保标
            	$mPDF1 = Yii::app()->ePdf->mpdf();
            	$mPDF1 = Yii::app()->ePdf->mpdf('UTF-8', 'A4', '', '', 15, 15, 30, 15);
            	$mPDF1->useAdobeCJK = true;
            	$mPDF1->SetAutoFont(AUTOFONT_ALL);
            	
            	$mPDF1->WriteHTML($this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	), true));
            	
            	$mPDF1->Output();
            	die;
            	
            	$this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	));
                break;
            case 3://抵押标
            	$mPDF1 = Yii::app()->ePdf->mpdf();
            	$mPDF1 = Yii::app()->ePdf->mpdf('UTF-8', 'A4', '', '', 15, 15, 30, 15);
            	$mPDF1->useAdobeCJK = true;
            	$mPDF1->SetAutoFont(AUTOFONT_ALL);
            	
            	$mPDF1->WriteHTML($this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	), true));
            	
            	$mPDF1->Output();
            	die;
            	
            	$this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	));
                break;
            case 4://秒标
            	$mPDF1 = Yii::app()->ePdf->mpdf();
            	$mPDF1 = Yii::app()->ePdf->mpdf('UTF-8', 'A4', '', '', 15, 15, 30, 15);
            	$mPDF1->useAdobeCJK = true;
            	$mPDF1->SetAutoFont(AUTOFONT_ALL);
            	
            	$mPDF1->WriteHTML($this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	), true));
            	
            	$mPDF1->Output();
            	die;
            	
            	$this ->renderPartial('invest/credit_project',array(
            			'visit_type'=>$visit_type,
            			'project_info'=>$project_info,
            			'project_order_info'=>$project_order_info,
            			'project_order_list'=>$project_order_list,
            	));
                break;
        }
    }
    
    public function actionDebt($id){
        $project_debt_model = ProjectDebt::model();
        $project_debt_info = $project_debt_model ->findByPk($id);
        $this ->renderPartial('debt/index');
    }
}