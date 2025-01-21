<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    public function update(Request $request){

        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$extension;
        $productImage->image = $imageName;
        $productImage->save();

        // Large Image
        $destPath = public_path().'/uploads/product/'.$imageName;
        //$image = Image::make($sourcePath);
        //$image->resize(1400, null, function ($constraint){
            //$constraint->aspectRadio();
        //});
        //$image->save($destPath);
        File::copy($sourcePath,$destPath);

        // Large Image
        //$destPath = public_path().'/uploads/product/small/'.$tempImageInfo->name;
        //$image = Image::make($sourcePath);
        //$image->fit(300,300);
        //$image->save($destPath);

        return response()->json([
            'status'    => true,
            'image_id'  => $productImage->id,
            'ImagePath' => asset('uploads/product/'.$productImage->image),
            'message'   => 'Image saved successfully'
        ]);
    }

    public function destroy(Request $request) {

        $productImage = ProductImage::find($request->id);
        if (empty($productImage)) {
            # code...
            return response()->json([
                'status'  => false,
                'message' => 'Image not found'
            ]);
        }

        // Delete
        File::delete(public_path('uploads/product/'.$productImage->image));
        $productImage->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Image delete successfully'
        ]);
    }
}
