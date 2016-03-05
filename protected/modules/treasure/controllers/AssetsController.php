<?php

class AssetsController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Assets::model();
			$model->unsetAttributes();
			$user_model=User::model();
			$criteria = new CDbCriteria;
			if(isset($_GET['User'])){
				$user_model->attributes=$_GET['User'];
			}
            if(isset($_GET['Search'])){
                 if(!empty($_GET['Search']['input_sel_type'])){
                      switch ($_GET['Search']['input_sel_type']){
                          case 'total_max':
                              $criteria ->addCondition('t.total_money>=:total_money');
                              $criteria -> params[':total_money']=$_GET['Search']['input_money'];
                              break;
                          case 'total_min':
                                        $criteria ->addCondition('t.total_money<=:total_money');
                                        $criteria -> params[':total_money']=$_GET['Search']['input_money'];
                                        break;
                                    case 'real_max':
                                        $criteria ->addCondition('t.real_money>=:real_money');
                                        $criteria -> params[':real_money']=$_GET['Search']['input_money'];
                                        break;
                                    case 'real_min':
                                        $criteria ->addCondition('t.real_money<=:real_money');
                                        $criteria -> params[':real_money']=$_GET['Search']['input_money'];
                                        break;
                                    case 'frost_max':
                                        $criteria ->addCondition('t.frost_money>=:frost_money');
                                        $criteria -> params[':frost_money']=$_GET['Search']['input_money'];
                                        break;
                                    case 'frost_min':
                                        $criteria ->addCondition('t.frost_money<=:frost_money');
                                        $criteria -> params[':frost_money']=$_GET['Search']['input_money'];
                                        break;
                                }
                            }
                        }
			$criteria->with='user';
			$criteria->compare('user.user_name',$user_model->user_name,true);
			$criteria->compare('user.real_name',$user_model->real_name,true);
			
			if(isset($_GET['outfile_excel'])){
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$list = $model->findAll($criteria);
				$data = array(
						array(
								"ID", "用户名", "真实姓名", "总金额", "可用金额", "冻结金额","商城余额","众筹余额","已收利息","待收利息","待收金额",
						),
				);
				foreach($list as $k => $v){
					$data[] = array(
							$v->user_id,
							empty($v->user->user_name) ? "" : $v->user->user_name,
							empty($v->user->real_name) ? "" : $v->user->real_name,
							$v->total_money,
							$v->real_money,
							$v->frost_money,
							$v->yuebao_money,
							$v->ourmoney,
							$v->have_interest,
							$v->wait_interest,
							$v->wait_total_money,
					);
				}
					
				$xls = new JPhpExcel('UTF-8',true);
				$xls->addArray($data);
				$xls->generateXML('资金列表',false);
				die;
			}
			
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
			$criteria -> order = " ourmoney desc" ;
			$list = $model->findAll($criteria);
            $this->render('list',array(
                'model'=>$model,
				'user_model'=>$user_model,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new Assets;
            
            if(isset($_POST['Assets'])){
                $model->attributes = $_POST['Assets'];
                $mr_arr = '[{"field_name":"user_id","fortablename":"lc_assets","iskey":"PRI","input_type":"0","title":"\u7528\u6237ID"},{"field_name":"user_name","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u7528\u6237\u540d"},{"field_name":"total_money","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u8d44\u91d1\u603b\u989d"},{"field_name":"real_money","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u53ef\u7528\u8d44\u91d1"},{"field_name":"frost_money","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u51bb\u7ed3\u8d44\u91d1"},{"field_name":"have_interest","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u5df2\u6536\u5229\u606f"},{"field_name":"wait_interest","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u5f85\u6536\u5229\u606f"},{"field_name":"wait_total_money","fortablename":"lc_assets","iskey":"","input_type":"1","title":"\u5f85\u6536\u603b\u989d"},{"field_name":"user_id","fortablename":"lc_user","iskey":"PRI","input_type":"0","title":"\u7528\u6237id"},{"field_name":"user_name","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u767b\u5f55\u540d"},{"field_name":"login_pass","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u767b\u9646\u5bc6\u7801"},{"field_name":"pay_pass","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u652f\u4ed8\u5bc6\u7801"},{"field_name":"user_email","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u90ae\u7bb1"},{"field_name":"user_phone","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u624b\u673a"},{"field_name":"home_tel","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u5bb6\u5ead\u7535\u8bdd"},{"field_name":"user_qq","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237QQ"},{"field_name":"user_pic","fortablename":"lc_user","iskey":"","input_type":"6","title":"\u7528\u6237\u5934\u50cf"},{"field_name":"real_name","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u771f\u5b9e\u59d3\u540d"},{"field_name":"card_num","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u8bc1\u4ef6\u53f7\u7801"},{"field_name":"user_sex","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u6027\u522b","data":"0,\u672a\u77e5$1,\u7537$2,\u5973"},{"field_name":"user_age","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u5e74\u9f84"},{"field_name":"user_edu","fortablename":"lc_user","iskey":""},{"field_name":"birth_place","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u51fa\u751f\u5730"},{"field_name":"live_place","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u5c45\u4f4f\u5730"},{"field_name":"user_address","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u8054\u7cfb\u5730\u5740"},{"field_name":"p_user_id","fortablename":"lc_user","iskey":""},{"field_name":"user_type","fortablename":"lc_user","iskey":""},{"field_name":"is_email_check","fortablename":"lc_user","iskey":""},{"field_name":"is_phone_check","fortablename":"lc_user","iskey":""},{"field_name":"is_realname_check","fortablename":"lc_user","iskey":""},{"field_name":"vip_stop_time","fortablename":"lc_user","iskey":""},{"field_name":"is_hook","fortablename":"lc_user","iskey":""},{"field_name":"resiter_time","fortablename":"lc_user","iskey":""},{"field_name":"login_time","fortablename":"lc_user","iskey":""}]';
                foreach(json_decode($mr_arr) as $k => $v){
                    if(!array_key_exists($v->field_name,$_POST['Assets']) || empty($_POST['Assets'][$v->field_name])){
                        $model->{$v->field_name} = $v->mr;
                    }
                }
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','资金添加成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('create',array(
                'model'=>$model,
            ));
        }
        
        /*
         * 更新
         */
        public function actionUpdate($id){
            $model = self::loadmodel($id);
            if(isset($_POST['Assets'])){
                $model->attributes = $_POST['Assets'];
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','资金更新成功！');
                    $this->redirect(Yii::app()->controller->createUrl('list'));
                }
            }
            $this->render('update',array(
                'model'=>$model,
            ));                    
        }
        
        /*
         * 删除单条记录
         */
        public function actionAjaxdelete($id){
            $model = self::loadmodel($id);
            if($model->delete()){
                echo json_encode(1);
                die;
            }else{
                echo json_encode(0);
                die;
            }
        }
        
        /*
         * 批量删除
         */
        public function actionAjaxdelmore(){
            if(isset($_POST['delarr'])){
                $del_result = array('status'=>0);
                $model = Assets::model();
                if($model->deleteAllByAttributes(array('assets_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Assets::model()->findByPk($id);
        }
}