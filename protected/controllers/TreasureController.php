<?php

/**
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class TreasureController extends Controller{

	private $password = "treasure@7pointer.com" ;

	public function actionLiubiao() {
		$result = array('status' => 0);
		if (isset($_POST['treasure_password']) && $_POST['treasure_password'] == $this->password) {
			$project_model = Project::model();
			$liubiao_list = $project_model->findAllByAttributes(array('p_status' => '1',),
					array('condition' => '(p_verifytime+(p_valid_time*3600*24)) < :thetime AND p_account <> p_account_yes',
						'params' => array(':thetime' => time()),));
			if (!empty($liubiao_list)) {
				foreach ($liubiao_list as $k => $v) {
					$liubiao_project_son = array(
						'project_id' => $v->p_id,
						'project_name' => $v->p_name,
					);
					if (LYCommon::Liubiao($v)) {
						$liubiao_project_son['liubiao_suc'] = 'suc';
					} else {
						$liubiao_project_son['liubiao_suc'] = 'fail';
					}
					$result['liubiao_list'][] = $liubiao_project_son;
				}
				if (!empty($result['liubiao_list'])) {
					$result['status'] = 1;
				} else {
					$result['status'] = 2;
					$result['message'] = 'There is no flow mark project'; //没有流标的项目
				}
			} else {
				$result['status'] = 2;
				$result['message'] = 'There is no flow mark project'; //没有流标的项目
			}
		} else {
			$result['message'] = 'password is not correct';
		}
		echo json_encode($result);
	}
	
}

?>