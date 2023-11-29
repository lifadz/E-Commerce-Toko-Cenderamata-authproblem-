<?php

use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPUnit\Framework\MockObject\Generator\OriginalConstructorInvocationRequiredException;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'],function (){
    
    Route::group(['middleware' => 'admin.guest'],function (){
        
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');        
    });

    Route::group(['middleware' => 'admin.auth'],function (){
        
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');
        
        Route::get('/profile', [HomeController::class, 'showProfileForm'])->name('admin.profile');
        Route::post('/update-profile', [HomeController::class, 'updateProfile'])->name('admin.updateProfile');

        //Route Kategori
        Route::get('/kategori',[CategoryController::class,'index'])->name('categories.index');
        Route::get('/kategori/membuat-kategori',[CategoryController::class,'create'])->name('categories.create');
        Route::post('/kategori',[CategoryController::class,'store'])->name('categories.store');
        Route::get('/kategori/{category}/edit-kategori',[CategoryController::class,'edit'])->name('categories.edit');
        Route::put('/kategori/{category}',[CategoryController::class,'update'])->name('categories.update');
        Route::delete('/kategori/{category}',[CategoryController::class,'destroy'])->name('categories.delete');

        //Route Sub-kategori
        Route::get('/sub-kategori',[SubCategoryController::class,'index'])->name('sub-categories.index');
        Route::get('/sub-kategori/membuat-sub_kategori',[SubCategoryController::class,'create'])->name('sub-categories.create');
        Route::post('/sub-kategori',[SubCategoryController::class,'store'])->name('sub-categories.store');
        Route::get('/sub-kategori/{subCategory}/edit-sub-kategori',[SubCategoryController::class,'edit'])->name('sub-categories.edit');
        Route::put('/sub-kategori/{subCategory}',[SubCategoryController::class,'update'])->name('sub-categories.update');
        Route::delete('/sub-kategori/{subCategory}',[SubCategoryController::class,'destroy'])->name('sub-categories.delete');

        //Route Brands
        Route::get('/brand',[BrandController::class,'index'])->name('brands.index');
        Route::get('/brand/menambah-brand',[BrandController::class,'create'])->name('brands.create');
        Route::post('/brand',[BrandController::class,'store'])->name('brands.store');
        Route::get('/brand/{brand}/edit-brand',[BrandController::class,'edit'])->name('brands.edit');
        Route::put('/brand/{brand}',[BrandController::class,'update'])->name('brands.update');
        Route::delete('/brand/{brand}',[BrandController::class,'destroy'])->name('brands.delete');
        
        //Route Produk
        Route::get('/produk',[ProductController::class,'index'])->name('products.index');
        Route::get('/produk/menambah-produk',[ProductController::class,'create'])->name('products.create');
        Route::post('/produk',[ProductController::class,'store'])->name('products.store');
        Route::get('/produk/{product}/edit-produk',[ProductController::class,'edit'])->name('products.edit');
        Route::put('/produk/{product}',[ProductController::class,'update'])->name('products.update');
        Route::delete('/produk/{product}',[ProductController::class,'destroy'])->name('products.delete');

        
        
        Route::get('/produk-sub_kategori',[ProductSubCategoryController::class,'index'])->name('product-sub_categories.index');
        
        Route::post('/produk-gambar_produk/update',[ProductImageController::class,'update'])->name('product-images.update');
        Route::delete('/produk-gambar_produk',[ProductImageController::class,'destroy'])->name('product-images.destroy');













        
        //temp image category
        Route::post('/upload-temp-image',[TempImagesController::class,'create'])->name('temp-images.create');

        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }

            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
        
    });

    
    
});