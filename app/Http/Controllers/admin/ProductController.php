<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products(Request $request){

        $products = Product::latest('id')->with('product_images');

        if ($request->get('keyword') != "") {
            # code...
            $products = $products->where('title','like','%'.$request->keyword.'%');
        }

        $products = $products->paginate();
        return view('admin.products.list', compact('products'));
    }

    public function create(){

        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $subCategories = SubCategory::orderBy('name','ASC')->get();
        return view('admin.products.create', compact('categories','brands','subCategories'));
    }

    public function store(Request $request){

        $rules = [
            'title'         => 'required',
            'slug'          => 'required|unique:products',
            'price'         => 'required|numeric',
            'sku'           => 'required',
            'track_qty'     => 'required|in:Yes,No',
            'category'      => 'required|numeric',
            'is_featured'   => 'required',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            # code...
            $rules['qty'] = 'required|numeric';
        }

        $Validator = Validator::make($request->all(), $rules);

        if ($Validator->passes()) {
            # code...
            $product = new Product();
            $product->title             = $request->title;
            $product->slug              = $request->slug;
            $product->description       = $request->description;
            $product->short_description = $request->short_description;
            $product->shipping_returns  = $request->shipping_returns;
            $product->price             = $request->price;
            $product->compare_price     = $request->compare_price;
            $product->sku               = $request->sku;
            $product->barcode           = $request->barcode;
            $product->track_qty         = $request->track_qty;
            $product->qty               = $request->qty;
            $product->category_id       = $request->category;
            $product->sub_category_id   = $request->sub_category;
            $product->brand_id          = $request->brand;
            $product->status            = $request->status;
            $product->is_featured       = $request->is_featured;
            $product->related_products  = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
            $product->save();

            if (!empty($request->image_array)) {
                # code...
                foreach ($request->image_array as $temp_image_id) {
                    # code...
                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.',$tempImageInfo->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    // Large Image
                    $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
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
                }
            }

            Session()->flash('success','Product added successfully');

            return response()->json([
                'status'  => true,
                'message' => 'Product added successfully',
            ]);
        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors' => $Validator->errors(),
            ]);
        }
    }

    public function edit($productId, Request $request){

        $product = Product::find($productId);
        if (empty($product)) {
            # code...
            return redirect()->route('admin.product')->with('error','Product not found');
        }

        // Fetch Product Images
        $productImages = ProductImage::where('product_id',$product->id)->get();

        // Fetch related product
        $relatedProducts = [];
        if ($product->related_products) {
            # code...
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }

        $subCategories = SubCategory::where('category_id',$product->category_id)->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $subCategories = SubCategory::orderBy('name','ASC')->get();
        return view('admin.products.edit', compact('categories','brands','subCategories','product','subCategories','productImages','relatedProducts'));
    }

    public function updated($productId, Request $request){

        $product = Product::find($productId);

        $rules = [
            'title'         => 'required',
            'slug'          => 'required|unique:products,slug,'.$product->id.',id',
            'price'         => 'required|numeric',
            'sku'           => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty'     => 'required|in:Yes,No',
            'category'      => 'required|numeric',
            'is_featured'   => 'required',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            # code...
            $rules['qty'] = 'required|numeric';
        }

        $Validator = Validator::make($request->all(), $rules);

        if ($Validator->passes()) {
            # code...
            $product->title             = $request->title;
            $product->slug              = $request->slug;
            $product->description       = $request->description;
            $product->short_description = $request->short_description;
            $product->shipping_returns  = $request->shipping_returns;
            $product->price             = $request->price;
            $product->compare_price     = $request->compare_price;
            $product->sku               = $request->sku;
            $product->barcode           = $request->barcode;
            $product->track_qty         = $request->track_qty;
            $product->qty               = $request->qty;
            $product->category_id       = $request->category;
            $product->sub_category_id   = $request->sub_category;
            $product->brand_id          = $request->brand;
            $product->status            = $request->status;
            $product->is_featured       = $request->is_featured;
            $product->related_products  = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
            $product->save();

            Session()->flash('success','Product updated successfully');
            return response()->json([
                'status'  => true,
                'message' => 'Product updated successfully',
            ]);
        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors' => $Validator->errors(),
            ]);
        }
    }

    public function destroy($productId, Request $request){

        $product = Product::find($productId);
        if (empty($product)) {
            # code...
            Session()->flash('error','Product not found');
            return response()->json([
                'status'   => false,
                'notFound' => true,
            ]);
        }

        $productImages = ProductImage::where('product_id',$productId)->get();
        if (!empty($productImages)) {
            # code...
            foreach($productImages as $productImage){
                File::delete(public_path('uploads/product/'.$productImage));
            }
            $productImage::where('product_id',$productId);
        }

        $product->delete();
        Session()->flash('success','Product deleted successfully');
        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    public function getProducts(Request $request){

        $tempProduct = [];
        if ($request->term != "") {
            # code...
            $products = Product::where('title','like','%'.$request->term.'%')->get();

            if ($products != null) {
                # code...
                foreach ($products as $product) {
                    # code...
                    $tempProduct[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }

        return response()->json([
            'tags'   => $tempProduct,
            'status' => true
        ]);
    }
}
