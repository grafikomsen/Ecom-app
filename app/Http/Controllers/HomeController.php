<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){

        $featuredProducts = Product::where('is_featured','Yes')->orderBy('id','DESC')->where('status',1)->take(8)->get();
        $latestProducts   = Product::orderBy('id','ASC')->where('status',1)->take(8)->get();
        $olderProducts    = Product::orderBy('id','DESC')->where('status',1)->take(8)->get();

        $feaProducts = Product::where('is_featured','Yes')->orderBy('id','DESC')->where('status',1)->take(3)->get();
        $latProducts = Product::orderBy('id','ASC')->where('status',1)->take(3)->get();
        $oldProducts = Product::orderBy('id','DESC')->where('status',1)->take(3)->get();

        return view('home', compact('featuredProducts','latestProducts','olderProducts','feaProducts','latProducts','oldProducts'));
    }

    public function addToWishList(Request $request){
        if (Auth::check() == false) {
            # code...
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false
            ]);
        }

        $product = Product::where('id', $request->id)->first();

        if ($product == null) {
            # code...
            return response()->json([
                'status' => true,
                'message' => '<div class="py-4 text-center text-danger">Product not found.</div>'
            ]);
        }

        Wishlist::updateOrCreate(
            [
                'user_id'       => Auth::user()->id,
                'product_id'    => $request->id
            ],
            [
                'user_id'       => Auth::user()->id,
                'product_id'    => $request->id
            ]
        );

        //$wishlist = new Wishlist;
        //$wishlist->user_id = Auth::user()->id;
        //$wishlist->product_id = $request->id;
        //$wishlist->save();

        return response()->json([
            'status' => true,
            'message' => '<div class="py-4 text-center">"'.$product->title.'" added in your wishlist</div>'
        ]);
    }
}
