<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TypeController;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('index', [
        'banners' => Banner::all(),
        'product' => Product::latest()->skip(2)->take(4)->get()
    ]);
});

Route::get('/products/{cat_slug}/{sub_cat_slug}/{type_slug}/{main_cat_slug}/{slug}', [ProductController::class, 'getProduct']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('name');
Route::get('/dummy/admin', function(){
    return view('admin.index');
});

Route::post('/admin/login/', [AdminController::class, 'adminLogin']);
Route::get('/dummy/logout', [AdminController::class, 'logout'])->name('/dummy/logout');
Route::get('/dummy/dashboard', function(){
    return view('admin/dashboard');
});

Route::get('/dummy/banner', [BannerController::class, 'banner']);
Route::post('/dummy/addBanner', [BannerController::class, 'addBanner']);
Route::post('/dummy/viewBanner', [BannerController::class, 'viewBanner']);
Route::post('/dummy/editBanner', [BannerController::class, 'editBanner']);
Route::post('/dummy/deleteBanner', [BannerController::class, 'deleteBanner']);

Route::get('/dummy/category', [CategoryController::class, 'index']);
Route::post('/dummy/add_category', [CategoryController::class, 'add_category']);
Route::post('/dummy/veiw_category', [CategoryController::class, 'veiw_category']);
Route::post('/dummy/edit_category', [CategoryController::class, 'edit_category']);
Route::post('/dummy/deleteCategory', [CategoryController::class, 'deleteCategory']);

Route::get('/dummy/sub-category', [SubCategoryController::class, 'index']);
Route::post('/dummy/add_sub_category', [SubCategoryController::class, 'add_sub_category']);
Route::post('/dummy/veiw_sub_category', [SubCategoryController::class, 'veiw_sub_category']);
Route::post('/dummy/edit_sub_category', [SubCategoryController::class, 'edit_sub_category']);
Route::post('/dummy/delete_sub_category', [SubCategoryController::class, 'delete_sub_category']);

Route::get('/dummy/type', [TypeController::class, 'index']);
Route::post('/dummy/add_type', [TypeController::class, 'add_type']);
Route::post('/dummy/veiw_type', [TypeController::class, 'veiw_type']);
Route::post('/dummy/edit_type', [TypeController::class, 'edit_type']);
Route::post('/dummy/delete_type', [TypeController::class, 'delete_type']);

Route::get('/dummy/main-category', [MainCategoryController::class, 'index']);
Route::post('/dummy/add_main_category', [MainCategoryController::class, 'add_main_category']);
Route::post('/dummy/veiw_main_category', [MainCategoryController::class, 'veiw_main_category']);
Route::post('/dummy/edit_main_category', [MainCategoryController::class, 'edit_main_category']);
Route::post('/dummy/delete_main_category', [MainCategoryController::class, 'delete_main_category']);

Route::get('/dummy/brand', [BrandController::class, 'index']);
Route::post('/dummy/add_brand', [BrandController::class, 'add_brand']);
Route::post('/dummy/veiw_brand', [BrandController::class, 'veiw_brand']);
Route::post('/dummy/edit_brand', [BrandController::class, 'edit_brand']);
Route::post('/dummy/delete_brand', [BrandController::class, 'delete_brand']);

Route::get('/dummy/product', [ProductController::class, 'index']);
Route::post('/dummy/getSubCat', [ProductController::class, 'getSubCat']);
Route::post('/dummy/getType', [ProductController::class, 'getType']);
Route::post('/dummy/getMainCat', [ProductController::class, 'getMainCat']);
Route::post('/dummy/getBrand', [ProductController::class, 'getBrand']);

Route::post('/dummy/addProduct', [ProductController::class, 'addProduct']);
Route::post('/dummy/viewProduct', [ProductController::class, 'viewProduct']);
Route::post('/dummy/editProduct', [ProductController::class, 'editProduct']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::post('/addQty', [CartController::class, 'addQty']);
Route::post('/minusQty', [CartController::class, 'minusQty']);
Route::post('/deleteItem', [CartController::class, 'deleteItem']);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'shipping'])->name('checkout.shipping');

Route::get('/razorpay-payment', function(){
    return view('proceedToPay');
});
Route::post('/razorpay-payment', [CheckoutController::class, 'payment'])->name('razorpay-payment.payment');

Route::get('Thank-You', function(){
    return view('thankyou');
});
