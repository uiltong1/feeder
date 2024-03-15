<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return response([
        'message' => 'API Online'
    ], 200);
});


Route::prefix('tags')->group(function () {
    Route::get('',  [TagController::class, 'index']);
    Route::get('{id}',  [TagController::class, 'show']);
    Route::post('',  [TagController::class, 'store']);
    Route::put('{id}',  [TagController::class, 'update']);
    Route::delete('{id}',  [TagController::class, 'destroy']);
});


Route::prefix('users')->group(function () {
    Route::get('',  [UserController::class, 'index']);
    Route::get('{id}',  [UserController::class, 'show']);
    Route::post('',  [UserController::class, 'store']);
    Route::put('{id}',  [UserController::class, 'update']);
    Route::delete('{id}',  [UserController::class, 'destroy']);
});

Route::prefix('posts')->group(function () {
    Route::get('',  [PostController::class, 'index']);
    Route::get('{id}',  [PostController::class, 'show']);
    Route::post('',  [PostController::class, 'store']);
    Route::put('{id}',  [PostController::class, 'update']);
    Route::delete('{id}',  [PostController::class, 'destroy']);
});
