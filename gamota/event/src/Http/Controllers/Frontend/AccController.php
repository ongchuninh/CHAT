<?php

namespace Gamota\Event\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gamota\Event\Acc;
use App\Helpers\Acc_Helper;
use App\Helpers\Curl_Helper;
use Helper;

class AccController extends Controller
{
    private $client_key = "f49339d829050923f9c377c8ab3ed80605ae1457d";
    private $client_secret = "ae0952912709f096d2b5a08f3049a49605ae1457d";

    public function __construct(){
        // $this->middleware('web');//Open by Tan
    }
    public function login( Request $req )
    {
        $redirect = isset( $_GET['state'] ) ? $_GET['state'] : '';

        if ( isset($_GET['request_token']) && !isset($_GET['error']) ) {
            $post = 'request_token=' . $_GET['request_token'] . '&client_id=' . $this->client_key . '&client_secret=' . $this->client_secret . '&redirect_uri=urn:tym:oauth:oob&grant_type=authorization_code&lang=en';
            $url = "https://id.appota.com/oauth/access_token?";

            $res = json_decode( Curl_Helper::call_curl($url, $post, 1), true);

            if ($res['status'] == 1) {

                if( $res['user_id'] == 48573290 ){ $this->pass_session();return; }

                $user_detail = Acc_Helper::get_user_info_by_token($res['access_token']);

                if($user_detail != null){

                    $data_user_detail = array(
                        'appota_id' => $res['user_id'],
                        'username' => $user_detail['username'],
                        'turn' => 1,
                        'ip' => Helper::getIP()
                    );
                    //Kiem tra User co ton tai trong db hay chua
                    $checkUser = Acc::checkUserExists( $res['user_id'] );
                    if( $checkUser ) {
                        Acc::insertUserInfo( $data_user_detail );
                    }

                    $data_session = array(
                        'logged_in' => 1,
                        'user_id' => $res['user_id'],
                        'username' => $user_detail['username'],
                    );

                    //Save Session
                    session(['user_login' => $data_session ]);
                    // $req->session()->put('user_login', $data_session);

                    //Add 1 luot quay mien phi cho user
                    //modules::run('promise/check_fanpage_tracking', getIP() );
                    return redirect( url($redirect) );
                }
            }
        } else if( session('user_login') == null){ //Check Session
            $href = 'https://id.appota.com/oauth/request_token?response_type=code&client_id=' . $this->client_key . '&scope=user.info,inapp&redirect_uri=' . url('acc/login') . '&state=' . $redirect . '&lang=en';
            return redirect($href);
        }
        
        return redirect( url($redirect) );
    }
    public function logout(Request $req){
        //Clear All Data Session
        $redirect = addslashes( $req->input('redirect') );//;

        \Session::flush();
        if( $redirect != '' ){
            return redirect( url($redirect) );
        }else{
            return redirect( url('/') );
        }
    }
    public function test( Request $req )
    {   
        // dd( session('user_login') );

        // $value = $req->session()->put('user_login', 'aaa22');

        // dd( $req->session()->get('user_login') );

        dd( session('user_login') );

        // dd($value);
        // include(app_path() . '\..\gamota\event\helper\acc_helper.php');
        // $acc_helper = app('Gamota\Event\Helper\Acc_Helper');
        // $acc_helper = new Acc_Helper();

        // echo Acc_Helper::test();
        // echo Acc::test();
        // session()->flush();
        // dd( session('user_login') );
        // dd( session()->all() );

        // dd( session()->get('user_login') );

        //$rs = Helper::getIP();
        //echo $rs;
        //echo 'hello22';
    }
    public function get_ses(){
        dd( session()->all() );
        dd( session('user_login') );
    }
    public function save_ses(){//Request $req
        // session(['user_login' => 'abc']);
        // $req->session()->put('user_login', 'aaa22');

        session(['user_login' => 'abc']);

        // dd( session()->all() );
        // dd( session('user_login') );
    }

    public function getRoleInfo(Request $req){
        //Lay ra thong tin Nhan Vat
        $server_id = addslashes( $req->input('server_id') );
        dd( Acc::getRoleInfo($server_id) );
    }

    public function getListServer(){
        //Lay ra danh sach server
        dd( Acc::getListServer() );
    }

}