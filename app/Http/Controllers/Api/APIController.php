<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gamota\Games\Game;
use Gamota\Games\Language;
use Gamota\Contacts\Contact;
use Gamota\Options\Option;
use App\Helpers\Curl_Helper;
use Illuminate\Support\Facades\Validator;
use Mail;

use Session;

class APIController extends Controller
{
    //
    public function getListGame(Request $rq)
    {
        $lan = $rq->lang;

        if (!$lan) {
            return response()->json([
                'error' => 1,
                'message' => 'Bạn chưa chọn ngôn ngữ',

            ]);
        }

        $language = Language::where('code', $lan)->first();
        if (empty($language)) {
            return response()->json([
                'error' => 1,
                'message' => 'Không tồn tại ngôn ngữ này',

            ]);
        }

        $games = Game::all();

        if (count($games) > 0) {
            $data = [];

            foreach ($games as $key => $game) {

                $data[$key] = $game;

                $data[$key]['data'] = $game->getInfoLanguage($language->id);
            }

            return response()->json([
                'error' => 0,
                'message' => 'Success',
                'data' => $data

            ]);
        } else {

            return response()->json([
                'error' => 2,
                'message' => 'Chưa có danh sách game',
                

            ]);

            // $url = 'https://game.gamota.com/api/games';
            // $params = [
            //     'order' => 'order',
            //     'limit' => 1000,

            // ];

            // $res = Curl_Helper::curlGet($url,$params);
            // $data = json_decode($res['data']);

            // $games = $data->games;

            // $data = [];

            // foreach($games as $key => $game)
            // {
            //     $data[$key]['thumbnail'] = $game->icon;
            //     $data[$key]['thumbnail'] = $game->icon;
            //     $data[$key]['link'] = $game->slug;
            //     $data[$key]['id'] = $game->id;
            //     $data[$key]['qrcode'] = $game->qrcode;
            //     $data[$key]['data'] = [
            //         'name' =>  $game->name,
            //         'description' =>  $game->description,
            //     ];

            // }

        }
    }

    public function contact(Request $rq)
    {
      
        
        $validator = Validator::make($rq->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns',
            'subject' => 'required',
           
        ]);

        if ($validator->fails()){
            return response([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $contact = new Contact();
        $contact->name = $rq->name; 
        $contact->message = $rq->message;
        $contact->email = $rq->email;
        $contact->subject = $rq->subject;
        $contact->save();

        //send mail admin
        $data = Option::where('key', 'custom_general')->first();
        
        $data = json_decode($data->value);
        foreach($data as $key => $value)
        {
            Mail::send('clients.contact_mail', array('name' => $rq->name, 'email' => $rq->email, 'subject' => $rq->subject, 'msg' => $rq->message), function($message) use($value) {
                $message->to($value, 'Người dùng liên hệ')->subject('Người dùng liên hệ!');
            });
        }
        
        

        return response([
            'errors' => false,
            'msg' =>'success',
        ]);
       
    }

    public function getListLanguage()
    {
        $data = Language::all('id', 'name', 'code');
        if (count($data) == 0)
            return response()->json([
                'error' => 1,
                'message' => 'Chưa có ngôn ngữ',
                'data' => $data
            ]);

        return response()->json([
            'error' => 0,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function changeLanguege(Request $rq)
    {
        
        
        $lan = $rq->lang;

        if (!$lan) {
            return response()->json([
                'error' => 1,
                'message' => 'Bạn chưa chọn ngôn ngữ',

            ]);
        }

        $language = Language::where('code', $lan)->first();
        if (empty($language)) {
            return response()->json([
                'error' => 1,
                'message' => 'Không tồn tại ngôn ngữ này',

            ]);
        }

    
        $rq->session()->put('website_language', $language->code);
       
        
        return response()->json([
            'error' => 0,
            'message' => 'Success',
            

        ]);
    }

   

    public function getGame(Request $rq)
    {
        $perPage = 8;
        $page = $rq->page;

        if($page == '')
        {
            return response()->json([
                'error' => '1',
                'message' => 'param is missing',
            ]);
        }

        $games = Game::offset($page * $perPage)->limit(8)->get();
        $data = [];
        foreach($games as $key => $game)
        {
            $data[$key] = $game;
            $data[$key]['name'] = $game->getInfoLanguage(1)->name;
            $data[$key]['description'] = $game->getInfoLanguage(1)->description;
        }
        return response()->json([
            'error' => '0',
            'message' => 'success',
            'data' => $data
        ]);
    }
}