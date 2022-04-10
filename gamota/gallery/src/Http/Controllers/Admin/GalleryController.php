<?php

namespace Gamota\Gallery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Gallery\Gallery;

class GalleryController extends AdminController
{
    public function index()
    {
        $filter = Gallery::getRequestFilter();
        $gallery = Gallery::select('gallery.*')
            ->applyFilter($filter)->paginate($this->paginate);
        
        $this->data['gallery']  = $gallery;
        $this->data['filter']   = $filter;

        \Metatag::set('title', trans('gallery.list-gallery'));
        return view('Gallery::admin.list', $this->data);
    }

    public function create()
    {
        $gallery = new Gallery();
        $this->data['gallery'] = $gallery;

        \Metatag::set('title', trans('gallery.add-new-gallery'));
        return view('Gallery::admin.save', $this->data);
    }

    public function test(){
        dd( __DIR__ ); //Test by Tan
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gallery.title'            =>    'required|max:255|unique:gallery',
            'gallery.category_id'        =>    'required|exists:gallery_categories,id',
            'gallery.status'            =>    'required|in:enable,disable',
        ]);

        $gallery = new Gallery();
        $gallery->fill($request->input('gallery'));
        $gallery->author_id = \Auth::user()->id;
        $gallery->save();
        $gallery->categories()->sync((array) $request->input('gallery.category_id'));

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('gallery.create-gallery-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.gallery.edit', ['id' => $gallery->id]) :
                    route('admin.gallery.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.gallery.edit', ['id' => $gallery->id]);
        }

        return redirect()->route('admin.gallery.create');
    }

    public function edit(Gallery $gallery)
    {
        $this->data['gallery_id'] = $gallery->id;
        $this->data['gallery']    = $gallery;

        \Metatag::set('title', trans('gallery.edit-gallery'));
        return view('Gallery::admin.save', $this->data);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->validate($request, [
            'gallery.title'            =>    'required|max:255',
            'gallery.category_id'    =>    'required|exists:gallery_categories,id',
            'gallery.status'            =>    'required|in:enable,disable',
        ]);

        $gallery->fill($request->input('gallery'));

        $gallery->save();
        $gallery->categories()->sync((array) $request->input('gallery.category_id'));

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('gallery.update-gallery-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.gallery.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.gallery.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Gallery $gallery)
    {
        $gallery->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('gallery.disable-gallery-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Gallery $gallery)
    {
        $gallery->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('gallery.enable-gallery-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Gallery $gallery)
    {
        $gallery->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('gallery.destroy-gallery-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function applyStatus(Request $request, $status = 'enable')
    {
        $arrId = $request->input('id');
        $title = trans('cms.success');
        $message = trans('gallery.destroy-gallery-success');
        $code = 200;
        if($status != 'destroy'){
            if($status == 'enable'){
                $status = 1;
                $message = trans('gallery.enable-gallery-success');
            }else{
                $status = 0;
                $message = trans('gallery.disable-gallery-success');
            }
            $flag = Gallery::whereIn('id',$arrId)->update(['status'=>$status]);
        }
        else{
            $flag = Gallery::whereIn('id',$arrId)->delete();
        }
        if( !$flag ){
            $code = 422;
            $title = trans('cms.error');
            $message = trans('gallery.apply-err');
        }
        return response()->json([
            'title'     =>  $title,
            'message'   =>  $message,
            'success_id'=>  $arrId,
        ],$code);
    }
}
