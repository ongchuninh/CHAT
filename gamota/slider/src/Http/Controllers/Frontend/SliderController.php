<?php

namespace Gamota\Slider\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gamota\Slider\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function showSlider($isMobi=false)
    {
        $slider=Slider::where('status',1)->get();
        $view = 'Slider::frontend.slider.showSlider_pc';
        if($isMobi){
            $view = 'Slider::frontend.slider.showSlider_m';
        }
        return view($view,['slider'=>$slider]);
    }

    public function showSlider_sidebox(){
        $slider=Slider::where('status',1)->get();
        return view('Slider::frontend.slider.showSlider_sidebox',['slider'=>$slider]);
    }
}