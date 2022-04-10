<?php

namespace Gamota\Links\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Gamota\Links\Links;

class LinksController extends AdminController
{
    public function index()
    {
        $filter = Links::getRequestFilter();
        $this->data['filter'] = $filter;//dd($filter);
        $this->data['links'] = Links::applyFilter($filter)->with('author')->paginate($this->paginate);

        \Metatag::set('title', trans('links.list-links'));
        return view('Links::admin.list', $this->data);
    }

    public function create()
    {
        $links = new Links();
        $this->data['links'] = $links;

        \Metatag::set('title', trans('links.add-new-links'));
        return view('Links::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'links.title'            =>    'required|max:255',
            'links.slug'            =>    'required|max:255',
            'links.url'              =>      'required|max:255',
            'links.target'            =>    'required',
            'links.status'            =>    'required|in:enable,disable',
        ]);

        $links = new Links();
        $links->fill($request->input('links'));
        $links->author_id = \Auth::user()->id;
        $links->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('links.create-links-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.links.edit', ['id' => $links->id]) :
                    route('admin.links.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.links.edit', ['id' => $links->id]);
        }

        return redirect()->route('admin.links.create');
    }
    
    public function edit(Links $links)
    {
        $this->data['links_id'] = $links->id;
        $this->data['links']    = $links;

        \Metatag::set('title', trans('links.edit-links'));
        return view('Links::admin.save', $this->data);
    }

    public function update(Request $request, Links $links)
    {
        $this->validate($request, [
            'links.title'            =>    'required|max:255',
            'links.slug'            =>    'required|max:255',
            'links.url'              =>      'required|max:255',
            'links.target'            =>    'required',
            'links.status'            =>    'required|in:enable,disable',
        ]);

        $links->fill($request->input('links'));

        $links->save();

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('links.update-links-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.links.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.links.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, Links $links)
    {
        $links->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('links.disable-links-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, Links $links)
    {
        $links->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('links.enable-links-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Links $links)
    {
        $links->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('links.destroy-links-success'),
            ], 200);
        }

        return redirect()->back();
    }
}
