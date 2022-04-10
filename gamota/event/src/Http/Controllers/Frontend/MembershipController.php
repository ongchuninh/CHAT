<?php

namespace Gamota\Event\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Gamota\Event\Membership;
use App\Helpers\Acc_Helper;

class MembershipController extends Controller
{
    public function __construct()
    {

    }
    public function ajax_getLevelVip(){
        // dd('alo');
    	$this->check_login();

        $this->getTotalInfo();

        //Kiem tra xem User da dang ky lan nao trong thang hay chua?
        //$this->membership->getTotalInfo();
    }
    function check_login(){
        if( session('user_login') == null ){
            echo json_encode( array('status' => 0, 'msg' => 'Vui lòng đăng nhập !') );die;
        }
        // dd( session('user_login')['user_id'] );
        // $user_login = session('user_login');
        // dd( $user_login['username'] );
        return TRUE;
    }
    function getTotalInfo(){
        $user_id = session('user_login')['user_id'];
        //Kiem tra xem User da co thong tin trong DB hay chua
        $time = $this->getTimeConfig();
        $pay_info = $this->getInfoExist();
        //dd($pay_info);
        if($pay_info){
            //Luu so tien vao session
            session(['payinfo' => $pay_info]);

            $output = array('status' => 1, 'vipinfo' => $pay_info->lv_key);
            $output['payinfo'] = (object) array('total_g' => number_format($pay_info->total_g, 0 ,",", ".") , 'total_m' => number_format($pay_info->total_m, 0 ,",", "."), 'lv_name' => $pay_info->lv_name, 'lv_class' => $pay_info->lv_key );

            $output['msg'] = sprintf("
                Tổng nạp của bạn từ lúc game ra mắt đến hiện tại là : %s VNĐ <br/>
                Mức nạp từ tháng trước của bạn <br/> ( từ %s - %s ) là %s VNĐ. <br/>
                Bạn đã đủ điều kiện để nhận quà của mốc Vip %s.
            ",
            number_format($pay_info->total_g, 0 ,",", "."),
            date('d.m.Y', strtotime($time->start)),
            date('d.m.Y', strtotime($time->end)),
            number_format($pay_info->total_m, 0 ,",", "."),
            $pay_info->lv_name );
            
            dd( $output );
            echo json_encode( $output );die;
        }else{
            //Goi qua Api de lay thong tin
            $rs_pay = $this->getTotalPay();

            //Kiem tra xem User co dat moc vip nao hay khong
            $v_level = $this->getLevelMemberShip($rs_pay->total_m, $rs_pay->total_g);//+ 4000000

            //Luu so tien vao session
            session(['payinfo' => $rs_pay]);

            if(!$v_level){
                $output = array('status' => 0, 'title' => 'Thông báo', 'msg' => 'Bạn không đủ điều kiện !');
                $output['payinfo'] = (object) array('total_g' => number_format($rs_pay->total_g, 0 ,",", ".") , 'total_m' => number_format($rs_pay->total_m, 0 ,",", "."), 'lv_name' => 'Chưa đạt' );

                $output['msg'] = sprintf("
                    Tổng nạp của bạn từ lúc game ra mắt đến hiện tại là : %s <br/>
                    Mức nạp từ tháng trước của bạn <br/> ( từ %s - %s ) là %s VNĐ. <br/>
                    Bạn chưa đủ điều kiện để nhận quà của mốc Vip.
                ",
                number_format($rs_pay->total_g, 0 ,",", "."),
                date('d.m.Y', strtotime($time->start)),
                date('d.m.Y', strtotime($time->end)),
                number_format($rs_pay->total_m, 0 ,",", ".")
                );

                dd( $output );
                echo json_encode( $output );die;
            }

            //Luu thong tin vao DB
            $dt = array(
                'user_id' => $user_id,
                'total_g' => $rs_pay->total_g,
                'total_m' => $rs_pay->total_m,
                'lv_key' => $v_level->lv_key,
                'lv_name' => $v_level->lv_name,
                'created' => date('Y-m-d H:i:s'),
            );
            DB::table('member_level')->insert($dt);

            $output = array('status' => 1, 'vipinfo' => $v_level->lv_key);
            $output['payinfo'] = (object) array('total_g' => number_format($rs_pay->total_g, 0 ,",", ".") , 'total_m' => number_format($rs_pay->total_m, 0 ,",", "."), 'lv_name' => $v_level->lv_name, 'lv_class' => $v_level->lv_key );

            $output['msg'] = sprintf("
                Tổng nạp của bạn từ lúc game ra mắt đến hiện tại là : %s VNĐ <br/>
                Mức nạp từ tháng trước của bạn <br/> ( từ %s - %s ) là %s VNĐ. <br/>
                Bạn đã đủ điều kiện để nhận quà của mốc Vip %s.
            ",
            number_format($rs_pay->total_g, 0 ,",", "."),
            date('d.m.Y', strtotime($time->start)),
            date('d.m.Y', strtotime($time->end)),
            number_format($rs_pay->total_m, 0 ,",", "."),
            $v_level->lv_name );

            dd( $output );
            echo json_encode( $output );die;
        }
    }
    function getTimeConfig(){
        $d = new \DateTime();
        $d->modify("-1 month");
        $data['start'] = $d->format('Y-m-01 00:00:00');//dau thang
        //$data['end'] = date('Y-m-t 23:59:59');// $d->format('Y-m-d');//cuoi thang
        $data['end'] = $d->format('Y-m-t 23:59:59');
        $data['start_g'] = '2019-08-29 10:00:00';//Thoi gian game ra mat
        $data['end_g'] = date('Y-m-d H:i:s');//Thoi gian hien tai
        return (object) $data;
    }
    function getInfoExist(){
        $user_id = session('user_login')['user_id'];
        $time = $this->getTimeConfigCurrent();

        $start = date('Y-m-d', strtotime($time->start) );
        $end = date('Y-m-d', strtotime($time->end) );

        $rs = DB::table( 'member_level' )
        ->where('user_id', $user_id)
        ->where(function($query) use ($start, $end){
            $query  ->whereDate("created", '>=', $start)
                    ->whereDate("created", '<=', $end);
        })
        ->first();//first();
        return $rs;
    }
    function getTotalPay(){
        $user_id = session('user_login')['user_id'];
        //Call Api get Total Pay Info
        $time = $this->getTimeConfig();

        $data['total_g'] = 10000000;//Acc_Helper::getTotalAmountGameByUserId($user_id, $time->start_g, $time->end_g);
        usleep(300000);//0.3s
        $data['total_m'] = 3000000;//Acc_Helper::getTotalAmountGameByUserId($user_id, $time->start, $time->end);

        return (object) $data;
    }
    function getLevelMemberShip( $pay_m, $pay_g ){
        $config_lv = $this->getConfigMemberShip();
        foreach ($config_lv as $k => $vl) {
            //Kiem tra nap theo thang va tong nap xem co du dieu kien hay khong
            if( $pay_m >= $vl['pay_m'] && $pay_g >= $vl['pay_g'] ){
                return (object) $vl;break;
            }
        }
        return false;//No rank
    }
    function getTimeConfigCurrent(){
        //Lay thoi gian bat dau, ket thuc cua thang nay
        $data['start'] = date('Y-m-01 00:00:00');
        $data['end'] = date('Y-m-t 23:59:59');
        return (object) $data;
    }
    function getConfigMemberShip($key = null){
        $config = array(
            array('lv_key' => 'kimcuong', 'lv_name' => 'Kim Cương', 'pay_g' => 40000000, 'pay_m' => 3000000),
            array('lv_key' => 'bachkim', 'lv_name' => 'Bạch Kim', 'pay_g' => 20000000, 'pay_m' => 2000000),
            array('lv_key' => 'vang', 'lv_name' => 'Vàng', 'pay_g' => 10000000, 'pay_m' => 1000000),
            array('lv_key' => 'bac', 'lv_name' => 'Bạc', 'pay_g' => 5000000, 'pay_m' => 500000),
        );
        // return ($key != null && isset( $config[$key] ) ) ? $config[$key] : $config;
        if($key != null){
            return ( isset( $config[$key] ) ? $config[$key] : false );
        }
        return $config;
    }
    function ajax_updateUserInfo(Request $req){
        //Kiem tra login
        $this->check_login();

        $input = $req->input();
        Membership::updateUserInfo( $input );
    }
}