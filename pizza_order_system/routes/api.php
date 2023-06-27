<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RouteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('pizza_order_system/datas',[RouteController::class,"pizzaOrderSystemDatas"]);

Route::post('create/category',[RouteController::class,"createCategory"]);
Route::post('create/contact',[RouteController::class,"createContact"]);

//delete category
Route::get('delete/category/{id}',[RouteController::class,"deleteCategory"]);

Route::get('category/detail/{id}',[RouteController::class,"categoryDetails"]);
Route::post('category/update',[RouteController::class,"updateCategory"]);
