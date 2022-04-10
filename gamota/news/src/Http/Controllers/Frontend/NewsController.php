<?php

namespace Gamota\News\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gamota\News\News;
use Gamota\News\NewsToCategory;
use Gamota\News\News_categories;
use Helper;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function showContent($isMobi=false)
    {
        $tintuc = self::getListContentBySlug('tin-tuc', 6);
        $sukien = self::getListContentBySlug('su-kien', 6);
        $camnang = self::getListContentBySlug('cam-nang', 6);
        $view = 'News::frontend.news.showContent_pc';
        if($isMobi){
            $view = 'News::frontend.news.showContent_m';
        }
        return view($view,['tintuc'=>$tintuc,'sukien'=>$sukien,'camnang'=>$camnang]);
    }

    public function showKCL($isMobi=false)
    {
        $hoatdong = self::getListContentBySlug('hoat-dong', 6);
        $nhanvat = self::getListContentBySlug('nhan-vat', 6);
        $nhiemvu = self::getListContentBySlug('nhiem-vu', 6);
        $view = 'News::frontend.news.showKCL_pc';
        if($isMobi){
            $view = 'News::frontend.news.showKCL_m';
        }
        return view($view,['hoatdong'=>$hoatdong,'nhanvat'=>$nhanvat,'nhiemvu'=>$nhiemvu]);
    }

    public function getNewsByParenId($category_id,$id_news_current=0,$limit=false)
    {
        $arrContent = News::where('status', 1)
        ->whereIn('id',function($que) use ($category_id){
            $que->select('news_id')
            ->from((new NewsToCategory)->getTable())
            ->where('category_id',$category_id);
        })
        ->where('id','!=',$id_news_current)
        ->where('created_at','<=', date('Y-m-d H:i:s'))
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc');
        if($limit){
            $arrContent->limit($limit);
        }
        return $arrContent->get();
    }
    
    public function getListContentBySlug($slug='', $limit = 6, $start = 0,$paginate=false,$total=2)
    {
        $arrContent = News::where('status', 1)
        ->whereIn('id',function($que) use ($slug){
            $que->select('news_id')
            ->from((new NewsToCategory)->getTable())
            ->where('category_id',function($q) use ($slug)
            {
                $q->select('id')
                ->from((new News_categories)->getTable())
                ->where('slug',$slug);
            });
        })
        ->where('created_at','<=', date('Y-m-d H:i:s'))
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc');
        if($paginate){
            return $arrContent->paginate($total);
        }
        return $arrContent->offset($start)->limit($limit)->get();
    }

    public function detail($id,$isMobi=false){
        $content = News::where('id', $id)->where('created_at','<=', date('Y-m-d H:i:s'))->first();
 
        if(!$content || $content->status == 0){
            if(request()->ajax()){
                return "404";
            }
            return redirect()->route('home');
        }

        $data['category'] = News_categories::where('id',function($q) use ($id)
        {
            $q->select('category_id')
            ->from((new NewsToCategory)->getTable())
            ->where((new NewsToCategory)->getTable().".news_id",$id)->first();
        })->get()->first();
       
        if( !$data['category'] ){
            if(request()->ajax()){
                return "404";
            }
            return redirect()->route('home');
        }

        $data['result'] = $content;
        $title = $content->title;
        $meta_keywords = $content->meta_keyword ? $content->meta_keyword : Helper::getSetting('meta_keyword') ;
        $meta_description = $content->meta_description ? $content->meta_description :  Helper::getSetting('meta_description') ;
        $meta_image = Helper::getImageDetail( $content->thumbnail, $data['category']->id );

        $data['relate_content'] = self::getRelatedContent( $data['category']->id,$id );
        $res=[
            'result'=>$data['result'],
            'title'=>$title,
            'relate_content'=>$data['relate_content'],
            'meta_keywords'=>$meta_keywords,
            'meta_description'=>$meta_description,
            'meta_image'=>$meta_image,
            'parent'=>  $data['category']->name,
            'parent_cat'=>$data['category']->slug
        ];
        $view = 'site.detail_pc';
        $viewAjax = 'site.detail_change';
        if($isMobi){
            $view = 'site.detail_m';
            $viewAjax = 'site.detail_change_m';
        }
        if(request()->ajax()){
            return view($viewAjax,$res)->render(); 
        }

        return view($view,$res);
    }
    public function getRelatedContent($category_id,$id_news_current){
        $arrRelated = self::getNewsByParenId($category_id,$id_news_current,6);
        return $arrRelated;
    }
    public function listdetail($url,$isMobi=false){
        $category = News_categories::where('slug',$url)->first();
        if(!$category){
            if(request()->ajax()){
                return "404";
            }
            return redirect()->route('home');
        }
        $title = $category->name;
        $listContent = self::getListContentBySlug($url,0,0,true);
        $meta_keywords = $category->meta_keyword ? $category->meta_keyword : Helper::getSetting('meta_keyword') ;
        $meta_description = $category->meta_description ? $category->meta_description :  Helper::getSetting('meta_description') ;
        $meta_image = Helper::getImageDetail( $category->thumbnail, $category->id );
        $res=[
            'listDetail'=>$listContent,
            'title'=>$title,
            'category_id'=>$category->id,
            'parent'=> $title,
            'parent_cat'=>$category->slug,
            'meta_keywords'=>$meta_keywords,
            'meta_description'=>$meta_description,
            'meta_image'=>$meta_image,
        ];
        $view = 'site.listDetail_pc';
        $viewAjax = 'site.list_detail_change';
        if($isMobi){
            $view = 'site.listDetail_m';
            $viewAjax = 'site.list_detail_change_m';
        }
        if(request()->ajax()){
            return view($viewAjax,$res)->render(); 
        }

        return view($view,$res);

    }
    
    
}