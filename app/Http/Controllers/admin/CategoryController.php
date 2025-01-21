<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories(Request $request){

        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            # code...
            $categories = $categories->where('name','like','%'. $request->get('keyword') .'%');
        }

        $categories = $categories->paginate(8);
        return view('admin.categories.list', compact('categories'));
    }

    public function create(){

        return view('admin.categories.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'slug'  => 'required|unique:categories'
        ]);

        if ($validator->passes()) {
            # code...
            $category = new Category();
            $category->name     = $request->name;
            $category->slug     = $request->slug;
            $category->showHome = $request->showHome;
            $category->status   = $request->status;
            $category->save();

            //$oldImage = $category->image;

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/categories/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$newImageName->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $category->image = $newImageName;
                $category->save();

                // Delete Old Images Here
                //File::delete(public_path().'/uploads/categories/thump/'.$oldImage);
                //File::delete(public_path().'/uploads/categories/'.$oldImage);
            }

            Session()->flash('success','Category added successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Category added successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function edit($categoryId, Request $request){

        $category = Category::find($categoryId);
        if (empty($category)) {
            # code...
            return redirect()->route('admin.categorie');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function updated($categoryId, Request $request){

        $category = Category::find($categoryId);
        if (empty($category)) {
            # code...
            Session()->flash('error','Category not fount');
            return response()->json([
                'status'   => false,
                'notFound' => true,
                'message'  => 'Category not found'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'slug'  => 'required|unique:categories,slug,'.$category->id.',id'
        ]);

        if ($validator->passes()) {
            # code...
            $category->name     = $request->name;
            $category->slug     = $request->slug;
            $category->showHome = $request->showHome;
            $category->status   = $request->status;
            $category->save();

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/categories/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$tempImage->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $category->image = $newImageName;
                $category->save();
            }

            Session()->flash('success','Category updated successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Category updated successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($categoryId, Request $request){

        $category = Category::find($categoryId);
        if (empty($category)) {
            # code...
            Session()->flash('error','Category not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'Category not found'
            ]);
        }

        File::delete(public_path().'/uploads/categories/thump/'.$category->id);
        File::delete(public_path().'/uploads/categories/'.$category->id);

        $category->delete();

        Session()->flash('success','Category delete successfully');
        return response()->json([
            'status'    => true,
            'message'   => 'Category deleted successfully'
        ]);
    }
}
