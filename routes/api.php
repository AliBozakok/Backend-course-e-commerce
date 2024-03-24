<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\productController as ControllersProductController;
use App\Http\Controllers\userProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('Adminregister', [adminController::class,'register']);
Route::post('Adminlogin', [adminController::class,'login']);

Route::group([

    'middleware' => 'auth:admin',
    'prefix' => 'auth'

], function ($router) {

    Route::apiResource('category',categoryController::class);
    Route::apiResource('product',ProductController::class);
    Route::get('category/{categoryId}/product', [ProductController::class,'showByCategory']);
    Route::get('logout', [adminController::class,'logout']);
    Route::get('me', [adminController::class,'me']);

});


Route::apiResource('userProduct',userProductController::class)->only(['index','show']);
Route::get('recentUserProduct', [userProductController::class,'recent']);
