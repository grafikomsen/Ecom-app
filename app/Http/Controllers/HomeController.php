<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
}
