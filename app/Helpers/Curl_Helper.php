<?php
namespace App\Helpers;

class Curl_Helper
{
    const TYPE_JSON = 'json';
    const TYPE_PLAIN = 'plain';
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_DELETE = 'delete';

    /**
     * Send curl
     * @param  string $url url to send
     * @param  array $data data to send
     * @param  string $method [get|post] (defaut 'get')
     * @param  string $type type of response body to return ('json', 'plain') (default TYPE_PLAIN)
     * @param  int $timeout timeout for request (default 15s)
     * @return array(
     *             'http_code' => int,
     *             'header' => string,
     *             'body' => mixed (string|array)
     *         )
     */
    public static function call_curl($url, $data, $option = '')
    {
        if (!$url || !$data) {
            return false;
        }

        switch ($option) {
            case '1':{
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $info = curl_exec($ch);
                curl_close($ch);
                break;
            }
            case '2':{
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $info = curl_exec($ch);
                curl_close($ch);
                break;
            }
            default:{
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $info = curl_exec($ch);
                curl_close($ch);
                break;
            }
        }
        return $info;
    }
    
    public static function send_curl($url, $data, $param, $method = self::METHOD_GET, $decode = self::TYPE_PLAIN, $check_post_type = 1, $timeout = 15){
        $post_info = http_build_query($param);

//            send curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'otoc:lttt');
        if ($method === self::METHOD_POST) {
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $post_info);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
        } elseif($method === self::METHOD_GET) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $post_info);
        } elseif($method === self::METHOD_DELETE) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_URL, $url . "?" . $post_info);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $result = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $result_ary = array(
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            'header' => substr($result, 0, $header_size),
            'body' => substr($result, $header_size),
        );
//    echo $result;
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200 && $decode === self::TYPE_JSON) {
            $result_ary['body'] = json_decode($result_ary['body'], true);
        }

        return $result_ary;

    }

    public static function curlPost($URL, $param, $user_agent = null)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        if (!empty($user_agent)) {
            curl_setopt($ch, CURLOPT_USERAGENT, "$user_agent");
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $server_output = curl_exec($ch);
        $info          = curl_getinfo($ch);
        $result        = [
            'data' => $server_output,
            'info' => $info, //["http_code"]
        ];
        curl_close($ch);
        return $result;
    }

    public static function curlGet($URL, $param = null)
    {
        $params = '';
        $ch = curl_init();

        if(!empty($param))
        {
            $first = array_slice($param, 0, 1);
            foreach($first as $key => $value)
            {
                $params .= '?'.$key .'='. $value; 
            }
            array_shift($param);
          
            foreach($param as $key => $value)
            {
                
                $params .= '&'.$key .'='. $value; 
            }

        }

        

        //$fullUrl = !empty($param) ? "$URL?$param" : "$URL";

        $fullUrl = $URL.$params;
       
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, sdch, br');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $server_output = curl_exec($ch);
        $info          = curl_getinfo($ch);
        $result        = [
            'data' => $server_output,
            'info' => $info, //["http_code"]
        ];
        curl_close($ch);
        return $result;
    }


}