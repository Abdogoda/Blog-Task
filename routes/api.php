<?php

use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\StatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function(){

    // ###### Authentication Routes ######
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/verify', VerificationController::class);

    // ###### Protected Routes ######
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('/logout', LogoutController::class);

        // ###### Tags API Resource ######
        Route::apiResource('tags', TagController::class);

        // ###### Posts API Resource ######
        Route::get("posts/deleted", [PostController::class, 'deleted']);
        Route::post("posts/{post}/restore", [PostController::class, 'restore']);
        Route::apiResource('posts', PostController::class);
        
    });

    // ###### Stats Route ######
    Route::get('stats', StatsController::class);
});