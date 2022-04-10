<?php

namespace App\Helpers;
use App\Helpers\Curl_Helper;
use App\Helpers\Aes_Algorithm;

class Acc_Helper
{
	const NAP_URL = 'https://nap.gamota.com';
    const API_KEY = 'A180822-71VnGY-145080BA3E05C2AC';

    public function __construct(){

    }

	public static function test(){
		echo 'hello helper';
	}

	public static function get_user_info_by_token($appota_token){
		$url = 'https://gamota.com/api/login/appota_access_token';
	    $data['appota_token'] = $appota_token;
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
	    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	    $res = curl_exec($ch);

	    $info = curl_getinfo($ch);
	    curl_close($ch);
	    // var_dump($info['http_code']);
	    if (!$info['http_code']) {
	        error_log('failed to connect to Gamota server');
	        return null;
	    }
	    $json = json_decode($res, true);
	    // var_dump($json);die;
	    if ($json['error_code'] != 0) {
	        return null;
	    }

	    return $json['data'];
	}

	public static function getTotalAmountGameByUserId( $appota_id = '', $start_time = '', $end_time = '' ){
        if($appota_id == '') return false;
        $api_url = 'http://103.53.171.79/api/payment/user';
        $secret_key = 'AppotaGMT123!@#*(NFVNF';
        $start_time = ( $start_time == '' ? '2018/03/01 00:00:00' : $start_time );
        $end_time = ( $end_time == '' ? date('Y/m/d H:i:s') : $end_time );
        
        $ts = time();
        $gmaid = '180822'; //Hien Vien

        $params     = [
            'game_id' => $gmaid,
            'appota_userid' => $appota_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'ts' => $ts,
        ];
        ksort($params);
        $sign = sha1(implode("|", $params) . "|" . $secret_key);
        $params['sign'] = $sign;
        // pr($params,1);
        $result = Curl_Helper::curlGet($api_url, http_build_query($params));
        if ($result['info']['http_code'] != 200) {
            return false;
        }
        $data   = json_decode($result['data']);

        return ( isset( $data->data ) ? $data->data : 0 );
    }

	public static function get_all_server(){
        //Lay tat ca server theo game id
        $url         = self::NAP_URL . '/api/get-list-server';
        $secret_key  = '46e199f9e4b22540cdd4cedffc642fba';
        $params_1    = array(
            'api_key' => self::API_KEY,
        );
        $str_token = serialize($params_1);
        $token     = Aes_Algorithm::AES_256_CBC_Encrypt($str_token, $secret_key);

        $params = array(
            'token' => $token,
        );

        $result_curl = Curl_Helper::send_curl($url, array(), $params, Curl_Helper::METHOD_GET, Curl_Helper::TYPE_JSON);
        if ($result_curl['http_code'] == 200 && is_array($result_curl['body'])) {
            if ($result_curl['body']['errorCode'] == 0) {
                $data_server =  $result_curl['body']['data'];
                $list_server = array();
                if (count($data_server) > 0) {
                    foreach ($data_server as $server_group) {
                        $list_server = $list_server + $server_group['list'];
                    }
                }
                return $list_server;
            }
        }
        return null;
    }
    public static function get_role_by_server($appota_user_id = 0, $server_id = 0){
        //Lay thong tin nhan vat theo server id
        if ($appota_user_id == 0 || $server_id == 0) {
            return null;
        }
        $url         = self::NAP_URL . '/api/get-list-roles';
        $secret_key  = '445c5dea7b27135eb72cc1bd24ead9de';

        $params_2 = array(
            'api_key'        => self::API_KEY,
            'server_id'      => $server_id,
            'appota_user_id' => $appota_user_id,
        );
        $str_token = serialize($params_2);
        $token     = Aes_Algorithm::AES_256_CBC_Encrypt($str_token, $secret_key);
        $params = array(
            'token' => $token,
        );

        $result_curl = Curl_Helper::send_curl($url, array(), $params, Curl_Helper::METHOD_GET, Curl_Helper::TYPE_JSON);
        if ($result_curl['http_code'] == 200 && is_array($result_curl['body'])) {
            if ($result_curl['body']['errorCode'] == 0) {
                return $result_curl['body']['data'];
            }
        }
        return null;
    }
}