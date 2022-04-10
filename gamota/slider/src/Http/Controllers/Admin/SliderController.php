<?php

namespace Gamota\Slider\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Slider\Slider;

class SliderController extends AdminController
{
    public function index()
    {
        $filter = Slider::getRequestFilter();
        $this->data['filter'] = $filter;//dd($filter);
        $this->data['slider'] = Slider::applyFilter($filter)->with('author')->paginate($this->paginate);
        \Metatag::set('title', trans('slider.list-slider'));
        return view('Slider::admin.list', $this->data);
    }

    public function create()
    {
        $slider = new Slider();
        $this->data['slider'] = $slider;

        \Metatag::set('title', trans('slider.add-new-slider'));
        return view('Slider::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'slider.title'            =>    'required|max:200',
            'slider.link'             =>    'required|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/|regex:/^(https?:\/\/)/m',
            'slider.target'           =>    'required',
            'slider.status'           =>    'required|in:enable,disable',
        ]);

        $slider = new Slider();
        $slider->fill($request->input('slider'));
        $slider->author_id = \Auth::user()->id;
        $slider->save();

        if ($request->ajax()) {
            return response()->json([
                'title'         =>    trans('cms.success'),
                'message'       =>    trans('slider.create-slider-success'),
                'redirect'      =>    $request->exists('save_only') ?
                    route('admin.slider.edit', ['id' => $slider->id]) :
                    route('admin.slider.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.slider.edit', ['id' => $slider->id]);
        }

        return redirect()->route('admin.slider.create');
    }
    
    public function edit(Slider $slider)
    {
        $this->data['slider_id'] = $slider->id;
        $this->data['slider']    = $slider;

        \Metatag::set('title', trans('slider.edit-slider'));
        return view('Slider::admin.save', $this->data);
    }

    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'slider.title'            =>    'required|max:200',
            'slider.link'             =>    'required|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/|regex:/^(https?:\/\/)/m    ',
            'slider.target'           =>    'required',
            'slider.status'           =>    'required|in:enable,disable',
        ]);

        $slider->fill($request->input('slider'));

        $slider->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('slider.update-slider-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.slider.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.slider.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Slider $slider)
    {
        $slider->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('slider.disable-slider-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Slider $slider)
    {
        $slider->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('slider.enable-slider-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Slider $slider)
    {
        $slider->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('slider.destroy-slider-success'),
            ], 200);
        }

        return redirect()->back();
    }
}
