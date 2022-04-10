<?php

namespace Gamota\Gallery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Gamota\Gallery\Category;
use AdminController;
use Validator;

class CategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter = Category::getRequestFilter();
        $this->data['categories']    = Category::applyFilter($filter)->paginate($this->paginate);
        $this->data['filter'] = $filter;

        \Metatag::set('title', trans('gallery.category.list-category'));
        return view('Gallery::admin.category.list', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->data['category'] = new Category();

        \Metatag::set('title', trans('gallery.category.add-new-category'));
        return view('Gallery::admin.category.save', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category.name'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300'
        ]);

        $category = new Category();
        
        $category->fill($request->input('category'))->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('gallery.category.create-category-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.gallery.category.edit', ['id' => $category->id]) :
                    route('admin.gallery.category.create'),
            ]);
        }
        
        if ($request->exists('save_only')) {
            return redirect(route('admin.gallery.category.edit', ['id' => $category->id]));
        }

        return redirect(route('admin.gallery.category.create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Category $category)
    {
        $this->data['category'] = $category;
        $this->data['category_id'] = $category->id;

        \Metatag::set('title', trans('gallery.category.edit-category'));
        return view('Gallery::admin.category.save', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'category.name'        => 'required|max:255',
            'category.slug'            => 'max:255',
            'category.description'    => 'max:300'
        ]);

        $category->fill($request->input('category'))->save();

        if ($request->ajax()) {
            $response = [
                'title'      =>    trans('cms.success'),
                'message'    =>    trans('gallery.category.update-category-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.gallery.category.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.gallery.category.index');
        }
                
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, Category $category)
    {
        if ($category->gallery()->count()) {
            if ($request->ajax()) {
                return response()->json([
                    'title'        =>    trans('cms.error'),
                    'message'    =>    trans('gallery.category.category-has-gallery'),
                ], 422);
            }
            
            return redirect()->back();
        }

        $category->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('gallery.category.destroy-category-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function appplyStatus(Request $request, $status = 'enable')
    {
        $arrId = $request->input('id');
        $title = trans('cms.success');
        $message = trans('gallery.category.destroy-category-success');
        $code = 200;
        if($status != 'destroy'){
            if($status == 'enable'){
                $status = 1;
                $message = trans('gallery.category.enable-category-success');
            }else{
                $status = 0;
                $message = trans('gallery.category.disable-category-success');
            }
            $flag = Category::whereIn('id',$arrId)->update(['status'=>$status]);
        }
        else{
            $flag = Category::whereIn('id',$arrId)->delete();
        }
        if( !$flag ){
            $code = 422;
            $title = trans('cms.error');
            $message = trans('gallery.category.apply_err');
        }
        return response()->json([
            'title'     =>  $title,
            'message'   =>  $message,
            'success_id'=>  $arrId,
        ],$code);
    }
}
