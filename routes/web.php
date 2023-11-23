<?php

use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
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
        Route::get('/kategori',[CategoryController::class,'index'])->name('kategori.index');
        Route::get('/kategori/tambah-kategori',[CategoryController::class,'create'])
        ->where('tambah-kategori','tambah')
        ->name('kategori.create');
        Route::post('/kategori',[CategoryController::class,'store'])->name('kategori.store');

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