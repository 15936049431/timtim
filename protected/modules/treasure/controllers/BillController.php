<?php

class BillController extends BController
{
	public function actionIndex()
	{
            $this->render('index');
	}
        /*
         * 列表
         */
        public function actionList(){
            $model = Bill::model();
			$model->unsetAttributes();
			$user_model=User::model();
			$criteria = new CDbCriteria;
			if(isset($_GET['Bill'])){
				$model->attributes=$_GET['Bill'];
			}
			if(isset($_GET['User'])){
				$user_model->attributes=$_GET['User'];
			}
			$criteria->with='user';
			$criteria->compare('b_itemtype',$model->b_itemtype);
			$criteria->compare('user.user_name',$user_model->user_name,true);
            if(!empty($_GET['start_time'])){
                $criteria->addCondition('b_time > '. strtotime($_GET['start_time']));
            }
            if(!empty($_GET['end_time'])){
                $criteria->addCondition('b_time <= '. strtotime($_GET['end_time']. '23:59:59'));
            }
			if(isset($_GET['outfile_excel'])){
				set_time_limit(0);
				Yii::import('application.extensions.phpexcel.JPhpExcel');
				$criteria -> order = 'b_time  DESC,b_id DESC';
				
				
				$list = $model->findAll($criteria);
				
				$data = array(
						array(
							 "序号","ID", "用户名", "真实姓名", "操作类型", "操作金额", "总金额", "可用金额", "冻结金额", "待收金额", "发生时间", "备注"
						),
				);

				foreach($list as $k => $v){
					$data[] = array(
							$k+1,
							$v->b_id,
							empty($v->user) ? "" : $v->user->user_name,
							empty($v->user) ? "" : $v->user->real_name,
							LYCommon::GetItem($v->b_itemtype,'assets_type'),
							$v->b_money,
							$v->u_total_money,
							$v->u_real_money,
							$v->u_frost_money,
							$v->u_wait_total_money,
							LYCommon::subtime($v->b_time,2),
							$v->remark,
					);

				}
			
				$xls = new JPhpExcel('UTF-8',true);
				$xls->addArray($data);
				$xls->generateXML('资金记录',false);
				die;
			}
			
            $total_count = $model->count($criteria);
            $page = new Pagination($total_count,10);
            $page_list = $page->fpage(array(4,5,6, 3, 7,0,2));
            $page_list = $total_count<=$page->limitnum?"":$page_list;
            $criteria -> order = 'b_time  DESC,b_id DESC';
            $criteria -> limit = $page->limitnum;
            $criteria -> offset = $page->offset;
            $list = $model->findAll($criteria);
            $item=LYCommon::GetItemList('assets_type');
            $type_list[''] = '全部';
            foreach($item as $key=>$value){
                    $type_list[$value->i_nid]=$value->i_name;
            }
            $this->render('list',array(
                'model'=>$model,
				'user_model'=>$user_model,
				'type_list'=>$type_list,
                'list'=>$list,
                'page_list'=>$page_list,
            ));
        }
        
