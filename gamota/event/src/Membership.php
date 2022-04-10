<?php

namespace Gamota\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Gamota\Dashboard\Support\Traits\Filter;
use Helper;

class Membership extends Model
{
    use Filter;

	protected $tbl = 'member_level';

    protected $table = 'member_level';

	protected $tbl_role_inf = 'member_role_info';

    protected static $defaultFilter = [
        'status'            => 'enable',
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
    ];

    protected static $filterable = [
        'id' => '',
        'user_id' => '',
        'keyword' => '',
        '_orderby' => '',//add by Tan
        '_sort' => 'in:asc,desc',//add by Tan
    ];
	/* BEGIN OF ADMIN ======================================================================================================== */
	public function scopeApplyFilter($query, $args = [])
    {
        $query->from('member_level');
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (! empty($args['keyword'])) {
            $query->where('user_id', $args['keyword']);
            $query->orWhere('lv_name', $args['keyword']);
        }
    }
    public function scopeApplyFilterRole($query, $args = [])
    {
        $this->table = 'member_level';
        $query->from('member_level');
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (! empty($args['keyword'])) {
            $query->where('user_id', $args['keyword']);
            $query->orWhere('lv_name', $args['keyword']);
        }

        $query->join('member_role_info', 'member_role_info.user_id', '=', 'member_level.user_id');
    }
	/* BEGIN OF FRONTEND ======================================================================================================== */
	public static function updateUserInfo( $input ){
		$user_id = session('user_login')['user_id'];

		//Kiem tra User da nhap thong tin hay chua
		$check_exist = self::getUserInfoExist( $user_id );
		if($check_exist){
            //Neu User da tham gia hen uoc, thi ko insert them du lieu no vua nhap nua
            $rs = array('status' => 0, 'msg'=> "Bạn đã nhập thông tin cá nhân rồi !");
            die( json_encode( $rs ) );
        }else{
        	$data = self::validate_post_info( $input );
            $data['user_id'] = $user_id;
            
            DB::table( (new self)->tbl_role_inf )->insert( $data );

            $rs = array('status' => 1, 'msg' => "Bạn đã lưu thông tin thành công !<br/> Vui lòng chọn mốc VIP để nhận quà !");
            die( json_encode( $rs ) );
        }

	}
	static function getUserInfoExist($user_id){
		$rs = DB::table( (new self)->tbl_role_inf )
        ->where('user_id', $user_id)
        ->first();//first();
		return $rs;
	}
	static function validate_post_info( $input ){
		$param = array('fullname', 'email', 'phone', 'address', 'server_id', 'role_name', 'role_id');

		foreach ($param as $vl) {
			if( !isset( $input[$vl] ) ){
				$rs = array('status' => 0, 'msg'=> "Missed param : ".$vl);
            	die( json_encode( $rs ) );
			}
		}

        $fullname = addslashes( $input['fullname'] );
        $email = addslashes( $input['email'] );
        $phone = addslashes( $input['phone'] );
        $address = addslashes( $input['address'] );

        $server_id = addslashes( $input['server_id'] );
        $role_name = addslashes( $input['role_name'] );
        $role_id = addslashes( $input['role_id'] );

        if($fullname == '' || $email == '' || $phone == '' || $address == '' ){
            $rs = array('status' => 0, 'msg'=> "Vui lòng nhập đầy đủ Thông tin cá nhân !");
            die( json_encode( $rs ) );
        }

        if( !Helper::validate_email( $email ) ){
            $rs = array('status' => 0, 'msg'=> "Địa chỉ email không hợp lệ !");
            die( json_encode( $rs ) );
        }
        if( !Helper::validate_phone( $phone ) ){
            $rs = array('status' => 0, 'msg'=> "Số điện thoại không hợp lệ !");
            die( json_encode( $rs ) );
        }

        if($server_id == '' || $server_id == 0){
            $rs = array('status' => 0, 'msg'=> "Vui lòng nhập đầy đủ Server !");
            die( json_encode( $rs ) );
        }
        if($role_id == '' || $role_id == '0'){
            $rs = array('status' => 0, 'msg'=> "Vui lòng nhập đầy đủ Thông tin nhân vật !");
            die( json_encode( $rs ) );
        }
        if($role_name == ''){
            $rs = array('status' => 0, 'msg'=> "Vui lòng nhập đầy đủ Thông tin Nhân Vật. !");
            die( json_encode( $rs ) );
        }

        return array(
            'server_id' => $server_id, 
            'role_name' => $role_name, 
            'role_id' => $role_id,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        );
	}
}