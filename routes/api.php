<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductManagerController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





Route::middleware('auth:sanctum')->group(function() {

    Route::controller(UserController::class)->group(function (){
        Route::get('/profile', 'profile');
        Route::patch('/profile', 'update');
    });

    Route::delete('/logout', [AuthController::class, 'logout']);

    Route::controller(ProductController::class)->group(function () {
        Route::post('/products/{product}/comment',  'addComment');
        Route::get('/products/{product}/comment',  'getComments');
        Route::post('/products/{product}/rating', 'setRating');
    });


    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/{product}', [CartController::class, 'add']);
    Route::delete('/cart/{cart}', [CartController::class, 'delete']);

    Route::middleware('admin')->group(function() {
        Route::controller(ProductManagerController::class)->group(function () {
            Route::post('/products', 'store');
            Route::delete('/products/{product}', 'delete');
            Route::patch('/products/{product}', 'update');
        });


    });

});

Route::controller(AuthController::class)->group(function () {
    Route::post('/registration', 'registration');
    Route::post('/login', 'login');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'show');
    Route::get('/products/{product}', 'getOne');
});
