<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\loginController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class, 'home'])->name('home');
Route::get('/shop/{categorySlug?}/{SubCategorySlug?}', [ShopController::class, 'shop'])->name('shop');
Route::get('/produit/{slug}',[ShopController::class, 'product'])->name('product');
Route::get('/panier',[CartController::class, 'cart'])->name('cart');
Route::post('/ajouter-au-panier',[CartController::class, 'addToCart'])->name('cart.addToCart');

Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('/login', [loginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [loginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

        // CATÉGORIE ROUTES
        Route::get('/categorie', [CategoryController::class, 'categories'])->name('admin.categorie');
        Route::get('/categorie/create', [CategoryController::class, 'create'])->name('admin.categorie.create');
        Route::post('/categorie', [CategoryController::class, 'store'])->name('admin.categorie.store');
        Route::get('/categorie/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categorie.edit');
        Route::put('/categorie/{category}', [CategoryController::class, 'updated'])->name('admin.categorie.updated');
        Route::delete('/categorie/{category}', [CategoryController::class, 'destroy'])->name('admin.categorie.destroy');

        // SUBCATÉGORIE ROUTES
        Route::get('/sub-categorie', [SubCategoryController::class, 'categories'])->name('admin.subcategorie');
        Route::get('/sub-categorie/create', [SubCategoryController::class, 'create'])->name('admin.subcategorie.create');
        Route::post('/sub-categorie', [SubCategoryController::class, 'store'])->name('admin.subcategorie.store');
        Route::get('/sub-categorie/{category}/edit', [SubCategoryController::class, 'edit'])->name('admin.subcategorie.edit');
        Route::put('/sub-categorie/{category}', [SubCategoryController::class, 'updated'])->name('admin.subcategorie.updated');
        Route::delete('/sub-categorie/{category}', [SubCategoryController::class, 'destroy'])->name('admin.subcategorie.destroy');

        // BRAND ROUTES
        Route::get('/brand', [BrandController::class, 'brands'])->name('admin.brand');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/brand', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/brand/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/brand/{brand}', [BrandController::class, 'updated'])->name('admin.brand.updated');
        Route::delete('/brand/{brand}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');

        // PRODUCT ROUTES
        Route::get('/product', [ProductController::class, 'products'])->name('admin.product');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{product}', [ProductController::class, 'updated'])->name('admin.product.updated');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('admin.productSubCategorie');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('product.getProducts');

        // IMAGES
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images/delete', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if (!empty($request->title)) {
                # code...
                $slug = Str::slug($request->title);
            }

            return response()->json([
                'status' => true,
                'slug'   => $slug,
            ]);
        })->name('getSlug');
    });
});
