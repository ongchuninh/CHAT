<?php

namespace Gamota\Event;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\Acc_Helper;
use App\Helpers\Curl_Helper;

class Acc extends Model
{
	protected $table = 'acc';

	protected $primaryKey = 'id';

	/* BEGIN OF FRONTEND ============================================================================== */
	static function checkUserExists($user_id){
		//Kiem tra xem User co ton tai trong DB hay chua ?
		$rs = Acc::where('appota_id', $user_id)->first();
		return ( $rs != null ? FALSE : TRUE );
		//dd($rs);
	}
	static function insertUserInfo( $data ){
		DB::table( (new self)->table )->insert( $data );
		return TRUE;
	}

	static function test(){
		//Goi bien tu protected
		return (new self)->table;
	}

	static function getRoleInfo( $server_id ){
        // return 'abc';
        $user_id = session('user_login')['user_id'];

        if(!$server_id || $server_id == 0){
            $rs_arr = array('status' => 0, 'msg' => "Server không hợp lệ !" );
            die( json_encode( $rs_arr ) );
        }

        $rs = Acc_Helper::get_role_by_server( $user_id , $server_id);

        if(!$rs || empty($rs) ){
            $rs_arr = array('status' => 0, 'msg' => "Lỗi kết nối API !" );
            die( json_encode( $rs_arr ) );
        }

        $sum_nv = count($rs);
        if($sum_nv > 0){
            $str_html = "<option value=''>-- Có ".$sum_nv." nhân vật --</option>";
            foreach ($rs as $k => $vl) {
                $str_html .= "<option value ='".$k."' >".$vl."</option>";
            }
        }else{
            $str_html = "<option value=''>-- Không có nhân vật --</option>";
        }

        $rs_arr = array('status' => 1, 'html' => $str_html );
        die( json_encode( $rs_arr ) );
    }
    static function getListServer(){
    	return Acc_Helper::get_all_server();
    }
}