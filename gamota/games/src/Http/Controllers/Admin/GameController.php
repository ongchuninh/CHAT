<?php

namespace Gamota\Games\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;

use Illuminate\Support\Facades\Validator;
use Gamota\Games\Game;
use Gamota\Games\Language;
use Gamota\Games\GameToLanguage;
use Gamota\Games\GameCategory;
use Gamota\Games\GameToCategory;
use App\Helpers\Curl_Helper;
use Image;
use Session;

// use QrCode;


class GameController extends AdminController
{

    public function __construct()
    {
        parent::__construct();

        $this->languages = Language::all();
    }
    public function index()
    {
        $filter = Game::getRequestFilter();
        $this->data['filter'] = $filter; 
       
        $this->data['games'] = Game::applyFilter($filter)->paginate($this->paginate);
        //dd($this->data['games']);
        \Metatag::set('title', 'Danh sách Game');

        return view('Games::admin.list', $this->data);
    }

    public function create()
    {
        $game = new Game();
        $this->data['game'] = $game;

        $this->data['gameCate'] = GameCategory::all();


        \Metatag::set('title', "Thêm mới game");
        return view('Games::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'game.name.*' => 'required|max:200|unique:game_language,name',
            'game.game_id' => 'required|max:255',
            'game.thumbnail' => 'required',
            'game.status' => 'required',
            'game.category_id' => 'required'
        ]);

        $game = new Game();
        $game->fill($request->input('game'));



        $game->save();


        foreach ($this->languages as $language) {

            $gameToLanguage = new GameToLanguage();

            $gameToLanguage->game_id = $game->id;
            $gameToLanguage->language_id = $language->id;
            $gameToLanguage->name = $request->game['name'][$language->code];
            $gameToLanguage->description = $request->game['description'][$language->code];

            $gameToLanguage->save();
        }


        $gameToCate = new GameToCategory();
        $gameToCate->game_id = $game->id;
        $gameToCate->category_id = $request->game['category_id'];
        $gameToCate->save();

