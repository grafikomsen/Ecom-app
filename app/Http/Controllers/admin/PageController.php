<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function pages(Request $request){

        $pages = Page::latest();
        if (!empty($request->get('keyword'))) {
            # code...
            $pages = $pages->where('name','like','%'. $request->get('keyword') .'%');
        }

        $pages = $pages->paginate(8);
        Session::put('page', 'pages');
        return view('admin.pages.list', compact('pages'));
    }

    public function create(){

        return view('admin.pages.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'     => 'required',
            'slug'     => 'required|unique:pages',
        ]);

        if ($validator->passes()) {
            # code...
            $page = new Page();
            $page->name    = $request->name;
            $page->slug    = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'Page added successfully';
            Session()->flash('success',$message);
            return response()->json([
                'status'    => true,
                'message'   => $message,
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function edit($pageId, Request $request){

        $page = Page::find($pageId);
        return view('admin.pages.edit', compact('page'));
    }

    public function updated($pageId, Request $request){

        $page = Page::find($pageId);
        if (empty($page)) {
            # code...
            Session()->flash('error','Pgae not fount');
            return response()->json([
                'status'   => false,
                'notFound' => true,
                'message'  => 'Pgae not found'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'slug'  => 'required|unique:pages,slug,'.$page->id.',id'
        ]);

        if ($validator->passes()) {
            # code...
            $page->name    = $request->name;
            $page->slug    = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'Page updated successfully';
            Session()->flash('success',$message);
            return response()->json([
                'status'    => true,
                'message'   => $message,
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($pageId){

        $page = Page::find($pageId);
        if (empty($page)) {
            # code...
            Session()->flash('error','Page not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'Page not found'
            ]);
        }

        $page->delete();
        $message = 'Page delete successfully';
        Session()->flash('success', $message);
        return response()->json([
            'status'    => true,
            'message'   => $message
        ]);
    }
}
