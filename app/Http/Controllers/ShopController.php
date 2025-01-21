<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(){

        $categories = Category::orderBy('name','ASC')->with('sub_categories')->where('status',1)->get();
        $brands = Brand::orderBy('name','ASC')->where('status',1)->get();
        $products = Product::orderBy('id','DESC')->where('status',1)->take(9)->get();
        return view('shop', compact('categories','products','brands'));
    }
}
