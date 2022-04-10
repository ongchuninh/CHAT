<?php 
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper {

    public static function getCategoryById($id){
        return DB::table('news_categories')->where('id',$id)->pluck('name')->first();
    }

    public static function CutText($text, $n = 80)
    {
        // string is shorter than n, return as is
        if (strlen($text) <= $n) {
            return $text;
        }
        $text = substr($text, 0, $n);
        if ($text[$n - 1] == ' ') {
            return trim($text) . "...";
        }
        $x  = explode(" ", $text);
        $sz = sizeof($x);
        if ($sz <= 1) {
            return $text . "...";
        }
        $x[$sz - 1] = '';
        return trim(implode(" ", $x)) . "...";
    }

    public static function create_slug($str)
    {
        if (!$str)
            return false;
        $str     = trim($str);
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            ' ' => ' - |- | -',
            '-' => '/|,|.|(|)|-|“|”|?|!|' . "'|" . '"',
            ''  => '[|]'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        $str = str_replace('(*)', '', $str);
        $str = preg_replace('/\s+/', '-', $str);
        $str = strtolower($str);
        return $str;
    }
    public static function getSetting($slug = '')
    {
        if(is_null($slug)){
            return '';
        }
       return DB::table('settings')->select('value')->where('key', $slug)->value('value');
    }

    public static function getSettingJson($key = '')
    {
        if(is_null($key)){
            return '';
        }
       $data = DB::table('settings')->select('value')->where('key', $key)->value('value');
       return json_decode($data);
    }

    public static function getLinkDownload($slug = '')
    {
        if(is_null($slug)){
            return '';
        }
       return DB::table('links')->where('slug', $slug)->where('status',1)->select('title','slug','url','target')->first();
    }
    public static function getImageDetail( $image_path, $category_id )
    {
        if( $image_path != '' ){

            $pattern = '/http/';
            if (preg_match($pattern, $image_path)) {
                return $image_path;
            }
            return asset('').$image_path;
        }
        $img_thumbnail = self::getImgCategory($category_id);
        return ( $img_thumbnail ? $img_thumbnail : asset('').'storage/no-thumbnail.png' );
    }
    public static function getImgCategory($category_child_id)
    {
        //Kiem tra Category Child co img_thumbnail hay khong
        $row = DB::table('news_categories')->select('thumbnail','parent_id')->where('id',$category_child_id)->first();
        if(isset($row->thumbnail) && $row->thumbnail!=''){
            return asset('').$row->thumbnail;
        }
        // dd($row);
        //Neu Child Category Khong co Img Thumbnail 
        $row = DB::table('news_categories')->select('thumbnail')->where('id',$row->parent_id)->first();
        if(isset($row->thumbnail) && $row->thumbnail!=''){
            return asset('').$row->thumbnail;
        }
       
        return asset('').'storage/no-thumbnail.png';
    }
    public static function getIP(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public static function current_url()
    {
       return \Illuminate\Support\Facades\URL::current();
    }
    public static function validate_email($email){
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
    }
    public static function validate_phone($phone){
        $pattern = "/^[0-9]{10,12}+$/";

        return ( !preg_match($pattern, $phone) ) ? FALSE : TRUE;
    }
}
?>