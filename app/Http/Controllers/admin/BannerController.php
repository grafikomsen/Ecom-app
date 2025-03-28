<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function banners(Request $request){

        $banners = Banner::orderBy('created_at','DESC');
        if (!empty($request->keyword)) {
            # code...
            $banners->where('name','like','%'.$request->keyword.'%');
        }

        $banners = $banners->paginate(5);
        return view('admin.banners.banners', compact('banners'));
    }

    public function create(){
        return view('admin.banners.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $banner = new Banner;
            $banner->name       = $request->name;
            $banner->content    = $request->content;
            $banner->url        = $request->url;
            $banner->status     = $request->status;
            $banner->save();

            //$oldImage = $category->image;

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $banner->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/banners/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/banners/thumb/'.$newImageName->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $banner->image = $newImageName;
                $banner->save();

                // Delete Old Images Here
                //File::delete(public_path().'/uploads/banners/thump/'.$oldImage);
                //File::delete(public_path().'/uploads/banners/'.$oldImage);
            }

        Session()->flash('success','Banner crée avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'Banner crée avec succéss',
        ]);

        } else {
            # code...
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($bannerId, Request $request){

        $banner = Banner::find($bannerId);
        if (empty($banner)) {
            # code...
            Session()->flash('error','Element non disponible');
            return response()->json([
                'status' => 0
            ]);
        }
        return view('admin.banners.edit', compact('banner'));
    }

    public function updated($bannerId, Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $banner = banner::find($bannerId);
            if (empty($banner)) {
                # code...
                Session()->flash('error','Element non disponible');
                return response()->json([
                    'status' => 0
                ]);
            }

            $oldImageName = $banner->image;

            $banner->name       = $request->name;
            $banner->content    = $request->content;
            $banner->url        = $request->url;
            $banner->status     = $request->status;
            $banner->save();

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $banner->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/banners/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$tempImage->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $banner->image = $newImageName;
                $banner->save();
            }

        Session()->flash('success','Banner modifié avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'Banner modifié avec succéss',
        ]);

        } else {
            # code...
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function destroy($bannerId){

        $banner = banner::find($bannerId);
        if (empty($banner)) {
            # code...
            Session()->flash('error','Element non disponible');
            return response()->json([
                'status' => 0
            ]);
        }

        $path = './uploads/banners/'.$banner->image;
        File::delete($path);

        Banner::where('id', $bannerId)->delete();
        Session()->flash('success','Banner supprimé avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'Banner supprimé avec succéss',
        ]);
    }
}
