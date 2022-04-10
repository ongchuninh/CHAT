<?php

namespace Gamota\Appearance\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Appearance\Frontend;

class FrontendController extends AdminController
{
    public function index()
    {
        $filter = Frontend::getRequestFilter();
        $this->data['filter'] = $filter;//dd($filter);
        $this->data['frontend'] = Frontend::applyFilter($filter)->with('author')->paginate($this->paginate);

        \Metatag::set('title', trans('frontend.list-frontend'));
        return view('Appearance::admin.frontend.list', $this->data);
    }

    public function create()
    {
        $frontend = new Frontend();
        $this->data['frontend'] = $frontend;

        \Metatag::set('title', trans('frontend.add-new-frontend'));
        return view('Appearance::admin.frontend.save', $this->data);
    }

    public function store(Request $request)
    {
        $frontend = new Frontend();
        
        $this->validate($request, [
            'frontend.name'            =>    'required|max:255|unique:frontend,name,'.$frontend->id,
            'frontend.slug'        =>    'required|max:255|unique:frontend,slug,'.$frontend->id,
        ]);

        $frontend->fill($request->input('frontend'));
        $frontend->author_id = \Auth::user()->id;
        $frontend->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('frontend.create-frontend-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.appearance.frontend.edit', ['id' => $frontend->id]) :
                    route('admin.appearance.frontend.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.appearance.frontend.edit', ['id' => $frontend->id]);
        }

        return redirect()->route('admin.appearance.frontend.create');
    }

    public function edit(Frontend $frontend)
    {
        $this->data['frontend_id'] = $frontend->id;
        $this->data['frontend']    = $frontend;

        \Metatag::set('title', trans('frontend.edit-frontend'));
        return view('Appearance::admin.frontend.save', $this->data);
    }
    public function update(Request $request, Frontend $frontend)
    {
        $this->validate($request, [
            'frontend.name'            =>    'required|max:255|unique:frontend,name,'.$frontend->id,
            'frontend.slug'        =>    'required|max:255|unique:frontend,slug,'.$frontend->id,
        ]);

        $frontend->fill($request->input('frontend'));

        $frontend->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('frontend.update-frontend-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.appearance.frontend.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.appearance.frontend.index');
        }
                
        return redirect()->back();
    }
    public function destroy(Request $request, Frontend $frontend)
    {
        $frontend->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('frontend.destroy-frontend-success'),
            ], 200);
        }

        return redirect()->back();
    }
    public function applyStatus(Request $request, $status = 'enable')
    {
        $arrId = $request->input('id');
        $title = trans('cms.success');
        $message = trans('frontend.destroy-frontend-success');
        $code = 200;
        if($status != 'destroy'){
            if($status == 'enable'){
                $status = 1;
                $message = trans('frontend.enable-frontend-success');
            }else{
                $status = 0;
                $message = trans('frontend.disable-frontend-success');
            }
            $flag = Frontend::whereIn('id',$arrId)->update(['status'=>$status]);
        }
        else{
            $flag = Frontend::whereIn('id',$arrId)->delete();
        }
        if( !$flag ){
            $code = 422;
            $title = trans('cms.error');
            $message = trans('frontend.apply-err');
        }
        return response()->json([
            'title'     =>  $title,
            'message'   =>  $message,
            'success_id'=>  $arrId,
        ],$code);
    }
}
