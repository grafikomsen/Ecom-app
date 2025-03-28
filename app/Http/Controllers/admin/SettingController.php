<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function settings(Request $request){

        $settings = Setting::orderBy('created_at','DESC');
        if (!empty($request->keyword)) {
            # code...
            $settings->where('name','like','%'.$request->keyword.'%');
        }

        $settings = $settings->paginate(5);
        return view('admin.settings.settings', compact('settings'));
    }

    public function create(){
        return view('admin.settings.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'question' => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $setting = new Setting();
            $setting->question  = $request->question;
            $setting->answer    = $request->answer;
            $setting->status    = $request->status;
            $setting->save();

        Session()->flash('success','setting crée avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'setting crée avec succéss',
        ]);

        } else {
            # code...
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function edit($settingId, Request $request){

        $setting = Setting::find($settingId);
        if (empty($setting)) {
            # code...
            Session()->flash('error','Element non disponible');
            return response()->json([
                'status' => 0
            ]);
        }

        return view('admin.settings.edit', compact('setting'));
    }

    public function updated($settingId, Request $request){

        $validator = Validator::make($request->all(),[
            'website_title' => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $setting = Setting::find($settingId);
            if (empty($setting)) {
                # code...
                Session()->flash('error','Element non disponible');
                return response()->json([
                    'status' => 0
                ]);
            }

            //$oldImageName = $setting->image;

            $setting->website_title = $request->website_title;
            $setting->description   = $request->description;
            $setting->keyword       = $request->keyword;
            $setting->og_locale     = $request->og_locale;
            $setting->og_type       = $request->og_type;
            $setting->og_type       = $request->og_type;
            $setting->twitter_card  = $request->twitter_card;
            $setting->email         = $request->email;
            $setting->address       = $request->address;
            $setting->phone         = $request->phone;
            $setting->article_modified_time     = $request->article_modified_time;
            $setting->url_canonique             = $request->url_canonique;
            $setting->url_googleSearchConsole   = $request->url_googleSearchConsole;
            $setting->url_googleMaps            = $request->url_googleMaps;
            $setting->url_googleMaps            = $request->url_googleMaps;
            $setting->url_facebook              = $request->url_facebook;
            $setting->url_twintter  = $request->url_twintter;
            $setting->url_instagram = $request->url_instagram;
            $setting->url_tictok    = $request->url_tictok;
            $setting->copyright     = $request->copyright;
            $setting->sitemap       = $request->sitemap;
            $setting->status        = $request->status;
            $setting->save();

            // Sauvegardez une image
            if (!empty($request->image_id)) {
                # code...
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $setting->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/settings/'.$newImageName;
                File::copy($sPath,$dPath);

                // Generate Image Thumbnail
                //$dPath = public_path().'/uploads/categories/thumb/'.$tempImage->name;
                //$img = Image::make($sPath);
                //$img->resize(450,600);
                //$img->save($sPath);

                $setting->image = $newImageName;
                $setting->save();
            }

        Session()->flash('success','setting modifié avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'setting modifié avec succéss',
        ]);

        } else {
            # code...
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function destroy($settingId){

        $setting = Setting::find($settingId);
        if (empty($setting)) {
            # code...
            Session()->flash('error','Element non disponible');
            return response()->json([
                'status' => 0
            ]);
        }

        Setting::where('id', $settingId)->delete();
        Session()->flash('success','setting supprimé avec succéss');
        return response()->json([
            'status' => 200,
            'message' => 'setting supprimé avec succéss',
        ]);
    }
}
