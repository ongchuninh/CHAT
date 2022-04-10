<?php

namespace Gamota\Promise\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Promise\Promise;

class PromiseController extends AdminController
{
    public function index()
    {
        $filter = Promise::getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['promise'] = Promise::applyFilter($filter)->paginate($this->paginate);

        \Metatag::set('title', trans('promise.list-promise'));
        return view('Promise::admin.list', $this->data);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'slider.title'            =>    'required|max:255',
            'slider.url'              =>      'required|max:255',
            'slider.target'            =>    'required',
            'slider.status'            =>    'required|in:enable,disable',
        ]);

        $slider = new Slider();
        $slider->fill($request->input('slider'));
        $slider->author_id = \Auth::user()->id;
        $slider->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('slider.create-slider-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.slider.edit', ['id' => $slider->id]) :
                    route('admin.slider.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.slider.edit', ['id' => $slider->id]);
        }

        return redirect()->route('admin.slider.create');
    }
    
}