        if ($request->ajax()) {
            return response()->json([
                'title'         =>    trans('cms.success'),
                'message'       =>    'Thêm mới thành công',
                'redirect'      =>    $request->exists('save_only') ?
                    route('admin.game.edit', ['id' => $game->id]) :
                    route('admin.game.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.game.edit', ['id' => $game->id]);
        }

        return redirect()->route('admin.game.create');
    }

    public function edit(Game $game)
    {
        $this->data['game'] = $game;

        $this->data['gameCate'] = GameCategory::all();
        \Metatag::set('title', 'Chỉnh sửa Game');
        return view('Games::admin.save', $this->data);
    }

    public function update(Request $request, Game $game)
    {

        // $this->validate($request, [

        //     'game.name' => 'required|max:200|unique:games,name,'.$game->id.',id',
        //     'game.game_id' => 'required|max:255',
        //     'game.thumbnail' => 'required',
        //     'game.status' => 'required',
        // ]);
        $this->validate($request, [
            'game.name.*' => 'required|max:200',
            'game.game_id' => 'required|max:255',
            'game.thumbnail' => 'required',
            'game.status' => 'required',
            'game.category_id' => 'required'
        ]);

        $game->fill($request->input('game'));
        
        $game->save();

        $game->getLanguage()->delete();

        foreach ($this->languages as $language) {

            $gameToLanguage = new GameToLanguage();

            $gameToLanguage->game_id = $game->id;
            $gameToLanguage->language_id = $language->id;
            $gameToLanguage->name = $request->game['name'][$language->code];
            $gameToLanguage->description = $request->game['description'][$language->code];

            $gameToLanguage->save();
        }

        GameToCategory::where('game_id', $game->id)->delete();

        $gameToCate = new GameToCategory();
        $gameToCate->game_id = $game->id;
        $gameToCate->category_id = $request->game['category_id'];
        $gameToCate->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    'Chỉnh sửa thành công',
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.game.index');
            }

            return response()->json($response, 200);
        }

        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.game.index');
        }

        return redirect()->back();
    }


    public function destroy(Request $request, Game $weapon)
    {
        $weapon->delete();

        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('Weapons::weapon.destroy-weapon-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function appplyStatusGame(Request $request, $status = 'enable')
    {

        $arrId = $request->input('id');
        $title = trans('cms.success');
        $message = 'Xóa game thành công';
        $code = 200;
        if ($status != 'destroy') {
        } else {
            $flag = Game::whereIn('id', $arrId)->delete();
        }
        if (!$flag) {
            $code = 422;
            $title = trans('cms.error');
            $message = trans('news.apply_err');
        }
        return response()->json([
            'title'     =>  $title,
            'message'   =>  $message,
            'success_id' =>  $arrId,
        ], $code);
    }


    public function updateGameFromGame(Request $rq)
    {
        set_time_limit(0);

        
        $url = 'https://game.gamota.com/api/games';
        $params = [
            'order' => 'order',
            'limit' => 1000,

        ];

        $res = Curl_Helper::curlGet($url, $params);
        $data = json_decode($res['data']);
        
        $games = $data->games;
        
       
        foreach ($games as $key => $value) {
            
            //check ton tai
            $check = Game::where('game_id',$value->payhubAppId )->count();
           
            if($check > 0 )
                continue;

            $qrCode = '/uploads/images/qrcode/'.$value->slug.'.png';

            $linkImg = ($value->installUrl->itunes != "")?$value->installUrl->itunes:$value->installUrl->gp;
            $linkItune = ($value->installUrl->itunes != "")?$value->installUrl->itunes : 'https://game.gamota.com/';
            $linkGP = ($value->installUrl->gp != "")?$value->installUrl->gp : 'https://game.gamota.com/';

            $params = [
                'type' => 'APP_DOWNLOAD',
                'app-download-url-itunes-checked' => 1,
                'app-download-url-itunes' => $linkItune,
                'app-download-url-itunes-ipad' => 'https =>//go.onelink.me/app/39db7164',
                'app-download-url-google-play-tablet' => '',
                'app-download-url-google-play-tablet-cn' => '',
                'app-download-url-google-play-checked' => 1,
                'app-download-url-google-play'=> $linkGP,
                'app-download-url-google-play-cn' => '',
                'app-download-url-blackberry-app-world' => '',
                'app-download-url-blackberry-ten-app-world' => '',
                'app-download-url-windows-marketplace' => '',
                'app-download-url-fallback-checked' => 1,
                'app-download-url-fallback' => 'https://game.gamota.com/',
                'ecc_level' => 'L',
                'width_pixels' => 400,
                'dpi' => 72,
                'file_type' => 'png',
                'module_shape' => 'Normal',
                'finder_shape' => 'Normal',
                'module_color' => '#000000',
                'finder_color' => '#000000',
                'finder_eye_color' => '#000000',
                'transparent_bg' => 'null',
            ];
            
    
            $linkImg = Curl_Helper::curlPost('https://www.qrstuff.com/generate.generate?sendBase64=1&preview=1&style=1',$params);
            
            $image = Image::make($linkImg['data']);
            
            $image->fit(150, 150)->save(public_path($qrCode));
            
            $game = new Game;

            $game->thumbnail = $value->covermd;
            $game->thumbnail_lg = $value->coverlg;
            $game->icon = $value->icon;
            $game->total_play = $value->numPlayers;
            $game->game_id = $value->payhubAppId;
            $game->gma_id = '';
            //$game->link = 'https://game.gamota.com/game/'.$value->slug . '-' . $value->id;
            $game->link =  ($value->landing != '') ? $value->landing : 'https://game.gamota.com/';
            $game->api_key = '';
            $game->fb_page_id = $value->fb_fanpage;
            $game->qr_code = $qrCode;

            $game->status = 1;
            $game->save();

            //check game cate
            $cate = GameCategory::where('name', $value->genres[0])->first();
            if (empty($cate)) {
                $cate = new GameCategory();
                $cate->name = $value->genres[0];
                $cate->description = '';
                $cate->save();
            } 

            //
            $gameToCate = new GameToCategory();
            $gameToCate->category_id = $cate->id;
            $gameToCate->game_id = $game->id;
            $gameToCate->save();

            //translate
            $languages = Language::all();

            $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
            $apiKey = 'trnsl.1.1.20190524T020422Z.62f3f4ce28157ea1.44bdecad555387e5e1f4cc5acae517ac5f0136ae';
            foreach($languages as $language)
            {
               
                $params = [
                    'key' => $apiKey,
                    'text' => urlencode($value->name),
                    'lang' => 'vi-'.(($language->code == 'cn')?'zh':$language->code),
                ];
               
                $res = Curl_Helper::curlGet($url,$params);
               
                $res = json_decode($res['data']);
                
                $gameName = $value->name;

                if(isset($res->code) && $res->code == 200)
                {
                    
                    $gameName = ($res->text[0] == "")? $gameName :$res->text[0];
                }

                $params = [
                    'key' => $apiKey,
                    'text' => urlencode($value->desc),
                
                    'lang' => 'vi-'.(($language->code == 'cn')?'zh':$language->code),
                ];

                $res = Curl_Helper::curlGet($url,$params);
                $res = json_decode($res['data']);

                $description = $value->desc;

                if(isset($res->code) && $res->code == 200)
                {
                    
                    $description = ($res->text[0] == "")? $description :$res->text[0];
                }

                $gameLanguege = new GameToLanguage();
                $gameLanguege->game_id = $game->id;
                $gameLanguege->language_id = $language->id;
                $gameLanguege->name = $gameName;
                $gameLanguege->description = $description;
                $gameLanguege->save();
               
            }

            

        }

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Cập nhật thành công',
        ];
        if ($rq->ajax()) {
           
          

            $response['redirect'] = route('admin.game.index');
            return response()->json($response, 200);

        }
        
        return response()->json($response, 200);
    }

    

}