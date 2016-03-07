<?php
/**
 * 
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class LYCommon {
    /*
     * 随机生成一个不重复16位的ID值
     */

    public static function getInsertID() {
        return time() . substr(microtime(), 2, 5) . sprintf('%d', rand(10, 99));
    }

    /*
     * 返回时间格式
     * $type 1:2014-08-08 12:12:12(返回时间精确到秒)
     * $type 2:2014-08-08 12:12(返回时间精确到分)
     * $type 3:2014-08-08（返回时间精确到日期）
     */

    public static function subtime($time = null, $type = 1) {
        if ($time <= 0) {
            return '未知时间';
        }
        switch ($type) {
            case 1:
                return date('Y-m-d H:i:s', $time);
                break;
            case 2:
                return date('Y-m-d H:i', $time);
                break;
            case 3:
                return date('Y-m-d', $time);
                break;
        }
    }

    /*
     * 生成缩略图功能
     * 主要参数： imgPath,图片路径;width,宽度;height,高度;s_imgPath,缩略图路径。
     */

    public static function saveThumb($imgPath, $s_imgPath, $width = 200, $height = 125) {
        Yii::import("ext.EPhpThumb.EPhpThumb");         //生成缩略图,原文件名加前缀s_作为缩略图文件名。
        $thumb = new EPhpThumb();
        $thumb->init();
        $thumb->create($imgPath)->resize($width, $height)->save($s_imgPath);
    }

    /*
     * lC字符串解密
     * $ser_key 需要接密的字符串
     * $slat 加盐值
     */

    public static function zjy_decode($ser_key, $slat) {
        $value = '';
        if (strlen($ser_key) > 1000 || strlen($ser_key) == 0 || strlen($slat) == 0)
            return $ser_key;
        $user_md5 = substr(strtoupper(md5($slat)), 5, 8);
        $key_arr = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            '=', '/', '+'
        );

        $key_arr_1 = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            '=', '/', '+', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '|', '-', '?', '<', '>',
        );
        for ($i = 0; $i < strlen($ser_key); $i++) {
            $csz = $i % 8;
            $str = substr($user_md5, $csz, 1);
            $ser_key_sub = substr($ser_key, $i, 1);
            $user_num_arr = array_keys($key_arr, $str);
            $ser_num_arr = array_keys($key_arr_1, $ser_key_sub);
            $key_value = $key_arr[($ser_num_arr[0] - $user_num_arr[0])];
            $value.=$key_value;
        }
        return base64_decode($value);
    }

    /*
     * lc字符串加密
     * $ser_key 需要加密的字符串
     * $slat 加盐值
     */

    public static function zjy_encode($ser_key, $slat) {
        $value = '';
        if (strlen($ser_key) > 1000 || strlen($ser_key) == 0 || strlen($slat) == 0)
            return $ser_key;
        $user_md5 = substr(strtoupper(md5($slat)), 5, 8);
        $ser_key = base64_encode($ser_key);

        $key_arr = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            '=', '/', '+'
        );

        $key_arr_1 = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            '=', '/', '+', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '|', '-', '?', '<', '>',
        );

        for ($i = 0; $i < strlen($ser_key); $i++) {
            $csz = $i % 8;
            $str = substr($user_md5, $csz, 1);
            $ser_key_sub = substr($ser_key, $i, 1);
            $user_num_arr = array_keys($key_arr, $str);
            $ser_num_arr = array_keys($key_arr, $ser_key_sub);
            $value.= $key_arr_1[($user_num_arr[0] + $ser_num_arr[0])];
        }

        return $value;
    }

    /*
     * 生成谷歌验证码
     */

    public static function setGoogleCode() {
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();      //生成密钥，随机值
        return $secret;
    }

    /*
     * 图片上传
     */

    public static function uploadimage($model, $fieldn_name, $dirname) {
        $image = CUploadedFile::getInstance($model, $fieldn_name);
        if ($image) {
            $end_name = strtolower($image->extensionName);
            if ($end_name != 'jpg' && $end_name != 'jpeg' && $end_name != 'png' && $end_name != 'gif')
                die('上传文件非法');
            if (!empty($image)) {
                $dir = dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
                if (!is_dir($dir)) {
                    mkdir($dir);
                    if (!is_dir($dir)) {
                        die('文件夹不存在');
                    }
                }
                $name = time() . strtolower(rand(1000, 9999)) . strrchr($image->name, '.');
                $image->saveAs($dir . $name);
                self::saveThumb($dir . $name, $dir . 's_' . $name);    //保存图像的时候，生成缩略图。
            }
        }
        return !empty($name) ? $name : false;
    }

    public static function get_pass($username, $password) {
        return md5(sha1(substr(md5($password), 7, 24) . $username));
    }

    /*
     * 正则验证
     * type 要检查的类型
     * value 要校正的值
     * return 1 返回true&false 2返回值&false
     */

    public static function check($type, $value, $return = 1) {
        $rule_arr = array(
            "id" => "/^[1-9][\d]*$/",
            "money" => "/^[0-9]{1,12}(\.[0-9]{1,2})?$/",
            "tel" => "/^1[0-9]{10}$/",
            "phone" => "/^\d{3,4}-?\d{6,10}$/",
            "email" => "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",
            "user" => "/^[a-zA-z]\w{5,15}$/",
            "qq" => "/^[1-9][0-9]{4,}$/",
            "card" => "/^[0-9]{8,36}$/",
            "pass" => "/^[\w.]{6,20}$/",
            "code" => "/^[a-zA-Z0-9]*$/",
            "type" => "/^[\d]{1,3}$/",
            "key" => "/^[a-zA-Z0-9]{1,32}$/"
        );
        if (array_key_exists($type, $rule_arr)) {
            if (preg_match($rule_arr[$type], $value)) {
                if ($return == 2) {
                    return $value;
                } else {
                    return true;
                }
            }
        }
        return false;
    }

    /*
     * 生成验证码
     * $len 长度
     */

    public static function getcode($len = 6) {
        $str = '';
        for ($i = 0; $i <= 5; $i++) {
            $str .= rand(1, 9);
        }
        return $str;
    }

    public static function format_money($value) {
        return sprintf("%.2f", substr(sprintf("%.6f", $value), 0, -2));
    }

    public static function get_message($type = 1) {
        return '恭喜提现成功';
    }

    /*
     * 根据经纬度算出距离
     */

    public static function getDistance($lat1, $lng1, $lat2, $lng2) {
        //地球半径
        $R = 6378137;
        //将角度转为狐度
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        //结果
        $s = acos(cos($radLat1) * cos($radLat2) * cos($radLng1 - $radLng2) + sin($radLat1) * sin($radLat2)) * $R;
        //精度
        $s = round($s * 10000) / 10000;
        return round($s);
    }

    public static function getByID($id, $type = "age") {
        if (strlen($id) == 15 || strlen($id) == 18) {
            if ($type == "age") {
                $date = strtotime(strlen($id) == 15 ? ('19' . substr($id, 6, 6)) : substr($id, 6, 8));
                $today = strtotime('today');
                $diff = floor(($today - $date) / 86400 / 365);
                $age = strtotime(substr($id, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;
                return $age;
            } else {
                //1,男 2,女
                $sex = substr($id, (strlen($id) == 15 ? -2 : -1), 1) % 2 ? 2 : 1;
                return $sex;
            }
        }
        return '';
    }

    /**
     * 验证身份证号
     * @param $vStr
     * @return bool
     */
    public static function isCard($vStr) {
        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr))
            return false;

        if (!in_array(substr($vStr, 0, 2), $vCity))
            return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday)
            return false;
        if ($vLength == 18) {
            $vSum = 0;

            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }

            if ($vSum % 11 != 1)
                return false;
        }

        return true;
    }

    public static function AddBill($data = array()) {
        $args = isset($data['args']) ? $data['args'] : array();
        unset($data['args']);
        $bill = new Bill();
        $check_num = array("b_money", "u_total_money", "u_real_money", "u_frost_money", "u_have_interest", "u_wait_interest", "u_wait_total_money","yuebao_money");
        foreach ($data as $k => $v) {
            if (in_array($k, $check_num)) {
                $data[$k] = round($v, 4);
            }
        }
        $bill->b_id = self::getInsertID();
        $bill->attributes = $data;
        if(isset($data['yuebao_money'])){
        	$bill->yuebao_money = $data['yuebao_money'];
        }
        if(isset($data['yuebao_income'])){
        	$bill->yuebao_income = $data['yuebao_income'];
        }
        $bill->b_addip = $_SERVER['REMOTE_ADDR'];
        if ($bill->insert()) {

            $assets = new assets();
            $user_assets = $assets->findByPk($data['user_id']);
            self::checkSign($user_assets); //校验数据完整性
            $user_assets->total_money = $data['u_total_money'];
            $user_assets->real_money = $data['u_real_money'];
            $user_assets->frost_money = $data['u_frost_money'];
            $user_assets->wait_interest = $data['u_wait_interest'];
            $user_assets->have_interest = $data['u_have_interest'];
            $user_assets->wait_total_money = $data['u_wait_total_money'];
            if(isset($data['yuebao_money'])){
            	$user_assets->yuebao_money = $data['yuebao_money'];
            }
            if(isset($data['yuebao_income'])){
            	$user_assets->yuebao_income = $data['yuebao_income'];
            }
            if (is_array($args)) {
                foreach ($args as $key => $value) {
                    $user_assets->$key = $value;
                }
            }
            if ($user_assets->save()) {
                self::sumPlatForm($data);
                //self::encryptSign($user_assets);
                return true;
            }
        } else {
            return false;
        }
    }

    public static function sumPlatForm($data = array()) {
        $everyday = array("assets_cash_success", "assets_recharge", "assets_order_forzen", "exp_money", "assets_repay", "assets_manage_fee", "assets_cash_fee");
        if (in_array($data['b_itemtype'], $everyday)) {
            $tixian = ($data['b_itemtype'] == "assets_cash_success") ? $data['b_money'] : 0;
            $chongzhi = ($data['b_itemtype'] == "assets_recharge") ? $data['b_money'] : 0;
            $order = ($data['b_itemtype'] == "assets_order_forzen") ? $data['b_money'] : 0;
            $register = ($data['b_itemtype'] == "exp_money") ? $data['b_money'] : 0;
            $repay = ($data['b_itemtype'] == "assets_repay") ? $data['b_money'] : 0;
            $manager_fee = ($data['b_itemtype'] == "assets_manage_fee") ? $data['b_money'] : 0;
            $cash_fee = ($data['b_itemtype'] == "assets_cash_fee") ? $data['b_money'] : 0;
            $date = date("Y-m-d", time());
            $every = new Everyday();
            $is_have = $every->findByAttributes(array('date' => $date));
            if (empty($is_have)) {
                $every->id = self::getInsertID();
                $every->date = $date;
                $every->recharge = $chongzhi;
                $every->cash = $tixian;
                $every->order = $order;
                $every->recharge_num = ($chongzhi > 0) ? 1 : 0;
                $every->cash_num = ($tixian > 0) ? 1 : 0;
                $every->order_num = ($order > 0) ? 1 : 0;
                $every->recharge_user = ($chongzhi > 0) ? 1 : 0;
                $every->cash_user = ($tixian > 0) ? 1 : 0;
                $every->order_user = ($order > 0) ? 1 : 0;
                $every->register_user = ($register > 0) ? 1 : 0;
                $every->repay_account = $repay;
                $every->repay_num = ($repay > 0) ? 1 : 0;
                $every->manager_fee = $manager_fee;
                $every->cash_fee = $cash_fee;
                $every->addtime = $every->lasttime = time();
                $every->addip = $_SERVER['REMOTE_ADDR'];
                $every->save();
            } else {
                $ret = self::GetTodayNum($data);
                $is_have->recharge = $is_have->recharge + $chongzhi;
                $is_have->cash = $is_have->cash + $tixian;
                $is_have->order = $is_have->order + $order;
                $is_have->repay_account = $is_have->repay_account + $repay;
                $is_have->manager_fee = $is_have->manager_fee + $manager_fee;
                $is_have->cash_fee = $is_have->cash_fee + $cash_fee;
                $is_have->repay_num = ($repay > 0) ? $is_have->repay_num + 1 : $is_have->repay_num;
                $is_have->recharge_num = ($chongzhi > 0) ? $is_have->recharge_num + 1 : $is_have->recharge_num;
                $is_have->cash_num = ($tixian > 0) ? $is_have->cash_num + 1 : $is_have->cash_num;
                $is_have->order_num = ($order > 0) ? $is_have->order_num + 1 : $is_have->order_num;
                $is_have->register_user = ($register > 0) ? $is_have->register_user + 1 : $is_have->register_user;
                $is_have->recharge_user = empty($ret['recharge_user']) ? $is_have->recharge_user : $ret['recharge_user'];
                $is_have->cash_user = empty($ret['cash_user']) ? $is_have->cash_user : $ret['cash_user'];
                $is_have->order_user = empty($ret['order_user']) ? $is_have->order_user : $ret['order_user'];
                $is_have->lasttime = time();
                $is_have->update();
            }
        }

        $every_user = new Everyuser();
        $user_now = $every_user->findByPk($data['user_id']);
        if (!empty($user_now)) {
            switch ($data['b_itemtype']) {
                case "assets_recharge":
                    $user_now->user_recharge = $user_now->user_recharge + $data['b_money'];
                    $user_now->user_recharge_num = $user_now->user_recharge_num + 1;
                    $user_now->user_first_recharge = empty($user_now->user_first_recharge) ? time() : $user_now->user_first_recharge;
                    $user_now->user_end_recharge = time();
                    $user_now->update();
                    break;
                case "assets_order_forzen":
                    $user_now->user_order = $user_now->user_order + $data['b_money'];
                    $user_now->user_order_num = $user_now->user_order_num + 1;
                    $user_now->user_first_order = empty($user_now->user_first_order) ? time() : $user_now->user_first_order;
                    $user_now->user_end_order = time();
                    $user_now->update();
                    break;
                case "assets_cash_success":
                    $user_now->user_cash = $user_now->user_cash + $data['b_money'];
                    $user_now->user_cash_num = $user_now->user_cash_num + 1;
                    $user_now->user_first_cash = empty($user_now->user_first_cash) ? time() : $user_now->user_first_cash;
                    $user_now->user_end_cash = time();
                    $user_now->update();
                    break;
                case "assets_cash_fee":
                    $user_now->user_cashfee = $user_now->user_cashfee + $data['b_money'];
                    $user_now->update();
                    break;
                case "assets_receivables":
                    $user_now->user_haverepay = $user_now->user_haverepay + $data['b_money'];
                    $user_now->update();
                    break;
                case "assets_record":
                    $user_now->user_project = $user_now->user_project + $data['b_money'];
                    $user_now->user_first_project = empty($user_now->user_first_project) ? time() : $user_now->user_first_project;
                    $user_now->user_end_project = time();
                    $user_now->update();
                    break;
            }
        }
    }

    public static function GetTodayNum($data = array()) {
        $connection = Yii::app()->db;
        $result['recharge_user'] = $result['cash_user'] = $result['order_user'] = 0;
        $today = strtotime(date("Y-m-d", time()));
        $tommorrow = $today + 60 * 60 * 24;
        if ($data['b_itemtype'] == "assets_cash_success") {
            $sql = "select count(distinct c_user_id) from {{assets_cash}} where c_addtime>{$today} and c_addtime<{$tommorrow} and c_status=1";
            $ret = $connection->createCommand($sql)->queryScalar();
            $result['cash_user'] = $ret;
        } elseif ($data['b_itemtype'] == "assets_recharge") {
            $sql = "select count(distinct r_user_id) from {{assets_recharge}} where r_addtime>{$today} and r_addtime<{$tommorrow} and r_status=1";
            $ret = $connection->createCommand($sql)->queryScalar();
            $result['recharge_user'] = $ret;
        } elseif ($data['b_itemtype'] == "assets_order_forzen") {
            $sql = "select count(distinct p_user_id) from {{project_order}} where p_addtime>{$today} and p_addtime<{$tommorrow}";
            $ret = $connection->createCommand($sql)->queryScalar();
            $result['order_user'] = $ret;
        }
        return $result;
    }

    /*
     * 积分操作
     * 所需参数
     * $data = array();
     * $data['user_id']     操作用户
     * $data['integral']    操作积分
     * $data['type'] 收支类型    1表示收入    2表示支出
     * $data['i_cat_alias'] 操作类型  填写item里面的积分类型即可
     * remark 备注 可不填
     * 
     */

    public static function Addintegral($data = array()) {
        $integral_model = Integral::model();
        $integral_info = $integral_model->findByPk($data['user_id']);
        if ($data['type'] == 1) {
            switch ($data['i_cat_alias']) {
                case 'newday':
                case 'invest_give_integral'://如果是投标成功赠送积分
                    $integral_info->i_total_value += $data['integral'];
                    $integral_info->i_real_value += $data['integral'];
                    break;
            }
        } elseif ($data['type'] == 2) {
            switch ($data['i_cat_alias']) {
                default:
                    $integral_info->i_total_value -= $data['integral'];
                    $integral_info->i_real_value -= $data['integral'];
                    $integral_info->i_used_value += $data['integral'];
                    break;
            }
        }
        $integral_info->i_updatetime = time();
        if ($integral_info->update()) {
            $integral_log_model = new IntegralLog();
            $integral_log_model->i_id = self::getInsertID();
            $integral_log_model->i_user_id = $integral_info->user_id;
            $integral_log_model->i_type = $data['type'];
            $integral_log_model->i_cat_alias = $data['i_cat_alias'];
            $integral_log_model->i_value = $data['integral'];
            $integral_log_model->i_now = $integral_info->i_real_value;
            $integral_log_model->i_remark = $data['remark'];
            $integral_log_model->i_addtime = time();
            $integral_log_model->i_addip = Yii::app()->request->userHostAddress;
            if ($integral_log_model->insert()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /*
     * 积分操作
     * 所需参数
     * $data = array();
     * $data['i_cat_alias'] 操作类型  填写item里面的积分类型即可
     * $data['remark'] 备注 可不填
     * 
     */

    public static function Add_integral($integral_info, $data = array()) {
        $assets_model = Integral::model();
        $integral_old = $assets_model->findByPk($integral_info->user_id);

        $integral_info->i_updatetime = time();
        if ($integral_info->update()) {
            $change_modle = $integral_info->i_real_value - $integral_old->i_real_value;
            $integral_log_model = new IntegralLog();
            $integral_log_model->i_id = self::getInsertID();
            $integral_log_model->i_user_id = $integral_info->user_id;
            $integral_log_model->i_type = $change_modle > 0 ? 1 : 2;
            $integral_log_model->i_cat_alias = $data['i_cat_alias'];
            $integral_log_model->i_value = abs($change_modle);
            $integral_log_model->i_now = $integral_info->i_real_value;
            $integral_log_model->i_remark = $data['remark'];
            $integral_log_model->i_addtime = time();
            $integral_log_model->i_addip = Yii::app()->request->userHostAddress;
            if ($integral_log_model->insert()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /*
     * 授信额度操作
     * 所需参数
     * $data = array();
     * $data['user_id']     用户id
     * $data['type']       收支类型  1表示收入    2表示支出
     * $data['style']       使用场景 对应 item表
     * $data['credit_num']       变动授信额度
     * $data['remark']       备注
     */

    public static function Addusercredit($data) {
        $usercredit_model = Usercredit::model();
        $usercredit_info = $usercredit_model->findByPk($data['user_id']);
        if ($data['type'] == 1) {
            switch ($data['style']) {
                case 'app_credit_suc'://如果是申请授信额度成功
                    $usercredit_info->total_credit += $data['credit_num'];
                    $usercredit_info->real_credit += $data['credit_num'];
                    break;
            }
        } elseif ($data['type'] == 2) {
            switch ($data['style']) {
                case 'app_borrow'://如果是申请借款
                    $usercredit_info->real_credit -= $data['credit_num'];
                    $usercredit_info->use_credit += $data['credit_num'];
                    break;
            }
        }
        if ($usercredit_info->update()) {
            $creditlog_model = new Creditlog;
            $creditlog_model->c_id = self::getInsertID();
            $creditlog_model->user_id = $data['user_id'];
            $creditlog_model->c_type = $data['type'];
            $creditlog_model->c_style = $data['style'];
            $creditlog_model->c_credit = $data['credit_num'];
            $creditlog_model->now_credit = $usercredit_info->real_credit;
            $creditlog_model->remark = $data['remark'];
            $creditlog_model->add_time = time();
            $creditlog_model->add_ip = Yii::app()->request->userHostAddress;
            if ($creditlog_model->insert()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public static function GetItem($nid, $type) {
        $itemcat_model = new Itemcat();
        $itemcat = $itemcat_model->findByAttributes(array('i_nid' => $type));
        $item_model = new Item();
        $item = $item_model->findByAttributes(array('i_cat_id' => $itemcat->i_cat_id, 'i_nid' => $nid));
        if ($item != null) {
            return $item->i_name;
        } else {
            return '';
        }
    }

    public static function GetItemList($type, $order = '') {
        $itemcat_model = new Itemcat();
        $itemcat = $itemcat_model->findByAttributes(array('i_nid' => $type));
        $item_model = new Item();
        $item = $item_model->findAllByAttributes(array('i_cat_id' => $itemcat->i_cat_id, 'i_status' => 1), array(
            'order' => $order,
        ));
        return $item;
    }

    public static function GetItem_of_value($i_value, $type) {
        $itemcat_model = new Itemcat();
        $itemcat = $itemcat_model->findByAttributes(array('i_nid' => $type));
        $item_model = new Item();
        $item = $item_model->findByAttributes(array('i_cat_id' => $itemcat->i_cat_id, 'i_value' => $i_value));
        return $item->i_name;
    }

    public static function GetItem_of_alias($i_alias, $type) {
        $itemcat_model = new Itemcat();
        $itemcat = $itemcat_model->findByAttributes(array('i_nid' => $type));
        $item_model = new Item();
        $item = $item_model->findByAttributes(array('i_cat_id' => $itemcat->i_cat_id, 'i_nid' => $i_alias));
        return $item->i_name;
    }

    public static function GetItem_of_id($i_id, $type) {
        $itemcat_model = new Itemcat();
        $itemcat = $itemcat_model->findByAttributes(array('i_nid' => $type));
        $item_model = new Item();
        $item = $item_model->findByAttributes(array('i_cat_id' => $itemcat->i_cat_id, 'i_id' => $i_id));
        return $item->i_name;
    }

    /*
     * 获取一些常用单位
     */

    public static function findcat($f_type, $f_value) {
        $arr = array(
            'project_type' => array(
                '1' => '信用标',
                '2' => '担保标',
                '3' => '抵押标',
                '4' => '秒标',
                //'5' => '体验标'
            ),
            'project_status' => array(
                '0' => '项目发布',
                '1' => '投标中',
                '2' => '初审失败',
                '3' => '复审成功',
                '4' => '复审失败',
                '5' => '流标',
                '6' => '撤销',
                '7' => '正常结束',
            ),
            'message_status' => array(
                '0' => '未读',
                '1' => '已读',
            ),
            'info_out_type' => array(
                '1' => '收入',
                '2' => '支出'
            ),
        	'our_type'=>array(
        		'0' => '转入',
        		'1' => '转出',	
        	),
        	'integral_type'=>array(
        		'0' =>'申请','1' =>'发货','2'=>'审核拒绝','3'=>'未到货','4'=>'已收件','5'=>'已返还金额'
        	),
        	'award_type'=>array(
        		'0'=>'可使用','1'=>'已使用 ','2'=>'已过期',
        	),
        );
        if (!isset($arr[$f_type][$f_value])) {
            return $arr[$f_type];
        }
        return $arr[$f_type][$f_value];
    }

    /*
     * 获取站内信模板
     */

    public static function get_sms_tmp($tmp_alias, $data = array()) {
        $smstmp_model = Smstmp::model();
        $smstmp_info = $smstmp_model->findByAttributes(array('tmp_alias' => $tmp_alias));
        $tmp_name = $smstmp_info->tmp_name;
        $tmp_con = $smstmp_info->tmp_con;
        foreach ($data as $k => $v) {
            $tmp_con = str_replace('$$' . $k . '$$', $v, $tmp_con);
        }
        $tmp_arr['tmp_name'] = $tmp_name;
        $tmp_arr['tmp_con'] = $tmp_con;
        return $tmp_arr;
    }

    /*
     * 发送站内信
     */

    public static function send_message($send_user_id = 0, $get_user_id, $tmp_alias, $data = array()) {
        $message_model = new Message;
        $message_model->m_id = self::getInsertID();
        $message_model->send_user_id = $send_user_id;
        $message_model->get_user_id = $get_user_id;
        $m_arr = self::get_sms_tmp($tmp_alias, $data);
        $message_model->m_con = $m_arr['tmp_con'];
        $message_model->is_view = 0;
        $message_model->add_time = time();
        $message_model->remark = $m_arr['tmp_name'];
        if ($message_model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendEmail($get_user_id = 0, $email, $tmp_alias, $data = array()) {
        $message = self::get_sms_tmp($tmp_alias, $data);
        $sms_model = new Sms;
        $sms_model->sms_id = self::getInsertID();
        $sms_model->get_user_id = $get_user_id;
        $sms_model->get_user_contact = $email;
        $sms_model->sms_con = $message['tmp_con'];
        $sms_model->sms_type = 2; //邮件
        $sms_model->send_type = 1;
        $sms_model->timing = 0;
        $sms_model->status = 0;
        $sms_model->send_time = 0;
        $sms_model->remark = $message['tmp_name'];
        $sms_model->send_ip = Yii::app()->request->userHostAddress;
        if ($sms_model->save()) {
            if (self::sendMail($sms_model->get_user_contact, $message)) {
                $sms_model->status = 1;
                $sms_model->send_time = time();
                if ($sms_model->update()) {
                    return true;
                }
            }
        }
        return false;
    }

    /*
     * 开始发送邮件
     */

    public static function sendMail($to, $message = array()) {
        $mailconfig['host'] = 'smtp.163.com';
        $mailconfig['username'] = '15936049431@163.com';
        $mailconfig['password'] = 'ly2540550';
        $mailconfig['from'] = '15936049431@163.com';
        $mailconfig['fromname'] = Yii::app()->params['site_name'];

        //SMTP发送邮件
        $mail = Yii::createComponent('application.extensions.mailer.EMailer');

        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = $mailconfig['host'];  // specify main and backup server
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = $mailconfig['username'];  // SMTP username
        $mail->Password = $mailconfig['password']; // SMTP password

        $mail->From = $mailconfig['from'];
        $mail->FromName = $mailconfig['fromname'];
        $mail->CharSet = 'utf-8';
        $mail->ContentType = 'text/html';
        $mail->AddAddress($to);                 // name is optional

        $mail->Subject = $message['tmp_name'];
        $mail->Body = $message['tmp_con'];
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendSms($get_user_id = 0, $phone, $tmp_alias, $data = array()) {
        $message = self::get_sms_tmp($tmp_alias, $data);
        $sms_model = new Sms;
        //找出单个手机号在一天内发送条数
        $send_count = $sms_model->countByAttributes(array('get_user_contact' => $phone), array(
            'condition' => 'send_time >= :time',
            'params' => array(':time' => strtotime(date('Y-m-d'))),
        ));
        if ($send_count > 25) {
            return false;
        }

        //找出单个ip在一天内发送的条数
        $send_count_ip = $sms_model->countByAttributes(array('send_ip' => Yii::app()->request->userHostAddress), array(
            'condition' => 'send_time >= :time',
            'params' => array(':time' => strtotime(date('Y-m-d'))),
        ));
        if ($send_count_ip > 150) {
            return false;
        }
        $sms_model->sms_id = self::getInsertID();
        $sms_model->get_user_id = $get_user_id;
        $sms_model->get_user_contact = $phone;
        $sms_model->sms_con = $message['tmp_con'];
        $sms_model->sms_type = 1; //手机
        $sms_model->send_type = 1;
        $sms_model->timing = 0;
        $sms_model->status = 0;
        $sms_model->send_time = 0;
        $sms_model->remark = $message['tmp_name'];
        $sms_model->send_ip = Yii::app()->request->userHostAddress;
        if ($sms_model->save()) {
            if (self::sendPhone($sms_model->get_user_contact, $sms_model->sms_con)) {
                $sms_model->status = 1;
                $sms_model->send_time = time();
                if ($sms_model->update()) {
                    return true;
                }
            }
        }
        return false;
    }

    //发送短信
    public static function sendPhone($phone, $message) {
        //开始发送短信
        if (self::sendPhone_4($phone, $message)) {
            return true;
        } elseif (self::sendPhone_1($phone, $message)) {
            return true;
        } elseif (self::sendphone_2($phone, $message)) {
            return true;
        }
        return false;
    }
    
    public static function sendPhone_4($phone,$message){
    	$buildParams = array(
    			"uid"=>"wpcf",
    			"pwd"=>md5("wpcf673"."wpcf"),
    			"mobile"=>$phone,
    			"content"=>$message,
    			'mobileids'=>'',
    			'time'=>''
    	);
    	$result = http_build_query($buildParams);
    	$result_length = strlen($result);
    	$socket = fsockopen("api.sms.cn",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
    	$treasure_post_data = "POST /mtutf8/ HTTP/1.1\r\n";
    	$treasure_post_data .= "Host:api.sms.cn\r\n";
    	$treasure_post_data .= "Content-Type: application/x-www-form-urlencoded\r\n";
    	$treasure_post_data .= "Content-Length: ".$result_length."\r\n";
    	$treasure_post_data .= "Connection: Close\r\n\r\n";
    	$treasure_post_data .= $result."\r\n";
    	fwrite($socket,$treasure_post_data);
    	$return_result = "" ;
    	while(!feof($socket)){
    		$return_result .= fgets($socket,1024);
    	}
    	return true;
    }

    //蝶信通
    public static function sendPhone_1($phone, $message) {
        $userName = "qiankeji";
        $userPass = "qalc123";
        $subid = "";   //选填	string	通道号码末尾添加的扩展号码
        $url = 'http://114.215.130.61:8082/SendMT/SendMessage';
        $params = 'UserName=' . $userName . '&UserPass=' . $userPass . '&subid=' . $subid . '&Mobile=' . $phone . '&Content=' . urlencode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $data = curl_exec($ch);
        curl_close($ch);

        $return = explode(",", $data);
        if ($return[0] == "00" || $return[0] == "03") {
            return true;
        }


        return false;
    }

    //建周
    public static function sendphone_2($phone, $message) {
        $user_name = "jzyy909";
        $userpass = "530726";
        $url = "http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage";
        $http_header = array(
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
        );

        $params = "account=" . $user_name . "&password=" . $userpass . "&destmobile=" . $phone . "&msgText=" . $message;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $data = curl_exec($ch);
        curl_close($ch);
        var_dump($data);
        return true;
    }

    //亿美
    public static function sendphone_3($phone, $message) {
        $serial = '9SDK-EMY-0999-JEXQK';
        $userpass = "902621";
        $special_num = '400075';
        $url = "http://sdk999ws.eucp.b2m.cn:8080/sdkproxy/sendsms.action";

        $params = "cdkey=" . $serial . "&password=" . $userpass . "&phone=" . $phone . "&message=" . $message . "&seqid=" . self::getInsertID() . "&smspriority=1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $data = curl_exec($ch);
        curl_close($ch);
        $xml_data = simplexml_load_string(trim($data));
        if ($xml_data->error == 0) {
            return true;
        }
        return false;
    }

    public static function getCashFee($userid, $money, $expr = "") {
        $expr = (isset($expr) && $expr != "") ? $expr : Yii::app()->params['assets_cash'];
        $end = round($money * $expr / 100, 2);
        return $end;
    }

    public static function sendcode($get_user_id = 0, $target = null, $type = null, $data = array()) {
        $result = array('status' => 0);
        if (empty($target)) {
            $result['status'] = 2;
            $result['msg'] = '手机号码不可空';
            return $result;
        }
        if (empty($type)) {
            $result['status'] = 3;
            $result['msg'] = '发送验证码类型不可空';
            return $result;
        }
        $codecat_model = Codecat::model();
        $codecat_info = $codecat_model->findByAttributes(array('codecat_alias' => $type));
        if (empty($codecat_info)) {
            $result['status'] = 4;
            $result['msg'] = '没有此验证码选项';
            return $result;
        }
        //判断来路域名是否是本站
        if (!strpos('0' . Yii::app()->request->urlReferrer, Yii::app()->request->hostInfo)) {
            $result['status'] = 5;
            $result['msg'] = '操作有误';
            return $result;
        }
        $code_model = new Code;

        //找出单个ip在2分钟之内发送的条数
        $ip_send_count = $code_model->countByAttributes(array('add_ip' => Yii::app()->request->userHostAddress), array(
            'condition' => 'add_time > :time',
            'params' => array(':time' => time() - 120),
        ));

        if ($ip_send_count >= 10) {
            $result['status'] = 8;
            $result['msg'] = '发送过于频繁'; //ip发送过于频繁
            return $result;
        }
        $code_info = $code_model->findByAttributes(array('target' => $target, 'codecat_id' => $codecat_info->codecat_id));
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if (!empty($code_info)) {
                if (time() > $code_info->add_time + (60)) {
                    $code_info->code = self::getcode();
                    $code_info->add_time = time();
                    $code_info->status = 0;
                    $code_info->exc_time = ($code_info->add_time) + (60 * 5);
                    $code_info->error_num = 0;
                    $code_info->add_ip = Yii::app()->request->userHostAddress;
                    if ($code_info->update()) {
                        if ($codecat_info->codecat_type == 1) {
                            $params = array('code' => $code_info->code);
                            $params = array_merge($params, $data);
                            if (self::sendSms($get_user_id, $target, $codecat_info->sms_tmp_alias, $params)) {
                                $transaction->commit();
                                return true;
                            } else {
                                $result['status'] = 7;
                                $result['msg'] = '验证码发送短信失败';
                                return $result;
                            }
                        } elseif ($codecat_info->codecat_type == 2) {
                            $params = array('code' => $code_info->code);
                            $params = array_merge($params, $data);
                            if (self::sendEmail($get_user_id, $target, $codecat_info->sms_tmp_alias, $params)) {
                                $transaction->commit();
                                return true;
                            } else {
                                $result['status'] = 7;
                                $result['msg'] = '验证码发送邮件失败';
                                return $result;
                            }
                        }
                    } else {
                        $result['status'] = 5;
                        $result['msg'] = '验证码更新失败';
                        return $result;
                    }
                } else {
                    $result['status'] = 6; //验证码发送过于频繁
                    $result['msg'] = '验证码发送过于频繁';
                    return $result;
                }
            } else {
                $code_model->code_id = self::getInsertID();
                $code_model->target = $target;
                $code_model->codecat_id = $codecat_info->codecat_id;
                $code_model->code = self::getcode();
                $code_model->status = 0;
                $code_model->add_time = time();
                $code_model->exc_time = ($code_model->add_time) + (60 * 10);
                $code_model->error_num = 0;
                $code_model->add_ip = Yii::app()->request->userHostAddress;
                if ($code_model->save()) {
                    if ($codecat_info->codecat_type == 1) {
                        $params = array('code' => $code_model->code);
                        $params = array_merge($params, $data);
                        if (self::sendSms($get_user_id, $target, $codecat_info->sms_tmp_alias, $params)) {
                            $transaction->commit();
                            return true;
                        } else {
                            $result['status'] = 7;
                            $result['msg'] = '验证码发送短信失败';
                            return $result;
                        }
                    } elseif ($codecat_info->codecat_type == 2) {
                        $params = array('code' => $code_model->code);
                        $params = array_merge($params, $data);
                        if (self::sendEmail($get_user_id, $target, $codecat_info->sms_tmp_alias, $params)) {
                            $transaction->commit();
                            return true;
                        } else {
                            $result['status'] = 7;
                            $result['msg'] = '验证码发送邮件失败';
                            return $result;
                        }
                    }
                } else {
                    $result['status'] = 5;
                    $result['msg'] = '验证码插入失败';
                    return $result;
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return true;
    }

    /*
     * 格式化保留两位小数（不四舍五入）
     */

    public static function sprintf_diy($number) {
        return sprintf("%.2f", substr(sprintf("%.10f", $number), 0, -8));
    }

    public static function sprintf_diy_9($number) {
        return sprintf("%.1f", substr(sprintf("%.10f", $number), 0, -9));
    }

    /**
     * 还款方式New
     * @param unknown $data(数组,自行扩展) 
     * real_money(金额)
     * p_apr(利率),
     * p_time_limit 天/月 天仅限于style=3,4
     * style 还款方式
     */
    public static function GetStyle($data = array()) {
        switch ($data['style']) {
            case "1": //等额本息
                $result = self::EqualsByEquals($data);
                break;
            case "2": //到期还本按月付息
                $result = self::EqualsByMonth($data);
                break;
            case "3": //到期还本息
                $result = self::EqualsByEnd($data);
                break;
            case "4": //天标按天回款
                $result = self::EqualsByDay($data);
                break;
            case "5": //按季度付息到期还本
                $result = self::EqualsBySeason($data);
                break;
        }
        $n_result = self::checkMoney($result);
        return $n_result;
    }

    /**
     * 还款信息过滤,确保还款总额=应还总额 还款利息=应还利息 避免0.01差额存在
     * 7pointer.com
     * @param 还款参数 $result
     * @return 还款信息
     */
    public static function checkMoney($result) {
        $end_key = $all_money = $all_interest = 0;
        foreach ($result['data'] as $k => $v) {
            $end_key = $k;
            $all_money +=$v['repay_account'];
            $all_interest += $v['repay_interest'];
        }
        if ($all_money != $result['all']['repay_account']) {
            if ($all_money > $result['all']['repay_account']) {
                $less = $all_money - $result['all']['repay_account'];
                $result['data'][$end_key]['repay_account'] = self::sprintf_diy($result['data'][$end_key]['repay_account'] - $less);
                $result['data'][$end_key]['real_money'] = self::sprintf_diy($result['data'][$end_key]['real_money'] - $less);
            } else {
                $less = $result['all']['repay_account'] - $all_money;
                $result['data'][$end_key]['repay_account'] = self::sprintf_diy($result['data'][$end_key]['repay_account'] + $less);
                $result['data'][$end_key]['real_money'] = self::sprintf_diy($result['data'][$end_key]['real_money'] + $less);
            }
        }
        if ($all_interest != $result['all']['repay_interest']) {
            if ($all_interest > $result['all']['repay_interest']) {
                $less = $all_interest - $result['all']['repay_interest'];
                $result['data'][$end_key]['real_money'] = self::sprintf_diy($result['data'][$end_key]['real_money'] + $less);
                $result['data'][$end_key]['repay_interest'] = self::sprintf_diy($result['data'][$end_key]['repay_interest'] - $less);
            } else {
                $less = $result['all']['repay_interest'] - $all_interest;
                $result['data'][$end_key]['real_money'] = self::sprintf_diy($result['data'][$end_key]['real_money'] - $less);
                $result['data'][$end_key]['repay_interest'] = self::sprintf_diy($result['data'][$end_key]['repay_interest'] + $less);
            }
        }
        return $result;
    }

    public static function EqualsByEquals($data) {
        $month_apr = $data['p_apr'] / 1200;
        $li_apr = pow((1 + $month_apr), $data['p_time_limit']);
        $month_money = self::sprintf_diy($data['real_money'] * ($month_apr * $li_apr) / ($li_apr - 1));
        for ($i = 0; $i < $data['p_time_limit']; $i++) {
            if ($i == 0) {
                $interest = self::sprintf_diy($data['real_money'] * $month_apr);
            } else {
                $_li_apr = pow((1 + $month_apr), $i);
                $interest = self::sprintf_diy(($data['real_money'] * $month_apr - $month_money) * $_li_apr + $month_money);
            }
            $equals_result['data'][$i]['repay_account'] = $month_money;
            $equals_result['data'][$i]['repay_interest'] = $interest;
            $equals_result['data'][$i]['repay_time'] = self::GetTime(1, time(), $i + 1);
            $equals_result['data'][$i]['real_money'] = self::sprintf_diy($month_money - $interest);
        }
        $equals_result['all']['repay_account'] = self::sprintf_diy($month_money * $data['p_time_limit']);
        $equals_result['all']['month_repay'] = self::sprintf_diy($month_money);
        $equals_result['all']['repay_time'] = self::GetTime(1, time(), $data['p_time_limit']);
        $equals_result['all']['repay_interest'] = self::sprintf_diy($month_money * $data['p_time_limit'] - $data['real_money']);
        return $equals_result;
    }

    public static function EqualsByMonth($data) {
        $month_apr = $data['p_apr'] / 1200;
        $have_repay = $have_repayment = 0;
        $interest = self::sprintf_diy($data['real_money'] * $month_apr);
        for ($i = 1; $i <= $data['p_time_limit']; $i++) {
            $month_result['data'][$i]['repay_account'] = ($i == $data['p_time_limit']) ? $data['real_money'] + $interest : $interest;
            $month_result['data'][$i]['repay_time'] = self::GetTime(1, time(), $i);
            $month_result['data'][$i]['repay_interest'] = $interest;
            $month_result['data'][$i]['real_money'] = ($i == $data['p_time_limit']) ? $data['real_money'] : 0;
        }
        $month_result['all']['repay_account'] = $data['real_money'] + $interest * $data['p_time_limit'];
        $month_result['all']['month_repay'] = $interest;
        $month_result['all']['repay_time'] = self::GetTime(1, time(), $data['p_time_limit']);
        $month_result['all']['repay_interest'] = $interest * $data['p_time_limit'];
        return $month_result;
    }

    public static function EqualsByEnd($data) {
        $end_result = array();
		$data['p_time_limit'] = ($data['p_time_limittype'] == 1 ) ? $data['p_time_limit'] : $data['p_time_limit']*30 ; 
        $end_result['data'][0]['real_money'] = $data['real_money']; //本金
        $interest = self::sprintf_diy($data['real_money'] * $data['p_apr'] / 36000 * $data['p_time_limit']); //利息
        $end_result['data'][0]['repay_account'] = $data['real_money'] + $interest; //待还金额
        $end_result['data'][0]['repay_interest'] = $interest;
        $end_result['data'][0]['repay_time'] = time() + ($data['p_time_limit'] * 3600 * 24); //还款时间

        $end_result['all']['repay_account'] = $data['real_money'] + $interest;
        $end_result['all']['repay_time'] = time() + ($data['p_time_limit'] * 3600 * 24);
        $end_result['all']['repay_interest'] = $interest;
        return $end_result;
    }

    public static function EqualsByDay($data) {
        for ($i = 1; $i <= $data['p_time_limit']; $i++) {
            $day_result['data'][$i]['real_money'] = self::sprintf_diy($data['real_money'] / $data['p_time_limit']);
            $day_result['data'][$i]['repay_interest'] = self::sprintf_diy($data['real_money'] * $data['p_apr'] / 36000);
            $day_result['data'][$i]['repay_time'] = time() + 3600 * 24 * $i;
            $day_result['data'][$i]['repay_account'] = $day_result['data'][$i]['real_money'] + $day_result['data'][$i]['repay_interest'];
        }
        $interest = self::sprintf_diy($data['real_money'] * $data['p_apr'] / 36000);
        $day_result['all']['repay_account'] = $data['real_money'] + $interest * $data['p_time_limit'];
        $day_result['all']['repay_interest'] = $interest * $data['p_time_limit'];
        $day_result['all']['repay_time'] = time() + 3600 * 24 * $data['p_time_limit'];
        return $day_result;
    }

    public static function EqualsBySeason($data) {
        $all = self::sprintf_diy($data['real_money'] * $data['p_apr'] / 1200 * $data['p_time_limit']);
        $season = ceil($data['p_time_limit'] / 3);
        $season_money = self::sprintf_diy($all / $season);
        for ($i = 1; $i <= $data['p_time_limit']; $i++) {
            //如果说是季末或期末，给钱
            if ($i % 3 == 0 || $i == $data['p_time_limit']) {
                $season_result['data'][$i]['real_money'] = ($i == $data['p_time_limit']) ? $data['real_money'] : 0;
                $season_result['data'][$i]['repay_interest'] = $season_money;
                $season_result['data'][$i]['repay_account'] = self::sprintf_diy($season_result['data'][$i]['real_money'] + $season_result['data'][$i]['repay_interest']);
                $season_result['data'][$i]['repay_time'] = self::GetTime(1, time(), $i);
            }
        }
        $season_result['all']['repay_account'] = $data['real_money'] + $all;
        $season_result['all']['repay_interest'] = $all;
        $season_result['all']['repay_time'] = self::GetTime(1, time(), $data['p_time_limit']);
        return $season_result;
    }

    public static function GetTime($type, $time, $add) {
        if ($type == 1) {
            $month = date('m', $time) + $add;
            $year = date('Y', $time);
            $hour = date('His', $time);
            $monAdd = ($month % 12 == 0) ? 12 : ($month % 12);
            $monAdd = sprintf("%02d", $monAdd);
            $yearAdd = $year + ceil(($month / 12) - 1);
            //某年某月的最大天数
            $monthDay = cal_days_in_month(CAL_GREGORIAN, $monAdd, $yearAdd);
            $day = date('d', $time);
            if ($monthDay < $day) {
                $day = $monthDay;
            }
            $returnYmd = "{$yearAdd}-{$monAdd}-{$day} {$hour}";
            $return_time = strtotime($returnYmd);
            return $return_time;
        } else {
            $returnYmd = strtotime($time . "+" . $add . " month");
            return $returnYmd;
        }
    }

    /*
     * 满标审核
     */

    public static function AddRepay($model, $project_order_list) {
        $assets_model = Assets::model();
        $project_collect_model = ProjectCollect::model();
        $url = Yii::app()->controller->createUrl("/project/tender", array('id' => $model->p_id));
        if ($model->p_status == 3) {
            //增加还款信息
            $repay_data['style'] = $model->p_style;
            $repay_data['real_money'] = $model->p_account;
            $repay_data['p_apr'] = $model->p_apr;
            $repay_data['p_time_limit'] = $model->p_time_limit;
			$repay_data['p_time_limittype'] = $model->p_time_limittype;
            $repay_result = self::GetStyle($repay_data);
            $i = $repay = 0;
            $time = "";
            foreach ($repay_result['data'] as $_k => $_v) {
                $project_repay_model = new ProjectRepay;
                $project_repay_model->p_id = self::getInsertID();
                $project_repay_model->p_order = $i++;
                $project_repay_model->p_status = 0;
                $project_repay_model->p_project_id = $model->p_id;
                $project_repay_model->p_repaytime = $_v['repay_time'];
                $project_repay_model->p_repayaccount = $_v['repay_account'];
                $project_repay_model->p_interest = $_v['repay_interest'];
                $project_repay_model->p_money = $_v['real_money'];
                $project_repay_model->p_addtime = time();
                $project_repay_model->p_addip = $_SERVER['REMOTE_ADDR'];
                $project_repay_model->insert();
                $time = $_v['repay_time'];
                $repay+=$_v['repay_account'];

//                        更新待收时间
                $project_collect_model->updateAll(array('p_repaytime' => $time), array(
                    'condition' => 'p_order = :p_order AND p_project_id = :p_project_id',
                    'params' => array(
                        ':p_order' => $project_repay_model->p_order,
                        ':p_project_id' => $project_repay_model->p_project_id,
                    ),
                ));
            }
            $model->p_success = $time;
            $model->p_repayment = $repay_result['all']['repay_account'];
            $model->update();

            //借款人资金增加
            $loan_userassets = $assets_model->findByPk($model->p_user_id);
            $data['user_id'] = $model->p_user_id;
            $data['b_money'] = $model->p_account;
            $data['b_type'] = 1;
            $data['b_itemtype'] = 'assets_record';
            $data['u_total_money'] = $loan_userassets->total_money + $data['b_money'];
            $data['u_real_money'] = $loan_userassets->real_money + $data['b_money'];
            $data['u_frost_money'] = $loan_userassets->frost_money;
            $data['u_have_interest'] = $loan_userassets->have_interest;
            $data['u_wait_interest'] = $loan_userassets->wait_interest;
            $data['u_wait_total_money'] = $loan_userassets->wait_total_money;
            $data['b_mark'] = $model->p_id;
            $data['b_time'] = time();
            $data['remark'] = "借款[<a href='{$url}'>{$model->p_name}</a>]金额入账";

            if (self::AddBill($data)) {
                //借款手续费
                $money = self::sprintf_diy($model->p_account * Yii::app()->params['project_fee']);
                if ($money > 0) {
                    $loan_userassets1 = $assets_model->findByPk($model->p_user_id);
                    $data1['user_id'] = $model->p_user_id;
                    $data1['b_money'] = $money;
                    $data1['b_type'] = 2;
                    $data1['b_itemtype'] = 'assets_project_fee';
                    $data1['u_total_money'] = $loan_userassets1->total_money - $data1['b_money'];
                    $data1['u_real_money'] = $loan_userassets1->real_money - $data1['b_money'];
                    $data1['u_frost_money'] = $loan_userassets1->frost_money;
                    $data1['u_have_interest'] = $loan_userassets1->have_interest;
                    $data1['u_wait_interest'] = $loan_userassets1->wait_interest;
                    $data1['u_wait_total_money'] = $loan_userassets1->wait_total_money;
                    $data1['b_mark'] = $model->p_id;
                    $data1['b_time'] = time();
                    $data1['remark'] = "借款[<a href='{$url}'>{$model->p_name}</a>]的手续费";
                    self::AddBill($data1);
                }


                //赠送借款积分
                $give_integral = 0;
                if (Yii::app()->params['loan_give_type'] == 1) {
                    $give_integral = $model->p_account * (Yii::app()->params['loan_give_scale'] / 100);
                } elseif (Yii::app()->params['loan_give_type'] == 2) {
                    $give_integral = Yii::app()->params['loan_give_fixed'];
                }
                $loan_give_integral_data = array(
                    'user_id' => $model->p_user_id,
                    'integral' => $give_integral,
                    'type' => 1,
                    'i_cat_alias' => 'loan_give_integral',
                    'remark' => '借款赠送积分',
                );
                self::Addintegral($loan_give_integral_data);

                //发送站内信
                self::send_message(0, $model->p_user_id, 'loan_check_suc_loaner', array(
                    'project_name' => $model->p_name,
                    'loan_money' => $model->p_account,
                ));

                //扣除投资人资金,增加投资人待收
                foreach ($project_order_list as $k => $v) {
                    $invest_userassets = $assets_model->findByPk($v->p_user_id);
                    $invest_data['user_id'] = $v->p_user_id;
                    $invest_data['b_money'] = $v->p_money;
                    $invest_data['b_type'] = 2;
                    $invest_data['b_itemtype'] = 'assets_order_deduction';
                    $invest_data['u_total_money'] = $invest_userassets->total_money - $invest_data['b_money'];
                    $invest_data['u_real_money'] = $invest_userassets->real_money;
                    $invest_data['u_frost_money'] = $invest_userassets->frost_money - $invest_data['b_money'];
                    $invest_data['u_have_interest'] = $invest_userassets->have_interest;
                    $invest_data['u_wait_interest'] = $invest_userassets->wait_interest;
                    $invest_data['u_wait_total_money'] = $invest_userassets->wait_total_money;
                    $invest_data['b_mark'] = $model->p_id;
                    $invest_data['b_time'] = time();
                    $invest_data['remark'] = "借款[<a href='{$url}'>{$model->p_name}</a>]审核通过，投标成功费用扣除";
                    self::AddBill($invest_data);

                    $invest_userassets1 = $assets_model->findByPk($v->p_user_id);
                    $invest_data1['user_id'] = $v->p_user_id;
                    $invest_data1['b_money'] = $v->p_repayaccount;
                    $invest_data1['b_type'] = 2;
                    $invest_data1['b_itemtype'] = 'assets_order_collection';
                    $invest_data1['u_total_money'] = $invest_userassets1->total_money + $invest_data1['b_money'];
                    $invest_data1['u_real_money'] = $invest_userassets1->real_money;
                    $invest_data1['u_frost_money'] = $invest_userassets1->frost_money;
                    $invest_data1['u_have_interest'] = $invest_userassets1->have_interest;
                    $invest_data1['u_wait_interest'] = $invest_userassets1->wait_interest + $v->p_interest;
                    $invest_data1['u_wait_total_money'] = $invest_userassets1->wait_total_money + $invest_data1['b_money'];
                    $invest_data1['b_mark'] = $model->p_id;
                    $invest_data1['b_time'] = time();
                    $invest_data1['remark'] = '增加待收金额';
                    self::AddBill($invest_data1);
                    
                    //发放借款奖励
                    if ($model->p_award_type != 0) {
                        if ($model->p_award_type == 1) {
                            $award_money = self::sprintf_diy($v->p_realmoney * $model->p_award / 100); //百分比奖励
                        } else {
                            $award_money = self::sprintf_diy(($v->p_realmoney / $model->p_account) * $model->p_award); //固定金额奖励
                        }
                        $invest_userassets2 = $assets_model->findByPk($v->p_user_id);
                        $invest_data2['user_id'] = $v->p_user_id;
                        $invest_data2['b_money'] = $award_money;
                        $invest_data2['b_type'] = 2;
                        $invest_data2['b_itemtype'] = 'assets_order_award';
                        $invest_data2['u_total_money'] = $invest_userassets2->total_money + $invest_data2['b_money'];
                        $invest_data2['u_real_money'] = $invest_userassets2->real_money + $invest_data2['b_money'];
                        $invest_data2['u_frost_money'] = $invest_userassets2->frost_money;
                        $invest_data2['u_have_interest'] = $invest_userassets2->have_interest;
                        $invest_data2['u_wait_interest'] = $invest_userassets2->wait_interest;
                        $invest_data2['u_wait_total_money'] = $invest_userassets2->wait_total_money;
                        $invest_data2['b_mark'] = $model->p_id;
                        $invest_data2['b_time'] = time();
                        $invest_data2['remark'] = "借款[<a href='{$url}'>{$model->p_name}</a>]的奖励发放";
                        self::AddBill($invest_data2);

                        $loan_userassets2 = $assets_model->findByPk($model->p_user_id);
                        $data2['user_id'] = $model->p_user_id;
                        $data2['b_money'] = $award_money;
                        $data2['b_type'] = 2;
                        $data2['b_itemtype'] = 'assets_project_award';
                        $data2['u_total_money'] = $loan_userassets2->total_money - $data2['b_money'];
                        $data2['u_real_money'] = $loan_userassets2->real_money - $data2['b_money'];
                        $data2['u_frost_money'] = $loan_userassets2->frost_money;
                        $data2['u_have_interest'] = $loan_userassets2->have_interest;
                        $data2['u_wait_interest'] = $loan_userassets2->wait_interest;
                        $data2['u_wait_total_money'] = $loan_userassets2->wait_total_money;
                        $data2['b_mark'] = $model->p_id;
                        $data2['b_time'] = time();
                        $data2['remark'] = "借款[<a href='{$url}'>{$model->p_name}</a>]的奖励扣除";
                        self::AddBill($data2);

                        //发送站内信
                        self::send_message(0, $v->p_user_id, 'loan_check_suc_invester', array(
                            'project_name' => $model->p_name,
                        ));
                    }
                }
            }
        } elseif ($model->p_status == 4) {
            $model->update();
            //发送站内信
            self::send_message(0, $model->p_user_id, 'loan_check_fail_loaner', array(
                'project_name' => $model->p_name,
            ));
            foreach ($project_order_list as $k => $v) {
                $invest_userassets = $assets_model->findByPk($v->p_user_id);
                $invest_data['user_id'] = $v->p_user_id;
                $invest_data['b_money'] = $v->p_money;
                $invest_data['b_type'] = 1;
                $invest_data['b_itemtype'] = 'assets_order_false';
                $invest_data['u_total_money'] = $invest_userassets->total_money;
                $invest_data['u_real_money'] = $invest_userassets->real_money + $v->p_money;
                $invest_data['u_frost_money'] = $invest_userassets->frost_money - $v->p_money;
                $invest_data['u_have_interest'] = $invest_userassets->have_interest;
                $invest_data['u_wait_interest'] = $invest_userassets->wait_interest;
                $invest_data['u_wait_total_money'] = $invest_userassets->wait_total_money;
                $invest_data['b_mark'] = '0';
                $invest_data['b_time'] = time();
                $invest_data['remark'] = '项目审核失败,招标金额返还';
                self::AddBill($invest_data);
                //发送站内信
                self::send_message(0, $v->p_user_id, 'loan_check_fail_invester', array(
                    'project_name' => $model->p_name,
                    'invest_money' => $v->p_money,
                ));
            }
        }
    }

    //投标函数
    //auto_invest true 表示自动投标
    //auto_invest false 表示用户投标

    public static function AddOrder($project_info, $project_order_model, $auto_invest = false) {
        if ($project_info->p_status != 1) {
            return '状态有误';
        }
        if (!is_numeric($project_order_model->p_money) || $project_order_model->p_money <= 0) {
            return '投标金额非法';
        }
        if ($project_info->p_account < ($project_info->p_account_yes + $project_order_model->p_money)) {
            return '投标金额大于可投金额';
        }
        if ($project_order_model->p_realmoney < $project_info->p_lowaccount && Yii::app()->params['project_quota'] == 1) {
            return '投标金额小于最小投标限额';
        }
        if ($project_order_model->p_money > $project_info->p_mostaccount && Yii::app()->params['project_quota'] == 1 && $project_info->p_mostaccount != 0) {
            return '投标金额大于最大投标限额';
        }

        //计算待收
        $collect_data['style'] = $project_info->p_style;
        $collect_data['real_money'] = $project_order_model->p_money;
        $collect_data['p_apr'] = $project_info->p_apr;
        $collect_data['p_time_limit'] = $project_info->p_time_limit;
		$collect_data['p_time_limittype'] = $project_info->p_time_limittype;
        $collection_result = self::GetStyle($collect_data);

        $project_order_model->p_project_id = $project_info->p_id;
        $project_order_model->p_repayaccount = $collection_result['all']['repay_account'];
        $project_order_model->p_interest = $collection_result['all']['repay_interest'];

        $project_order_model->p_waitrepay = $project_order_model->p_repayaccount;
        $project_order_model->p_waitinterest = $project_order_model->p_interest;
        $project_order_model->p_addtime = time();
        $project_order_model->p_addip = $_SERVER['REMOTE_ADDR'];
        if ($project_order_model->validate()) {
            if ($project_order_model->insert()) {
                $project_info->p_account_yes = $project_order_model->p_money + $project_info->p_account_yes;
                $project_info->p_ordernum = $project_info->p_ordernum + 1;
                $project_info->p_maxorder = $project_order_model->p_money > $project_info->p_maxorder ? $project_order_model->p_money : $project_info->p_maxorder;
                $project_info -> p_fulltime = time();
                $project_info->update();
                
                $i = 0;
                foreach ($collection_result['data'] as $k => $v) {
                    $project_collect_model = new ProjectCollect;
                    $project_collect_model->p_id = self::getInsertID();
                    $project_collect_model->p_order = $i++;
                    $project_collect_model->p_status = 0;
                    $project_collect_model->p_user_id = $project_order_model->p_user_id;
                    $project_collect_model->p_project_id = $project_info->p_id;
                    $project_collect_model->p_project_order = $project_order_model->p_id;
                    $project_collect_model->p_repaytime = $v['repay_time'];
                    $project_collect_model->p_repayaccount = $v['repay_account'];
                    $project_collect_model->p_interest = $v['repay_interest'];
                    $project_collect_model->p_realmoney = $v['real_money'];
                    $project_collect_model->p_addtime = time();
                    $project_collect_model->p_addip = $_SERVER['REMOTE_ADDR'];
                    $project_collect_model->insert();
                }

                //赠送投标积分
                $give_integral = 0;
                if (Yii::app()->params['invest_give_type'] == 1) {
                    $give_integral = $project_order_model->p_money * (Yii::app()->params['invest_give_scale'] / 100);
                    $give_integral = ($project_info->p_time_limittype == 1) ? $give_integral : $give_integral * $project_info->p_time_limit;
                } elseif (Yii::app()->params['invest_give_type'] == 2) {
                    $give_integral = Yii::app()->params['invest_give_fixed'];
                }
                $data = array(
                    'user_id' => $project_order_model->p_user_id,
                    'integral' => $give_integral,
                    'type' => 1,
                    'i_cat_alias' => 'invest_give_integral',
                    'remark' => '投标赠送积分',
                );
                self::Addintegral($data);

                $need_out_money = $project_order_model->p_money;
                
                //获取用户资金信息
                $assets_model = Assets::model();
                $assets_info = $assets_model->findByPk($project_order_model->p_user_id);
                $bill['user_id'] = $project_order_model->p_user_id;
                $bill['b_money'] = $need_out_money;
                $bill['b_type'] = 2;
                $bill['b_itemtype'] = "assets_order_forzen";
                $bill['u_total_money'] = $assets_info->total_money + (!empty($reward_info) ? $reward_info->r_share : 0);
                $bill['u_real_money'] = $assets_info->real_money - $bill['b_money'];
                $bill['u_frost_money'] = $assets_info->frost_money + $project_order_model->p_money;
                $bill['u_wait_interest'] = $assets_info->wait_interest;
                $bill['u_have_interest'] = $assets_info->have_interest;
                $bill['u_wait_total_money'] = $assets_info->wait_total_money;
                $bill['b_mark'] = $project_info->p_id;
                $bill['b_time'] = time();
                $bill['remark'] = "投标冻结{$bill['b_money']}元！";
                if (self::AddBill($bill)) {
                    if ($auto_invest) {//如果是自动投标，增加自动投标记录
                        $project_autolog_model = new ProjectAutolog;
                        $project_autolog_model->p_id = self::getInsertID();
                        $project_autolog_model->p_user_id = $project_order_model->p_user_id;
                        $project_autolog_model->p_project_id = $project_info->p_id;
                        $project_autolog_model->p_project_money = $project_order_model->p_money;
                        $project_autolog_model->p_project_minmoney = 0;
                        $project_autolog_model->p_project_maxmoney = 0;
                        $project_autolog_model->p_status = 1;
                        $project_autolog_model->p_content = $project_info->p_name;
                        $project_autolog_model->p_addtime = time();
                        $project_autolog_model->p_addip = Yii::app()->request->userHostAddress;
                        if ($project_autolog_model->insert()) {//自动投标记录添加成功
                        }
                    }

                    //发送站内信
                    self::send_message(0, $project_order_model->p_user_id, 'invest_suc', array(
                        'project_name' => $project_info->p_name,
                        'invest_money' => $project_order_model->p_money,
                    ));

                    if (!empty($project_order_model->user->user_phone) && !empty($project_order_model->user->is_phone_check)) {
                        //发送短信
                        self::sendSms($project_order_model->p_user_id, $project_order_model->user->user_phone, 'invest_suc', array(
                            'project_name' => $project_info->p_name,
                            'invest_money' => $project_order_model->p_money,
                        ));
                    }
                    self::checkMold($project_order_model);
                    return true;
                }
            }
        } else {
            $message = $project_order_model->getErrors();
            return current(current($message));
        }
    }

    /*
     * 前台用户还款
     */

    public static function Repay($repayment_info) {
        $project_model = Project::model();
        $repayment_model = ProjectRepay::model();
        $assets_model = Assets::model();
        $loan_user_info = $assets_model->findByPk($repayment_info->project->p_user_id);
        $project_info = $project_model->findByPk($repayment_info->p_project_id);
        if ($loan_user_info->real_money >= $repayment_info->p_repayaccount) {
            $url = Yii::app()->controller->createUrl("project/tender", array('id' => $repayment_info->p_project_id));
            $loan_bill['user_id'] = $loan_user_info->user_id;
            $loan_bill['b_money'] = $repayment_info->p_repayaccount;
            $loan_bill['b_type'] = 1;
            $loan_bill['b_itemtype'] = 'assets_repay';
            $loan_bill['u_total_money'] = $loan_user_info->total_money - $loan_bill['b_money'];
            $loan_bill['u_real_money'] = $loan_user_info->real_money - $loan_bill['b_money'];
            $loan_bill['u_frost_money'] = $loan_user_info->frost_money;
            $loan_bill['u_have_interest'] = $loan_user_info->have_interest;
            $loan_bill['u_wait_interest'] = $loan_user_info->wait_interest;
            $loan_bill['u_wait_total_money'] = $loan_user_info->wait_total_money;
            $loan_bill['b_mark'] = $repayment_info->p_project_id;
            $loan_bill['b_time'] = time();
            $loan_bill['remark'] = "对借款[<a href='{$url}'>{$repayment_info->project->p_name}</a>]的还款";
            $loan_bill['b_addip'] = Yii::app()->request->userHostAddress;
            self::AddBill($loan_bill);
            //发送站内信
            self::send_message(0, $project_info->p_user_id, 'project_repay_loaner', array(
                'project_name' => $project_info->p_name,
                'repay_num' => $repayment_info->p_order + 1,
                'repay_money' => $repayment_info->p_repayyesaccount,
            ));

            self::repay_info($repayment_info, $url);

            $repayment_info->p_status = 1;
            $repayment_info->p_repayyestime = time();
            $repayment_info->p_repayyesaccount = $repayment_info->p_repayaccount;
            $repayment_info->update();

            $project_info->p_repayment_yes = $project_info->p_repayment_yes + $repayment_info->p_repayaccount;
            if ($repayment_info->p_order + 1 >= $repayment_model->countByAttributes(array('p_project_id' => $repayment_info->p_project_id))) {
                $project_info->p_status = 7;
            }
            $project_info->update();

            return true;
        } else {
            return false;
        }
    }

    /*
     * 系统还款
     * $type  
     *   plat_back 表示管理员后台垫付
     *   plat_py 表示py自动帮助平台垫付
     * 
     */

    public static function Repay_play($repayment_info, $type = null) {
        $project_model = Project::model();
        $repayment_model = ProjectRepay::model();

        $assets_model = Assets::model();
        $project_info = $project_model->findByPk($repayment_info->p_project_id);

        $url = Yii::app()->controller->createUrl("project/tender", array('id' => $repayment_info->p_project_id));
        $transaction = Yii::app()->db->beginTransaction();
        try {
            self::repay_info($repayment_info, $url);

            $repayment_info->p_status = 2;
            $repayment_info->update();

            $project_info->p_repayment_yes = $project_info->p_repayment_yes + $repayment_info->p_repayaccount;
            if ($repayment_info->p_order + 1 >= $repayment_model->countByAttributes(array('p_project_id' => $repayment_info->p_project_id))) {
                $project_info->p_status = 7;
            }
            $project_info->update();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
        return true;
    }

    /*
     * 还款给投资用户
     */

    public static function repay_info($repayment_info, $url) {
        $assets_model = Assets::model();
        $order_model = ProjectOrder::model();
        $collect_model = ProjectCollect::model();

        $order_list = $order_model->findAllByAttributes(array('p_project_id' => $repayment_info->p_project_id));
        foreach ($order_list as $k => $v) {
            $collect_info = $collect_model->findByAttributes(array(
                'p_project_order' => $v->p_id,
                'p_order' => $repayment_info->p_order,
                'p_status' => array('0'),
            ));
            if (!empty($collect_info)) {
                $invest_assets_info = $assets_model->findByPk($v->p_user_id);
                
                $addbill['user_id'] = $v->p_user_id;
                $addbill['b_money'] = $collect_info->p_repayaccount;
                $addbill['b_type'] = 1;
                $addbill['b_itemtype'] = 'assets_receivables';
                $addbill['u_total_money'] = $invest_assets_info->total_money;
                $addbill['u_real_money'] = $invest_assets_info->real_money + $addbill['b_money'];
                $addbill['u_frost_money'] = $invest_assets_info->frost_money;
                $addbill['u_have_interest'] = $invest_assets_info->have_interest + $collect_info->p_interest;
                $addbill['u_wait_interest'] = $invest_assets_info->wait_interest - $collect_info->p_interest;
                $addbill['u_wait_total_money'] = $invest_assets_info->wait_total_money - $addbill['b_money'];
                $addbill['b_mark'] = $v->p_id;
                $addbill['b_time'] = time();
                $addbill['remark'] = "用户对借款[<a href='{$url}'>{$repayment_info->project->p_name}</a>]的还款";
                $addbill['b_addip'] = Yii::app()->request->userHostAddress;
                self::AddBill($addbill);

                //发送站内信
                self::send_message(0, $v->p_user_id, 'project_repay_invester', array(
                    'project_name' => $repayment_info->project->p_name,
                    'repay_num' => $repayment_info->p_order + 1,
                    'repay_money' => number_format($collect_info->p_repayaccount, 2),
                ));

                if (!empty($v->user->user_phone) && !empty($v->user->is_phone_check)) {
                    LYCommon::sendSms($v->p_user_id, $v->user->user_phone, 'project_repay_invester', array(
                        'project_name' => $repayment_info->project->p_name,
                        'repay_num' => $repayment_info->p_order + 1,
                        'repay_money' => number_format($collect_info->p_repayaccount, 2),
                    ));
                }
                $fee_money = self::sprintf_diy($collect_info->p_interest * Yii::app()->params['project_interest']);
                if ($fee_money > 0) {
                    $invest_assets_info1 = $assets_model->findByPk($v->p_user_id);
                    $addbill1['user_id'] = $v->p_user_id;
                    $addbill1['b_money'] = $fee_money;
                    $addbill1['b_type'] = 1;
                    $addbill1['b_itemtype'] = 'assets_manage_fee';
                    $addbill1['u_total_money'] = $invest_assets_info1->total_money - $addbill1['b_money'];
                    $addbill1['u_real_money'] = $invest_assets_info1->real_money - $addbill1['b_money'];
                    $addbill1['u_frost_money'] = $invest_assets_info1->frost_money;
                    $addbill1['u_have_interest'] = $invest_assets_info1->have_interest;
                    $addbill1['u_wait_interest'] = $invest_assets_info1->wait_interest;
                    $addbill1['u_wait_total_money'] = $invest_assets_info1->wait_total_money;
                    $addbill1['b_mark'] = $v->p_id;
                    $addbill1['b_time'] = time();
                    $addbill1['remark'] = "用户还款扣除的利息管理费";
                    $addbill1['b_addip'] = Yii::app()->request->userHostAddress;
                    self::AddBill($addbill1);
                }
                $v->p_repayyesaccount+=$collect_info->p_repayaccount;
                $v->p_waitrepay = $v->p_waitrepay - $collect_info->p_repayaccount;
                $v->p_yesinterest+=$collect_info->p_interest;
                $v->p_waitinterest = $v->p_waitinterest - $collect_info->p_interest;
                $v->update();

                $collect_info->p_status = 1;
                $collect_info->p_repayyestime = time();
                $collect_info->p_repayyesaccount = $collect_info->p_repayaccount;
                $collect_info->update();
            }
        }
    }

    public static function GetError($data) {
        if (!empty($data)) {
            $error = "";
            foreach ($data as $k => $v) {
                $error.=$v[0] . ',';
            }
            return $error;
        }
        return '操作有误';
    }

    public static function BuyDebt($debt) {
        $assets_model = Assets::model();
        $assets_info = $assets_model->findByPk($debt->buy_userid);
        $data['user_id'] = $debt->buy_userid;
        $data['b_money'] = $debt->to_money;
        $data['b_type'] = 2;
        $data['b_itemtype'] = 'buy_debt';
        $data['u_total_money'] = $assets_info->total_money - $data['b_money'];
        $data['u_real_money'] = $assets_info->real_money - $data['b_money'];
        $data['u_frost_money'] = $assets_info->frost_money;
        $data['u_have_interest'] = $assets_info->have_interest;
        $data['u_wait_interest'] = $assets_info->wait_interest;
        $data['u_wait_total_money'] = $assets_info->wait_total_money;
        $data['b_mark'] = 0;
        $data['b_time'] = time();
        $data['remark'] = "买入债权资金扣除";
        self::AddBill($data);

        $assets_info1 = $assets_model->findByPk($debt->buy_userid);
        $data1['user_id'] = $debt->buy_userid;
        $data1['b_money'] = $debt->have_money;
        $data1['b_type'] = 2;
        $data1['b_itemtype'] = 'buy_debtcollect';
        $data1['u_total_money'] = $assets_info1->total_money + $data1['b_money'];
        $data1['u_real_money'] = $assets_info1->real_money;
        $data1['u_frost_money'] = $assets_info1->frost_money;
        $data1['u_have_interest'] = $assets_info1->have_interest;
        $data1['u_wait_interest'] = $assets_info1->wait_interest + $debt->have_interest;
        $data1['u_wait_total_money'] = $assets_info1->wait_total_money + $data1['b_money'];
        $data1['b_mark'] = 0;
        $data1['b_time'] = time();
        $data1['remark'] = "买入债权待收增加";
        self::AddBill($data1);

        $fee_money = self::sprintf_diy($debt->to_money * Yii::app()->params['buy_debtfee']);
        if ($fee_money > 0) {
            $assets_info2 = $assets_model->findByPk($debt->buy_userid);
            $data2['user_id'] = $debt->buy_userid;
            $data2['b_money'] = $fee_money;
            $data2['b_type'] = 2;
            $data2['b_itemtype'] = 'buy_debtfee';
            $data2['u_total_money'] = $assets_info2->total_money - $data2['b_money'];
            $data2['u_real_money'] = $assets_info2->real_money - $data2['b_money'];
            $data2['u_frost_money'] = $assets_info2->frost_money;
            $data2['u_have_interest'] = $assets_info2->have_interest;
            $data2['u_wait_interest'] = $assets_info2->wait_interest;
            $data2['u_wait_total_money'] = $assets_info2->wait_total_money;
            $data2['b_mark'] = 0;
            $data2['b_time'] = time();
            $data2['remark'] = "债权买入手续费扣除";
            self::AddBill($data2);
        }

        //增加卖出人资金
        $assets_info3 = $assets_model->findByPk($debt->user_id);
        $data3['user_id'] = $debt->user_id;
        $data3['b_money'] = $debt->have_money;
        $data3['b_type'] = 1;
        $data3['b_itemtype'] = 'assign_debt';
        $data3['u_total_money'] = $assets_info3->total_money - $data3['b_money'];
        $data3['u_real_money'] = $assets_info3->real_money;
        $data3['u_frost_money'] = $assets_info3->frost_money;
        $data3['u_have_interest'] = $assets_info3->have_interest;
        $data3['u_wait_interest'] = $assets_info3->wait_interest - $debt->have_interest;
        $data3['u_wait_total_money'] = $assets_info3->wait_total_money - $data3['b_money'];
        $data3['b_mark'] = 0;
        $data3['b_time'] = time();
        $data3['remark'] = "卖出债权扣除待收";
        self::AddBill($data3);

        $assets_info4 = $assets_model->findByPk($debt->user_id);
        $data4['user_id'] = $debt->user_id;
        $data4['b_money'] = $debt->to_money;
        $data4['b_type'] = 1;
        $data4['b_itemtype'] = 'assign_debtadd';
        $data4['u_total_money'] = $assets_info4->total_money + $data4['b_money'];
        $data4['u_real_money'] = $assets_info4->real_money + $data4['b_money'];
        $data4['u_frost_money'] = $assets_info4->frost_money;
        $data4['u_have_interest'] = $assets_info4->have_interest;
        $data4['u_wait_interest'] = $assets_info4->wait_interest;
        $data4['u_wait_total_money'] = $assets_info4->wait_total_money;
        $data4['b_mark'] = 0;
        $data4['b_time'] = time();
        $data4['remark'] = "卖出债权增加金额";
        self::AddBill($data4);

        $assign_fee = self::sprintf_diy($debt->have_money * Yii::app()->params['assign_debtfee']);
        if ($assign_fee > 0) {
            $assets_info5 = $assets_model->findByPk($debt->user_id);
            $data5['user_id'] = $debt->user_id;
            $data5['b_money'] = $assign_fee;
            $data5['b_type'] = 2;
            $data5['b_itemtype'] = 'assign_debtfee';
            $data5['u_total_money'] = $assets_info5->total_money - $data5['b_money'];
            $data5['u_real_money'] = $assets_info5->real_money - $data5['b_money'];
            $data5['u_frost_money'] = $assets_info5->frost_money;
            $data5['u_have_interest'] = $assets_info5->have_interest;
            $data5['u_wait_interest'] = $assets_info5->wait_interest;
            $data5['u_wait_total_money'] = $assets_info5->wait_total_money;
            $data5['b_mark'] = 0;
            $data5['b_time'] = time();
            $data5['remark'] = "债权卖出手续费扣除";
            self::AddBill($data5);
        }

        $project_order_model = ProjectOrder::model();
        $project_order = $project_order_model->findByPk($debt->order_id);
        $project_order->p_user_id = $debt->buy_userid;
        if ($project_order->update()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获得来源类型 post get
     *
     * @return unknown
     */
    static public function method() {
        return strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET' );
    }

    /*
     * 截取字符串串
     * @param  string  要截断的字符串
     * @param  length  保留的长度
     * @param  etc  跟随的尾巴
     */

    static public function truncate_longstr($string, $length = 24, $etc = '...') {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

    public static function Liubiao($project_info) {
        $project_info->p_status = 5;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if ($project_info->update()) {
                //发送站内信
                self::send_message(0, $project_info->p_user_id, 'project_liubiao_loaner', array(
                    'project_name' => $project_info->p_name,
                ));
                $project_order_model = ProjectOrder::model();
                $project_order_list = $project_order_model->findAllByAttributes(array('p_project_id' => $project_info->p_id));
                foreach ($project_order_list as $k => $v) {
                    $invest_userassets = Assets::model()->findByPk($v->p_user_id);
                    $invest_data['user_id'] = $v->p_user_id;
                    $invest_data['b_money'] = $v->p_money;
                    $invest_data['b_type'] = 1;
                    $invest_data['b_itemtype'] = 'project_liubiao';
                    $invest_data['u_total_money'] = $invest_userassets->total_money;
                    $invest_data['u_real_money'] = $invest_userassets->real_money + $v->p_money;
                    $invest_data['u_frost_money'] = $invest_userassets->frost_money - $v->p_money;
                    $invest_data['u_have_interest'] = $invest_userassets->have_interest;
                    $invest_data['u_wait_interest'] = $invest_userassets->wait_interest;
                    $invest_data['u_wait_total_money'] = $invest_userassets->wait_total_money;
                    $invest_data['b_mark'] = '0';
                    $invest_data['b_time'] = time();
                    $invest_data['remark'] = '项目流标,招标金额返还';
                    self::AddBill($invest_data);
                    //发送站内信
                    self::send_message(0, $v->p_user_id, 'project_liubiao_invester', array(
                        'project_name' => $project_info->p_name,
                        'invest_money' => $v->p_money,
                    ));
                }
                $transaction->commit();
                return true;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public static function encryptSign($data_info = null) {
        if (empty($data_info)) {
            return false; //参数不可为空
        }
        unset($data_info->is_warning);
        unset($data_info->sign);
        $str = '';
        foreach ($data_info as $k => $v) {
            $str.=$v;
        }
        $sign = md5(base64_encode($str));
        $data_info->sign = $sign;
        $data_info->update();
        return true;
    }

    public static function checkSign($data_info = null) {
        if (empty($data_info)) {
            return false; //参数不可为空
        }
        $sign = $data_info->sign;
        $is_warning = $data_info->is_warning;

        if (!empty($is_warning)) {
            return false; //数据已经异常
        }

        unset($data_info->sign);
        unset($data_info->is_warning);
        $str = '';
        foreach ($data_info as $k => $v) {
            $str .= $v;
        }
        $sign_str = md5(base64_encode($str));
        if ($sign != $sign_str) {
            $data_info->is_warning = 1;
            $data_info->sign = $sign;

            $data_info->update();
            return false;
        } else {
            return true;
        }
    }

    /*
     * 字符串*号替换函数
     */

    public static function xing_replace($str = '', $start=1, $end=1, $destr = '*') {
        if (!preg_match("/[\x7f-\xff]/", $str)) {//不如果包含中文
            if (strlen($str) <= $start + $end) {
                $str .= '****';
                return $str;
            }
            return substr_replace($str, str_repeat($destr, strlen($str) - ($start + $end)), $start, strlen($str) - ($start + $end));
        } else {
            return self::xing_replace_utf8($str = '', $start, $end);
        }
    }

    public static function half_replace($str = '') {
        if (!preg_match("/[\x7f-\xff]/", $str)) {//不如果包含中文
            $len = strlen($str) / 2;
            return substr_replace($str, str_repeat('*', $len), ceil(($len) / 2), $len);
        } else {
            return self::half_replace_utf8($str);
        }
    }

    /*
     * utf8对半截取字符串
     * $str 要截取的字符串
     */

    public static function half_replace_utf8($str = '') {
        if (preg_match("/[\x7f-\xff]/", $str)) {//如果包含中文
            $len = mb_strlen($str, 'utf8');
            $first_str = mb_substr($str, 0, floor($len / 4) < 1 ? 1 : floor($len / 4), 'utf8');
            $end_str = mb_substr($str, (-(floor($len / 2))), floor($len / 2), 'utf8');
            return $first_str . str_repeat('*', $len - ((floor($len / 4) < 1 ? 1 : floor($len / 4)) + floor($len / 2))) . $end_str;
            //备用
            $bl = floor($len / 4) * 3;
            return substr_replace($str, str_repeat('*', floor($len / 2)), $bl < 3 ? 3 : $bl, floor($len / 2) * 3);
        } else {
            return self::half_replace($str);
        }
    }

    /*
     * utf8截取字符串
     * $str 要截取的字符串
     * $start 开头要保留的长度
     * $end 结尾要保留的长度
     * 
     */

    public static function xing_replace_utf8($str = '', $start = 1, $end = 1) {
        if (preg_match("/[\x7f-\xff]/", $str)) {//如果包含中文
            $len = mb_strlen($str, 'utf8');
            $bl = floor($len / 4) * 3;
            if ($start + $end >= $len) {
                return $str;
            }
            return substr_replace($str, str_repeat('*', $len - $start - $end), $start * 3, ($len - $end - $start) * 3);
        } else {
            return self::xing_replace($str = '', $start, $end);
        }
    }

    //验证短信验证码
    public static function validate_code($target = null, $codecat_alias = null, $code = null) {
        $code_model = Code::model();
        $criteria = new CDbCriteria;
        $criteria->with = 'codecat';
        $criteria->compare('codecat.codecat_alias', $codecat_alias);
        $code_info = $code_model->findByAttributes(array('target' => $target), $criteria);
        if (!empty($code_info)) {
            if ($code_info->exc_time > time() && $code_info->status == 0 && $code_info->error_num < 3) {
                if ($code == $code_info->code) {
                    $code_info->status = 1;
                    $code_info->update();
                    return true;
                } else {
                    $code_info->error_num ++;
                    if ($code_info->error_num >= 3) {
                        $code_info->status = 1;
                    }
                    $code_info->update();
                }
            }
        }
        return false;
    }

    public static function num_format($num) {
        if (!is_numeric($num)) {
            return false;
        }
        $num = explode('.', $num); //把整数和小数分开
        $rl = $num[1]; //小数部分的值
        $j = strlen($num[0]) % 3; //整数有多少位
        $sl = substr($num[0], 0, $j); //前面不满三位的数取出来
        $sr = substr($num[0], $j); //后面的满三位的数取出来
        $i = 0;
        while ($i <= strlen($sr)) {
            $rvalue = $rvalue . ',' . substr($sr, $i, 3); //三位三位取出再合并，按逗号隔开
            $i = $i + 3;
        }
        $rvalue = $sl . $rvalue;
        $rvalue = substr($rvalue, 0, strlen($rvalue) - 1); //去掉最后一个逗号
        $rvalue = explode(',', $rvalue); //分解成数组
        if ($rvalue[0] == 0) {
            array_shift($rvalue); //如果第一个元素为0，删除第一个元素
        }
        $rv = $rvalue[0]; //前面不满三位的数
        for ($i = 1; $i < count($rvalue); $i++) {
            $rv = $rv . ',' . $rvalue[$i];
        }
        if (!empty($rl)) {
            $rvalue = $rv . '.' . $rl; //小数不为空，整数和小数合并
        } else {
            $rvalue = $rv; //小数为空，只有整数
        }
        return $rvalue;
    }

    function unicode_encode($name) {

        $name = iconv('UTF-8', 'UCS-2', $name);
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0) {    // 两个字节的文字
                $str .= '\u' . base_convert(ord($c), 10, 16) . base_convert(ord($c2), 10, 16);
            } else {
                $str .= $c2;
            }
        }
        return $str;
    }

    public static function checkMoldArgs($type, $json) {
        $args = json_decode($json);
        $result = $json;
        if (empty($args)) {
            $result = json_encode(array($type));
        } else {
            if (!in_array($type, $args)) {
                $array = array_merge(array($type), $args);
                $result = json_encode($array);
            } else {
                $result = json_encode(array($type));
            }
        }
        return $result;
    }

    public static function checkMold($project_order_model) {
        $model = ProjectOrder::model();
        $first = $model->findByAttributes(array("p_project_id" => $project_order_model->p_project_id), array("order" => "p_addtime ASC"));
        $first->p_mold = self::checkMoldArgs(1, $first->p_mold);
        $first->update();
        $last = $model->findByAttributes(array("p_project_id" => $project_order_model->p_project_id), array("order" => "p_addtime DESC"));
        $last->p_mold = self::checkMoldArgs(2, $last->p_mold);
        $last->update();
        $max = $model->findByAttributes(array("p_project_id" => $project_order_model->p_project_id), array("order" => "p_realmoney DESC,p_addtime DESC"));
        $max->p_mold = self::checkMoldArgs(3, $max->p_mold);
        $max->update();
        $user_arr = join(",", array($first->p_id, $last->p_id, $max->p_id));
        $connection = Yii::app()->db;
        $sql = "update {{project_order}} set p_mold = '' where  p_id not in({$user_arr}) and p_project_id = '{$project_order_model->p_project_id}'";
        $result = $connection->createCommand($sql)->execute();
        return $result;
    }

    public static function check_wap() {
        if (!empty($_REQUEST['fr']) && $_REQUEST['fr'] == 'mobile_acc_pc') {//强制访问pc版本
            return false;
        }
        // 先检查是否为wap代理，准确度高
//		if(stristr($_SERVER['HTTP_VIA'],"wap")){
//			return true;
//		}
        // 检查浏览器是否接受 WML.
        elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            return true;
        }
        //检查USER_AGENT
        elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function GetOrderImg($value, $type) {
        if (!empty($value)) {
            $result = json_decode($value);
            $return = "";
            foreach ($result as $k => $v) {
                switch ($v) {
                    case "1":
                        $return.="<img src='" . BACK_IMG_URL . "order1.png' alt='一马当先' title='一马当先'>";
                        break;
                    case "2":
                        $return.="<img src='" . BACK_IMG_URL . "order2.png' alt='一锤定音' title='一锤定音'>";
                        break;
                    case "3":
                        $return.="<img src='" . BACK_IMG_URL . "order3.png' alt='一枝独秀' title='一枝独秀'>";
                        break;
                }
            }
            return $return;
        }
        return null;
    }

}
