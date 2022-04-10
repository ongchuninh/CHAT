<?php

namespace Gamota\Gallery\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gamota\Gallery\Gallery;
use Gamota\Gallery\Category;
use Gamota\Gallery\GalleryToCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function showGallery($isMobi=false)
    {
        if($isMobi){
            $hinhgame = self::getListGalleryBySlug('ingame',4);
            $clipgame = self::getListGalleryBySlug('video-clip',4);
            $hinhvui = self::getListGalleryBySlug('hinh-vui',4);
            $view = 'Gallery::frontend.showGallery_m';
        }else{
            $hinhgame = self::getListGalleryBySlug('ingame');
            $clipgame = self::getListGalleryBySlug('video-clip');
            $hinhvui = self::getListGalleryBySlug('hinh-vui');
            $view = 'Gallery::frontend.showGallery_pc';
        }
        return view($view,['hinhgame'=>$hinhgame,'clipgame'=>$clipgame,'hinhvui'=>$hinhvui]);
    }
    public function getListGalleryBySlug($slug='', $limit = 8)
    {
        $gallery = Gallery::where('status', 1)
        ->whereIn('id',function($que) use ($slug){
            $que->select('gallery_id')
            ->from((new GalleryToCategory)->getTable())
            ->where('category_id',function($q) use ($slug)
            {
                $q->select('id')
                ->from((new Category)->getTable())
                ->where('slug',$slug);
            });
        })
        ->where('created_at','<=', date('Y-m-d H:i:s'))
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->limit($limit)
        ->get();
        return $gallery;
    }
}