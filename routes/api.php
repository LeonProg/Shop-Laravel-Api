<?php

use App\Http\Controllers\AuthController;
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

Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/product', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function() {
  Route::get('/profile', [UserController::class, 'profile']);
  Route::patch('/profile', [UserController::class, 'update']);
  Route::delete('/logout', [AuthController::class, 'logout']);  

  Route::middleware('admin')->group(function() {
    Route::post('/product', [ProductManagerController::class, 'store']);
    Route::delete('/product/{product}', [ProductManagerController::class, 'delete']);
    Route::patch('/product/{product}', [ProductManagerController::class, 'update']);
  });
});
