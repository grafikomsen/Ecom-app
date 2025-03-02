<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request, $categorieSlug = null, $subCategorieSlug = null){

        $categorieSelected = '';
        $subCategorieSelected = '';
        $brandsArray = [];

        $categories = Category::orderBy('name','ASC')->with('sub_categories')->where('status',1)->get();
        $brands = Brand::orderBy('name','ASC')->where('status',1)->get();

        $products = Product::where('status',1);

        // Appliquer les filters ici

        if (!empty($categorieSlug)) {
            # code...
            $categorie = Category::where('slug', $categorieSlug)->first();
            $products = $products->where('category_id', $categorie->id);
            $categorieSelected = $categorie->id;
        }

        if (!empty($subCategorieSlug)) {
            # code...
            $subCategorie = SubCategory::where('slug', $subCategorieSlug)->first();
            $products = $products->where('sub_category_id', $subCategorie->id);
            $subCategorieSelected = $subCategorie->id;
        }

        if (!empty($request->get('brand'))) {
            # code...
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id',$brandsArray);
        }

        $products = $products->orderBy('id','DESC');
        $products = $products->get()->take(9);

        return view('shop', compact('categories','products','brands','categorieSelected','subCategorieSelected','brandsArray'));
    }
}
