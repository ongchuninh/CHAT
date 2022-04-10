<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Helper;
use Gamota\Games\Game;
use Gamota\Games\Language;
use Gamota\Dashboard\Setting;
use Gamota\Options\Option;
use Gamota\News\News;
use Session;


class HomeController extends Controller
{

     public function __construct()
     {
          $this->middleware('locale');
     }

     public function index()
     {
          $lan = \Session::get('website_language', config('app.locale'));
         
          
          if (!$lan) {

               abort(404);
          }

          $language = Language::where('code', $lan)->first();
          if (empty($language)) {

               abort(404);
          }

          $games = Game::where(['status'=>1,'display'=>1])->limit(8)->get();

          $data = [];

          foreach ($games as $key => $game) {

               $data[$key] = $game;

               $data[$key]['data'] = $game->getInfoLanguage($language->id);
          }
          $this->data['games'] = $data;

          $home = Option::where('key', 'custom_home')->first();
          $data = json_decode($home->value);

          foreach ($data->home_slide->game_id as $key => $value) {
               $game = Game::find($value);
               $data->home_slide->games[$key] = $game;
          }

          $this->data['news'] = News::where('status',1)->orderBy('id','desc')->limit(3)->get();
         
          $this->data['custom_home'] = $data;
          return view('clients.home', $this->data);
     }

     public function Service()
     {

          $home = Option::where('key', 'custom_service')->first();
          $data = json_decode($home->value);
          $this->data['custom_service'] = $data;
          //dd($this->data['custom_service']);
          return view('clients.service', $this->data);
     }

     public function Gamota()
     {    
          $home = Option::where('key', 'custom_gamota')->first();
          $data = json_decode($home->value);
          $this->data['custom_gamota'] = $data;
          // dd($this->data['custom_gamota']);
          return view('clients.gamota', $this->data);
     }

     public function Games()
     {
          $lan = \Session::get('website_language', config('app.locale'));

          if (!$lan) {

               abort(404);
          }

          $language = Language::where('code', $lan)->first();
          if (empty($language)) {

               abort(404);
          }

          $games = Game::all();

          $data = [];

          foreach ($games as $key => $game) {

               $data[$key] = $game;

               $data[$key]['data'] = $game->getInfoLanguage($language->id);
          }
          $this->data['games'] = $data;


          $this->data['custom_home'] = $data;





          return view('clients.games', $this->data);
     }

     public function Contact()
     {
          return view('clients.contact');
     }


     public function listNews()
     {
          $this->data['news'] = News::where('status',1)->limit(9)->orderBy('id','desc')->get();
          return view('clients.list_news', $this->data);
     }

     public function newDetail($cate = '',$slug = '')
     {
          if($slug == '' || $cate == '')
               return redirect(route('client.listNews'));
          $this->data['new'] = News::where('status',1)->where('slug',$slug)->first();
          if(empty($this->data['new']))
               return redirect(route('client.listNews'));

          $this->data['games'] = Game::where('status',1)->orderBy('total_play','desc')->limit(6)->get();
          
         //dd($this->data['games'][0]->categories()->first());

          return view('clients.new_detail', $this->data);
     }
     
}