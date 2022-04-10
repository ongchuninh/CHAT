<?php

namespace Gamota\Options\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;

use Illuminate\Support\Facades\Validator;
use Gamota\Options\Option;
use Gamota\Games\Game;
use Gamota\News\Category;
use Gamota\Page\Page;
use Session;


class OptionController extends AdminController
{
    public function showHome()
    {
        $games = Game::where('status', 1)->get();

        $this->data['games'] = $games;

        $home = Option::where('key', 'custom_home')->first();
        $data = json_decode($home->value);
        $this->data['data'] = $data;

        // if (empty($home))
        //     abort(404);

        \Metatag::set('title', trans('Options::option.home'));

        return view('Options::admin.custom_home', $this->data);
    }

    public function updateHome(Request $rq, Option $option)
    {
        // $validator = Validator::make($rq->all(), [
        //     'menu_link' => 'required',
        //     'menu_name' => 'required',

        // ],[

        //     'menu_name.required' => 'Tên menu không được để trống',
        //     'menu_link.required' => 'Tên đường dẫn không được để trống',
        // ]);

        // if ($validator->fails()) {

        //     return response([
        //         'status' => 0,
        //         'msg' => $validator->errors(),
        //     ]);
        // }

        //
        $data = [
            'title_seo' => $rq->title_seo,
            'description_seo' => $rq->description_seo,
            'keyword_seo' => $rq->keyword_seo,
            'home_slide' => $rq->home_slide,
            'home_partner' => $rq->home_partner,
            'home_service' => $rq->home_service
        ];

       

        $home = Option::where('key', 'custom_home')->first();

        foreach($rq->home_slide['game_id'] as $key => $val)
        {
            $game = Game::find($val);
            $game->thumbnail_lg = $rq->home_slide['slide'][$key];
            $game->save();
        }

        $home->value = json_encode($data, true);


        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    trans('Options::option.update-home-success'),
        ];

        return response()->json($response, 200);
    }

    public function gamota()
    {
        $data = Option::where('key', 'custom_gamota')->first();
        $data = json_decode($data->value);
        $this->data['data'] = $data;

        //dd($data);
        // if (empty($data))
        //     abort(404);
        \Metatag::set('title', 'Thiết lập trang Gamota');

        return view('Options::admin.custom_gamota', $this->data);
    }

    public function updateGamota(Request $rq, Option $option)
    {

        $data = [
            'title_seo' => $rq->title_seo,
            'description_seo' => $rq->description_seo,
            'keyword_seo' => $rq->keyword_seo,
            'background' => $rq->background,
            'text_content' => $rq->text,
            'timeline' => $rq->timeline,
            'about' => $rq->about,
        ];

        $home = Option::where('key', 'custom_gamota')->first();

        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập trang gamota thành công!',
        ];

        return response()->json($response, 200);
    }

    public function games()
    {
       
        $listNew = Option::where('key', 'custom_games')->first();
       
        $data = json_decode($listNew->value);
        
        $this->data['data'] = $data;


        
        \Metatag::set('title', 'Thiết lập trang Games');
        
        return view('Options::admin.custom_game', $this->data);
    }

    public function updateGames(Request $rq, Option $option)
    {

        $data = [
            'title_seo' => $rq->title_seo,
            'description_seo' => $rq->description_seo,
            'keyword_seo' => $rq->keyword_seo,
            
        ];

        $home = Option::where('key', 'custom_game')->first();
        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập trang Games thành công.',
        ];

        return response()->json($response, 200);
    }

    public function service()
    {
        $data = Option::where('key', 'custom_service')->first();
        $data = json_decode($data->value);
        $this->data['data'] = $data;


        
        \Metatag::set('title', 'Thiết lập trang dịch vụ');

        return view('Options::admin.custom_service', $this->data);
    }

    public function updateService(Request $rq, Option $option)
    {
        
        $data = [
            'title_seo' => $rq->title_seo,
            'description_seo' => $rq->description_seo,
            'keyword_seo' => $rq->keyword_seo,
            'text_content' => $rq->text,
            'about' => $rq->about,
            'background' => $rq->background,

        ];

        $home = Option::where('key', 'custom_service')->first();
        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập trang dịch vụ thành công!',
        ];

        return response()->json($response, 200);
    }

    public function contact()
    {
        $listNew = Option::where('key', 'custom_contact')->first();
        
        $data = json_decode($listNew->value);
        $this->data['data'] = $data;


        if (empty($listNew))
            abort(404);
        \Metatag::set('title', 'Thiết lập trang Liên hệ');

        return view('Options::admin.custom_contact', $this->data);
    }

    public function updateContact(Request $rq, Option $option)
    {
        $data = [
            'title_seo' => $rq->title_seo,
            'description_seo' => $rq->description_seo,
            'keyword_seo' => $rq->keyword_seo,
            
        ];

        $home = Option::where('key', 'custom_contact')->first();
        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập trang Liên hệ thành công.',
        ];

        return response()->json($response, 200);
    }

    public function general()
    {
        $data = Option::where('key', 'custom_general')->first();
       
        $data = json_decode($data->value);
        $this->data['data'] = $data;
       
        \Metatag::set('title', 'Thiết lập chung');

        return view('Options::admin.custom_general', $this->data);
    }

    public function updateGeneral(Request $rq, Option $option)
    {
        $data = [
            'admin_email' => $rq->admin_email,
            'admin_email_title' => $rq->admin_email_title,
            
        ];

        $home = Option::where('key', 'custom_general')->first();
        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập thành công.',
        ];

        return response()->json($response, 200);
    }


    public function language()
    {
        $data = Option::where('key', 'custom_language')->first();
        
        $data = json_decode($data->value);
        
        $this->data['data'] = $data;

        // dd($this->data);
        \Metatag::set('title', 'Thiết lập ngôn ngữ');

        return view('Options::admin.custom_language', $this->data);
    }

    public function updateLanguage(Request $rq, Option $option)
    {
        $data = [
            'home' => $rq->home,
            'slide' => $rq->slide,
            'btn' => $rq->btn,
            'our_service' => $rq->our_service,
            'gamota' => $rq->gamota,
            'service' => $rq->service,
            'contact' => $rq->contact,
            'location' => $rq->location,
            'home' => $rq->home,
            'text' => $rq->text,
            'new' => $rq->new,
            
        ];


        $home = Option::where('key', 'custom_language')->first();
        $home->value = json_encode($data, true);
        $home->save();

        $response = [
            'title'        =>    trans('cms.success'),
            'message'    =>    'Thiết lập thành công.',
        ];

        return response()->json($response, 200);
    }

   
}