        /*
         * 创建
         */
        public function actionCreate(){
            $model = new Bill;
            
            if(isset($_POST['Bill'])){
                $model->attributes = $_POST['Bill'];
                $mr_arr = '[{"field_name":"b_id","fortablename":"lc_bill","iskey":"PRI","input_type":"0","title":"\u8d44\u91d1\u8bb0\u5f55id"},{"field_name":"user_id","fortablename":"lc_bill","iskey":"","input_type":"0","title":"\u7528\u6237id"},{"field_name":"b_money","fortablename":"lc_bill","iskey":"","input_type":"1","title":"\u8d44\u91d1\u53d8\u52a8\u91d1\u989d"},{"field_name":"b_type","fortablename":"lc_bill","iskey":"","input_type":"3","title":"\u53d8\u52a8\u7c7b\u578b","data":"1,\u6536\u5165$2,\u652f\u51fa"},{"field_name":"u_total_money","fortablename":"lc_bill","iskey":"","input_type":"1","title":"\u7528\u6237\u8d44\u91d1\u603b\u989d"},{"field_name":"u_real_money","fortablename":"lc_bill","iskey":"","input_type":"1","title":"\u7528\u6237\u53ef\u7528\u8d44\u91d1"},{"field_name":"u_frost_money","fortablename":"lc_bill","iskey":"","input_type":"1","title":"\u7528\u6237\u51bb\u7ed3\u8d44\u91d1"},{"field_name":"b_time","fortablename":"lc_bill","iskey":"","input_type":"0","title":"\u53d8\u52a8\u65f6\u95f4"},{"field_name":"remark","fortablename":"lc_bill","iskey":"","input_type":"2","title":"\u5907\u6ce8"},{"field_name":"user_id","fortablename":"lc_user","iskey":"PRI","input_type":"0","title":"\u7528\u6237id"},{"field_name":"user_name","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u767b\u5f55\u540d"},{"field_name":"login_pass","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u767b\u9646\u5bc6\u7801"},{"field_name":"pay_pass","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u652f\u4ed8\u5bc6\u7801"},{"field_name":"user_email","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u90ae\u7bb1"},{"field_name":"user_phone","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u624b\u673a"},{"field_name":"home_tel","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u5bb6\u5ead\u7535\u8bdd"},{"field_name":"user_qq","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237QQ"},{"field_name":"user_pic","fortablename":"lc_user","iskey":"","input_type":"6","title":"\u7528\u6237\u5934\u50cf"},{"field_name":"real_name","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u771f\u5b9e\u59d3\u540d"},{"field_name":"card_num","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u8bc1\u4ef6\u53f7\u7801"},{"field_name":"user_sex","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u6027\u522b","data":"0,\u672a\u77e5$1,\u7537$2,\u5973"},{"field_name":"user_age","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u5e74\u9f84"},{"field_name":"user_edu","fortablename":"lc_user","iskey":""},{"field_name":"birth_place","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u51fa\u751f\u5730"},{"field_name":"live_place","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u5c45\u4f4f\u5730"},{"field_name":"user_address","fortablename":"lc_user","iskey":"","input_type":"1","title":"\u7528\u6237\u8054\u7cfb\u5730\u5740"},{"field_name":"p_user_id","fortablename":"lc_user","iskey":""},{"field_name":"user_type","fortablename":"lc_user","iskey":""},{"field_name":"is_email_check","fortablename":"lc_user","iskey":""},{"field_name":"is_phone_check","fortablename":"lc_user","iskey":""},{"field_name":"is_realname_check","fortablename":"lc_user","iskey":""},{"field_name":"vip_stop_time","fortablename":"lc_user","iskey":""},{"field_name":"is_hook","fortablename":"lc_user","iskey":""},{"field_name":"resiter_time","fortablename":"lc_user","iskey":""},{"field_name":"login_time","fortablename":"lc_user","iskey":""}]';
                foreach(json_decode($mr_arr) as $k => $v){
                    if(!array_key_exists($v->field_name,$_POST['Bill']) || empty($_POST['Bill'][$v->field_name])){
                        $model->{$v->field_name} = $v->mr;
                    }
                }
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','资金记录添加成功！');
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
            if(isset($_POST['Bill'])){
                $model->attributes = $_POST['Bill'];
                
                if($model->save()){
                    Yii::app()->user->setFlash('success','资金记录更新成功！');
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
                $model = Bill::model();
                if($model->deleteAllByAttributes(array('bill_id'=>$_POST['delarr']))){
                    $del_result['status'] = 1;
                }else{
                    $del_result['message'] = '删除失败';
                }
                echo json_encode($del_result);
            }
        }
        public function loadmodel($id){
            return Bill::model()->findByPk($id);
        }
}