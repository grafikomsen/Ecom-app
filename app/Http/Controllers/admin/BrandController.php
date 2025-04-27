<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function brands(Request $request){

        $brands = Brand::latest();
        if (!empty($request->get('keyword'))) {
            # code...
            $brands = $brands->where('name','like','%'. $request->get('keyword') .'%');
        }

        $brands = $brands->paginate(8);
        Session::put('page', 'brand');
        return view('admin.brands.list', compact('brands'));
    }

    public function create(){

        return view('admin.brands.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'slug'  => 'required|unique:brands'
        ]);

        if ($validator->passes()) {
            # code...
            $brand = new Brand();
            $brand->name     = $request->name;
            $brand->slug     = $request->slug;
            $brand->status   = $request->status;
            $brand->save();

            //$oldImage = brand->image;

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $brand->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/brands/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/brands/thumb/'.$newImageName->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $brand->image = $newImageName;
                $brand->save();

                // Delete Old Images Here
                //File::delete(public_path().'/uploads/brands/thump/'.$oldImage);
                //File::delete(public_path().'/uploads/brands/'.$oldImage);
            }

            Session()->flash('success','Brand added successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Brand added successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }

    }

    public function edit($brandId, Request $request){

        $brand = Brand::find($brandId);
        if (empty($brand)) {
            # code...
            return redirect()->route('admin.brand');
        }
        return view('admin.brands.edit', compact('brand'));
    }

    public function updated($brandId, Request $request){

        $brand = Brand::find($brandId);
        if (empty($brand)) {
            # code...
            Session()->flash('error','Brand not fount');
            return response()->json([
                'status'   => false,
                'notFound' => true,
                'message'  => 'Brand not found'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'slug'  => 'required|unique:brands,slug,'.$brand->id.',id'
        ]);

        if ($validator->passes()) {
            # code...
            $brand->name     = $request->name;
            $brand->slug     = $request->slug;
            $brand->status   = $request->status;
            $brand->save();

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $brand->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/brands/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/brands/thumb/'.$tempImage->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $brand->image = $newImageName;
                $brand->save();
            }

            Session()->flash('success','Brand updated successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'Brand updated successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($brandId, Request $request){

        $brand = Brand::find($brandId);
        if (empty($brand)) {
            # code...
            Session()->flash('error','Brand not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'Brand not found'
            ]);
        }

        File::delete(public_path().'/uploads/brands/thump/'.$brand->id);
        File::delete(public_path().'/uploads/brands/'.$brand->id);

        $brand->delete();

        Session()->flash('success','Brand delete successfully');
        return response()->json([
            'status'    => true,
            'message'   => 'Brand deleted successfully'
        ]);
    }
}

