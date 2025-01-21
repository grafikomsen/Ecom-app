<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImagesController extends Controller
{
    public function create(Request $request){

        $image = $request->image;
        if (!empty($image)) {
            # code...
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            // GENERATE THUMBNAIL
            //$sourcePath = public_path().'/temp/'.$newName;
            //$desPath = public_path().'/temp/thumb/'.$newName;
            //$image = Image::make($sourcePath);
            //$image->fit(300,275);
            //$image->save($desPath);

            return response()->json([
                'status'    => true,
                'image_id'  => $tempImage->id,
                'ImagePath' => asset('/temp/'.$newName),
                'message'   => 'Image uploaded successfully',
            ]);
        }
    }
}
