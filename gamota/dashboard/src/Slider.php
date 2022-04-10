<?php

namespace Phambinh\Cms;

use Illuminate\Database\Eloquent\Model;
use Phambinh\Cms\Support\Traits\Filter;
use DB;
use Illuminate\Database\Query\Builder;

class Slider extends Model
{
    protected $table = 'sliders';
    
    protected $primaryKey = 'id';

    public static function get_all(){
    	// $slider['data'] = DB::table('sliders')->get();
    	$slider = DB::table('sliders')->paginate(20);
    	return $slider;
    }

    public static function create()
    {
    	$post = new Slider();
        $post->title = $title;
        $post->content = $content;
        $post ->save();
    }
}
