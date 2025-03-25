<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\loginController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
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

//
Route::get('/',[HomeController::class, 'home'])->name('home');
Route::get('/shop/{categorySlug?}/{SubCategorySlug?}', [ShopController::class, 'shop'])->name('shop');
Route::get('/produit/{slug}',[ShopController::class, 'product'])->name('product');
Route::get('/panier',[CartController::class, 'cart'])->name('cart');
Route::post('/ajouter-au-panier',[CartController::class, 'addToCart'])->name('cart.addToCart');
Route::post('/mis-a-jour-panier',[CartController::class, 'updateCart'])->name('cart.updateCart');
Route::post('/supprimer-le-panier',[CartController::class, 'deleteItem'])->name('cart.deleteItem');
Route::get('/commandez',[CartController::class, 'checkout'])->name('checkout');
Route::post('/commandez', [CartController::class, 'processCheckout'])->name('processCheckout');
Route::get('/merci-de-commandez/{orderId}', [CartController::class, 'thankyou'])->name('thankyou');
Route::post('/get-order-summery', [CartController::class, 'getOrderSummery'])->name('getOrderSummery');
Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('applyDiscount');
Route::post('/remove-discount', [CartController::class, 'removeCoupon'])->name('removeCoupon');
Route::post('/add-to-wishlist', [HomeController::class, 'addToWishList'])->name('addToWishList');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');

//
Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');

        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/porcess-register', [AuthController::class, 'processRegister'])->name('account.processRegister');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/mon-profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile', [AuthController::class, 'updateProfile'])->name('account.UpdateProfile');
        Route::put('/update-address', [AuthController::class, 'updateAddress'])->name('account.updateAddress');
        Route::get('/mes-commandes', [AuthController::class, 'orders'])->name('account.orders');
        Route::get('/mes-commandes/{orderId}', [AuthController::class, 'ordersId'])->name('account.ordersId');
        Route::get('/mes-souhaits', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::post('/remove-product-from-wishlist', [AuthController::class, 'removeProductFromWishlist'])->name('account.removeProductFromWishlist');
        Route::get('/show-change-password', [AuthController::class, 'showChangePassword'])->name('account.showChangePassword');
        Route::post('/process-change-password', [AuthController::class, 'changePassword'])->name('account.changePassword');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});

//
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

        // SHIPPING ROUTES
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('admin.shipping.create');
        Route::post('/shipping', [ShippingController::class, 'store'])->name('admin.shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('admin.shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class, 'updated'])->name('admin.shipping.updated');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('admin.shipping.delete');

        // DISCOUNT ROUTES
        Route::get('/discount', [DiscountCodeController::class, 'discounts'])->name('admin.discount');
        Route::get('/discount/create', [DiscountCodeController::class, 'create'])->name('admin.discount.create');
        Route::post('/discount', [DiscountCodeController::class, 'store'])->name('admin.discount.store');
        Route::get('/discount/{discount}/edit', [DiscountCodeController::class, 'edit'])->name('admin.discount.edit');
        Route::put('/discount/{discount}', [DiscountCodeController::class, 'updated'])->name('admin.discount.updated');
        Route::delete('/discount/{discount}', [DiscountCodeController::class, 'destroy'])->name('admin.discount.destroy');

        // ORDERS ROUTES
        Route::get('/orders', [OrderController::class, 'orders'])->name('admin.order');
        Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('admin.order.detail');
        Route::post('/orders/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('admin.order.changeOrderStatus');
        Route::post('/orders/send-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('admin.order.sendInvoiceEmail');

        // USER ROUTES
        Route::get('/users', [UserController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'updated'])->name('admin.users.updated');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // PAGES ROUTES
        Route::get('/pages', [PageController::class, 'pages'])->name('admin.pages');
        Route::get('/pages/create', [PageController::class, 'create'])->name('admin.pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('admin.pages.store');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'updated'])->name('admin.pages.updated');
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('admin.pages.destroy');

        // PARAMÉTRES ROUTES
        Route::get('/settings', [SettingController::class, 'settings'])->name('admin.settings');
        Route::get('/settings/create', [SettingController::class, 'create'])->name('admin.settings.create');
        Route::post('/settings/store', [SettingController::class, 'store'])->name('admin.settings.store');
        Route::get('/settings/edit/{id}', [SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/settings/updated/{id}', [SettingController::class, 'updated'])->name('admin.settings.updated');
        Route::delete('/settings/delete/{id}', [SettingController::class, 'destroy'])->name('admin.settings.delete');

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
