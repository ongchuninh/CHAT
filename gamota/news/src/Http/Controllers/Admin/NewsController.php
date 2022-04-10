<?php

namespace Gamota\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\News\News;
use Gamota\Games\Language;
use Gamota\News\NewsToLanguage;

class NewsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->languages = Language::all();
    }
    public function index()
    {
        $filter = News::getRequestFilter();
        $this->data['filter'] = $filter;//dd($filter);
        $this->data['newses'] = News::applyFilter($filter)->with('author')->paginate($this->paginate);
        
        \Metatag::set('title', trans('news.list-news'));
        return view('News::admin.list', $this->data);
    }

    public function create()
    {
        
        $news = new News();
        $this->data['news'] = $news;

        \Metatag::set('title', trans('news.add-new-news'));
        return view('News::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'news.title.vi'            =>    'required|max:255',
            'news.content.vi'            =>    'min:0',
            'news.category_id'        =>    'required|exists:news_categories,id',
            'news.status'            =>    'required|in:enable,disable',
        ]);

        $news = new News();
        $news->fill($request->input('news'));
        $news->author_id = \Auth::user()->id;
        $news->save();
        $news->categories()->sync((array) $request->input('news.category_id'));

        //
        foreach ($this->languages as $language) {

            $newToLanguage = new NewsToLanguage();

            $newToLanguage->new_id = $news->id;
            $newToLanguage->language_id = $language->id;
            $newToLanguage->title = $request->news['title'][$language->code];
            $newToLanguage->content = $request->news['content'][$language->code];

            $newToLanguage->save();
        }
        

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('news.create-news-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.news.edit', ['id' => $news->id]) :
                    route('admin.news.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.news.edit', ['id' => $news->id]);
        }

        return redirect()->route('admin.news.create');
    }
    
    public function edit(News $news)
    {
        $this->data['news_id'] = $news->id;
        $this->data['news']    = $news;

        \Metatag::set('title', trans('news.edit-news'));
        return view('News::admin.save', $this->data);
    }

    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'news.title.vi'            =>    'required|max:255',
            'news.content.vi'        =>    'min:0',
            'news.category_id'    =>    'required|exists:news_categories,id',
            'news.status'            =>    'required|in:enable,disable',
        ]);

        $news->fill($request->input('news'));

        $news->save();
        $news->categories()->sync((array) $request->input('news.category_id'));

        NewsToLanguage::where('new_id', $news->id)->delete();
        foreach ($this->languages as $language) {

            $newToLanguage = new NewsToLanguage();

            $newToLanguage->new_id = $news->id;
            $newToLanguage->language_id = $language->id;
            $newToLanguage->title = $request->news['title'][$language->code];
            $newToLanguage->content = $request->news['content'][$language->code];

            $newToLanguage->save();
        }

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('news.update-news-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.news.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.news.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, News $news)
    {
        $news->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.disable-news-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, News $news)
    {
        $news->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.enable-news-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, News $news)
    {
        $news->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.destroy-news-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function appplyStatusNews(Request $request,$status='enable')
    {   
        $arrId = $request->input('id');
        $title = trans('cms.success');
        $message = trans('news.destroy-news-success');
        $code = 200;
        if($status != 'destroy'){
            if($status=='enable'){
                $status=1;
                $message=trans('news.enable-news-success');
            }else{
                $status=0;
                $message=trans('news.disable-news-success');
            }
            $flag = News::whereIn('id',$arrId)->update(['status'=>$status]);
        }
        else{
            $flag = News::whereIn('id',$arrId)->delete();
        }
        if(!$flag){
            $code=422;
            $title=trans('cms.error');
            $message = trans('news.apply_err');
        }
        return response()->json([
            'title'     =>  $title,
            'message'   =>  $message,
            'success_id'=>  $arrId,
        ],$code);
    }
}