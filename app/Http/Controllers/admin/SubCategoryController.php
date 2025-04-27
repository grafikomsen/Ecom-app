<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function categories(Request $request){

        $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
                        ->latest('sub_categories.id')
                        ->leftJoin('categories','categories.id','sub_categories.category_id');
        if (!empty($request->get('keyword'))) {
            # code...
            $subCategories = $subCategories->where('sub_categories.name','like','%'. $request->get('keyword') .'%');
            $subCategories = $subCategories->orWhere('categories.name','like','%'. $request->get('keyword') .'%');
        }

        $subCategories = $subCategories->paginate(8);

        Session::put('page', 'subcategorie');
        return view('admin.sub_categories.list', compact('subCategories'));
    }

    public function create(){

        $categories = Category::orderBy('name','ASC')->get();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'slug'          => 'required|unique:sub_categories',
            'category'      => 'required',
            'status'        => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $subCategory = new SubCategory();
            $subCategory->name          = $request->name;
            $subCategory->slug          = $request->slug;
            $subCategory->category_id   = $request->category;
            $subCategory->showHome      = $request->showHome;
            $subCategory->status        = $request->status;
            $subCategory->save();

            //$oldImage = $category->image;

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $subCategory->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/sub-categories/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$newImageName->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $subCategory->image = $newImageName;
                $subCategory->save();

                // Delete Old Images Here
                //File::delete(public_path().'/uploads/categories/thump/'.$oldImage);
                //File::delete(public_path().'/uploads/categories/'.$oldImage);
            }

            Session()->flash('success','Sub category added successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Sub category added successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }

    }

    public function edit($subCategoryId, Request $request){

        $categories = Category::orderBy('name','ASC')->get();
        $subCategory = subCategory::find($subCategoryId);
        if (empty($subCategory)) {
            # code...
            Session()->flash('error','Record not found');
            return redirect()->route('admin.subcategorie');
        }
        return view('admin.sub_categories.edit', compact('subCategory','categories'));
    }

    public function updated($subCategoryId, Request $request){

        $subCategory = subCategory::find($subCategoryId);
        if (empty($subCategory)) {
            # code...
            Session()->flash('error','Record not found');
            return response()->json([
                'status'    => false,
                'notFound'  => true,
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'slug'          => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category'      => 'required',
            'status'        => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $subCategory->name          = $request->name;
            $subCategory->slug          = $request->slug;
            $subCategory->category_id   = $request->category;
            $subCategory->showHome      = $request->showHome;
            $subCategory->status        = $request->status;
            $subCategory->save();

            //$oldImage = $category->image;

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $subCategory->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/sub-categories/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$newImageName->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $subCategory->image = $newImageName;
                $subCategory->save();

                // Delete Old Images Here
                //File::delete(public_path().'/uploads/categories/thump/'.$oldImage);
                //File::delete(public_path().'/uploads/categories/'.$oldImage);
            }

            Session()->flash('success','Sub category updated successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Sub category updated successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($subCategoryId, Request $request){

        $subCategory = subCategory::find($subCategoryId);
        if (empty($subCategory)) {
            # code...
            Session()->flash('error','Sub category not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'Sub category not found'
            ]);
        }

        File::delete(public_path().'/uploads/categories/thump/'.$subCategory->id);
        File::delete(public_path().'/uploads/categories/'.$subCategory->id);

        $subCategory->delete();

        Session()->flash('success','Sub category delete successfully');
        return response()->json([
            'status'    => true,
            'message'   => 'Sub category deleted successfully'
        ]);
    }
}

