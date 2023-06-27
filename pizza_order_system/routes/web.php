<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;


Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/','loginPage');
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('auth#dashboard');

    Route::middleware(['admin_auth'])->group(function(){
        //category
        Route::group(['prefix'=>'category'],function(){
            Route::get('list',[CategoryController::class,'list'])->name('category#list');
            Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
            Route::post('create',[CategoryController::class,'create'])->name('category#create');
            Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
            Route::get('edit/{id}',[CategoryController::class,'editPage'])->name('category#editPage');
            Route::post('update',[CategoryController::class, 'update'])->name('category#update');
        });
        //admin
        Route::prefix('admin')->group(function(){
            //password change
            Route::get('password/changePasswordPage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('password/changePassword',[AdminController::class,'changePassword'])->name('admin#changePassword');

            //contact
            Route::get('contact',[AdminController::class,'contactPage'])->name('admin#contactPage');
            Route::get('contact/delete/{id}',[AdminController::class,'contactDelete'])->name('contact#delete');
            Route::get('contact/detail/{id}',[AdminController::class,'contactDetail'])->name('contact#detail');

            //account detail
            Route::get('details',[AdminController::class,'accountDetailPage'])->name('admin#details');
            Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');

            //admin list
            Route::get('list',[AdminController::class,'adminList'])->name("admin#list");
            Route::get('delete/{id}',[AdminController::class,'delete'])->name("admin#delete");
            Route::get('change/role/{id}',[AdminController::class,'change'])->name("admin#change");
            Route::post('change/{id}',[AdminController::class,'changeRole'])->name("admin#changeRole");
        });

        //admin/user
        Route::group(['prefix'=>'user'],function(){
            Route::get('list',[UserController::class,'userList'])->name("admin#userList");
            Route::get('change/role',[UserController::class,'userChangeRole'])->name("admin#userChangeRole");
            Route::get('delete/{id}',[AdminController::class,'deleteUserAccount'])->name("admin#deleteUserAccount");
        });

        //products
        Route::group(['prefix'=>'products'],function(){
            Route::get('list',[ProductController::class,'productsList'])->name('products#list');
            Route::get('createPage',[ProductController::class,'productsCreatePage'])->name('products#createPage');
            Route::post('create',[ProductController::class,'productsCreate'])->name('products#create');
            Route::get('details/{id}',[ProductController::class,'productsDetail'])->name('products#details');
            Route::get('updatePage/{id}',[ProductController::class,'productsUpdatePage'])->name('products#updatePage');
            Route::post('update',[ProductController::class,'productsUpdate'])->name('products#update');
            Route::get('delete/{id}',[ProductController::class,'productsDelete'])->name('products#delete');
        });

        //orders
        Route::group(['prefix'=>'orders'],function(){
            Route::get('list',[OrderController::class,'orderList'])->name("admin#orderList");
            Route::get('order/change',[OrderController::class,'orderChange'])->name("order#change");
            Route::get('ajax/order/status/change',[OrderController::class,'statusChange'])->name("admin#statusChange");
            Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name("admin#listInfo");
        });
    });

    //user
    Route::group(['prefix'=>'user','middleware'=>'user_auth'],function(){
        Route::get('home/',[UserController::class,'home'])->name("user#home");
        Route::get('filter/{id}',[UserController::class,'filter'])->name("user#filter");
        Route::get('history',[UserController::class,'history'])->name("user#history");
        //contact us
        Route::get('contact',[UserController::class,'contact'])->name("user#contact");
        Route::get('contact/send',[UserController::class,'userMessage'])->name("user#message");

        Route::prefix('password')->group(function(){
            Route::get('change',[UserController::class,'passwordChangePage'])->name("user#passwordChangePage");
            Route::post('change',[UserController::class,'changePassword'])->name("user#changePassword");
        });

        Route::prefix('account')->group(function(){
            Route::get('detail/',[UserController::class,'detail'])->name("acount#detail");
            Route::post('update/{id}',[UserController::class,'update'])->name("acount#update");
        });

        Route::prefix('product')->group(function(){
            Route::get('detail/{id}',[UserController::class,'product_details'])->name("user#productsDetail");
        });

        //cart
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name("user#cartList");
        });

        //Ajax Jquery
        Route::prefix('ajax')->group(function(){
            Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name("ajax#pizzaList");
            Route::get('add/pizzaCart',[AjaxController::class,'pizzaAddCart'])->name("ajax#addCart");
            Route::get('order/list',[AjaxController::class,'orderList'])->name("ajax#orderList");
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name("ajax#clearCart");
            Route::get('delete/current/cart',[AjaxController::class,'deleteCurrentCart'])->name("ajax#deleteCurrentCart");
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name("ajax#increaseViewCount");
        });
    });
});


//admin category


