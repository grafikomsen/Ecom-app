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

        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            # code...
            if ($request->get('price_max') == 999999) {
                # code...
                $products = $products->whereBetween('price',[intval($request->get('price_min')),999999]);
            } else {
                # code...
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }
        }

        if (!empty($request->get('brand'))) {
            # code...
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id',$brandsArray);
        }

        if ($request->get('sort') != '') {
            # code...
            if ($request->get('sort') == 'latest') {
                # code...
                $products = $products->orderBy('price','DESC');
            } else if ($request->get('sort') == 'price_asc') {
                # code...
                $products = $products->orderBy('price','ASC');
            } else {
                # code...
                $products = $products->orderBy('price','DESC');
            }
        } else {
            # code...
            $products = $products->orderBy('id','DESC');
        }

        $products = $products->paginate(9);
        $priceMax = (intval($request->get('price_max')) == 0) ? 1000000 : $request->get('price_max');
        $priceMin = intval($request->get('price_min'));
        $sort = $request->get('sort');

        return view('shop', compact('categories','products','brands','categorieSelected','subCategorieSelected','brandsArray','priceMin', 'priceMax','sort'));
    }

    public function product($slug){
        $product = Product::where('slug',$slug)->with('product_images')->first();
        if ($product == null) {
            # code...
            abort('404');
        }

        // Fetch related product
        $relatedProducts = [];
        if ($product->related_products) {
            # code...
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }

        return view('product',compact('product','relatedProducts'));
    }
}
